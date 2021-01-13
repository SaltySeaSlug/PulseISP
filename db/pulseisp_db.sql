-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 03:44 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `pulseisp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_activity_log`
--

CREATE TABLE `ci_activity_log` (
                                   `id` int(11) NOT NULL,
                                   `activity_id` tinyint(4) NOT NULL,
                                   `user_id` int(11) NOT NULL,
                                   `admin_id` int(11) NOT NULL,
                                   `description` varchar(255) DEFAULT NULL,
                                   `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_activity_status`
--

CREATE TABLE `ci_activity_status` (
                                      `id` int(11) NOT NULL,
                                      `description` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_activity_status`
--

INSERT INTO `ci_activity_status` (`id`, `description`) VALUES
(1, 'Add'),
(2, 'Delete'),
(3, 'Update'),
(4, 'Misc');

-- --------------------------------------------------------

--
-- Table structure for table `ci_admin`
--

CREATE TABLE `ci_admin` (
                            `admin_id` int(11) NOT NULL,
                            `admin_role_id` int(11) NOT NULL,
                            `username` varchar(100) CHARACTER SET utf8 NOT NULL,
                            `firstname` varchar(255) NOT NULL,
                            `lastname` varchar(255) NOT NULL,
                            `email` varchar(255) NOT NULL,
                            `mobile_no` varchar(255) NOT NULL,
                            `image` varchar(300) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            `last_login` datetime NOT NULL,
                            `is_verify` tinyint(4) NOT NULL DEFAULT 1,
                            `is_admin` tinyint(4) NOT NULL DEFAULT 1,
                            `is_active` tinyint(4) NOT NULL DEFAULT 0,
                            `is_supper` tinyint(4) NOT NULL DEFAULT 0,
                            `token` varchar(255) NOT NULL,
                            `password_reset_code` varchar(255) NOT NULL,
                            `last_ip` varchar(255) NOT NULL,
                            `created_at` datetime NOT NULL,
                            `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_admin`
--

INSERT INTO `ci_admin` (`admin_id`, `admin_role_id`, `username`, `firstname`, `lastname`, `email`, `mobile_no`, `image`, `password`, `last_login`, `is_verify`, `is_admin`, `is_active`, `is_supper`, `token`, `password_reset_code`, `last_ip`, `created_at`, `updated_at`) VALUES
(25, 2, 'admin', 'Admin', 'User', 'admin@gmail.com', '544354353', '', '$2y$10$KyH0L.rMhaXWkMh/ZoN1.e44FOzEak.KzZoUjQdIGiuVJtuKa9z0y', '2019-01-09 00:00:00', 1, 1, 1, 0, '', '', '', '2018-03-19 00:00:00', '2019-11-24 00:00:00'),
(31, 1, 'superadmin', 'Mark', 'Cockbain', 'cockbainma@gmail.com', '0727938031', '', '$2y$10$KyH0L.rMhaXWkMh/ZoN1.e44FOzEak.KzZoUjQdIGiuVJtuKa9z0y', '0000-00-00 00:00:00', 1, 1, 1, 1, '', 'e620a99414d5ebf5c61d6a43a4ac94a2', '::1', '2019-01-16 06:01:58', '2020-12-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_admin_roles`
--

CREATE TABLE `ci_admin_roles` (
                                  `admin_role_id` int(11) NOT NULL,
                                  `admin_role_title` varchar(30) CHARACTER SET utf8 NOT NULL,
                                  `admin_role_status` int(11) NOT NULL,
                                  `admin_role_created_by` int(1) NOT NULL,
                                  `admin_role_created_on` datetime NOT NULL,
                                  `admin_role_modified_by` int(11) NOT NULL,
                                  `admin_role_modified_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_admin_roles`
--

INSERT INTO `ci_admin_roles` (`admin_role_id`, `admin_role_title`, `admin_role_status`, `admin_role_created_by`, `admin_role_created_on`, `admin_role_modified_by`, `admin_role_modified_on`) VALUES
(1, 'Super Admin', 1, 0, '2018-03-15 12:48:04', 0, '2018-03-17 12:53:16'),
(2, 'Admin', 1, 0, '2018-03-15 12:53:19', 0, '2019-01-26 08:27:34'),
(3, 'Accountant', 1, 0, '2018-03-15 01:46:54', 0, '2019-01-26 02:17:38'),
(4, 'Operator', 1, 0, '2018-03-16 05:52:45', 0, '2019-01-26 02:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `ci_cities`
--

CREATE TABLE `ci_cities` (
                             `id` int(11) NOT NULL,
                             `name` varchar(30) NOT NULL,
                             `slug` varchar(255) NOT NULL,
                             `state_id` int(11) NOT NULL,
                             `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_companies`
--

CREATE TABLE `ci_companies` (
                                `id` int(11) NOT NULL,
                                `name` varchar(100) NOT NULL,
                                `email` varchar(50) NOT NULL,
                                `mobile_no` varchar(50) NOT NULL,
                                `address1` varchar(255) NOT NULL,
                                `address2` varchar(255) NOT NULL,
                                `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_countries`
--

CREATE TABLE `ci_countries` (
                                `id` int(11) NOT NULL,
                                `sortname` varchar(3) NOT NULL,
                                `name` varchar(150) NOT NULL,
                                `slug` varchar(255) NOT NULL,
                                `phonecode` int(11) NOT NULL,
                                `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_email_templates`
--

CREATE TABLE `ci_email_templates` (
                                      `id` int(11) NOT NULL,
                                      `name` varchar(255) NOT NULL,
                                      `slug` varchar(100) NOT NULL,
                                      `subject` varchar(255) NOT NULL,
                                      `body` text NOT NULL,
                                      `last_update` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_email_templates`
--

INSERT INTO `ci_email_templates` (`id`, `name`, `slug`, `subject`, `body`, `last_update`) VALUES
(1, 'Email Verification', 'email-verification', 'Activate Your Account', '<p></p>\n\n<p>Hi  <b>{FULLNAME}</b>,<br><br></p><p>Welcome to LightAdmin!<br>Active your account with the link above and start your Career.</p><p>To verify your email, please click the link below:<br> {VERIFICATION_LINK}</p><p>\n\n</p><div><b>Regards,</b></div><div><b>Team</b></div>\n\n<p></p>', '2019-11-26 18:06:39'),
(2, 'Forget Password', 'forget-password', 'Recover your password', '<p>\n\n</p><p>Hi  <b>{FULLNAME}</b>,<br><br></p><p>Welcome to LightAdmin!<br></p><p>We have received a request to reset your password. If you did not initiate this request, you can simply ignore this message and no action will be taken.</p><p><br>To reset your password, please click the link below:<br> {RESET_LINK}</p>\n\n<p></p>', '2019-11-26 17:44:41'),
(3, 'General Notification', '', 'aaaaa', '<p>asdfasdfasdfasd </p>', '2019-08-26 02:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `ci_email_template_variables`
--

CREATE TABLE `ci_email_template_variables` (
                                               `id` int(11) NOT NULL,
                                               `template_id` int(11) NOT NULL,
                                               `variable_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_email_template_variables`
--

INSERT INTO `ci_email_template_variables` (`id`, `template_id`, `variable_name`) VALUES
(1, 1, '{FULLNAME}'),
(2, 1, '{VERIFICATION_LINK}'),
(3, 2, '{RESET_LINK}'),
(4, 2, '{FULLNAME}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_general_settings`
--

CREATE TABLE `ci_general_settings` (
                                       `id` int(11) NOT NULL,
                                       `favicon` varchar(255) DEFAULT NULL,
                                       `logo` varchar(255) DEFAULT NULL,
                                       `application_name` varchar(255) DEFAULT NULL,
                                       `timezone` varchar(255) DEFAULT NULL,
                                       `currency` varchar(100) DEFAULT NULL,
                                       `default_language` int(11) NOT NULL,
                                       `copyright` tinytext DEFAULT NULL,
                                       `email_from` varchar(100) NOT NULL,
                                       `smtp_host` varchar(255) DEFAULT NULL,
                                       `smtp_port` int(11) DEFAULT NULL,
                                       `smtp_user` varchar(50) DEFAULT NULL,
                                       `smtp_pass` varchar(50) DEFAULT NULL,
                                       `facebook_link` varchar(255) DEFAULT NULL,
                                       `twitter_link` varchar(255) DEFAULT NULL,
                                       `google_link` varchar(255) DEFAULT NULL,
                                       `youtube_link` varchar(255) DEFAULT NULL,
                                       `linkedin_link` varchar(255) DEFAULT NULL,
                                       `instagram_link` varchar(255) DEFAULT NULL,
                                       `recaptcha_secret_key` varchar(255) DEFAULT NULL,
                                       `recaptcha_site_key` varchar(255) DEFAULT NULL,
                                       `recaptcha_lang` varchar(50) DEFAULT NULL,
                                       `company_name` varchar(128) DEFAULT NULL,
                                       `address_line_1` varchar(255) NOT NULL,
                                       `address_line_2` varchar(255) NOT NULL,
                                       `email_address` varchar(128) NOT NULL,
                                       `contact_number` varchar(20) NOT NULL,
                                       `terms` varchar(2048) NOT NULL,
                                       `use_google_font` tinyint(1) DEFAULT NULL,
                                       `created_date` datetime DEFAULT NULL,
                                       `updated_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_general_settings`
--

INSERT INTO `ci_general_settings` (`id`, `favicon`, `logo`, `application_name`, `timezone`, `currency`, `default_language`, `copyright`, `email_from`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `facebook_link`, `twitter_link`, `google_link`, `youtube_link`, `linkedin_link`, `instagram_link`, `recaptcha_secret_key`, `recaptcha_site_key`, `recaptcha_lang`, `company_name`, `address_line_1`, `address_line_2`, `email_address`, `contact_number`, `terms`, `use_google_font`, `created_date`, `updated_date`) VALUES
(1, 'assets/img/fe84f0f94bd2023cd663f5c73baad88e.png', 'assets/img/dc48701e5a6a300744b873b63f772101.png', 'Pulse<b>ISP</b>', 'Africa/Johannesburg', 'ZAR', 2, '<strong><a href=\"http://www.unitechsol.co.za\">Unitech Solutions TTL</a> © 2020</strong> | All rights reserved.', 'info@domain.com', 'smtp.domain.com', 567, 'info@domain.com', '123456789', 'https://facebook.com', 'https://twitter.com', 'https://google.com', 'https://youtube.com', 'https://linkedin.com', 'https://instagram.com', '', '', 'en', 'Unitech Solutions TTL', 'De Beers Avenue', 'Firgrove Rural', 'accounts@unitechsol.co.za', '0218540000', 'Banking Details: \r\nFNB (250655)  62842291255 \r\nUnitech Solutions TTL', 0, '2020-12-22 00:00:00', '2020-12-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
                               `id` int(11) NOT NULL,
                               `name` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                               `short_name` varchar(15) NOT NULL,
                               `status` int(11) NOT NULL DEFAULT 1,
                               `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`id`, `name`, `short_name`, `status`, `created_at`) VALUES
(2, 'English', 'en', 1, '2019-09-16 01:13:17'),
(3, 'French', 'fr', 1, '2019-09-16 08:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `ci_payments`
--

CREATE TABLE `ci_payments` (
                               `id` int(11) NOT NULL,
                               `admin_id` int(11) NOT NULL,
                               `user_id` int(11) NOT NULL,
                               `company_id` int(11) NOT NULL,
                               `invoice_no` varchar(30) NOT NULL,
                               `txn_id` varchar(255) NOT NULL,
                               `items_detail` longtext NOT NULL,
                               `sub_total` decimal(10,2) NOT NULL,
                               `total_tax` decimal(10,2) NOT NULL,
                               `discount` decimal(10,2) NOT NULL,
                               `grand_total` decimal(10,2) NOT NULL,
                               `currency` varchar(20) NOT NULL,
                               `payment_method` varchar(50) NOT NULL,
                               `payment_status` varchar(30) NOT NULL,
                               `client_note` longtext NOT NULL,
                               `termsncondition` longtext NOT NULL,
                               `due_date` date NOT NULL,
                               `created_date` date NOT NULL,
                               `updated_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_states`
--

CREATE TABLE `ci_states` (
                             `id` int(11) NOT NULL,
                             `name` varchar(30) NOT NULL,
                             `slug` varchar(255) NOT NULL,
                             `country_id` int(11) NOT NULL DEFAULT 1,
                             `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_uploaded_files`
--

CREATE TABLE `ci_uploaded_files` (
                                     `id` int(11) NOT NULL,
                                     `name` varchar(225) NOT NULL,
                                     `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_users`
--

CREATE TABLE `ci_users` (
                            `id` int(11) NOT NULL,
                            `username` varchar(50) NOT NULL,
                            `account_code` varchar(255) DEFAULT NULL,
                            `firstname` varchar(30) NOT NULL,
                            `lastname` varchar(30) NOT NULL,
                            `email` varchar(50) NOT NULL,
                            `mobile_no` varchar(30) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            `address` varchar(255) NOT NULL,
                            `role` tinyint(4) NOT NULL DEFAULT 1,
                            `is_active` tinyint(4) NOT NULL DEFAULT 1,
                            `is_verify` tinyint(4) NOT NULL DEFAULT 0,
                            `is_admin` tinyint(4) NOT NULL DEFAULT 0,
                            `token` varchar(255) NOT NULL,
                            `password_reset_code` varchar(255) NOT NULL,
                            `last_ip` varchar(30) NOT NULL,
                            `created_at` datetime NOT NULL,
                            `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
                            `name` char(20) CHARACTER SET utf8 NOT NULL,
                            `code` char(3) CHARACTER SET utf8 NOT NULL,
                            `symbol` char(5) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`name`, `code`, `symbol`) VALUES
('Leke', 'ALL', 'Lek'),
('Dollars', 'USD', '$'),
('Afghanis', 'AFN', '؋'),
('Pesos', 'ARS', '$'),
('Guilders', 'AWG', 'ƒ'),
('Dollars', 'AUD', '$'),
('New Manats', 'AZN', 'ман'),
('Dollars', 'BSD', '$'),
('Dollars', 'BBD', '$'),
('Rubles', 'BYR', 'p.'),
('Euro', 'EUR', '€'),
('Dollars', 'BZD', 'BZ$'),
('Dollars', 'BMD', '$'),
('Bolivianos', 'BOB', '$b'),
('Convertible Marka', 'BAM', 'KM'),
('Pula', 'BWP', 'P'),
('Leva', 'BGN', 'лв'),
('Reais', 'BRL', 'R$'),
('Pounds', 'GBP', '£'),
('Dollars', 'BND', '$'),
('Riels', 'KHR', '៛'),
('Dollars', 'CAD', '$'),
('Dollars', 'KYD', '$'),
('Pesos', 'CLP', '$'),
('Yuan Renminbi', 'CNY', '¥'),
('Pesos', 'COP', '$'),
('Colón', 'CRC', '₡'),
('Kuna', 'HRK', 'kn'),
('Pesos', 'CUP', '₱'),
('Koruny', 'CZK', 'Kč'),
('Kroner', 'DKK', 'kr'),
('Pesos', 'DOP', 'RD$'),
('Dollars', 'XCD', '$'),
('Pounds', 'EGP', '£'),
('Colones', 'SVC', '$'),
('Pounds', 'FKP', '£'),
('Dollars', 'FJD', '$'),
('Cedis', 'GHC', '¢'),
('Pounds', 'GIP', '£'),
('Quetzales', 'GTQ', 'Q'),
('Pounds', 'GGP', '£'),
('Dollars', 'GYD', '$'),
('Lempiras', 'HNL', 'L'),
('Dollars', 'HKD', '$'),
('Forint', 'HUF', 'Ft'),
('Kronur', 'ISK', 'kr'),
('Rupees', 'INR', 'Rp'),
('Rupiahs', 'IDR', 'Rp'),
('Rials', 'IRR', '﷼'),
('Pounds', 'IMP', '£'),
('New Shekels', 'ILS', '₪'),
('Dollars', 'JMD', 'J$'),
('Yen', 'JPY', '¥'),
('Pounds', 'JEP', '£'),
('Tenge', 'KZT', 'лв'),
('Won', 'KPW', '₩'),
('Won', 'KRW', '₩'),
('Soms', 'KGS', 'лв'),
('Kips', 'LAK', '₭'),
('Lati', 'LVL', 'Ls'),
('Pounds', 'LBP', '£'),
('Dollars', 'LRD', '$'),
('Switzerland Francs', 'CHF', 'CHF'),
('Litai', 'LTL', 'Lt'),
('Denars', 'MKD', 'ден'),
('Ringgits', 'MYR', 'RM'),
('Rupees', 'MUR', '₨'),
('Pesos', 'MXN', '$'),
('Tugriks', 'MNT', '₮'),
('Meticais', 'MZN', 'MT'),
('Dollars', 'NAD', '$'),
('Rupees', 'NPR', '₨'),
('Guilders', 'ANG', 'ƒ'),
('Dollars', 'NZD', '$'),
('Cordobas', 'NIO', 'C$'),
('Nairas', 'NGN', '₦'),
('Krone', 'NOK', 'kr'),
('Rials', 'OMR', '﷼'),
('Rupees', 'PKR', '₨'),
('Balboa', 'PAB', 'B/.'),
('Guarani', 'PYG', 'Gs'),
('Nuevos Soles', 'PEN', 'S/.'),
('Pesos', 'PHP', 'Php'),
('Zlotych', 'PLN', 'zł'),
('Rials', 'QAR', '﷼'),
('New Lei', 'RON', 'lei'),
('Rubles', 'RUB', 'руб'),
('Pounds', 'SHP', '£'),
('Riyals', 'SAR', '﷼'),
('Dinars', 'RSD', 'Дин.'),
('Rupees', 'SCR', '₨'),
('Dollars', 'SGD', '$'),
('Dollars', 'SBD', '$'),
('Shillings', 'SOS', 'S'),
('Rand', 'ZAR', 'R'),
('Rupees', 'LKR', '₨'),
('Kronor', 'SEK', 'kr'),
('Dollars', 'SRD', '$'),
('Pounds', 'SYP', '£'),
('New Dollars', 'TWD', 'NT$'),
('Baht', 'THB', '฿'),
('Dollars', 'TTD', 'TT$'),
('Lira', 'TRY', '₺'),
('Liras', 'TRL', '£'),
('Dollars', 'TVD', '$'),
('Hryvnia', 'UAH', '₴'),
('Pesos', 'UYU', '$U'),
('Sums', 'UZS', 'лв'),
('Bolivares Fuertes', 'VEF', 'Bs'),
('Dong', 'VND', '₫'),
('Rials', 'YER', '﷼'),
('Zimbabwe Dollars', 'ZWD', 'Z$'),
('Rupees', 'INR', '₹');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
                          `module_id` int(11) NOT NULL,
                          `module_name` varchar(255) NOT NULL,
                          `controller_name` varchar(255) NOT NULL,
                          `fa_icon` varchar(100) NOT NULL,
                          `operation` text NOT NULL,
                          `sort_order` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `controller_name`, `fa_icon`, `operation`, `sort_order`) VALUES
(1, 'admin', 'admin', 'fas fa-chart-pie', 'view|add|edit|delete|change_status|access', 3),
(2, 'role_and_permissions', 'admin_roles', 'fa-book', 'view|add|edit|delete|change_status|access', 4),
(3, 'users', 'users', 'fas fa-users', 'view|add|edit|delete|change_status|access', 4),
(7, 'backup_and_export', 'export', 'fas fa-database', 'access', 12),
(8, 'settings', 'general_settings', 'fa-cogs', 'view|add|edit|access', 13),
(9, 'dashboard', 'dashboard', 'fas fa-tachometer-alt', 'view|index_2|index_3|access', 1),
(10, 'codeigniter_examples', 'example', 'fa-snowflake-o', 'access', 6),
(11, 'invoicing_system', 'invoices', 'fas fa-file', 'access', 9),
(12, 'database_joins_example', 'joins', 'fa-external-link-square', 'access', 7),
(13, 'language_setting', 'languages', 'fa-language', 'access|add', 14),
(14, 'locations', 'location', 'fa-map-pin', 'access', 11),
(15, 'widgets', 'widgets', 'fa-th', 'access', 19),
(16, 'charts', 'charts', 'fa-line-chart', 'access', 17),
(17, 'ui_elements', 'ui', 'fa-tree', 'access', 18),
(18, 'forms', 'forms', 'fa-edit', 'access', 20),
(19, 'tables', 'tables', 'fa-table', 'access', 21),
(21, 'mailbox', 'mailbox', 'fa-envelope-o', 'access', 23),
(22, 'pages', 'pages', 'fa-book', 'access', 24),
(23, 'extras', 'extras', 'fa-plus-square-o', 'access', 25),
(25, 'profile', 'profile', 'fa-user', 'access', 2),
(26, 'activity_log', 'activity', 'fa-flag-o', 'access', 11),
(27, 'nas_devices', 'nas', 'fa fa-server fa-fw', 'access|add|delete', 2);

-- --------------------------------------------------------

--
-- Table structure for table `module_access`
--

CREATE TABLE `module_access` (
                                 `id` int(11) NOT NULL,
                                 `admin_role_id` int(11) NOT NULL,
                                 `module` varchar(255) NOT NULL,
                                 `operation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_access`
--

INSERT INTO `module_access` (`id`, `admin_role_id`, `module`, `operation`) VALUES
(1, 1, 'users', 'view'),
(2, 1, 'users', 'add'),
(3, 1, 'users', 'edit'),
(5, 1, 'users', 'access'),
(6, 1, 'users', 'change_status'),
(7, 1, 'export', 'access'),
(8, 1, 'general_settings', 'view'),
(9, 1, 'general_settings', 'add'),
(10, 1, 'general_settings', 'edit'),
(11, 1, 'general_settings', 'access'),
(27, 2, 'dashboard', 'access'),
(28, 2, 'profile', 'access'),
(29, 2, 'dashboard', 'view'),
(34, 2, 'tables', 'access'),
(35, 2, 'forms', 'access'),
(36, 2, 'calendar', 'access'),
(37, 2, 'mailbox', 'access'),
(38, 2, 'pages', 'access'),
(39, 2, 'extras', 'access'),
(40, 2, 'ui', 'access'),
(41, 2, 'charts', 'access'),
(42, 2, 'widgets', 'access'),
(43, 2, 'users', 'view'),
(44, 2, 'users', 'add'),
(45, 2, 'users', 'edit'),
(46, 2, 'users', 'change_status'),
(47, 2, 'users', 'access'),
(48, 2, 'example', 'access'),
(49, 2, 'joins', 'access'),
(50, 2, 'invoices', 'access'),
(51, 2, 'location', 'access'),
(52, 2, 'activity', 'access'),
(53, 2, 'export', 'access'),
(54, 1, 'languages', 'access'),
(55, 1, 'dashboard', 'view'),
(56, 1, 'dashboard', 'index_2'),
(57, 1, 'dashboard', 'index_3'),
(58, 1, 'dashboard', 'access'),
(59, 1, 'profile', 'access'),
(60, 1, 'admin', 'view'),
(61, 1, 'admin', 'change_status'),
(62, 1, 'admin', 'add'),
(63, 1, 'admin', 'access'),
(64, 1, 'admin', 'edit'),
(65, 1, 'admin', 'delete'),
(66, 1, 'admin_roles', 'delete'),
(67, 1, 'admin_roles', 'edit'),
(68, 1, 'admin_roles', 'view'),
(69, 1, 'admin_roles', 'change_status'),
(70, 1, 'admin_roles', 'access'),
(71, 1, 'admin_roles', 'add'),
(72, 1, 'joins', 'access'),
(73, 1, 'example', 'access'),
(74, 1, 'invoices', 'access'),
(75, 1, 'location', 'access'),
(76, 1, 'activity', 'access'),
(77, 1, 'charts', 'access'),
(78, 1, 'ui', 'access'),
(79, 1, 'widgets', 'access'),
(80, 1, 'forms', 'access'),
(81, 1, 'tables', 'access'),
(82, 1, 'mailbox', 'access'),
(83, 1, 'extras', 'access'),
(84, 1, 'pages', 'access'),
(85, 1, 'users', 'delete'),
(91, 1, 'languages', 'add'),
(92, 1, 'nas', 'add');

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

CREATE TABLE `nas` (
                       `id` int(10) NOT NULL,
                       `nasname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `shortname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `nasidentifier` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'other',
                       `ports` int(5) DEFAULT 3799,
                       `secret` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'secret',
                       `server` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `community` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'RADIUS Client',
                       `connection_type` enum('direct','openvpn','pptp','dynamic') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'direct',
                       `record_auth` tinyint(1) NOT NULL DEFAULT 0,
                       `ignore_acct` tinyint(1) NOT NULL DEFAULT 0,
                       `monitor` tinyint(1) NOT NULL DEFAULT 0,
                       `last_contact` datetime DEFAULT NULL,
                       `session_auto_close` tinyint(1) NOT NULL DEFAULT 0,
                       `session_dead_time` int(5) NOT NULL DEFAULT 3600,
                       `on_public_maps` tinyint(1) NOT NULL DEFAULT 0,
                       `lat` double DEFAULT NULL,
                       `lon` double DEFAULT NULL,
                       `photo_file_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
                       `user_id` int(11) DEFAULT NULL,
                       `created` datetime DEFAULT NULL,
                       `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nas`
--

INSERT INTO `nas` (`id`, `nasname`, `shortname`, `nasidentifier`, `type`, `ports`, `secret`, `server`, `community`, `description`, `connection_type`, `record_auth`, `ignore_acct`, `monitor`, `last_contact`, `session_auto_close`, `session_dead_time`, `on_public_maps`, `lat`, `lon`, `photo_file_name`, `user_id`, `created`, `modified`) VALUES
(8, '100.99.2.255', 'Unity Kramat Core', 'UNITY-KRA_CORE', 'other', 3799, 'testing123', NULL, NULL, 'RADIUS Client', 'direct', 0, 0, 0, '2021-01-12 15:24:48', 0, 3600, 0, NULL, NULL, NULL, NULL, '2019-10-30 12:17:30', NULL),
(6, '100.99.1.255', 'Unity Helderview Core', 'UNITY-HDV_CORE', 'other', 3799, 'testing123', NULL, 'dude', 'RADIUS Client', 'direct', 0, 0, 0, '2021-01-12 15:24:45', 0, 3600, 0, NULL, NULL, NULL, NULL, '2019-10-26 16:45:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

CREATE TABLE `radacct` (
                           `radacctid` bigint(21) NOT NULL,
                           `acctsessionid` varchar(64) NOT NULL DEFAULT '',
                           `acctuniqueid` varchar(32) NOT NULL DEFAULT '',
                           `username` varchar(64) NOT NULL DEFAULT '',
                           `groupname` varchar(64) NOT NULL DEFAULT '',
                           `realm` varchar(64) DEFAULT '',
                           `nasipaddress` varchar(15) NOT NULL DEFAULT '',
                           `nasportid` varchar(100) DEFAULT NULL,
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
                           `calledstationid` varchar(50) NOT NULL DEFAULT '',
                           `callingstationid` varchar(50) NOT NULL DEFAULT '',
                           `acctterminatecause` varchar(32) NOT NULL DEFAULT '',
                           `servicetype` varchar(32) DEFAULT NULL,
                           `framedprotocol` varchar(32) DEFAULT NULL,
                           `framedipaddress` varchar(15) NOT NULL DEFAULT '',
                           `framedipv6address` varchar(45) NOT NULL DEFAULT '',
                           `framedipv6prefix` varchar(45) NOT NULL DEFAULT '',
                           `framedinterfaceid` varchar(44) NOT NULL DEFAULT '',
                           `delegatedipv6prefix` varchar(45) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

CREATE TABLE `radcheck` (
                            `id` int(11) UNSIGNED NOT NULL,
                            `username` varchar(64) NOT NULL DEFAULT '',
                            `attribute` varchar(64) NOT NULL DEFAULT '',
                            `op` char(2) NOT NULL DEFAULT '==',
                            `value` varchar(253) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `radcheck`
--

INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'matthew@uni', 'Pool-Name', ':=', 'main_pool'),
(2, 'matthew@uni', 'Cleartext-Password', ':=', 'client@unity');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

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

CREATE TABLE `radippool` (
                             `id` int(11) UNSIGNED NOT NULL,
                             `pool_name` varchar(30) NOT NULL,
                             `framedipaddress` varchar(15) NOT NULL DEFAULT '',
                             `nasipaddress` varchar(15) NOT NULL DEFAULT '',
                             `calledstationid` varchar(30) NOT NULL,
                             `callingstationid` varchar(30) NOT NULL,
                             `expiry_time` datetime DEFAULT NULL,
                             `username` varchar(64) DEFAULT NULL,
                             `pool_key` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

CREATE TABLE `radpostauth` (
                               `id` int(11) NOT NULL,
                               `username` varchar(64) NOT NULL DEFAULT '',
                               `pass` varchar(64) NOT NULL DEFAULT '',
                               `reply` varchar(32) NOT NULL DEFAULT '',
                               `authdate` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

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

CREATE TABLE `radusergroup` (
                                `id` int(11) UNSIGNED NOT NULL,
                                `username` varchar(64) NOT NULL DEFAULT '',
                                `groupname` varchar(64) NOT NULL DEFAULT '',
                                `priority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sub_module`
--

CREATE TABLE `sub_module` (
                              `id` int(11) NOT NULL,
                              `parent` int(11) NOT NULL,
                              `name` varchar(255) NOT NULL,
                              `link` varchar(255) NOT NULL,
                              `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_module`
--

INSERT INTO `sub_module` (`id`, `parent`, `name`, `link`, `sort_order`) VALUES
(2, 2, 'module_setting', 'module', 1),
(3, 2, 'role_and_permissions', '', 2),
(4, 1, 'add_new_admin', 'add', 2),
(6, 1, 'admin_list', '', 1),
(26, 9, 'dashboard_v1', '', 1),
(27, 9, 'dashboard_v2', 'index_2', 2),
(28, 9, 'dashboard_v3', 'index_3', 3),
(30, 3, 'users_list', '', 1),
(31, 3, 'add_new_user', 'add', 2),
(32, 10, 'simple_datatable', 'simple_datatable', 1),
(33, 10, 'ajax_datatable', 'ajax_datatable', 2),
(34, 10, 'pagination', 'pagination', 3),
(35, 10, 'advance_search', 'advance_search', 4),
(36, 10, 'file_upload', 'file_upload', 5),
(37, 11, 'invoice_list', '', 1),
(38, 11, 'add_new_invoice', 'add', 2),
(39, 12, 'serverside_join', '', 1),
(40, 12, 'simple_join', 'simple', 2),
(41, 14, 'country', '', 1),
(42, 14, 'state', 'state', 2),
(43, 14, 'city', 'city', 3),
(44, 16, 'charts_js', 'chartjs', 1),
(45, 16, 'charts_flot', 'flot', 2),
(46, 16, 'charts_inline', 'inline', 3),
(47, 17, 'general', 'general', 1),
(48, 17, 'icons', 'icons', 2),
(49, 17, 'buttons', 'buttons', 3),
(50, 18, 'general_elements', 'general', 1),
(51, 18, 'advanced_elements', 'advanced', 2),
(52, 18, 'editors', 'editors', 3),
(53, 19, 'simple_tables', 'simple', 1),
(54, 19, 'data_tables', 'data', 2),
(55, 21, 'inbox', 'inbox', 1),
(56, 21, 'compose', 'compose', 2),
(57, 21, 'read', 'read_mail', 3),
(58, 22, 'invoice', 'invoice', 1),
(59, 22, 'profile', 'profile', 2),
(60, 22, 'login', 'login', 3),
(61, 22, 'register', 'register', 4),
(62, 22, 'lock_screen', 'Lockscreen', 4),
(63, 23, 'error_404', 'error404', 1),
(64, 23, 'error_500', 'error500', 2),
(65, 23, 'blank_page', 'blank', 3),
(66, 23, 'starter_page', 'starter', 4),
(67, 8, 'general_settings', '', 1),
(68, 8, 'email_template_settings', 'email_templates', 2),
(69, 25, 'view_profile', '', 1),
(70, 25, 'change_password', 'change_pwd', 2),
(71, 10, 'multiple_files_upload', 'multi_file_upload', 6),
(72, 10, 'dynamic_charts', 'charts', 7),
(73, 10, 'locations', 'locations', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_activity_log`
--
ALTER TABLE `ci_activity_log`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_activity_status`
--
ALTER TABLE `ci_activity_status`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_admin`
--
ALTER TABLE `ci_admin`
    ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ci_admin_roles`
--
ALTER TABLE `ci_admin_roles`
    ADD PRIMARY KEY (`admin_role_id`);

--
-- Indexes for table `ci_cities`
--
ALTER TABLE `ci_cities`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_companies`
--
ALTER TABLE `ci_companies`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_countries`
--
ALTER TABLE `ci_countries`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_email_templates`
--
ALTER TABLE `ci_email_templates`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_email_template_variables`
--
ALTER TABLE `ci_email_template_variables`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_general_settings`
--
ALTER TABLE `ci_general_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_language`
--
ALTER TABLE `ci_language`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_payments`
--
ALTER TABLE `ci_payments`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_states`
--
ALTER TABLE `ci_states`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_uploaded_files`
--
ALTER TABLE `ci_uploaded_files`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_users`
--
ALTER TABLE `ci_users`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
    ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `module_access`
--
ALTER TABLE `module_access`
    ADD PRIMARY KEY (`id`),
    ADD KEY `RoleId` (`admin_role_id`);

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
    ADD KEY `nasipaddress` (`nasipaddress`),
    ADD KEY `bulk_close` (`acctstoptime`,`nasipaddress`,`acctstarttime`);

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
    ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sub_module`
--
ALTER TABLE `sub_module`
    ADD PRIMARY KEY (`id`),
    ADD KEY `Parent Module ID` (`parent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_activity_log`
--
ALTER TABLE `ci_activity_log`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ci_activity_status`
--
ALTER TABLE `ci_activity_status`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_admin`
--
ALTER TABLE `ci_admin`
    MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ci_admin_roles`
--
ALTER TABLE `ci_admin_roles`
    MODIFY `admin_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_cities`
--
ALTER TABLE `ci_cities`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48357;

--
-- AUTO_INCREMENT for table `ci_companies`
--
ALTER TABLE `ci_companies`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ci_countries`
--
ALTER TABLE `ci_countries`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `ci_email_templates`
--
ALTER TABLE `ci_email_templates`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_email_template_variables`
--
ALTER TABLE `ci_email_template_variables`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_general_settings`
--
ALTER TABLE `ci_general_settings`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_language`
--
ALTER TABLE `ci_language`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_payments`
--
ALTER TABLE `ci_payments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ci_states`
--
ALTER TABLE `ci_states`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4122;

--
-- AUTO_INCREMENT for table `ci_uploaded_files`
--
ALTER TABLE `ci_uploaded_files`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `ci_users`
--
ALTER TABLE `ci_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
    MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `module_access`
--
ALTER TABLE `module_access`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `nas`
--
ALTER TABLE `nas`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `radacct`
--
ALTER TABLE `radacct`
    MODIFY `radacctid` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radcheck`
--
ALTER TABLE `radcheck`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `sub_module`
--
ALTER TABLE `sub_module`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;
