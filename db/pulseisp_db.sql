-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 04:29 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_activity_status`
--

CREATE TABLE `ci_activity_status` (
                                      `id` int(11) NOT NULL,
                                      `description` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
                            `username` varchar(100) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_admin`
--

INSERT INTO `ci_admin` (`admin_id`, `admin_role_id`, `username`, `firstname`, `lastname`, `email`, `mobile_no`, `image`, `password`, `last_login`, `is_verify`, `is_admin`, `is_active`, `is_supper`, `token`, `password_reset_code`, `last_ip`, `created_at`, `updated_at`) VALUES
(25, 2, 'admin', 'Admin', 'User', 'admin@gmail.com', '544354353', '', '$2y$10$KyH0L.rMhaXWkMh/ZoN1.e44FOzEak.KzZoUjQdIGiuVJtuKa9z0y', '2019-01-09 00:00:00', 1, 1, 1, 0, '', '', '', '2018-03-19 00:00:00', '2019-11-24 00:00:00'),
(31, 1, 'superadmin', 'Super', 'Admin', 'test@test.com', '', '', '$2y$10$KyH0L.rMhaXWkMh/ZoN1.e44FOzEak.KzZoUjQdIGiuVJtuKa9z0y', '0000-00-00 00:00:00', 1, 1, 1, 1, '', 'e620a99414d5ebf5c61d6a43a4ac94a2', '::1', '2019-01-16 06:01:58', '2020-12-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_admin_roles`
--

CREATE TABLE `ci_admin_roles` (
                                  `admin_role_id` int(11) NOT NULL,
                                  `admin_role_title` varchar(30) NOT NULL,
                                  `admin_role_status` int(11) NOT NULL,
                                  `admin_role_created_by` int(1) NOT NULL,
                                  `admin_role_created_on` datetime NOT NULL,
                                  `admin_role_modified_by` int(11) NOT NULL,
                                  `admin_role_modified_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for table `ci_currency`
--

CREATE TABLE `ci_currency` (
                               `name` char(20) NOT NULL,
                               `code` char(3) NOT NULL,
                               `symbol` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_currency`
--

INSERT INTO `ci_currency` (`name`, `code`, `symbol`) VALUES
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
-- Table structure for table `ci_email_templates`
--

CREATE TABLE `ci_email_templates` (
                                      `id` int(11) NOT NULL,
                                      `name` varchar(255) NOT NULL,
                                      `slug` varchar(100) NOT NULL,
                                      `subject` varchar(255) NOT NULL,
                                      `body` text NOT NULL,
                                      `last_update` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
                                       `radius_secret` varchar(255) DEFAULT NULL,
                                       `realm_suffix` varchar(255) DEFAULT NULL,
                                       `created_date` datetime DEFAULT NULL,
                                       `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_general_settings`
--

INSERT INTO `ci_general_settings` (`id`, `favicon`, `logo`, `application_name`, `timezone`, `currency`, `default_language`, `copyright`, `email_from`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `facebook_link`, `twitter_link`, `google_link`, `youtube_link`, `linkedin_link`, `instagram_link`, `recaptcha_secret_key`, `recaptcha_site_key`, `recaptcha_lang`, `company_name`, `address_line_1`, `address_line_2`, `email_address`, `contact_number`, `terms`, `use_google_font`, `radius_secret`, `realm_suffix`, `created_date`, `updated_date`) VALUES
(1, 'assets/img/fe84f0f94bd2023cd663f5c73baad88e.png', 'assets/img/dc48701e5a6a300744b873b63f772101.png', 'Pulse<b>ISP</b>', 'Africa/Johannesburg', 'ZAR', 2, '<strong><a href=\"http://www.domain.co.za\">Private Company</a> © 2020</strong> | All rights reserved.', '', 'smtp.gmail.com', 587, NULL, NULL, 'https://facebook.com', 'https://twitter.com', 'https://google.com', 'https://youtube.com', 'https://linkedin.com', 'https://instagram.com', '', '', 'en', 'Private Company', '', '', '', '', '', 1, NULL, 'unity', '2021-01-21 00:00:00', '2021-01-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
                               `id` int(11) NOT NULL,
                               `name` varchar(225) NOT NULL,
                               `short_name` varchar(15) NOT NULL,
                               `status` int(11) NOT NULL DEFAULT 1,
                               `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`id`, `name`, `short_name`, `status`, `created_at`) VALUES
(2, 'English', 'en', 1, '2019-09-16 01:13:17'),
(3, 'French', 'fr', 1, '2019-09-16 08:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language_keys`
--

CREATE TABLE `ci_language_keys` (
                                    `key` varchar(255) NOT NULL,
                                    `filename` varchar(255) NOT NULL,
                                    `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_language_keys`
--

INSERT INTO `ci_language_keys` (`key`, `filename`, `comment`) VALUES
('contact', 'site_lang.php', ''),
('logout', 'site_lang.php', ''),
('search', 'site_lang.php', ''),
('invoice', 'site_lang.php', ''),
('dashboard', 'site_lang.php', ''),
('dashboard_v1', 'site_lang.php', ''),
('dashboard_v2', 'site_lang.php', ''),
('dashboard_v3', 'site_lang.php', ''),
('admin', 'site_lang.php', ''),
('admin_list', 'site_lang.php', ''),
('add_new_admin', 'site_lang.php', ''),
('profile', 'site_lang.php', ''),
('view_profile', 'site_lang.php', ''),
('change_password', 'site_lang.php', ''),
('role_and_permissions', 'site_lang.php', ''),
('module_setting', 'site_lang.php', ''),
('users', 'site_lang.php', ''),
('users_list', 'site_lang.php', ''),
('add_new_user', 'site_lang.php', ''),
('activity_log', 'site_lang.php', ''),
('settings', 'site_lang.php', ''),
('general_settings', 'site_lang.php', ''),
('email_template_settings', 'site_lang.php', ''),
('codeigniter_examples', 'site_lang.php', ''),
('simple_datatable', 'site_lang.php', ''),
('ajax_datatable', 'site_lang.php', ''),
('pagination', 'site_lang.php', ''),
('advance_search', 'site_lang.php', ''),
('file_upload', 'site_lang.php', ''),
('multiple_files_upload', 'site_lang.php', ''),
('backup_and_export', 'site_lang.php', ''),
('invoicing_system', 'site_lang.php', ''),
('invoice_list', 'site_lang.php', ''),
('add_new_invoice', 'site_lang.php', ''),
('database_joins_example', 'site_lang.php', ''),
('serverside_join', 'site_lang.php', ''),
('simple_join', 'site_lang.php', ''),
('language_setting', 'site_lang.php', ''),
('locations', 'site_lang.php', ''),
('country', 'site_lang.php', ''),
('state', 'site_lang.php', ''),
('city', 'site_lang.php', ''),
('widgets', 'site_lang.php', ''),
('charts', 'site_lang.php', ''),
('charts_js', 'site_lang.php', ''),
('charts_flot', 'site_lang.php', ''),
('charts_inline', 'site_lang.php', ''),
('ui_elements', 'site_lang.php', ''),
('general', 'site_lang.php', ''),
('icons', 'site_lang.php', ''),
('buttons', 'site_lang.php', ''),
('forms', 'site_lang.php', ''),
('general_elements', 'site_lang.php', ''),
('advanced_elements', 'site_lang.php', ''),
('editors', 'site_lang.php', ''),
('tables', 'site_lang.php', ''),
('simple_tables', 'site_lang.php', ''),
('data_tables', 'site_lang.php', ''),
('mailbox', 'site_lang.php', ''),
('inbox', 'site_lang.php', ''),
('compose', 'site_lang.php', ''),
('read', 'site_lang.php', ''),
('pages', 'site_lang.php', ''),
('login', 'site_lang.php', ''),
('register', 'site_lang.php', ''),
('lock_screen', 'site_lang.php', ''),
('extras', 'site_lang.php', ''),
('error_404', 'site_lang.php', ''),
('error_500', 'site_lang.php', ''),
('blank_page', 'site_lang.php', ''),
('starter_page', 'site_lang.php', ''),
('miscellaneous', 'site_lang.php', ''),
('documentation', 'site_lang.php', ''),
('labels', 'site_lang.php', ''),
('important', 'site_lang.php', ''),
('warning', 'site_lang.php', ''),
('informational', 'site_lang.php', ''),
('signin_to_start_your_session', 'site_lang.php', ''),
('signin', 'site_lang.php', ''),
('username', 'site_lang.php', ''),
('password', 'site_lang.php', ''),
('remember_me', 'site_lang.php', ''),
('i_forgot_my_password', 'site_lang.php', ''),
('register_new_membership', 'site_lang.php', ''),
('firstname', 'site_lang.php', ''),
('lastname', 'site_lang.php', ''),
('email', 'site_lang.php', ''),
('confirm', 'site_lang.php', ''),
('i_agree_to_the', 'site_lang.php', ''),
('terms', 'site_lang.php', ''),
('i_already_have_membership', 'site_lang.php', ''),
('forgot_password', 'site_lang.php', ''),
('submit', 'site_lang.php', ''),
('you_remember_password', 'site_lang.php', ''),
('reset_password', 'site_lang.php', ''),
('reset', 'site_lang.php', ''),
('home', 'site_lang.php', ''),
('user_registrations', 'site_lang.php', ''),
('active_users', 'site_lang.php', ''),
('inactive_users', 'site_lang.php', ''),
('unique_visitors', 'site_lang.php', ''),
('more_info', 'site_lang.php', ''),
('sales', 'site_lang.php', ''),
('visitors', 'site_lang.php', ''),
('area', 'site_lang.php', ''),
('donut', 'site_lang.php', ''),
('online', 'site_lang.php', ''),
('direct_chat', 'site_lang.php', ''),
('send', 'site_lang.php', ''),
('type_message', 'site_lang.php', ''),
('sales_graph', 'site_lang.php', ''),
('to_do_list', 'site_lang.php', ''),
('add_item', 'site_lang.php', ''),
('calendar', 'site_lang.php', ''),
('mobile_no', 'site_lang.php', ''),
('select_admin_role', 'site_lang.php', ''),
('select_role', 'site_lang.php', ''),
('add_admin', 'site_lang.php', ''),
('edit_admin', 'site_lang.php', ''),
('all_admin_types', 'site_lang.php', ''),
('all_status', 'site_lang.php', ''),
('active', 'site_lang.php', ''),
('inactive', 'site_lang.php', ''),
('search_from_here', 'site_lang.php', ''),
('id', 'site_lang.php', ''),
('user', 'site_lang.php', ''),
('role', 'site_lang.php', ''),
('status', 'site_lang.php', ''),
('select_status', 'site_lang.php', ''),
('action', 'site_lang.php', ''),
('update_profile', 'site_lang.php', ''),
('new_password', 'site_lang.php', ''),
('confirm_password', 'site_lang.php', ''),
('add_new_module', 'site_lang.php', ''),
('operations', 'site_lang.php', ''),
('sub_module', 'site_lang.php', ''),
('controller_name', 'site_lang.php', ''),
('module_name', 'site_lang.php', ''),
('fa_icon', 'site_lang.php', ''),
('module_list', 'site_lang.php', ''),
('sort_order', 'site_lang.php', ''),
('add_module', 'site_lang.php', ''),
('update_module', 'site_lang.php', ''),
('lang_index_message', 'site_lang.php', ''),
('admin_role', 'site_lang.php', ''),
('permission', 'site_lang.php', ''),
('add_new_role', 'site_lang.php', ''),
('back', 'site_lang.php', ''),
('edit_role', 'site_lang.php', ''),
('admin_permissions', 'site_lang.php', ''),
('permission_access', 'site_lang.php', ''),
('created_date', 'site_lang.php', ''),
('email_verification', 'site_lang.php', ''),
('add_user', 'site_lang.php', ''),
('address', 'site_lang.php', ''),
('edit_user', 'site_lang.php', ''),
('update_user', 'site_lang.php', ''),
('users_activity_log', 'site_lang.php', ''),
('activity', 'site_lang.php', ''),
('date', 'site_lang.php', ''),
('time', 'site_lang.php', ''),
('general_setting', 'site_lang.php', ''),
('email_setting', 'site_lang.php', ''),
('google_setting', 'site_lang.php', ''),
('favicon', 'site_lang.php', ''),
('logo', 'site_lang.php', ''),
('application_name', 'site_lang.php', ''),
('allowed_types', 'site_lang.php', ''),
('timezone', 'site_lang.php', ''),
('default_language', 'site_lang.php', ''),
('currency', 'site_lang.php', ''),
('copyright', 'site_lang.php', ''),
('save_changes', 'site_lang.php', ''),
('email_from', 'site_lang.php', ''),
('smtp_host', 'site_lang.php', ''),
('smtp_port', 'site_lang.php', ''),
('smtp_user', 'site_lang.php', ''),
('smtp_password', 'site_lang.php', ''),
('site_key', 'site_lang.php', ''),
('secret_key', 'site_lang.php', ''),
('language', 'site_lang.php', ''),
('email_templates', 'site_lang.php', ''),
('select_a_template', 'site_lang.php', ''),
('preview', 'site_lang.php', ''),
('variables', 'site_lang.php', ''),
('title', 'site_lang.php', ''),
('area_chart', 'site_lang.php', ''),
('donut_chart', 'site_lang.php', ''),
('line_chart', 'site_lang.php', ''),
('bar_chart', 'site_lang.php', ''),
('users_area_chart', 'site_lang.php', ''),
('payment_line_chart', 'site_lang.php', ''),
('admin_donut_chart', 'site_lang.php', ''),
('payment_bar_chart', 'site_lang.php', ''),
('simple_table_example', 'site_lang.php', ''),
('datatable_example', 'site_lang.php', ''),
('pagination_example', 'site_lang.php', ''),
('advance_search_example', 'site_lang.php', ''),
('file_upload_example', 'site_lang.php', ''),
('multiple_file_upload_example', 'site_lang.php', ''),
('export_as_pdf', 'site_lang.php', ''),
('export_as_csv', 'site_lang.php', ''),
('max_allowed_size', 'site_lang.php', ''),
('max_files', 'site_lang.php', ''),
('multiple_files_uploader', 'site_lang.php', ''),
('dynamic_charts', 'site_lang.php', ''),
('database_backup', 'site_lang.php', ''),
('download_and_create_backup', 'site_lang.php', ''),
('client', 'site_lang.php', ''),
('amount', 'site_lang.php', ''),
('due_date', 'site_lang.php', ''),
('bill_from', 'site_lang.php', ''),
('bill_to', 'site_lang.php', ''),
('company_name', 'site_lang.php', ''),
('address_line', 'site_lang.php', ''),
('customer', 'site_lang.php', ''),
('billing_date', 'site_lang.php', ''),
('product', 'site_lang.php', ''),
('quantity', 'site_lang.php', ''),
('price', 'site_lang.php', ''),
('tax', 'site_lang.php', ''),
('total', 'site_lang.php', ''),
('subtotal', 'site_lang.php', ''),
('discount', 'site_lang.php', ''),
('client_note', 'site_lang.php', ''),
('terms_and_conditions', 'site_lang.php', ''),
('edit_invoice', 'site_lang.php', ''),
('download', 'site_lang.php', ''),
('send_email', 'site_lang.php', ''),
('nas_devices', 'site_lang.php', ''),
('nas_list', 'site_lang.php', ''),
('name', 'site_lang.php', ''),
('ip_address', 'site_lang.php', ''),
('identifier', 'site_lang.php', ''),
('add_new_nas', 'site_lang.php', ''),
('edit_nas', 'site_lang.php', ''),
('update_nas', 'site_lang.php', ''),
('ip_pool', 'site_lang.php', ''),
('dashboard_test', 'site_lang.php', ''),
('social_setting', 'site_lang.php', ''),
('company_setting', 'site_lang.php', ''),
('use_google_font', 'site_lang.php', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_module`
--

CREATE TABLE `ci_module` (
                             `module_id` int(11) NOT NULL,
                             `module_name` varchar(255) NOT NULL,
                             `controller_name` varchar(255) NOT NULL,
                             `fa_icon` varchar(100) NOT NULL,
                             `operation` text NOT NULL,
                             `sort_order` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_module`
--

INSERT INTO `ci_module` (`module_id`, `module_name`, `controller_name`, `fa_icon`, `operation`, `sort_order`) VALUES
(1, 'admin', 'admin', 'fad fa-chart-pie', 'view|add|edit|delete|change_status|access', 3),
(2, 'role_and_permissions', 'admin_roles', 'fad fa-book-user', 'view|add|edit|delete|change_status|access', 4),
(3, 'users', 'users', 'fad fa-users', 'view|add|edit|delete|change_status|access', 4),
(7, 'backup_and_export', 'export', 'fad fa-database', 'access', 12),
(8, 'settings', 'general_settings', 'fad fa-cogs', 'view|add|edit|access', 13),
(9, 'dashboard', 'dashboard', 'fad fa-tachometer-alt', 'view|index_2|index_3|access', 1),
(10, 'codeigniter_examples', 'example', 'fad fa-snowflake', 'access', 6),
(11, 'invoicing_system', 'invoices', 'fad fa-file-invoice-dollar', 'access', 9),
(12, 'database_joins_example', 'joins', 'fad fa-external-link-square', 'access', 7),
(13, 'language_setting', 'languages', 'fad fa-language', 'access|add', 14),
(14, 'locations', 'location', 'fad fa-map-pin', 'access', 11),
(15, 'widgets', 'widgets', 'fad fa-th', 'access', 19),
(16, 'charts', 'charts', 'fad fa-chart-line', 'access', 17),
(17, 'ui_elements', 'ui', 'fad fa-tree', 'access', 18),
(18, 'forms', 'forms', 'fad fa-edit', 'access', 20),
(19, 'tables', 'tables', 'fad fa-table', 'access', 21),
(21, 'mailbox', 'mailbox', 'fad fa-envelope-open', 'access', 23),
(22, 'pages', 'pages', 'fad fa-book', 'access', 24),
(23, 'extras', 'extras', 'fad fa-plus-square', 'access', 25),
(25, 'profile', 'profile', 'fad fa-user', 'access', 20),
(26, 'activity_log', 'activity', 'fad fa-flag-alt', 'access', 11),
(27, 'nas_devices', 'nas', 'fad fa-server', 'access|add|delete', 2),
(28, 'ip_pool', 'ip_pool', 'fad fa-dice-d12', 'access|add|edit|view|delete', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ci_module_access`
--

CREATE TABLE `ci_module_access` (
                                    `id` int(11) NOT NULL,
                                    `admin_role_id` int(11) NOT NULL,
                                    `module` varchar(255) NOT NULL,
                                    `operation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_module_access`
--

INSERT INTO `ci_module_access` (`id`, `admin_role_id`, `module`, `operation`) VALUES
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
(84, 1, 'pages', 'access'),
(85, 1, 'users', 'delete'),
(91, 1, 'languages', 'add'),
(95, 2, 'nas', 'access'),
(96, 2, 'profile', 'access'),
(100, 1, 'nas', 'access'),
(102, 1, 'nas', 'add'),
(103, 1, 'nas', 'delete'),
(104, 1, 'ip_pool', 'add'),
(105, 1, 'extras', 'access');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sub_module`
--

CREATE TABLE `ci_sub_module` (
                                 `id` int(11) NOT NULL,
                                 `parent` int(11) NOT NULL,
                                 `name` varchar(255) NOT NULL,
                                 `link` varchar(255) NOT NULL,
                                 `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sub_module`
--

INSERT INTO `ci_sub_module` (`id`, `parent`, `name`, `link`, `sort_order`) VALUES
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
(73, 10, 'locations', 'locations', 8),
(76, 9, 'dashboard_test', 'index_1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ci_uploaded_files`
--

CREATE TABLE `ci_uploaded_files` (
                                     `id` int(11) NOT NULL,
                                     `name` varchar(225) NOT NULL,
                                     `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `link_radippool_ppp_accounts`
--

CREATE TABLE `link_radippool_ppp_accounts` (
                                               `id` int(11) NOT NULL,
                                               `ippool_id` int(11) DEFAULT NULL,
                                               `ppp_id` int(11) DEFAULT NULL,
                                               `type` enum('static','dynamic','','') NOT NULL DEFAULT 'dynamic',
                                               `start_date` datetime NOT NULL DEFAULT current_timestamp(),
                                               `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `link_users_ppp_accounts`
--

CREATE TABLE `link_users_ppp_accounts` (
                                           `id` int(11) NOT NULL,
                                           `user_id` int(11) DEFAULT NULL,
                                           `ppp_id` int(11) DEFAULT NULL,
                                           `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
                                           `start_date` datetime DEFAULT current_timestamp(),
                                           `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ppp_accounts`
--

CREATE TABLE `ppp_accounts` (
                                `id` int(11) NOT NULL,
                                `profileid` int(11) DEFAULT NULL,
                                `username` varchar(128) NOT NULL,
                                `password` varchar(128) NOT NULL,
                                `staticip` varchar(24) DEFAULT NULL,
                                `startdate` datetime DEFAULT NULL,
                                `enddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ppp_accounts`
--

INSERT INTO `ppp_accounts` (`id`, `profileid`, `username`, `password`, `staticip`, `startdate`, `enddate`) VALUES
(1, NULL, 'test@test', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ppp_accounts_stats`
--

CREATE TABLE `ppp_accounts_stats` (
                                      `id` int(11) NOT NULL,
                                      `radacct_id` int(11) NOT NULL,
                                      `username` varchar(64) NOT NULL DEFAULT '',
                                      `realmid` int(11) DEFAULT NULL,
                                      `nasipaddress` varchar(15) NOT NULL DEFAULT '',
                                      `nasidentifier` varchar(64) DEFAULT NULL,
                                      `framedipaddress` varchar(15) NOT NULL DEFAULT '',
                                      `calledstationid` varchar(64) DEFAULT NULL,
                                      `callingstationid` varchar(50) NOT NULL DEFAULT '',
                                      `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                      `acctinputoctets` bigint(20) NOT NULL,
                                      `acctoutputoctets` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `radacct`
--
DELIMITER $$
CREATE TRIGGER `radacct_after_update_add_ppp_accounts_stats` AFTER UPDATE ON `radacct` FOR EACH ROW BEGIN
    INSERT INTO ppp_accounts_stats
    SET
        radacct_id        = OLD.radacctid,
        username          = OLD.username,
        realmid           = OLD.realm,
        nasipaddress      = OLD.nasipaddress,
        framedipaddress   = OLD.framedipaddress,
        callingstationid  = OLD.callingstationid,
        acctinputoctets   = (NEW.acctinputoctets - OLD.acctinputoctets),
        acctoutputoctets  = (NEW.acctoutputoctets - OLD.acctoutputoctets);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `radacct_before_insert_check_username_exists` BEFORE INSERT ON `radacct` FOR EACH ROW BEGIN
    IF NEW.username NOT IN (
        SELECT A.username
        FROM ppp_accounts A
        WHERE (NEW.username = A.username)
    ) THEN
        CALL `Insert not allowed`;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `radacct_clean_string` BEFORE INSERT ON `radacct` FOR EACH ROW BEGIN
    SET NEW.nasportid = REPLACE(NEW.nasportid, "=3D28", "[");
    SET NEW.nasportid = REPLACE(NEW.nasportid, "=3D29", "]");
END
$$
DELIMITER ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `raddictionary`
--

CREATE TABLE `raddictionary` (
                                 `id` int(10) NOT NULL,
                                 `type` varchar(30) DEFAULT NULL,
                                 `attribute` varchar(64) DEFAULT NULL,
                                 `value` varchar(64) DEFAULT NULL,
                                 `format` varchar(20) DEFAULT NULL,
                                 `vendor` varchar(32) DEFAULT NULL,
                                 `recommended_op` varchar(32) DEFAULT NULL,
                                 `recommended_table` varchar(32) DEFAULT NULL,
                                 `recommended_helper` varchar(32) DEFAULT NULL,
                                 `recommended_tooltip` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `radippool`
--
DELIMITER $$
CREATE TRIGGER `link_radippool_ppp_accounts` AFTER UPDATE ON `radippool` FOR EACH ROW BEGIN
    DECLARE type VARCHAR(10);

/* CHECK TYPE */
    IF (NEW.pool_key IS NULL OR NEW.pool_key = '') THEN
        SET type = 'static';
    ELSE
        SET type = 'dynamic';
    END IF;

    IF (SELECT count(*) FROM link_radippool_ppp_accounts WHERE link_radippool_ppp_accounts.ippool_id= OLD.id AND link_radippool_ppp_accounts.end_date IS NULL) = 1
    THEN
        UPDATE link_radippool_ppp_accounts SET link_radippool_ppp_accounts.end_date= CURRENT_TIMESTAMP WHERE link_radippool_ppp_accounts.ippool_id=OLD.id;
        /*ELSE
        INSERT INTO tbl2 (stn) VALUES (NEW.stn);*/
    END IF;


    /* UPDATE RECORD IF EXISTS
    UPDATE link_users_ppp_accounts
        SET link_radippool_ppp_accounts.end_date = CURRENT_TIMESTAMP
        WHERE link_radippool_ppp_accounts.ippool_id = OLD.id AND link_radippool_ppp_accounts.end_date IS NULL;*/

/* INSERT NEW RECORD */
    IF (SELECT A.id FROM ppp_accounts A WHERE (NEW.username = A.username)) IS NOT NULL THEN
        INSERT INTO link_radippool_ppp_accounts
        SET
            link_radippool_ppp_accounts.ippool_id = OLD.id,
            link_radippool_ppp_accounts.ppp_id = (SELECT A.id
                                                  FROM ppp_accounts A
                                                  WHERE (NEW.username = A.username)),
            link_radippool_ppp_accounts.type = type;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `radnas`
--

CREATE TABLE `radnas` (
                          `id` int(10) NOT NULL,
                          `nasname` varchar(128) DEFAULT NULL,
                          `shortname` varchar(32) DEFAULT NULL,
                          `nasidentifier` varchar(64) DEFAULT NULL,
                          `type` varchar(30) DEFAULT 'other',
                          `ports` int(5) DEFAULT 3799,
                          `secret` varchar(60) NOT NULL DEFAULT 'secret',
                          `server` varchar(64) DEFAULT NULL,
                          `community` varchar(50) DEFAULT NULL,
                          `description` varchar(200) DEFAULT 'RADIUS Client',
                          `connection_type` enum('direct','openvpn','pptp','dynamic') NOT NULL DEFAULT 'direct',
                          `record_auth` tinyint(1) NOT NULL DEFAULT 0,
                          `ignore_acct` tinyint(1) NOT NULL DEFAULT 0,
                          `monitor` tinyint(1) NOT NULL DEFAULT 0,
                          `last_contact` datetime DEFAULT NULL,
                          `session_auto_close` tinyint(1) NOT NULL DEFAULT 0,
                          `session_dead_time` int(5) NOT NULL DEFAULT 3600,
                          `on_public_maps` tinyint(1) NOT NULL DEFAULT 0,
                          `lat` double DEFAULT NULL,
                          `lon` double DEFAULT NULL,
                          `photo_file_name` varchar(128) DEFAULT NULL,
                          `user_id` int(11) DEFAULT NULL,
                          `created` datetime DEFAULT NULL,
                          `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `radnas_pool_names`
--

CREATE TABLE `radnas_pool_names` (
                                     `id` int(11) UNSIGNED NOT NULL,
                                     `nas_ip_address` varchar(128) NOT NULL DEFAULT '',
                                     `pool_name` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

CREATE TABLE `radpostauth` (
                               `id` int(11) NOT NULL,
                               `username` varchar(64) NOT NULL DEFAULT '',
                               `pass` varchar(64) NOT NULL DEFAULT '',
                               `reply` varchar(32) NOT NULL DEFAULT '',
                               `reply_msg` varchar(256) DEFAULT NULL,
                               `authdate` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
                               `nasipaddress` varchar(100) DEFAULT NULL,
                               `callingstationid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

CREATE TABLE `radusergroup` (
                                `id` int(11) UNSIGNED NOT NULL,
                                `username` varchar(64) NOT NULL DEFAULT '',
                                `groupname` varchar(64) NOT NULL DEFAULT '',
                                `priority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indexes for table `ci_module`
--
ALTER TABLE `ci_module`
    ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `ci_module_access`
--
ALTER TABLE `ci_module_access`
    ADD PRIMARY KEY (`id`),
    ADD KEY `RoleId` (`admin_role_id`);

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
-- Indexes for table `ci_sub_module`
--
ALTER TABLE `ci_sub_module`
    ADD PRIMARY KEY (`id`),
    ADD KEY `Parent Module ID` (`parent`);

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
-- Indexes for table `link_radippool_ppp_accounts`
--
ALTER TABLE `link_radippool_ppp_accounts`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_users_ppp_accounts`
--
ALTER TABLE `link_users_ppp_accounts`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppp_accounts`
--
ALTER TABLE `ppp_accounts`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppp_accounts_stats`
--
ALTER TABLE `ppp_accounts_stats`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_stats_index` (`radacct_id`,`username`,`realmid`,`nasipaddress`,`nasidentifier`,`callingstationid`);

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
-- Indexes for table `raddictionary`
--
ALTER TABLE `raddictionary`
    ADD PRIMARY KEY (`id`);

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
-- Indexes for table `radnas`
--
ALTER TABLE `radnas`
    ADD PRIMARY KEY (`id`),
    ADD KEY `nasname` (`nasname`);

--
-- Indexes for table `radnas_pool_names`
--
ALTER TABLE `radnas_pool_names`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `nas_ip_address_pool_name` (`nas_ip_address`,`pool_name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_activity_log`
--
ALTER TABLE `ci_activity_log`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_companies`
--
ALTER TABLE `ci_companies`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ci_countries`
--
ALTER TABLE `ci_countries`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
    MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ci_module_access`
--
ALTER TABLE `ci_module_access`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `ci_payments`
--
ALTER TABLE `ci_payments`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_states`
--
ALTER TABLE `ci_states`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_sub_module`
--
ALTER TABLE `ci_sub_module`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `ci_uploaded_files`
--
ALTER TABLE `ci_uploaded_files`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `ci_users`
--
ALTER TABLE `ci_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `link_radippool_ppp_accounts`
--
ALTER TABLE `link_radippool_ppp_accounts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `link_users_ppp_accounts`
--
ALTER TABLE `link_users_ppp_accounts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppp_accounts`
--
ALTER TABLE `ppp_accounts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppp_accounts_stats`
--
ALTER TABLE `ppp_accounts_stats`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `raddictionary`
--
ALTER TABLE `raddictionary`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;

--
-- AUTO_INCREMENT for table `radnas`
--
ALTER TABLE `radnas`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `radnas_pool_names`
--
ALTER TABLE `radnas_pool_names`
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
-- Constraints for dumped tables
--

--
-- Constraints for table `radnas_pool_names`
--
ALTER TABLE `radnas_pool_names`
    ADD CONSTRAINT `radnas_pool_names_ibfk_1` FOREIGN KEY (`nas_ip_address`) REFERENCES `radnas` (`nasname`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
