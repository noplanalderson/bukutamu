-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2022 at 03:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bukutamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_app_setting`
--

CREATE TABLE `tb_app_setting` (
  `app_id` int(1) UNSIGNED NOT NULL,
  `app_title` char(100) NOT NULL,
  `app_footer` char(150) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_logo_dashboard` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_app_setting`
--

INSERT INTO `tb_app_setting` (`app_id`, `app_title`, `app_footer`, `app_logo`, `app_logo_dashboard`) VALUES
(1, 'Buku Tamu DC', 'Bidang TIK - Dinas Komunikasi dan Informatika Kota Tangerang', 'bukutamu_logo_vfxudL4XDj43Y5HoXHAkbg_rCJyswtS_3452_693741250_7aOGuI_1642322360.webp', 'bukutamu_logo_dashboard_0PwPrVqwAG4cW7u6U2A_UkwEQInm_1946_723109865_GAO8pB_1642322360.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_sistem`
--

CREATE TABLE `tb_log_sistem` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `log_type` enum('info','warning') NOT NULL DEFAULT 'info',
  `log_timestamp` datetime NOT NULL,
  `log_message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_tamu`
--

CREATE TABLE `tb_log_tamu` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `visitor_hash` varchar(255) NOT NULL,
  `time_in` int(11) NOT NULL,
  `time_out` int(11) DEFAULT NULL,
  `nama_tamu` char(150) NOT NULL,
  `nomor_telepon` char(16) NOT NULL,
  `organisasi` char(255) NOT NULL,
  `keperluan` varchar(512) NOT NULL,
  `token_tamu` int(6) UNSIGNED DEFAULT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_menus`
--

CREATE TABLE `tb_menus` (
  `menu_id` int(10) UNSIGNED NOT NULL,
  `menu_parent` int(11) DEFAULT NULL,
  `menu_label` char(255) NOT NULL,
  `menu_link` char(255) NOT NULL,
  `menu_icon` char(100) NOT NULL,
  `menu_location` enum('mainmenu','submenu','content') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_menus`
--

INSERT INTO `tb_menus` (`menu_id`, `menu_parent`, `menu_label`, `menu_link`, `menu_icon`, `menu_location`) VALUES
(1, NULL, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 'mainmenu'),
(2, NULL, 'Manajemen Akses', 'manajemen-akses', 'fas fa-key', 'mainmenu'),
(3, 2, 'Tambah Akses', 'tambah-akses', 'fas fa-plus-square', 'content'),
(4, 2, 'Ubah Akses', 'ubah-akses', 'fas fa-edit', 'content'),
(5, 2, 'Hapus Akses', 'hapus-akses', 'fas fa-trash-alt', 'content'),
(6, NULL, 'Manajemen User', 'manajemen-user', 'fas fa-users-cog', 'mainmenu'),
(7, 6, 'Tambah User', 'tambah-user', 'fas fa-user-plus', 'content'),
(8, 6, 'Ubah User', 'ubah-user', 'fas fa-user-edit', 'content'),
(9, 6, 'Hapus User', 'hapus-user', 'fas fa-trash-alt', 'content'),
(10, NULL, 'Utilitas', '#utilitas', 'fas fa-tools', 'mainmenu'),
(11, 10, 'Log Sistem', 'log-sistem', 'fas fa-file-medical-alt', 'submenu'),
(12, 10, 'Pengaturan SMTP', 'pengaturan-smtp', 'fab fa-telegram-plane', 'submenu'),
(13, 10, 'Pengaturan Aplikasi', 'pengaturan-aplikasi', 'fas fa-cogs', 'submenu'),
(14, NULL, 'Data Tamu', 'data-tamu', 'fas fa-address-book', 'mainmenu'),
(15, 15, 'Detail Tamu', 'detail-tamu', 'fas fa-eye', 'content');

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`role_id`, `type_id`, `menu_id`) VALUES
(42, 1, 1),
(43, 1, 14),
(44, 1, 15),
(45, 1, 5),
(46, 1, 9),
(47, 1, 11),
(48, 1, 2),
(49, 1, 6),
(50, 1, 13),
(51, 1, 12),
(52, 1, 3),
(53, 1, 7),
(54, 1, 4),
(55, 1, 8),
(56, 1, 10),
(62, 2, 1),
(63, 2, 14),
(64, 2, 15),
(65, 2, 11),
(66, 2, 12),
(67, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `real_name` char(150) NOT NULL,
  `user_name` char(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` char(150) NOT NULL,
  `user_token` int(6) UNSIGNED DEFAULT NULL,
  `user_picture` varchar(255) NOT NULL,
  `last_login` int(10) UNSIGNED DEFAULT NULL,
  `last_ip` varbinary(16) DEFAULT NULL,
  `subscribe_notif` tinyint(1) DEFAULT 0,
  `user_status` enum('enable','disable') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `type_id`, `real_name`, `user_name`, `user_password`, `user_email`, `user_token`, `user_picture`, `last_login`, `last_ip`, `subscribe_notif`, `user_status`) VALUES
(1, 1, 'Administrator', 'admin', '$argon2id$v=19$m=2048,t=4,p=1$aUNnUzZiZmR3bXplQ1lBSQ$zdYjU+3rF/PjOr5Zun7i3Asws9q03qylUh7Rf5zictI', 'admin@somewhere.com', NULL, 'user.jpg', NULL, NULL, 0, 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_type`
--

CREATE TABLE `tb_user_type` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `type_name` char(100) NOT NULL,
  `index_page` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_type`
--

INSERT INTO `tb_user_type` (`type_id`, `type_name`, `index_page`) VALUES
(1, 'admin', 'manajemen-akses'),
(2, 'user', 'dashboard');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_app_setting`
--
ALTER TABLE `tb_app_setting`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `tb_log_sistem`
--
ALTER TABLE `tb_log_sistem`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_log_tamu`
--
ALTER TABLE `tb_log_tamu`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `visitor_hash` (`visitor_hash`);

--
-- Indexes for table `tb_menus`
--
ALTER TABLE `tb_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `tb_user_type`
--
ALTER TABLE `tb_user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_app_setting`
--
ALTER TABLE `tb_app_setting`
  MODIFY `app_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_log_sistem`
--
ALTER TABLE `tb_log_sistem`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_log_tamu`
--
ALTER TABLE `tb_log_tamu`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_menus`
--
ALTER TABLE `tb_menus`
  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user_type`
--
ALTER TABLE `tb_user_type`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD CONSTRAINT `tb_roles_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tb_user_type` (`type_id`),
  ADD CONSTRAINT `tb_roles_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `tb_menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tb_user_type` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
