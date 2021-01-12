-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 04:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ci_adminlte_db`
--
CREATE DATABASE IF NOT EXISTS `%DATABASE%` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `%DATABASE%`;
-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
CREATE TABLE `alerts` (
                          `alert_id` bigint(20) NOT NULL,
                          `user_id` bigint(20) DEFAULT NULL,
                          `type` varchar(255) DEFAULT NULL,
                          `message` varchar(255) DEFAULT NULL,
                          `published` tinyint(1) DEFAULT 1,
                          `acknowledged` tinyint(1) DEFAULT 0,
                          `created_at` timestamp NULL DEFAULT current_timestamp(),
                          `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                          `deleted_at` timestamp NULL DEFAULT NULL,
                          `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
                               `id` varchar(40) NOT NULL,
                               `ip_address` varchar(45) NOT NULL,
                               `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
                               `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE `contact_info` (
                                `contact_id` bigint(20) NOT NULL,
                                `type` varchar(255) DEFAULT NULL,
                                `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
                             `customer_id` bigint(20) NOT NULL,
                             `role_id` bigint(20) DEFAULT NULL,
                             `account_code` varchar(12) DEFAULT NULL,
                             `name` varchar(64) NOT NULL,
                             `surname` varchar(128) NOT NULL,
                             `id_number` varchar(15) DEFAULT NULL,
                             `portal_username` varchar(128) DEFAULT NULL,
                             `portal_password` varchar(128) DEFAULT NULL,
                             `customer_type` bigint(20) NOT NULL,
                             `company_name` varchar(128) DEFAULT NULL,
                             `company_registration` varchar(128) DEFAULT NULL,
                             `vat_registration` varchar(128) DEFAULT NULL,
                             `contact_phone` varchar(64) DEFAULT NULL,
                             `contact_mobile` varchar(64) DEFAULT NULL,
                             `contact_email` varchar(128) DEFAULT NULL,
                             `physical_address` varchar(255) DEFAULT NULL,
                             `postal_address` varchar(255) DEFAULT NULL,
                             `gps_coordinates` varchar(64) DEFAULT NULL,
                             `start_date` datetime NOT NULL DEFAULT current_timestamp(),
                             `end_date` datetime DEFAULT NULL,
                             `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
                             `created_at` datetime DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers_contact_info`
--

DROP TABLE IF EXISTS `customers_contact_info`;
CREATE TABLE `customers_contact_info` (
                                          `customer_contact_id` bigint(20) NOT NULL,
                                          `customer_id` bigint(20) DEFAULT NULL,
                                          `contact_info_id` bigint(20) DEFAULT NULL,
                                          `created_at` timestamp NULL DEFAULT current_timestamp(),
                                          `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                          `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=16384 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `data_accounts`
--

DROP TABLE IF EXISTS `data_accounts`;
CREATE TABLE `data_accounts` (
                                 `data_account_id` bigint(20) NOT NULL,
                                 `profile_id` bigint(20) DEFAULT NULL,
                                 `username` varchar(255) NOT NULL,
                                 `password` varchar(255) NOT NULL,
                                 `framedipaddress` varchar(15) DEFAULT NULL,
                                 `framedipv6address` varchar(45) DEFAULT NULL,
                                 `start_date` datetime DEFAULT current_timestamp(),
                                 `end_date` datetime DEFAULT NULL,
                                 `isdisabled` tinyint(1) DEFAULT 0,
                                 `is_deleted` tinyint(1) DEFAULT 0,
                                 `created_at` timestamp NULL DEFAULT current_timestamp(),
                                 `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                 `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

DROP TABLE IF EXISTS `nas`;
CREATE TABLE `nas` (
                       `id` int(10) NOT NULL,
                       `nasname` varchar(128) NOT NULL,
                       `shortname` varchar(32) DEFAULT NULL,
                       `type` varchar(30) DEFAULT 'other',
                       `ports` int(5) DEFAULT NULL,
                       `secret` varchar(60) NOT NULL DEFAULT 'secret',
                       `server` varchar(64) DEFAULT NULL,
                       `community` varchar(50) DEFAULT NULL,
                       `description` varchar(200) DEFAULT 'RADIUS Client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

DROP TABLE IF EXISTS `radacct`;
CREATE TABLE `radacct` (
                           `radacctid` bigint(21) NOT NULL,
                           `acctsessionid` varchar(64) NOT NULL DEFAULT '',
                           `acctuniqueid` varchar(32) NOT NULL DEFAULT '',
                           `username` varchar(64) NOT NULL DEFAULT '',
                           `realm` varchar(64) DEFAULT NULL,
                           `nasipaddress` varchar(15) DEFAULT NULL,
                           `nasportid` varchar(15) DEFAULT NULL,
                           `nasporttype` varchar(32) DEFAULT NULL,
                           `acctstarttime` datetime DEFAULT NULL,
                           `acctupdatetime` datetime DEFAULT NULL,
                           `acctstoptime` datetime DEFAULT NULL,
                           `acctinterval` int(12) DEFAULT NULL,
                           `acctsessiontime` int(12) UNSIGNED DEFAULT NULL,
                           `acctauthentic` varchar(32) DEFAULT NULL,
                           `connectinfo_start` varchar(50) DEFAULT NULL,
                           `connectinfo_stop` varchar(50) DEFAULT NULL,
                           `acctinputoctets` bigint(20) DEFAULT NULL,
                           `acctoutputoctets` bigint(20) DEFAULT NULL,
                           `calledstationid` varchar(50) DEFAULT NULL,
                           `callingstationid` varchar(50) DEFAULT NULL,
                           `acctterminatecause` varchar(32) DEFAULT NULL,
                           `servicetype` varchar(32) DEFAULT NULL,
                           `framedprotocol` varchar(32) DEFAULT NULL,
                           `framedipaddress` varchar(15) DEFAULT NULL,
                           `framedipv6address` varchar(45) DEFAULT NULL,
                           `framedipv6prefix` varchar(45) DEFAULT NULL,
                           `framedinterfaceid` varchar(44) DEFAULT NULL,
                           `delegatedipv6prefix` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

DROP TABLE IF EXISTS `radcheck`;
CREATE TABLE `radcheck` (
                            `id` int(11) UNSIGNED NOT NULL,
                            `username` varchar(64) NOT NULL DEFAULT '',
                            `attribute` varchar(64) NOT NULL DEFAULT '',
                            `op` char(2) NOT NULL DEFAULT '==',
                            `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

DROP TABLE IF EXISTS `radgroupcheck`;
CREATE TABLE `radgroupcheck` (
                                 `id` int(11) UNSIGNED NOT NULL,
                                 `groupname` varchar(64) NOT NULL DEFAULT '',
                                 `attribute` varchar(64) NOT NULL DEFAULT '',
                                 `op` char(2) NOT NULL DEFAULT '==',
                                 `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

DROP TABLE IF EXISTS `radgroupreply`;
CREATE TABLE `radgroupreply` (
                                 `id` int(11) UNSIGNED NOT NULL,
                                 `groupname` varchar(64) NOT NULL DEFAULT '',
                                 `attribute` varchar(64) NOT NULL DEFAULT '',
                                 `op` char(2) NOT NULL DEFAULT '=',
                                 `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radippool`
--

DROP TABLE IF EXISTS `radippool`;
CREATE TABLE `radippool` (
                             `id` int(11) UNSIGNED NOT NULL,
                             `pool_name` varchar(30) NOT NULL,
                             `framedipaddress` varchar(15) NOT NULL,
                             `nasipaddress` varchar(15) DEFAULT NULL,
                             `calledstationid` varchar(30) DEFAULT NULL,
                             `callingstationid` varchar(30) DEFAULT NULL,
                             `expiry_time` datetime DEFAULT NULL,
                             `username` varchar(64) DEFAULT NULL,
                             `pool_key` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

DROP TABLE IF EXISTS `radpostauth`;
CREATE TABLE `radpostauth` (
                               `id` int(11) NOT NULL,
                               `username` varchar(64) NOT NULL DEFAULT '',
                               `pass` varchar(64) NOT NULL DEFAULT '',
                               `reply` varchar(32) NOT NULL DEFAULT '',
                               `authdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

DROP TABLE IF EXISTS `radreply`;
CREATE TABLE `radreply` (
                            `id` int(11) UNSIGNED NOT NULL,
                            `username` varchar(64) NOT NULL DEFAULT '',
                            `attribute` varchar(64) NOT NULL DEFAULT '',
                            `op` char(2) NOT NULL DEFAULT '=',
                            `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

DROP TABLE IF EXISTS `radusergroup`;
CREATE TABLE `radusergroup` (
                                `id` int(11) UNSIGNED NOT NULL,
                                `username` varchar(64) NOT NULL DEFAULT '',
                                `groupname` varchar(64) NOT NULL DEFAULT '',
                                `priority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
                         `id` int(11) NOT NULL,
                         `type` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
                         `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
                         `perms` text CHARACTER SET utf8mb4 NOT NULL,
                         `created_at` timestamp NULL DEFAULT current_timestamp(),
                         `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `roles`
--

TRUNCATE TABLE `roles`;
--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `type`, `name`, `perms`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Root Administrator', 'a:129:{i:0;s:11:\"addCustomer\";i:1;s:12:\"editCustomer\";i:2;s:14:\"deleteCustomer\";i:3;s:14:\"manageCustomer\";i:4;s:14:\"adminsCustomer\";i:5;s:12:\"viewCustomer\";i:6;s:8:\"addAsset\";i:7;s:9:\"editAsset\";i:8;s:11:\"deleteAsset\";i:9;s:11:\"manageAsset\";i:10;s:12:\"licenseAsset\";i:11;s:10:\"viewAssets\";i:12;s:10:\"addLicense\";i:13;s:11:\"editLicense\";i:14;s:13:\"deleteLicense\";i:15;s:13:\"manageLicense\";i:16;s:12:\"assetLicense\";i:17;s:12:\"viewLicenses\";i:18;s:10:\"addProject\";i:19;s:11:\"editProject\";i:20;s:13:\"deleteProject\";i:21;s:13:\"manageProject\";i:22;s:13:\"adminsProject\";i:23;s:12:\"viewProjects\";i:24;s:18:\"manageProjectNotes\";i:25;s:9:\"addTicket\";i:26;s:10:\"editTicket\";i:27;s:12:\"deleteTicket\";i:28;s:12:\"manageTicket\";i:29;s:17:\"manageTicketRules\";i:30;s:17:\"manageTicketNotes\";i:31;s:22:\"manageTicketAssignment\";i:32;s:11:\"viewTickets\";i:33;s:8:\"addIssue\";i:34;s:9:\"editIssue\";i:35;s:11:\"deleteIssue\";i:36;s:11:\"manageIssue\";i:37;s:10:\"viewIssues\";i:38;s:10:\"addComment\";i:39;s:11:\"editComment\";i:40;s:13:\"deleteComment\";i:41;s:13:\"assignComment\";i:42;s:12:\"viewComments\";i:43;s:13:\"addCredential\";i:44;s:14:\"editCredential\";i:45;s:16:\"deleteCredential\";i:46;s:14:\"viewCredential\";i:47;s:5:\"addKB\";i:48;s:6:\"editKB\";i:49;s:8:\"deleteKB\";i:50;s:6:\"viewKB\";i:51;s:9:\"addPReply\";i:52;s:10:\"editPReply\";i:53;s:12:\"deletePReply\";i:54;s:12:\"viewPReplies\";i:55;s:10:\"uploadFile\";i:56;s:12:\"downloadFile\";i:57;s:10:\"deleteFile\";i:58;s:9:\"viewFiles\";i:59;s:7:\"addHost\";i:60;s:8:\"editHost\";i:61;s:10:\"deleteHost\";i:62;s:10:\"manageHost\";i:63;s:14:\"viewMonitoring\";i:64;s:7:\"addUser\";i:65;s:8:\"editUser\";i:66;s:10:\"deleteUser\";i:67;s:9:\"viewUsers\";i:68;s:8:\"addStaff\";i:69;s:9:\"editStaff\";i:70;s:11:\"deleteStaff\";i:71;s:9:\"viewStaff\";i:72;s:7:\"addRole\";i:73;s:8:\"editRole\";i:74;s:10:\"deleteRole\";i:75;s:9:\"viewRoles\";i:76;s:10:\"addContact\";i:77;s:11:\"editContact\";i:78;s:13:\"deleteContact\";i:79;s:12:\"viewContacts\";i:80;s:10:\"manageData\";i:81;s:14:\"manageSettings\";i:82;s:8:\"viewLogs\";i:83;s:10:\"viewSystem\";i:84;s:10:\"viewPeople\";i:85;s:11:\"viewReports\";i:86;s:11:\"autorefresh\";i:87;s:6:\"search\";i:88;s:12:\"addAttribute\";i:89;s:13:\"editAttribute\";i:90;s:15:\"deleteAttribute\";i:91;s:14:\"viewAttributes\";i:92;s:14:\"addDataAccount\";i:93;s:15:\"editDataAccount\";i:94;s:17:\"deleteDataAccount\";i:95;s:18:\"disableDataAccount\";i:96;s:17:\"manageDataAccount\";i:97;s:17:\"showSensitiveData\";i:98;s:17:\"editSensitiveData\";i:99;s:10:\"viewRadius\";i:100;s:11:\"viewProfile\";i:101;s:10:\"addProfile\";i:102;s:11:\"editProfile\";i:103;s:13:\"manageProfile\";i:104;s:13:\"deleteProfile\";i:105;s:20:\"viewProfileComponent\";i:106;s:19:\"addProfileComponent\";i:107;s:20:\"editProfileComponent\";i:108;s:22:\"manageProfileComponent\";i:109;s:22:\"deleteProfileComponent\";i:110;s:10:\"viewIPPool\";i:111;s:11:\"viewSession\";i:112;s:9:\"viewRealm\";i:113;s:7:\"viewNAS\";i:114;s:6:\"addNAS\";i:115;s:7:\"editNAS\";i:116;s:9:\"deleteNAS\";i:117;s:9:\"manageNAS\";i:118;s:15:\"viewAuthRequest\";i:119;s:16:\"allowKickSession\";i:120;s:12:\"viewHighsite\";i:121;s:11:\"addHighsite\";i:122;s:12:\"editHighsite\";i:123;s:14:\"deleteHighsite\";i:124;s:14:\"manageHighsite\";i:125;s:13:\"viewInventory\";i:126;s:14:\"viewAccounting\";i:127;s:13:\"viewDashboard\";i:128;s:4:\"Null\";}', '2020-04-24 08:48:44', NULL, NULL),
(2, 'admin', 'Realm Administrator', 'a:123:{i:0;s:11:\"addCustomer\";i:1;s:12:\"editCustomer\";i:2;s:14:\"deleteCustomer\";i:3;s:14:\"manageCustomer\";i:4;s:14:\"adminsCustomer\";i:5;s:12:\"viewCustomer\";i:6;s:8:\"addAsset\";i:7;s:9:\"editAsset\";i:8;s:11:\"deleteAsset\";i:9;s:11:\"manageAsset\";i:10;s:12:\"licenseAsset\";i:11;s:10:\"viewAssets\";i:12;s:10:\"addLicense\";i:13;s:11:\"editLicense\";i:14;s:13:\"deleteLicense\";i:15;s:13:\"manageLicense\";i:16;s:12:\"assetLicense\";i:17;s:12:\"viewLicenses\";i:18;s:10:\"addProject\";i:19;s:11:\"editProject\";i:20;s:13:\"deleteProject\";i:21;s:13:\"manageProject\";i:22;s:18:\"manageProjectNotes\";i:23;s:13:\"adminsProject\";i:24;s:12:\"viewProjects\";i:25;s:9:\"addTicket\";i:26;s:10:\"editTicket\";i:27;s:12:\"deleteTicket\";i:28;s:12:\"manageTicket\";i:29;s:17:\"manageTicketRules\";i:30;s:17:\"manageTicketNotes\";i:31;s:22:\"manageTicketAssignment\";i:32;s:11:\"viewTickets\";i:33;s:8:\"addIssue\";i:34;s:9:\"editIssue\";i:35;s:11:\"deleteIssue\";i:36;s:11:\"manageIssue\";i:37;s:10:\"viewIssues\";i:38;s:10:\"addComment\";i:39;s:11:\"editComment\";i:40;s:13:\"deleteComment\";i:41;s:13:\"assignComment\";i:42;s:12:\"viewComments\";i:43;s:13:\"addCredential\";i:44;s:14:\"editCredential\";i:45;s:16:\"deleteCredential\";i:46;s:14:\"viewCredential\";i:47;s:15:\"viewCredentials\";i:48;s:5:\"addKB\";i:49;s:6:\"editKB\";i:50;s:8:\"deleteKB\";i:51;s:6:\"viewKB\";i:52;s:9:\"addPReply\";i:53;s:10:\"editPReply\";i:54;s:12:\"deletePReply\";i:55;s:12:\"viewPReplies\";i:56;s:10:\"uploadFile\";i:57;s:12:\"downloadFile\";i:58;s:10:\"deleteFile\";i:59;s:9:\"viewFiles\";i:60;s:7:\"addHost\";i:61;s:8:\"editHost\";i:62;s:10:\"deleteHost\";i:63;s:10:\"manageHost\";i:64;s:14:\"viewMonitoring\";i:65;s:7:\"addUser\";i:66;s:8:\"editUser\";i:67;s:10:\"deleteUser\";i:68;s:9:\"viewUsers\";i:69;s:8:\"addStaff\";i:70;s:9:\"editStaff\";i:71;s:11:\"deleteStaff\";i:72;s:9:\"viewStaff\";i:73;s:7:\"addRole\";i:74;s:8:\"editRole\";i:75;s:10:\"deleteRole\";i:76;s:9:\"viewRoles\";i:77;s:10:\"addContact\";i:78;s:11:\"editContact\";i:79;s:13:\"deleteContact\";i:80;s:12:\"viewContacts\";i:81;s:10:\"manageData\";i:82;s:14:\"manageSettings\";i:83;s:8:\"viewLogs\";i:84;s:10:\"viewSystem\";i:85;s:10:\"viewPeople\";i:86;s:11:\"viewReports\";i:87;s:11:\"autorefresh\";i:88;s:6:\"search\";i:89;s:12:\"addAttribute\";i:90;s:13:\"editAttribute\";i:91;s:15:\"deleteAttribute\";i:92;s:14:\"viewAttributes\";i:93;s:14:\"addDataAccount\";i:94;s:15:\"editDataAccount\";i:95;s:17:\"deleteDataAccount\";i:96;s:15:\"viewDataAccount\";i:97;s:18:\"disableDataAccount\";i:98;s:17:\"manageDataAccount\";i:99;s:17:\"showSensitiveData\";i:100;s:17:\"editSensitiveData\";i:101;s:10:\"viewRadius\";i:102;s:11:\"viewProfile\";i:103;s:10:\"addProfile\";i:104;s:11:\"editProfile\";i:105;s:13:\"manageProfile\";i:106;s:13:\"deleteProfile\";i:107;s:20:\"viewProfileComponent\";i:108;s:19:\"addProfileComponent\";i:109;s:20:\"editProfileComponent\";i:110;s:22:\"manageProfileComponent\";i:111;s:22:\"deleteProfileComponent\";i:112;s:10:\"viewIPPool\";i:113;s:11:\"viewSession\";i:114;s:9:\"viewRealm\";i:115;s:7:\"viewNAS\";i:116;s:6:\"addNAS\";i:117;s:7:\"editNAS\";i:118;s:9:\"deleteNAS\";i:119;s:9:\"manageNAS\";i:120;s:15:\"viewAuthRequest\";i:121;s:16:\"allowKickSession\";i:122;s:4:\"Null\";}', '2020-04-24 08:48:44', NULL, NULL),
(3, 'admin', 'Administrator', 'a:58:{i:0;s:9:\"addClient\";i:1;s:12:\"manageClient\";i:2;s:11:\"viewClients\";i:3;s:8:\"addAsset\";i:4;s:11:\"manageAsset\";i:5;s:10:\"viewAssets\";i:6;s:10:\"addLicense\";i:7;s:13:\"manageLicense\";i:8;s:12:\"viewLicenses\";i:9;s:10:\"addProject\";i:10;s:13:\"manageProject\";i:11;s:18:\"manageProjectNotes\";i:12;s:12:\"viewProjects\";i:13;s:9:\"addTicket\";i:14;s:12:\"manageTicket\";i:15;s:17:\"manageTicketRules\";i:16;s:17:\"manageTicketNotes\";i:17;s:11:\"viewTickets\";i:18;s:8:\"addIssue\";i:19;s:11:\"manageIssue\";i:20;s:10:\"viewIssues\";i:21;s:10:\"addComment\";i:22;s:13:\"assignComment\";i:23;s:12:\"viewComments\";i:24;s:13:\"addCredential\";i:25;s:14:\"editCredential\";i:26;s:14:\"viewCredential\";i:27;s:15:\"viewCredentials\";i:28;s:5:\"addKB\";i:29;s:6:\"viewKB\";i:30;s:9:\"addPReply\";i:31;s:12:\"viewPReplies\";i:32;s:10:\"uploadFile\";i:33;s:9:\"viewFiles\";i:34;s:7:\"addHost\";i:35;s:8:\"editHost\";i:36;s:10:\"manageHost\";i:37;s:14:\"viewMonitoring\";i:38;s:7:\"addUser\";i:39;s:8:\"editUser\";i:40;s:9:\"viewUsers\";i:41;s:8:\"addStaff\";i:42;s:9:\"editStaff\";i:43;s:9:\"viewStaff\";i:44;s:7:\"addRole\";i:45;s:8:\"editRole\";i:46;s:9:\"viewRoles\";i:47;s:10:\"addContact\";i:48;s:11:\"editContact\";i:49;s:12:\"viewContacts\";i:50;s:10:\"manageData\";i:51;s:8:\"viewLogs\";i:52;s:10:\"viewSystem\";i:53;s:10:\"viewPeople\";i:54;s:11:\"viewReports\";i:55;s:11:\"autorefresh\";i:56;s:6:\"search\";i:57;s:4:\"Null\";}', '2020-04-24 08:48:44', NULL, NULL),
(4, 'staff', 'Staff', 'a:48:{i:0;s:9:\"addClient\";i:1;s:12:\"manageClient\";i:2;s:11:\"viewClients\";i:3;s:8:\"addAsset\";i:4;s:11:\"manageAsset\";i:5;s:10:\"viewAssets\";i:6;s:10:\"addLicense\";i:7;s:13:\"manageLicense\";i:8;s:12:\"viewLicenses\";i:9;s:10:\"addProject\";i:10;s:13:\"manageProject\";i:11;s:18:\"manageProjectNotes\";i:12;s:12:\"viewProjects\";i:13;s:9:\"addTicket\";i:14;s:12:\"manageTicket\";i:15;s:17:\"manageTicketRules\";i:16;s:17:\"manageTicketNotes\";i:17;s:11:\"viewTickets\";i:18;s:8:\"addIssue\";i:19;s:11:\"manageIssue\";i:20;s:10:\"viewIssues\";i:21;s:10:\"addComment\";i:22;s:12:\"viewComments\";i:23;s:13:\"addCredential\";i:24;s:14:\"viewCredential\";i:25;s:15:\"viewCredentials\";i:26;s:5:\"addKB\";i:27;s:6:\"viewKB\";i:28;s:9:\"addPReply\";i:29;s:12:\"viewPReplies\";i:30;s:10:\"uploadFile\";i:31;s:12:\"downloadFile\";i:32;s:9:\"viewFiles\";i:33;s:7:\"addHost\";i:34;s:10:\"manageHost\";i:35;s:14:\"viewMonitoring\";i:36;s:7:\"addUser\";i:37;s:9:\"viewUsers\";i:38;s:10:\"addContact\";i:39;s:11:\"editContact\";i:40;s:12:\"viewContacts\";i:41;s:10:\"manageData\";i:42;s:10:\"viewSystem\";i:43;s:10:\"viewPeople\";i:44;s:11:\"viewReports\";i:45;s:11:\"autorefresh\";i:46;s:6:\"search\";i:47;s:4:\"Null\";}', '2020-04-24 08:48:44', NULL, NULL),
(5, 'client', 'Client', 'a:22:{i:0;s:11:\"manageAsset\";i:1;s:10:\"viewAssets\";i:2;s:13:\"manageLicense\";i:3;s:12:\"viewLicenses\";i:4;s:12:\"viewProjects\";i:5;s:9:\"addTicket\";i:6;s:10:\"editTicket\";i:7;s:12:\"manageTicket\";i:8;s:11:\"viewTickets\";i:9;s:8:\"addIssue\";i:10;s:10:\"viewIssues\";i:11;s:10:\"addComment\";i:12;s:12:\"viewComments\";i:13;s:6:\"viewKB\";i:14;s:14:\"viewMonitoring\";i:15;s:8:\"addStaff\";i:16;s:9:\"editStaff\";i:17;s:11:\"deleteStaff\";i:18;s:9:\"viewStaff\";i:19;s:10:\"viewPeople\";i:20;s:11:\"viewReports\";i:21;s:4:\"Null\";}', '2020-04-24 08:48:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `user_id` bigint(20) NOT NULL,
                         `parent_id` bigint(20) DEFAULT NULL,
                         `role_id` bigint(20) DEFAULT NULL,
                         `title` varchar(64) DEFAULT NULL,
                         `name` varchar(64) DEFAULT NULL,
                         `surname` varchar(128) NOT NULL,
                         `occupation` varchar(128) DEFAULT NULL,
                         `username` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `avatar` blob DEFAULT NULL,
                         `signature` varchar(255) DEFAULT NULL,
                         `last_ip_address` varchar(30) DEFAULT NULL,
                         `start_date` datetime NOT NULL DEFAULT current_timestamp(),
                         `end_date` datetime DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT current_timestamp(),
                         `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         `deleted_at` timestamp NULL DEFAULT NULL,
                         `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_contact_info`
--

DROP TABLE IF EXISTS `users_contact_info`;
CREATE TABLE `users_contact_info` (
                                      `user_contact_id` bigint(20) NOT NULL,
                                      `user_id` bigint(20) DEFAULT NULL,
                                      `contact_info_id` bigint(20) DEFAULT NULL,
                                      `created_at` timestamp NULL DEFAULT current_timestamp(),
                                      `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                      `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
    ADD PRIMARY KEY (`alert_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
    ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
    ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
    ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customers_contact_info`
--
ALTER TABLE `customers_contact_info`
    ADD PRIMARY KEY (`customer_contact_id`),
    ADD KEY `FK_customers_contact_details_customers_customer_id` (`customer_id`),
    ADD KEY `FK_customers_contact_details_contact_details_contact_id` (`contact_info_id`);

--
-- Indexes for table `data_accounts`
--
ALTER TABLE `data_accounts`
    ADD PRIMARY KEY (`data_account_id`);

--
-- Indexes for table `nas`
--
ALTER TABLE `nas`
    ADD PRIMARY KEY (`id`),
    ADD KEY `nasname` (`nasname`);

--
-- Indexes for table `radacct`
--
ALTER TABLE `radacct`
    ADD PRIMARY KEY (`radacctid`),
    ADD UNIQUE KEY `acctuniqueid` (`acctuniqueid`),
    ADD KEY `username` (`username`),
    ADD KEY `framedipaddress` (`framedipaddress`),
    ADD KEY `framedipv6address` (`framedipv6address`),
    ADD KEY `framedipv6prefix` (`framedipv6prefix`),
    ADD KEY `framedinterfaceid` (`framedinterfaceid`),
    ADD KEY `delegatedipv6prefix` (`delegatedipv6prefix`),
    ADD KEY `acctsessionid` (`acctsessionid`),
    ADD KEY `acctsessiontime` (`acctsessiontime`),
    ADD KEY `acctstarttime` (`acctstarttime`),
    ADD KEY `acctinterval` (`acctinterval`),
    ADD KEY `acctstoptime` (`acctstoptime`),
    ADD KEY `nasipaddress` (`nasipaddress`);

--
-- Indexes for table `radcheck`
--
ALTER TABLE `radcheck`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`(32));

--
-- Indexes for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
    ADD PRIMARY KEY (`id`),
    ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
    ADD PRIMARY KEY (`id`),
    ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radippool`
--
ALTER TABLE `radippool`
    ADD PRIMARY KEY (`id`),
    ADD KEY `radippool_poolname_expire` (`pool_name`,`expiry_time`),
    ADD KEY `framedipaddress` (`framedipaddress`),
    ADD KEY `radippool_nasip_poolkey_ipaddress` (`nasipaddress`,`pool_key`,`framedipaddress`);

--
-- Indexes for table `radpostauth`
--
ALTER TABLE `radpostauth`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`(32));

--
-- Indexes for table `radreply`
--
ALTER TABLE `radreply`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`(32));

--
-- Indexes for table `radusergroup`
--
ALTER TABLE `radusergroup`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`(32));

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_contact_info`
--
ALTER TABLE `users_contact_info`
    ADD PRIMARY KEY (`user_contact_id`),
    ADD KEY `FK_users_contact_details_users_user_id` (`user_id`),
    ADD KEY `FK_users_contact_details_contact_details_contact_id` (`contact_info_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
    MODIFY `alert_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
    MODIFY `contact_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
    MODIFY `customer_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers_contact_info`
--
ALTER TABLE `customers_contact_info`
    MODIFY `customer_contact_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_accounts`
--
ALTER TABLE `data_accounts`
    MODIFY `data_account_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nas`
--
ALTER TABLE `nas`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radacct`
--
ALTER TABLE `radacct`
    MODIFY `radacctid` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radcheck`
--
ALTER TABLE `radcheck`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radippool`
--
ALTER TABLE `radippool`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radpostauth`
--
ALTER TABLE `radpostauth`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radreply`
--
ALTER TABLE `radreply`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radusergroup`
--
ALTER TABLE `radusergroup`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_contact_info`
--
ALTER TABLE `users_contact_info`
    MODIFY `user_contact_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers_contact_info`
--
ALTER TABLE `customers_contact_info`
    ADD CONSTRAINT `FK_customers_contact_details_contact_details_contact_id` FOREIGN KEY (`contact_info_id`) REFERENCES `contact_info` (`contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `FK_customers_contact_details_customers_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_contact_info`
--
ALTER TABLE `users_contact_info`
    ADD CONSTRAINT `FK_users_contact_details_contact_details_contact_id` FOREIGN KEY (`contact_info_id`) REFERENCES `contact_info` (`contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `FK_users_contact_details_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
