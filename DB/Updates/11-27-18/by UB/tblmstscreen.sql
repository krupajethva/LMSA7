-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2018 at 07:10 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblmstscreen`
--

CREATE TABLE `tblmstscreen` (
  `ScreenId` int(11) NOT NULL,
  `InvitedByUserId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `Url` varchar(100) NOT NULL,
  `Icon` varchar(100) NOT NULL,
  `SerialNo` int(2) NOT NULL,
  `SelectedClass` varchar(100) DEFAULT NULL,
  `InMenu` bit(1) NOT NULL,
  `IsActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmstscreen`
--

INSERT INTO `tblmstscreen` (`ScreenId`, `InvitedByUserId`, `Name`, `DisplayName`, `Url`, `Icon`, `SerialNo`, `SelectedClass`, `InMenu`, `IsActive`) VALUES
(1, 0, 'General', 'General', '', 'fa fa-users', 1, 'general', b'0', b'1'),
(2, 1, 'Dashboard', 'Dashboard', '/admin/dashboard', 'fa fa-tachometer', 1, 'dashboard', b'1', b'1'),
(3, 1, 'Calendar', 'Calendar', '/admin/calendar', 'fa fa-calendar', 2, 'calendar', b'1', b'1'),
(4, 0, 'Manage', 'Manage', '', '', 2, 'manage', b'0', b'1'),
(5, 4, 'Users', 'Users', '/admin/user-list', 'fa fa-users', 1, 'users', b'1', b'1'),
(6, 4, 'Courses', 'Courses', '', 'fa fa-book', 2, 'courses', b'0', b'1'),
(7, 6, 'View', 'View', '/admin/Courselist', 'fa fa-list', 1, 'view', b'1', b'1'),
(8, 6, 'Add', 'Add', '/admin/Course', 'fa fa-plus', 2, 'add', b'1', b'1'),
(9, 4, 'Categories', 'Categories', '', 'fa fa-sitemap', 3, 'categories', b'0', b'1'),
(10, 9, 'View', 'View', '/admin/Categorylist', 'fa fa-list', 1, 'view', b'1', b'1'),
(11, 9, 'Add', 'Add', '/admin/Category', 'fa fa-plus', 2, 'add', b'1', b'1'),
(12, 4, 'Certificate', 'Certificate', '', 'fa fa-certificate', 4, 'certificatetemplate', b'0', b'1'),
(13, 12, 'View', 'View', '/admin/certificatetemplatelist', 'fa fa-list', 1, 'view', b'1', b'1'),
(14, 12, 'Add', 'Add', '/admin/certificatetemplate', 'fa fa-plus', 2, 'add', b'1', b'1'),
(15, 4, 'Country', 'Country', '', 'fa fa-globe', 5, 'country', b'0', b'1'),
(16, 15, 'View', 'View', '/admin/country-list', 'fa fa-list', 1, 'view', b'1', b'1'),
(17, 15, 'Add', 'Add', '/admin/country', 'fa fa-plus', 2, 'add', b'1', b'1'),
(18, 4, 'State', 'State', '', 'fa fa-globe', 6, 'state', b'0', b'1'),
(19, 18, 'View', 'View', '/admin/state-list', 'fa fa-list', 1, 'view', b'1', b'1'),
(20, 18, 'Add', 'Add', '/admin/state', 'fa fa-plus', 2, 'add', b'1', b'1'),
(21, 4, 'Configuration', 'Configuration', '', 'fa fa-cogs', 7, 'configuration', b'0', b'1'),
(22, 21, 'Role Permission', 'Role Permission', '/admin/rolepermission', 'fa fa-users', 1, 'rolepermission', b'1', b'1'),
(23, 21, 'Settings', 'Settings', '/admin/settings', 'fa fa-cog', 2, 'settings', b'1', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmstscreen`
--
ALTER TABLE `tblmstscreen`
  ADD PRIMARY KEY (`ScreenId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblmstscreen`
--
ALTER TABLE `tblmstscreen`
  MODIFY `ScreenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
