#
# Table structure for table 'fr_ippool'
#
CREATE TABLE fr_ippool (
	id			int unsigned NOT NULL auto_increment,
	pool_name		varchar(30) NOT NULL,
	address		        varchar(43) NOT NULL DEFAULT '',
	owner		        varchar(128) NOT NULL DEFAULT '',
	gateway			varchar(128) NOT NULL DEFAULT '',
	expiry_time		DATETIME NOT NULL DEFAULT NOW(),
	status			ENUM('dynamic', 'static', 'declined', 'disabled') DEFAULT 'dynamic',
	counter			int unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (id),
	KEY fr_ippool_poolname_expire (pool_name, expiry_time),
	KEY address (address),
	KEY fr_ippool_poolname_poolkey_ipaddress (pool_name, owner, address)
) ENGINE=InnoDB;


--
-- A stored procedure to reallocate a user's previous address, otherwise
-- provide a free address.
--
-- Using this SP reduces the usual set dialogue of queries to a single
-- query:
--
--   START TRANSACTION; SELECT FOR UPDATE; UPDATE; COMMIT;  ->  CALL sp()
--
-- The stored procedure is executed on an database instance within a single
-- round trip which often leads to reduced deadlocking and significant
-- performance improvements especially on multi-master clusters, perhaps even
-- by an order of magnitude or more.
--
-- To use this stored procedure the corresponding queries.conf statements must
-- be configured as follows:
--
-- allocate_begin = ""
-- allocate_find = "\
-- 	CALL fr_ippool_allocate_previous_or_new_address( \
-- 		'%{control.${pool_name}}', \
-- 		'${gateway}', \
-- 		'${owner}', \
-- 		${offer_duration}, \
--		'%{${requested_address}:-0.0.0.0}' \
-- 	)"
-- allocate_update = ""
-- allocate_commit = ""
--

DELIMITER $$

DROP PROCEDURE IF EXISTS fr_ippool_allocate_previous_or_new_address;
CREATE PROCEDURE fr_ippool_allocate_previous_or_new_address (
	IN v_pool_name VARCHAR(64),
	IN v_gateway VARCHAR(128),
	IN v_owner VARCHAR(128),
	IN v_lease_duration INT,
	IN v_requested_address VARCHAR(15)
)
proc:BEGIN
	DECLARE r_address VARCHAR(15);

	SET TRANSACTION ISOLATION LEVEL READ COMMITTED;

	START TRANSACTION;

	-- Reissue an existing IP address lease when re-authenticating a session
	--
	SELECT address INTO r_address
	FROM fr_ippool
	WHERE pool_name = v_pool_name
		AND expiry_time > NOW()
		AND owner = v_owner
		AND `status` IN ('dynamic', 'static')
	LIMIT 1
	FOR UPDATE;
--      FOR UPDATE SKIP LOCKED;  -- Better performance, but limited support

	-- NOTE: You should enable SKIP LOCKED here (as well as any other
	--       instances) if your database server supports it. If it is not
	--       supported and you are not running a multi-master cluster (e.g.
	--       Galera or MaxScale) then you should instead consider using the
	--       SP in procedure-no-skip-locked.sql which will be faster and
	--       less likely to result in thread starvation under highly
	--       concurrent load.

	-- Reissue an user's previous IP address, provided that the lease is
	-- available (i.e. enable sticky IPs)
	--
	-- When using this SELECT you should delete the one above. You must also
	-- set allocate_clear = "" in queries.conf to persist the associations
	-- for expired leases.
	--
	-- SELECT address INTO r_address
	-- FROM fr_ippool
	-- WHERE pool_name = v_pool_name
	--	AND owner = v_owner
	--	AND `status` IN ('dynamic', 'static')
	-- LIMIT 1
	-- FOR UPDATE;
	-- -- FOR UPDATE SKIP LOCKED;  -- Better performance, but limited support

	-- Issue the requested IP address if it is available
	--
	IF r_address IS NULL AND v_requested_address <> '0.0.0.0' THEN
		SELECT address INTO r_address
		FROM fr_ippool
		WHERE pool_name = v_pool_name
			AND address = v_requested_address
			AND `status` = 'dynamic'
			AND expiry_time < NOW()
		FOR UPDATE;
--		FOR UPDATE SKIP LOCKED;  -- Better performance, but limited support
	END IF;

	-- If we didn't reallocate a previous address then pick the least
	-- recently used address from the pool which maximises the likelihood
	-- of re-assigning the other addresses to their recent user
	--
	IF r_address IS NULL THEN
		SELECT address INTO r_address
		FROM fr_ippool
		WHERE pool_name = v_pool_name
			AND expiry_time < NOW()
			AND `status` = 'dynamic'
		ORDER BY
			expiry_time
		LIMIT 1
		FOR UPDATE;
--		FOR UPDATE SKIP LOCKED;  -- Better performance, but limited support
	END IF;

	-- Return nothing if we failed to allocated an address
	--
	IF r_address IS NULL THEN
		COMMIT;
		LEAVE proc;
	END IF;

	-- Update the pool having allocated an IP address
	--
	UPDATE fr_ippool
	SET
		gateway = v_gateway,
		owner = v_owner,
		expiry_time = NOW() + INTERVAL v_lease_duration SECOND
	WHERE address = r_address;

	COMMIT;

	-- Return the address that we allocated
	SELECT r_address;

END$$

DELIMITER ;



#  -*- text -*-
##
## admin.sql -- MySQL commands for creating the RADIUS user.
##
##	WARNING: You should change 'localhost' and 'radpass'
##		 to something else.  Also update raddb/mods-available/sql
##		 with the new RADIUS password.
##
##	$Id$

#
#  Create default administrator for RADIUS
#
CREATE USER 'radius'@'localhost' IDENTIFIED BY 'radpass';

# The server can read any table in SQL
GRANT SELECT ON radius.* TO 'radius'@'localhost';

# The server can write to the accounting and post-auth logging table.
#
#  i.e.
GRANT ALL on radius.radacct TO 'radius'@'localhost';
GRANT ALL on radius.radpostauth TO 'radius'@'localhost';


#ce the authdate definition with the following
#        if your software is too old:
#
#   authdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
#
CREATE TABLE radpostauth (
  id int(11) NOT NULL auto_increment,
  username varchar(64) NOT NULL default '',
  pass varchar(64) NOT NULL default '',
  reply varchar(32) NOT NULL default '',
  authdate timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY  (id)
) ENGINE = INNODB;

#
# Table structure for table 'nas'
#
CREATE TABLE nas (
  id int(10) NOT NULL auto_increment,
  nasname varchar(128) NOT NULL,
  shortname varchar(32),
  type varchar(30) DEFAULT 'other',
  ports int(5),
  secret varchar(60) DEFAULT 'secret' NOT NULL,
  server varchar(64),
  community varchar(50),
  description varchar(200) DEFAULT 'RADIUS Client',
  PRIMARY KEY (id),
  KEY nasname (nasname)
);



#  -*- text -*-
#
#  main/mysql/process-radacct.sql -- Schema extensions for processing radacct entries
#
#  $Id$

--  ---------------------------------
--  - Per-user data usage over time -
--  ---------------------------------
--
--  An extension to the standard schema to hold per-user data usage statistics
--  for arbitrary periods.
--
--  The data_usage_by_period table is populated by periodically calling the
--  fr_new_data_usage_period stored procedure.
--
--  This table can be queried in various ways to produce reports of aggregate
--  data use over time. For example, if the fr_new_data_usage_period SP is
--  invoked one per day just after midnight, to produce usage data with daily
--  granularity, then a reasonably accurate monthly bandwidth summary for a
--  given user could be obtained with:
--
--      SELECT
--          DATE_FORMAT(period_start, '%Y-%M') AS month,
--          SUM(acctinputoctets)/1000/1000/1000 AS GB_in,
--          SUM(acctoutputoctets)/1000/1000/1000 AS GB_out
--      FROM
--          data_usage_by_period
--      WHERE
--          username='bob' AND
--          period_end IS NOT NULL
--      GROUP BY
--          YEAR(period_start), MONTH(period_start);
--
--      +----------------+----------------+-----------------+
--      | month          | GB_in          | GB_out          |
--      +----------------+----------------+-----------------+
--      | 2019-July      | 5.782279230000 | 50.545664820000 |
--      | 2019-August    | 4.230543340000 | 48.523096420000 |
--      | 2019-September | 4.847360590000 | 48.631835480000 |
--      | 2019-October   | 6.456763250000 | 51.686231930000 |
--      | 2019-November  | 6.362537730000 | 52.385710570000 |
--      | 2019-December  | 4.301524440000 | 50.762240270000 |
--      | 2020-January   | 5.436280540000 | 49.067775280000 |
--      +----------------+----------------+-----------------+
--      7 rows in set (0.000 sec)
--
CREATE TABLE data_usage_by_period (
    username VARCHAR(64),
    period_start DATETIME,
    period_end DATETIME,
    acctinputoctets BIGINT(20),
    acctoutputoctets BIGINT(20),
    PRIMARY KEY (username,period_start)
);
CREATE INDEX idx_data_usage_by_period_period_start ON data_usage_by_period (period_start);
CREATE INDEX idx_data_usage_by_period_period_end ON data_usage_by_period (period_end);


--
--  Stored procedure that when run with some arbitrary frequency, say
--  once per day by cron, will process the recent radacct entries to extract
--  time-windowed data containing acct{input,output}octets ("data usage") per
--  username, per period.
--
--  Each invocation will create new rows in the data_usage_by_period tables
--  containing the data used by each user since the procedure was last invoked.
--  The intervals do not need to be identical but care should be taken to
--  ensure that the start/end of each period aligns well with any intended
--  reporting intervals.
--
--  It can be invoked by running:
--
--      CALL fr_new_data_usage_period();
--
--
DELIMITER $$

DROP PROCEDURE IF EXISTS fr_new_data_usage_period;
CREATE PROCEDURE fr_new_data_usage_period ()
BEGIN

    DECLARE v_start DATETIME;
    DECLARE v_end DATETIME;

    SELECT IFNULL(DATE_ADD(MAX(period_end), INTERVAL 1 SECOND), FROM_UNIXTIME(0)) INTO v_start FROM data_usage_by_period;
    SELECT NOW() INTO v_end;

    START TRANSACTION;

    --
    -- Add the data usage for the sessions that were active in the current
    -- period to the table. Include all sessions that finished since the start
    -- of this period as well as those still ongoing.
    --
    INSERT INTO data_usage_by_period (username, period_start, period_end, acctinputoctets, acctoutputoctets)
    SELECT *
    FROM (
        SELECT
            username,
            v_start,
            v_end,
            SUM(acctinputoctets) AS acctinputoctets,
            SUM(acctoutputoctets) AS acctoutputoctets
        FROM
            radacct
        WHERE
            acctstoptime > v_start OR
            acctstoptime IS NULL
        GROUP BY
            username
    ) AS s
    ON DUPLICATE KEY UPDATE
        acctinputoctets = data_usage_by_period.acctinputoctets + s.acctinputoctets,
        acctoutputoctets = data_usage_by_period.acctoutputoctets + s.acctoutputoctets,
        period_end = v_end;

    --
    -- Create an open-ended "next period" for all ongoing sessions and carry a
    -- negative value of their data usage to avoid double-accounting when we
    -- process the next period. Their current data usage has already been
    -- allocated to the current and possibly previous periods.
    --
    INSERT INTO data_usage_by_period (username, period_start, period_end, acctinputoctets, acctoutputoctets)
    SELECT *
    FROM (
        SELECT
            username,
            DATE_ADD(v_end, INTERVAL 1 SECOND),
            NULL,
            0 - SUM(acctinputoctets),
            0 - SUM(acctoutputoctets)
        FROM
            radacct
        WHERE
            acctstoptime IS NULL
        GROUP BY
            username
    ) AS s;

    COMMIT;

END$$

DELIMITER ;