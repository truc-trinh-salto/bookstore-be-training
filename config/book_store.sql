-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2024 at 01:53 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` text,
  `description` text COMMENT 'Content of the post',
  `category_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sale` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `hotItem` tinyint(1) DEFAULT NULL,
  `authors` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `image`, `description`, `category_id`, `price`, `created_at`, `updated_at`, `sale`, `stock`, `hotItem`, `authors`) VALUES
(1, 'Sách 1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxbAY61EBioG2gt4PJLN6Hy-Xx1YbUc-_KKQ&s', 'Nội dung sách 1', 1, 45000, '2024-09-02 08:42:22', '2024-08-05 08:35:27', 10, 499, 1, 'David'),
(2, 'Sách 2', 'data:image/jpeg;base64,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', 'Nội dung sách 2', 2, 60000, '2024-09-02 08:42:22', '2024-08-07 06:39:53', NULL, 120, 1, 'Robert'),
(3, 'Sách 3', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8rI_tn3BpM-qwJC7iEu1ntsQtAN4ZDteE4g&s', 'Nội dung sách 3', 1, 65000, '2024-09-02 08:42:22', '2024-08-07 06:40:07', NULL, 998, 1, 'Jennie'),
(4, 'Sách 4', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEOFsRCF8BgL8J_OQDsqiltHAiRF-9QVoMKA&s', 'Nội dung sách 4', 2, 89000, '2024-08-15 03:32:24', '2024-08-07 06:40:30', NULL, 599, 1, 'Daniel'),
(5, 'Sách 5', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-UTDgX_RA934tszuSugPBiaGcpJc8ycN0hQ&s', 'Nội dung sách 5', 3, 76000, '2024-08-15 03:32:24', '2024-08-07 06:40:53', NULL, 769, 1, 'Joe'),
(6, 'Sách 6', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSds95BsInWXGyDNJAKrlY64SBgYloSS9JtuA&s', 'Nội dung sách 6', 3, 52000, '2024-08-15 03:25:24', '2024-08-07 06:41:08', NULL, 423, 1, 'Daivd'),
(7, 'Sách 7', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 194915, '2024-08-15 03:32:24', NULL, NULL, 259, 0, 'Joe'),
(8, 'Sách 8', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8jzZpd3GS1estVt_FsMl7Y-uS92IgZpgM7A&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 86977, '2024-08-15 03:25:24', '2024-08-07 06:41:33', NULL, 545, 1, 'Alice'),
(9, 'Sách 9', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa3Pf-3DqBsYElBHqhvgU5kw5QAzpf6a9v8g&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 103080, '2024-08-28 06:18:31', '2024-08-07 06:41:48', NULL, 412, 1, 'Jane'),
(10, 'Sách 10', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlZWkMafJbmgP1pAxgU_D8yS8oPXEkQ4WHFg&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 111679, '2024-08-15 03:32:24', '2024-08-07 06:42:03', NULL, 140, 1, 'David'),
(11, 'Sách 11', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHowXzy0YyXPmc6BebP7OeTPcNbcSLqWz52A&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 132623, '2024-08-15 03:25:24', '2024-08-07 06:42:17', NULL, 114, 1, ''),
(12, 'Sách 12', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSx4ONp_TLFBtxBvGsPl3Ny-r3l-EYkYjB6pQ&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 88465, '2024-08-15 03:25:24', '2024-08-07 06:42:28', NULL, 128, 1, 'Bob'),
(13, 'Sách 13', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEAACQRlbcHQ1TlF98P6de-8MY7tC1ZqQFGQ&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 123195, '2024-08-15 03:25:24', '2024-08-07 06:42:38', NULL, 113, 1, 'Eve'),
(14, 'Sách 13', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 60548, '2024-08-15 03:25:24', NULL, NULL, 303, 1, 'Alice'),
(15, 'Sách 14', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 125165, '2024-08-15 03:32:24', NULL, NULL, 652, 0, 'Alice'),
(16, 'Sách 15', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 142196, '2024-08-15 03:25:24', NULL, NULL, 929, 0, 'Bob'),
(17, 'Sách 16', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 130791, '2024-08-15 03:25:24', NULL, NULL, 142, 0, 'Eve'),
(18, 'Sách 17', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 185968, '2024-08-15 03:25:24', NULL, NULL, 557, 1, 'Jane'),
(19, 'Sách 18', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 77773, '2024-08-15 03:25:24', NULL, NULL, 197, 0, 'Jane'),
(20, 'Sách 19', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 71560, '2024-08-15 03:32:24', NULL, NULL, 400, 0, 'Eve'),
(21, 'Sách 20', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 140229, '2024-08-15 03:25:24', NULL, NULL, 784, 1, 'Eve'),
(22, 'Sách 21', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 94529, '2024-08-15 03:25:24', NULL, NULL, 971, 0, 'David'),
(23, 'Sách 22', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 140450, '2024-08-15 03:25:24', NULL, NULL, 356, 1, 'Eve'),
(24, 'Sách 23', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 139072, '2024-08-15 03:25:24', NULL, NULL, 112, 1, 'Bob'),
(25, 'Sách 24', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 196074, '2024-08-15 03:32:24', NULL, NULL, 603, 1, 'David'),
(26, 'Sách 25', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 176390, '2024-08-15 03:25:24', NULL, NULL, 336, 0, 'David'),
(27, 'Sách 26', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 193264, '2024-09-02 08:42:22', NULL, NULL, 170, 1, 'Charlie'),
(28, 'Sách 27', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 54578, '2024-08-15 03:25:24', NULL, NULL, 469, 0, 'Bob'),
(29, 'Sách 28', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 147400, '2024-08-15 03:25:24', NULL, NULL, 398, 0, 'Alice'),
(30, 'Sách 29', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 109503, '2024-08-15 03:32:24', NULL, NULL, 874, 1, 'Eve'),
(31, 'Sách 30', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 53053, '2024-08-15 03:25:24', NULL, NULL, 707, 1, 'David'),
(32, 'Sách 31', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 52250, '2024-08-15 03:25:24', NULL, NULL, 323, 0, 'Charlie'),
(33, 'Sách 32', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 53517, '2024-08-15 03:25:24', NULL, NULL, 642, 1, 'Jane'),
(34, 'Sách 33', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 51120, '2024-08-15 03:32:24', NULL, NULL, 713, 0, 'Bob'),
(35, 'Sách 34', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 85822, '2024-08-15 03:32:24', NULL, NULL, 199, 0, 'David'),
(36, 'Sách 35', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 157460, '2024-08-15 03:32:24', NULL, NULL, 230, 0, 'David'),
(37, 'Sách 36', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 194288, '2024-08-15 03:25:24', NULL, NULL, 138, 0, 'Alice'),
(38, 'Sách 37', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 191436, '2024-09-02 08:42:22', NULL, NULL, 716, 1, 'Bob'),
(39, 'Sách 38', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 55729, '2024-08-15 03:25:24', NULL, NULL, 989, 0, 'David'),
(40, 'Sách 39', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 70411, '2024-08-15 03:25:24', NULL, NULL, 863, 1, 'David'),
(41, 'Sách 40', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 158123, '2024-08-15 03:25:24', NULL, NULL, 344, 0, 'David'),
(42, 'Sách 41', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 53000, '2024-08-15 03:25:24', NULL, NULL, 280, 1, 'Bob'),
(43, 'Sách 42', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 78819, '2024-08-15 03:25:24', NULL, NULL, 181, 0, 'Alice'),
(44, 'Sách 43', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 71840, '2024-08-15 03:25:24', NULL, NULL, 185, 0, 'Jane'),
(45, 'Sách 44', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 136711, '2024-08-15 03:25:24', NULL, NULL, 381, 0, 'Bob'),
(46, 'Sách 45', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 92538, '2024-08-15 03:25:24', NULL, NULL, 347, 0, 'Charlie'),
(47, 'Sách 46', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 159561, '2024-08-15 03:25:24', NULL, NULL, 304, 1, 'Alice'),
(48, 'Sách 47', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 169283, '2024-08-21 06:48:49', '2024-08-21 06:48:49', 30, 392, 0, 'Charlie'),
(49, 'Sách 48', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 116276, '2024-08-21 06:48:49', '2024-08-21 06:48:49', 25, 807, 0, 'Jane'),
(50, 'Sách 49', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 194604, '2024-08-21 06:48:49', '2024-08-21 06:48:49', 20, 499, 0, 'David'),
(54, 'TEST', '2', 'TEST', 1, 100000, '2024-08-14 04:33:50', '2024-08-14 04:33:50', NULL, 1000, 1, 'TEST'),
(4234, 'Cách giao tiếp', NULL, 'Nói về cách giao tiếp', 6, 45000.5, '2024-08-20 04:15:34', '2024-08-20 04:15:34', 0, 0, 0, 'John'),
(4235, 'Naruto', NULL, 'Chap 430', 11, 42000, '2024-08-20 04:15:34', '2024-08-20 04:15:34', 0, 200, 0, 'TEST'),
(4236, 'Cách giao tiếp 1', NULL, 'Nói về cách giao tiếp', 6, 45000.5, '2024-08-21 04:38:47', '2024-08-21 04:38:47', 0, 50, 0, 'John'),
(4237, 'Naruto 2', NULL, 'Chap 430', 11, 42000, '2024-08-21 04:38:47', '2024-08-21 04:38:47', 0, 150, 0, 'TEST'),
(4238, 'Cách giao tiếp 3', NULL, 'Nói về cách giao tiếp', 6, 45000.5, '2024-08-21 04:39:40', NULL, NULL, 100, 0, 'John'),
(4239, 'Naruto 3', NULL, 'Chap 430', 11, 42000, '2024-08-21 07:28:14', '2024-08-21 07:28:14', 9, 200, 1, 'TEST'),
(4243, 'Sách 502', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 116276, '2024-08-30 02:59:48', NULL, 10, 807, 0, 'Jane'),
(4244, 'Sách 503', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 169283, '2024-08-30 02:59:48', NULL, 19, 392, 0, 'Charlie');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `hotline` varchar(255) DEFAULT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `title`, `address`, `hotline`, `image`) VALUES
(1, 'Chi nhánh Quận 7', '17 Đ. Số 10, Tân Quy, Quận 7, Hồ Chí Minh, Việt Nam', '0123456789', 'public/assets/img/download (1).jpg'),
(2, 'Chi nhánh quận 1', '233 Đ. Nguyễn Trãi, Phường Nguyễn Cư Trinh, Quận 1, Hồ Chí Minh', '0987654321', 'public/assets/img/default.png'),
(3, 'Chi nhánh Quận 3', '79 Hồ Xuân Hương, Phường 6, Quận 3, Hồ Chí Minh', '02476231243', 'public/assets/img/default.png'),
(4, 'Chi nhánh Quận 4', '15 Đ. Hoàng Diệu, Phường 12, Quận 4, Hồ Chí Minh', '0912342332', 'public/assets/img/download (2).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `branchstockitem`
--

CREATE TABLE `branchstockitem` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `branch_select` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branchstockitem`
--

INSERT INTO `branchstockitem` (`id`, `branch_id`, `book_id`, `status`, `branch_select`) VALUES
(1, 2, 1, 1, 0),
(2, 2, 2, 1, 0),
(3, 2, 3, 1, 0),
(4, 2, 4, 1, 1),
(5, 3, 1, 1, 0),
(6, 3, 2, 1, 0),
(7, 3, 3, 1, 0),
(8, 3, 4, 1, 0),
(9, 1, 1, 1, 0),
(10, 1, 2, 1, 0),
(11, 1, 3, 1, 1),
(12, 1, 4, 1, 0),
(13, 1, 8, 1, 1),
(14, 2, 8, 1, 0),
(15, 3, 8, 1, 0),
(16, 1, 9, 1, 1),
(17, 2, 9, 1, 0),
(18, 3, 9, 1, 0),
(19, 1, 10, 1, 0),
(20, 2, 10, 1, 0),
(21, 3, 10, 1, 1),
(22, 1, 11, 1, 1),
(23, 2, 11, 1, 0),
(24, 3, 11, 1, 0),
(25, 1, 12, 1, 1),
(26, 2, 12, 1, 0),
(27, 3, 12, 1, 0),
(28, 1, 13, 1, 1),
(29, 2, 13, 1, 0),
(30, 3, 13, 1, 0),
(31, 1, 14, 1, 0),
(32, 2, 14, 1, 1),
(33, 3, 14, 1, 0),
(34, 1, 15, 1, 0),
(35, 2, 15, 1, 1),
(36, 3, 15, 1, 0),
(37, 1, 16, 1, 0),
(38, 2, 16, 1, 0),
(39, 3, 16, 1, 1),
(40, 1, 17, 1, 0),
(41, 2, 17, 1, 0),
(42, 3, 17, 1, 1),
(43, 1, 18, 1, 0),
(44, 2, 18, 1, 0),
(45, 3, 18, 1, 1),
(46, 1, 19, 1, 1),
(47, 2, 19, 1, 0),
(48, 3, 19, 1, 0),
(49, 1, 20, 1, 0),
(50, 2, 20, 1, 0),
(51, 3, 20, 1, 1),
(52, 1, 21, 1, 1),
(53, 2, 21, 1, 0),
(54, 3, 21, 1, 0),
(55, 1, 22, 1, 0),
(56, 2, 22, 1, 0),
(57, 3, 22, 1, 1),
(58, 1, 23, 1, 0),
(59, 2, 23, 1, 1),
(60, 3, 23, 1, 0),
(61, 1, 24, 1, 0),
(62, 2, 24, 1, 0),
(63, 3, 24, 1, 1),
(64, 1, 25, 1, 0),
(65, 2, 25, 1, 0),
(66, 3, 25, 1, 1),
(67, 1, 26, 1, 1),
(68, 2, 26, 1, 0),
(69, 3, 26, 1, 0),
(70, 1, 27, 1, 0),
(71, 2, 27, 1, 1),
(72, 3, 27, 1, 0),
(73, 1, 28, 1, 0),
(74, 2, 28, 1, 1),
(75, 3, 28, 1, 0),
(76, 1, 29, 1, 0),
(77, 2, 29, 1, 0),
(78, 3, 29, 1, 1),
(79, 1, 30, 1, 0),
(80, 2, 30, 1, 0),
(81, 3, 30, 1, 1),
(82, 1, 31, 1, 1),
(83, 2, 31, 1, 0),
(84, 3, 31, 1, 0),
(85, 1, 32, 1, 0),
(86, 2, 32, 1, 0),
(87, 3, 32, 1, 1),
(88, 1, 33, 1, 0),
(89, 2, 33, 1, 1),
(90, 3, 33, 1, 0),
(91, 1, 34, 1, 0),
(92, 2, 34, 1, 1),
(93, 3, 34, 1, 0),
(94, 1, 35, 1, 0),
(95, 2, 35, 1, 0),
(96, 3, 35, 1, 1),
(97, 1, 36, 1, 0),
(98, 2, 36, 1, 0),
(99, 3, 36, 1, 1),
(100, 1, 37, 1, 1),
(101, 2, 37, 1, 0),
(102, 3, 37, 1, 0),
(103, 1, 38, 1, 0),
(104, 2, 38, 1, 1),
(105, 3, 38, 1, 0),
(106, 1, 39, 1, 0),
(107, 2, 39, 1, 1),
(108, 3, 39, 1, 0),
(109, 1, 40, 1, 1),
(110, 2, 40, 1, 0),
(111, 3, 40, 1, 0),
(112, 1, 41, 1, 1),
(113, 2, 41, 1, 0),
(114, 3, 41, 1, 0),
(115, 1, 42, 1, 0),
(116, 2, 42, 1, 0),
(117, 3, 42, 1, 1),
(118, 1, 43, 1, 0),
(119, 2, 43, 1, 1),
(120, 3, 43, 1, 0),
(121, 1, 44, 1, 0),
(122, 2, 44, 1, 0),
(123, 3, 44, 1, 1),
(124, 1, 45, 1, 0),
(125, 2, 45, 1, 0),
(126, 3, 45, 1, 1),
(127, 1, 46, 1, 0),
(128, 2, 46, 1, 0),
(129, 3, 46, 1, 1),
(130, 1, 47, 1, 1),
(131, 2, 47, 1, 0),
(132, 3, 47, 1, 0),
(133, 1, 48, 1, 1),
(134, 2, 48, 1, 0),
(135, 3, 48, 1, 0),
(136, 1, 49, 1, 0),
(137, 2, 49, 1, 0),
(138, 3, 49, 1, 1),
(139, 1, 50, 1, 0),
(140, 2, 50, 1, 0),
(141, 3, 50, 1, 1),
(142, 1, 5, 1, 0),
(143, 2, 5, 1, 1),
(144, 3, 5, 1, 0),
(145, 1, 6, 1, 1),
(146, 2, 6, 1, 0),
(147, 3, 6, 1, 0),
(148, 1, 7, 1, 0),
(149, 2, 7, 1, 0),
(150, 3, 7, 1, 1),
(151, 4, 1, 1, 0),
(152, 4, 2, 1, 0),
(153, 4, 3, 1, 0),
(154, 4, 4, 1, 0),
(155, 4, 5, 1, 0),
(156, 4, 6, 1, 0),
(157, 4, 7, 1, 0),
(158, 4, 8, 1, 0),
(159, 4, 9, 1, 0),
(160, 4, 10, 1, 0),
(161, 4, 11, 1, 0),
(162, 4, 12, 1, 0),
(163, 4, 13, 1, 0),
(164, 4, 14, 1, 0),
(165, 4, 15, 1, 0),
(166, 4, 16, 1, 0),
(167, 4, 17, 1, 0),
(168, 4, 18, 1, 0),
(169, 4, 19, 1, 0),
(170, 4, 20, 1, 0),
(171, 4, 21, 1, 0),
(172, 4, 22, 1, 0),
(173, 4, 23, 1, 0),
(174, 4, 24, 1, 0),
(175, 4, 25, 1, 0),
(176, 4, 26, 1, 0),
(177, 4, 27, 1, 0),
(178, 4, 28, 1, 0),
(179, 4, 29, 1, 0),
(180, 4, 30, 1, 0),
(181, 4, 31, 1, 0),
(182, 4, 32, 1, 0),
(183, 4, 33, 1, 0),
(184, 4, 34, 1, 0),
(185, 4, 35, 1, 0),
(186, 4, 36, 1, 0),
(187, 4, 37, 1, 0),
(188, 4, 38, 1, 0),
(189, 4, 39, 1, 0),
(190, 4, 40, 1, 0),
(191, 4, 41, 1, 0),
(192, 4, 42, 1, 0),
(193, 4, 43, 1, 0),
(194, 4, 44, 1, 0),
(195, 4, 45, 1, 0),
(196, 4, 46, 1, 0),
(197, 4, 47, 1, 0),
(198, 4, 48, 1, 0),
(199, 4, 49, 1, 0),
(200, 4, 50, 1, 0),
(628, 1, 4234, 1, 0),
(629, 2, 4234, 1, 0),
(630, 3, 4234, 1, 0),
(631, 4, 4234, 1, 0),
(632, 1, 4235, 1, 0),
(633, 2, 4235, 1, 0),
(634, 3, 4235, 1, 0),
(635, 4, 4235, 1, 0),
(636, 1, 4236, 1, 0),
(637, 2, 4236, 1, 0),
(638, 3, 4236, 1, 0),
(639, 4, 4236, 1, 0),
(640, 1, 4237, 1, 0),
(641, 2, 4237, 1, 0),
(642, 3, 4237, 1, 0),
(643, 4, 4237, 1, 0),
(644, 1, 4238, 1, 0),
(645, 2, 4238, 1, 0),
(646, 3, 4238, 1, 0),
(647, 4, 4238, 1, 0),
(648, 1, 4239, 1, 0),
(649, 2, 4239, 1, 0),
(650, 3, 4239, 1, 0),
(651, 4, 4239, 1, 0),
(664, 1, 4243, 1, 0),
(665, 2, 4243, 1, 0),
(666, 3, 4243, 1, 0),
(667, 4, 4243, 1, 0),
(668, 1, 4244, 1, 1),
(669, 2, 4244, 1, 0),
(670, 3, 4244, 1, 0),
(671, 4, 4244, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name_category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name_category`) VALUES
(1, 'Khoa học'),
(2, 'Truyện cổ tích'),
(3, 'Viễn Tưởng'),
(4, 'Tiếng Việt'),
(5, 'Truyện Tranh'),
(6, 'Xã hội'),
(9, 'Ngôn ngữ'),
(10, 'Ngôn tình'),
(11, 'Manga');

-- --------------------------------------------------------

--
-- Table structure for table `codesale`
--

CREATE TABLE `codesale` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `createAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `startAt` timestamp NULL DEFAULT NULL,
  `endAt` timestamp NULL DEFAULT NULL,
  `value` float DEFAULT NULL,
  `min` float DEFAULT NULL,
  `max` float DEFAULT NULL,
  `description` text,
  `deactivate` tinyint(1) NOT NULL DEFAULT '0',
  `method` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `codesale`
--

INSERT INTO `codesale` (`id`, `code`, `createAt`, `startAt`, `endAt`, `value`, `min`, `max`, `description`, `deactivate`, `method`) VALUES
(1, 'ABCDEF567', '2024-08-30 08:12:13', '2024-08-01 17:00:00', '2024-08-02 11:00:00', 25000, 125000, 0, 'Giảm 25k cho đơn tối thiểu 125k', 1, 1),
(2, 'ABC20DE', '2024-08-20 06:12:26', '2024-08-20 04:56:00', '2024-08-21 04:56:00', 20, 200000, 150000, 'Discount 20% for bill over 200k VND', 1, 0),
(3, 'ABC15EF', '2024-08-28 02:57:23', '2024-08-20 06:27:00', '2024-08-29 06:27:00', 15, 200000, 100000, 'Discount 15% for bill over 200k VND', 1, 0),
(4, 'ABC19EF', '2024-08-30 08:11:37', '2024-08-30 07:56:00', '2024-09-03 07:56:00', 19, 100000, 50000, 'Discount 19% for bill over 200k VND', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `text`, `user_id`, `book_id`, `createdAt`, `updatedAt`, `parent_id`) VALUES
(1, 'Good book!', 1, 1, '2024-07-26 07:39:12', NULL, NULL),
(3, 'This is an excellent book', 1, 1, '2024-07-26 07:56:03', NULL, NULL),
(4, 'you\'re right!', 1, 1, '2024-07-30 04:57:11', NULL, 3),
(5, 'Sách hay lắm!', 1, 25, '2024-08-02 10:02:36', NULL, NULL),
(6, 'Đúng vậy!', 1, 25, '2024-08-02 10:03:58', NULL, 5),
(7, 'awesome', 1, 1, '2024-08-05 04:54:31', NULL, 3),
(8, 'Very good', 1, 1, '2024-08-05 04:54:41', NULL, NULL),
(9, 'TEST 28/08/2024', 1, 1, '2024-08-28 07:59:48', NULL, NULL),
(10, 'test', 1, 1, '2024-08-28 08:06:57', NULL, 9),
(11, 'TEST 29/08/2024', 1, 1, '2024-08-29 06:50:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_image`
--

CREATE TABLE `gallery_image` (
  `image_id` int(11) NOT NULL,
  `address` text,
  `book_id` int(11) DEFAULT NULL,
  `isShow` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery_image`
--

INSERT INTO `gallery_image` (`image_id`, `address`, `book_id`, `isShow`) VALUES
(1, 'public/assets/img/images (2).jpg', 54, 0),
(2, 'public/assets/img/download.jpg', 54, 1),
(4, 'public/assets/img/images.jpg', 54, 0),
(5, 'public/assets/img/1.jpg', 1, 1),
(6, 'public/assets/img/2.jpg', 1, 0),
(7, 'public/assets/img/3.jpg', 2, 1),
(8, 'public/assets/img/4.jpg', 2, 0),
(9, 'public/assets/img/5.jpg', 3, 0),
(10, 'public/assets/img/6.jpg', 3, 1),
(11, 'public/assets/img/7.jpg', 5, 0),
(12, 'public/assets/img/8.jpg', 5, 1),
(13, 'public/assets/img/9.jpg', 8, 0),
(14, 'public/assets/img/10.jpg', 8, 1),
(15, 'public/assets/img/11.jpg', 11, 0),
(16, 'public/assets/img/12.jpg', 11, 1),
(17, 'public/assets/img/8.jpg', 1, 0),
(18, 'public/assets/img/9.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `import`
--

CREATE TABLE `import` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `import` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `import`
--

INSERT INTO `import` (`id`, `title`, `import`, `quantity`, `status`) VALUES
(2, 'Nhập hàng ngày 08-08-2024', '2024-08-08 07:05:38', 65, 1),
(9, 'Nhập hàng ngày 20-08-2024', '2024-08-20 04:22:40', 660, 0),
(14, 'Nhập hàng ngày 02-09-2024', '2024-09-02 08:30:27', 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `import_item`
--

CREATE TABLE `import_item` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `import_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `after_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `import_item`
--

INSERT INTO `import_item` (`id`, `book_id`, `import_id`, `quantity`, `stock`, `after_stock`) VALUES
(3, 1, 2, 20, 465, 485),
(4, 2, 2, 61, 59, 120),
(5, 3, 2, 2, 998, 1000),
(6, 4, 2, 4, 596, 600),
(7, 5, 2, 10, 790, 800),
(8, 6, 2, 0, 423, 423),
(9, 7, 2, 0, 261, 261),
(10, 8, 2, 0, 545, 545),
(11, 9, 2, 1, 427, 428),
(12, 10, 2, 0, 142, 142),
(13, 11, 2, 0, 114, 114),
(14, 12, 2, 0, 128, 128),
(15, 13, 2, 0, 113, 113),
(16, 14, 2, 0, 303, 303),
(17, 15, 2, 0, 653, 653),
(18, 16, 2, 0, 929, 929),
(19, 17, 2, 0, 142, 142),
(20, 18, 2, 0, 557, 557),
(21, 19, 2, 0, 197, 197),
(22, 20, 2, 0, 401, 401),
(23, 21, 2, 0, 784, 784),
(24, 22, 2, 0, 971, 971),
(25, 23, 2, 0, 356, 356),
(26, 24, 2, 0, 112, 112),
(27, 25, 2, 0, 604, 604),
(28, 26, 2, 0, 336, 336),
(29, 27, 2, 0, 170, 170),
(30, 28, 2, 0, 469, 469),
(31, 29, 2, 0, 398, 398),
(32, 30, 2, 0, 875, 875),
(33, 31, 2, 0, 707, 707),
(34, 32, 2, 0, 323, 323),
(35, 33, 2, 0, 642, 642),
(36, 34, 2, 0, 714, 714),
(37, 35, 2, 1, 199, 200),
(38, 36, 2, 0, 231, 231),
(39, 37, 2, 0, 138, 138),
(40, 38, 2, 0, 716, 716),
(41, 39, 2, 0, 989, 989),
(42, 40, 2, 0, 863, 863),
(43, 41, 2, 0, 344, 344),
(44, 42, 2, 0, 280, 280),
(45, 43, 2, 0, 181, 181),
(46, 44, 2, 0, 185, 185),
(47, 45, 2, 0, 381, 381),
(48, 46, 2, 0, 347, 347),
(49, 47, 2, 0, 304, 304),
(50, 48, 2, 0, 392, 392),
(51, 49, 2, 0, 807, 807),
(52, 50, 2, 0, 499, 499),
(369, 1, 9, 20, 460, 480),
(370, 2, 9, 10, 100, 110),
(371, 3, 9, 10, 979, 989),
(372, 4, 9, 0, 599, 599),
(373, 5, 9, 0, 769, 769),
(374, 6, 9, 0, 423, 423),
(375, 7, 9, 0, 259, 259),
(376, 8, 9, 0, 545, 545),
(377, 9, 9, 0, 413, 413),
(378, 10, 9, 0, 140, 140),
(379, 11, 9, 0, 114, 114),
(380, 12, 9, 0, 128, 128),
(381, 13, 9, 0, 113, 113),
(382, 14, 9, 0, 303, 303),
(383, 15, 9, 0, 652, 652),
(384, 16, 9, 0, 929, 929),
(385, 17, 9, 0, 142, 142),
(386, 18, 9, 0, 557, 557),
(387, 19, 9, 0, 197, 197),
(388, 20, 9, 0, 400, 400),
(389, 21, 9, 0, 784, 784),
(390, 22, 9, 0, 971, 971),
(391, 23, 9, 0, 356, 356),
(392, 24, 9, 0, 112, 112),
(393, 25, 9, 0, 603, 603),
(394, 26, 9, 0, 336, 336),
(395, 27, 9, 10, 150, 160),
(396, 28, 9, 0, 469, 469),
(397, 29, 9, 0, 398, 398),
(398, 30, 9, 0, 874, 874),
(399, 31, 9, 0, 707, 707),
(400, 32, 9, 0, 323, 323),
(401, 33, 9, 0, 642, 642),
(402, 34, 9, 0, 713, 713),
(403, 35, 9, 0, 199, 199),
(404, 36, 9, 0, 230, 230),
(405, 37, 9, 0, 138, 138),
(406, 38, 9, 10, 696, 706),
(407, 39, 9, 0, 989, 989),
(408, 40, 9, 0, 863, 863),
(409, 41, 9, 0, 344, 344),
(410, 42, 9, 0, 280, 280),
(411, 43, 9, 0, 181, 181),
(412, 44, 9, 0, 185, 185),
(413, 45, 9, 0, 381, 381),
(414, 46, 9, 0, 347, 347),
(415, 47, 9, 0, 304, 304),
(416, 48, 9, 0, 392, 392),
(417, 49, 9, 0, 807, 807),
(418, 50, 9, 0, 499, 499),
(419, 54, 9, 0, 1000, 1000),
(420, 4234, 9, 0, 0, 0),
(421, 4235, 9, 0, 200, 200),
(422, 4236, 9, 100, 0, 100),
(423, 4237, 9, 200, 0, 200),
(479, 4238, 9, 100, 0, 100),
(480, 4239, 9, 200, 0, 200),
(717, 1, 14, 20, 479, 499),
(718, 2, 14, 10, 110, 120),
(719, 3, 14, 10, 988, 998),
(720, 4, 14, 0, 599, 599),
(721, 5, 14, 0, 769, 769),
(722, 6, 14, 0, 423, 423),
(723, 7, 14, 0, 259, 259),
(724, 8, 14, 0, 545, 545),
(725, 9, 14, 0, 412, 412),
(726, 10, 14, 0, 140, 140),
(727, 11, 14, 0, 114, 114),
(728, 12, 14, 0, 128, 128),
(729, 13, 14, 0, 113, 113),
(730, 14, 14, 0, 303, 303),
(731, 15, 14, 0, 652, 652),
(732, 16, 14, 0, 929, 929),
(733, 17, 14, 0, 142, 142),
(734, 18, 14, 0, 557, 557),
(735, 19, 14, 0, 197, 197),
(736, 20, 14, 0, 400, 400),
(737, 21, 14, 0, 784, 784),
(738, 22, 14, 0, 971, 971),
(739, 23, 14, 0, 356, 356),
(740, 24, 14, 0, 112, 112),
(741, 25, 14, 0, 603, 603),
(742, 26, 14, 0, 336, 336),
(743, 27, 14, 10, 160, 170),
(744, 28, 14, 0, 469, 469),
(745, 29, 14, 0, 398, 398),
(746, 30, 14, 0, 874, 874),
(747, 31, 14, 0, 707, 707),
(748, 32, 14, 0, 323, 323),
(749, 33, 14, 0, 642, 642),
(750, 34, 14, 0, 713, 713),
(751, 35, 14, 0, 199, 199),
(752, 36, 14, 0, 230, 230),
(753, 37, 14, 0, 138, 138),
(754, 38, 14, 10, 706, 716),
(755, 39, 14, 0, 989, 989),
(756, 40, 14, 0, 863, 863),
(757, 41, 14, 0, 344, 344),
(758, 42, 14, 0, 280, 280),
(759, 43, 14, 0, 181, 181),
(760, 44, 14, 0, 185, 185),
(761, 45, 14, 0, 381, 381),
(762, 46, 14, 0, 347, 347),
(763, 47, 14, 0, 304, 304),
(764, 48, 14, 0, 392, 392),
(765, 49, 14, 0, 807, 807),
(766, 50, 14, 0, 499, 499),
(767, 54, 14, 0, 1000, 1000),
(768, 4234, 14, 0, 0, 0),
(769, 4235, 14, 0, 200, 200),
(770, 4236, 14, 0, 50, 50),
(771, 4237, 14, 0, 150, 150),
(772, 4238, 14, 0, 100, 100),
(773, 4239, 14, 0, 200, 200),
(774, 4243, 14, 0, 807, 807),
(775, 4244, 14, 0, 392, 392);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `book_id`, `quantity`, `price`, `total`, `order_id`) VALUES
(17, 2, 12, 60000, 720000, 39),
(18, 3, 1, 65000, 65000, 39),
(19, 2, 15, 60000, 900000, 40),
(20, 3, 1, 65000, 65000, 40),
(21, 2, 1, 60000, 60000, 44),
(22, 3, 2, 65000, 130000, 44),
(23, 1, 4, 45000, 180000, 45),
(36, 4, 1, 89000, 89000, 48),
(37, 7, 1, 194915, 194915, 48),
(38, 10, 1, 111679, 111679, 48),
(39, 20, 1, 71560, 71560, 48),
(40, 25, 1, 196074, 196074, 48),
(41, 35, 1, 85822, 85822, 48),
(42, 1, 1, 40500, 40500, 49),
(43, 1, 20, 40500, 810000, 50),
(44, 3, 1, 65000, 65000, 50),
(45, 5, 31, 76000, 2356000, 50),
(46, 9, 15, 103080, 1546200, 50),
(47, 15, 1, 125165, 125165, 50),
(48, 34, 1, 51120, 51120, 50),
(49, 36, 1, 157460, 157460, 50),
(50, 7, 1, 194915, 194915, 51),
(51, 10, 1, 111679, 111679, 51),
(52, 30, 1, 109503, 109503, 51),
(53, 1, 1, 40500, 40500, 52),
(54, 3, 1, 65000, 65000, 52),
(55, 9, 1, 103080, 103080, 52);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `user_id`, `status`) VALUES
(39, 1, 0),
(40, 1, 0),
(44, 1, 0),
(45, 1, 0),
(48, 1, 0),
(49, 1, 0),
(50, 1, 0),
(51, 1, 0),
(52, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `startAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endAt` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `book_id`, `user_id`, `value`) VALUES
(1, 1, 1, 5),
(2, 2, 1, 5),
(3, 25, 1, 4),
(4, 3, 1, 4),
(5, 3, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `estimateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `transport_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `estimateDate`, `status`, `point`, `transport_id`) VALUES
(1, '2024-08-13 05:03:14', 1, 0, 1),
(2, '2024-08-13 05:03:18', 1, 1, 1),
(3, '2024-08-13 07:15:51', 1, 2, 1),
(4, '2024-08-13 10:05:14', 1, 0, 2),
(5, '2024-08-13 10:06:07', 1, 1, 2),
(6, '2024-08-13 10:06:09', 1, 2, 2),
(7, '2024-09-02 18:36:17', 1, 0, 3),
(8, '2024-09-02 18:36:23', 1, 1, 3),
(9, '2024-09-02 18:36:26', 1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `typePayment` tinyint(1) DEFAULT NULL,
  `shippedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `codesale` int(11) DEFAULT NULL,
  `transport_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `createdAt`, `typePayment`, `shippedAt`, `address`, `receiver`, `order_id`, `total`, `codesale`, `transport_id`) VALUES
(2, '2024-07-24 06:18:24', NULL, '2024-07-24 06:18:31', '58 33 street United States California', 'Truc Trinh', 39, 785000, NULL, NULL),
(3, '2024-07-24 06:21:11', NULL, '2024-07-30 17:00:00', '58 33 street United States California', 'Truc Trinh', 40, 965000, NULL, NULL),
(7, '2024-07-25 10:04:12', NULL, '2024-07-31 17:00:00', '35 Nguyen Hue street United States California', 'Nguyen An', 44, 190000, NULL, NULL),
(8, '2024-08-02 07:01:11', NULL, '2024-08-08 17:00:00', '1600 Amphitheatre Parkway United States California', 'Jon Doe', 45, 155000, 1, NULL),
(9, '2024-08-06 04:53:43', NULL, '2024-08-12 17:00:00', '58 33 street United States California', 'Truc Trinh', 48, 749050, NULL, NULL),
(10, '2024-08-06 09:43:22', NULL, '2024-08-12 17:00:00', '1234 main St United States California', 'Truc Trinh', 49, 40500, NULL, NULL),
(11, '2024-08-13 03:51:48', NULL, '2024-08-14 17:00:00', '1234 main St United States California', 'Truc Trinh', 50, 5110945, NULL, 1),
(12, '2024-08-13 08:32:26', NULL, '2024-08-19 17:00:00', '1234 Main st United States California', 'Truc Trinh', 51, 416097, NULL, 2),
(13, '2024-08-28 06:18:31', NULL, '2024-09-03 17:00:00', '1234 Main st United States California', 'Truc Trinh', 52, 208580, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `plannedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `actualAt` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `plannedAt`, `actualAt`, `status`) VALUES
(1, '2024-08-13 07:15:53', '2024-08-13 07:15:53', 1),
(2, '2024-08-13 10:06:09', '2024-08-13 10:06:09', 1),
(3, '2024-09-02 18:36:26', '2024-09-02 18:36:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(255) DEFAULT NULL,
  `image` text,
  `deactivate` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `phonenumber`, `birthday`, `password`, `role`, `created_at`, `email`, `image`, `deactivate`) VALUES
(1, 'trinhtruc', 'Trịnh Ngọc Trung Trực', '0934541496', '2003-02-04', '12345678', '1', '2024-08-29 07:38:48', 'trungtruc201563@gmail.com', 'public/assets/img/z5560424909017_c8bb3df0db4112634d4fca60a4df59ba.jpg', 0),
(2, 'nguyenvana', 'Nguyễn Văn A', '012345678', '2002-08-06', '12345678', NULL, '2024-08-30 13:45:02', 'nguyenvana@gmail.com', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_code`
--

CREATE TABLE `user_code` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_code`
--

INSERT INTO `user_code` (`id`, `user_id`, `code_id`, `status`) VALUES
(1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `branchstockitem`
--
ALTER TABLE `branchstockitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_id` (`book_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `codesale`
--
ALTER TABLE `codesale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `FK_GALLERY_BOOKS` (`book_id`);

--
-- Indexes for table `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_item`
--
ALTER TABLE `import_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IMPORT_BOOK` (`book_id`),
  ADD KEY `FK_IMPORT_IMPORT` (`import_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_OTP_USER` (`user_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transport_id` (`transport_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `codesale` (`codesale`),
  ADD KEY `transport_id` (`transport_id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_code`
--
ALTER TABLE `user_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_code_1` (`user_id`),
  ADD KEY `FK_user_code_2` (`code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4245;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branchstockitem`
--
ALTER TABLE `branchstockitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=672;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `codesale`
--
ALTER TABLE `codesale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gallery_image`
--
ALTER TABLE `gallery_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `import`
--
ALTER TABLE `import`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `import_item`
--
ALTER TABLE `import_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=776;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_code`
--
ALTER TABLE `user_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `branchstockitem`
--
ALTER TABLE `branchstockitem`
  ADD CONSTRAINT `branchstockitem_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `branchstockitem_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD CONSTRAINT `FK_GALLERY_BOOKS` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `import_item`
--
ALTER TABLE `import_item`
  ADD CONSTRAINT `FK_IMPORT_BOOK` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `FK_IMPORT_IMPORT` FOREIGN KEY (`import_id`) REFERENCES `import` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order_item` (`id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `otp`
--
ALTER TABLE `otp`
  ADD CONSTRAINT `FK_OTP_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_1` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_item` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`codesale`) REFERENCES `codesale` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`);

--
-- Constraints for table `user_code`
--
ALTER TABLE `user_code`
  ADD CONSTRAINT `FK_user_code_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_user_code_2` FOREIGN KEY (`code_id`) REFERENCES `codesale` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
