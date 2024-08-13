-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2024 at 07:27 PM
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
(1, 'Sách 1', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxbAY61EBioG2gt4PJLN6Hy-Xx1YbUc-_KKQ&s', 'Nội dung sách 1', 1, 45000, '2024-08-08 10:28:29', '2024-08-05 08:35:27', 10, 460, 1, 'David'),
(2, 'Sách 2', 'data:image/jpeg;base64,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', 'Nội dung sách 2', 2, 60000, '2024-08-08 09:06:06', '2024-08-07 06:39:53', NULL, 120, 1, 'Robert'),
(3, 'Sách 3', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8rI_tn3BpM-qwJC7iEu1ntsQtAN4ZDteE4g&s', 'Nội dung sách 3', 1, 65000, '2024-08-08 09:48:58', '2024-08-07 06:40:07', NULL, 999, 1, 'Jennie'),
(4, 'Sách 4', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEOFsRCF8BgL8J_OQDsqiltHAiRF-9QVoMKA&s', 'Nội dung sách 4', 2, 89000, '2024-08-07 06:40:30', '2024-08-07 06:40:30', NULL, 596, 1, 'Daniel'),
(5, 'Sách 5', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-UTDgX_RA934tszuSugPBiaGcpJc8ycN0hQ&s', 'Nội dung sách 5', 3, 76000, '2024-08-08 10:21:12', '2024-08-07 06:40:53', NULL, 791, 1, 'Joe'),
(6, 'Sách 6', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSds95BsInWXGyDNJAKrlY64SBgYloSS9JtuA&s', 'Nội dung sách 6', 3, 52000, '2024-08-07 06:41:08', '2024-08-07 06:41:08', NULL, 423, 1, 'Daivd'),
(7, 'Sách 7', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 194915, '2024-08-06 04:53:43', NULL, NULL, 261, 0, 'Joe'),
(8, 'Sách 8', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8jzZpd3GS1estVt_FsMl7Y-uS92IgZpgM7A&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 86977, '2024-08-07 06:41:33', '2024-08-07 06:41:33', NULL, 545, 1, 'Alice'),
(9, 'Sách 9', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa3Pf-3DqBsYElBHqhvgU5kw5QAzpf6a9v8g&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 103080, '2024-08-08 10:25:15', '2024-08-07 06:41:48', NULL, 428, 1, 'Jane'),
(10, 'Sách 10', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlZWkMafJbmgP1pAxgU_D8yS8oPXEkQ4WHFg&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 111679, '2024-08-07 06:42:03', '2024-08-07 06:42:03', NULL, 142, 1, 'David'),
(11, 'Sách 11', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHowXzy0YyXPmc6BebP7OeTPcNbcSLqWz52A&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 132623, '2024-08-07 06:42:17', '2024-08-07 06:42:17', NULL, 114, 1, ''),
(12, 'Sách 12', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSx4ONp_TLFBtxBvGsPl3Ny-r3l-EYkYjB6pQ&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 88465, '2024-08-07 06:42:28', '2024-08-07 06:42:28', NULL, 128, 1, 'Bob'),
(13, 'Sách 13', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEAACQRlbcHQ1TlF98P6de-8MY7tC1ZqQFGQ&s', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 123195, '2024-08-07 06:42:38', '2024-08-07 06:42:38', NULL, 113, 1, 'Eve'),
(14, 'Sách 13', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 60548, '2024-08-02 09:07:11', NULL, NULL, 303, 1, 'Alice'),
(15, 'Sách 14', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 125165, '2024-08-08 09:48:58', NULL, NULL, 652, 0, 'Alice'),
(16, 'Sách 15', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 142196, '2024-08-02 09:07:11', NULL, NULL, 929, 0, 'Bob'),
(17, 'Sách 16', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 130791, '2024-08-02 09:07:25', NULL, NULL, 142, 0, 'Eve'),
(18, 'Sách 17', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 185968, '2024-08-02 09:07:25', NULL, NULL, 557, 1, 'Jane'),
(19, 'Sách 18', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 77773, '2024-08-02 09:07:25', NULL, NULL, 197, 0, 'Jane'),
(20, 'Sách 19', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 71560, '2024-08-06 04:53:43', NULL, NULL, 401, 0, 'Eve'),
(21, 'Sách 20', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 140229, '2024-08-02 09:07:25', NULL, NULL, 784, 1, 'Eve'),
(22, 'Sách 21', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 94529, '2024-08-02 09:07:25', NULL, NULL, 971, 0, 'David'),
(23, 'Sách 22', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 140450, '2024-08-02 09:07:25', NULL, NULL, 356, 1, 'Eve'),
(24, 'Sách 23', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 139072, '2024-08-02 09:07:25', NULL, NULL, 112, 1, 'Bob'),
(25, 'Sách 24', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 196074, '2024-08-06 04:53:43', NULL, NULL, 604, 1, 'David'),
(26, 'Sách 25', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 176390, '2024-08-02 09:07:25', NULL, NULL, 336, 0, 'David'),
(27, 'Sách 26', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 193264, '2024-08-02 09:07:25', NULL, NULL, 170, 1, 'Charlie'),
(28, 'Sách 27', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 54578, '2024-08-02 09:07:25', NULL, NULL, 469, 0, 'Bob'),
(29, 'Sách 28', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 147400, '2024-08-02 09:07:25', NULL, NULL, 398, 0, 'Alice'),
(30, 'Sách 29', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 109503, '2024-08-02 09:07:25', NULL, NULL, 875, 1, 'Eve'),
(31, 'Sách 30', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 53053, '2024-08-02 09:07:25', NULL, NULL, 707, 1, 'David'),
(32, 'Sách 31', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 52250, '2024-08-02 09:07:11', NULL, NULL, 323, 0, 'Charlie'),
(33, 'Sách 32', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 53517, '2024-08-02 09:07:25', NULL, NULL, 642, 1, 'Jane'),
(34, 'Sách 33', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 51120, '2024-08-08 09:48:58', NULL, NULL, 713, 0, 'Bob'),
(35, 'Sách 34', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 85822, '2024-08-08 10:09:02', NULL, NULL, 200, 0, 'David'),
(36, 'Sách 35', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 157460, '2024-08-08 09:48:58', NULL, NULL, 230, 0, 'David'),
(37, 'Sách 36', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 194288, '2024-08-02 09:07:25', NULL, NULL, 138, 0, 'Alice'),
(38, 'Sách 37', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 191436, '2024-08-02 09:07:25', NULL, NULL, 716, 1, 'Bob'),
(39, 'Sách 38', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 55729, '2024-08-02 09:07:25', NULL, NULL, 989, 0, 'David'),
(40, 'Sách 39', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 70411, '2024-08-02 09:07:25', NULL, NULL, 863, 1, 'David'),
(41, 'Sách 40', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 158123, '2024-08-02 09:07:11', NULL, NULL, 344, 0, 'David'),
(42, 'Sách 41', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 53000, '2024-08-02 09:07:25', NULL, NULL, 280, 1, 'Bob'),
(43, 'Sách 42', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 78819, '2024-08-02 09:07:25', NULL, NULL, 181, 0, 'Alice'),
(44, 'Sách 43', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 71840, '2024-08-02 09:07:11', NULL, NULL, 185, 0, 'Jane'),
(45, 'Sách 44', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 136711, '2024-08-02 09:07:25', NULL, NULL, 381, 0, 'Bob'),
(46, 'Sách 45', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 92538, '2024-08-02 09:07:25', NULL, NULL, 347, 0, 'Charlie'),
(47, 'Sách 46', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 159561, '2024-08-02 09:07:25', NULL, NULL, 304, 1, 'Alice'),
(48, 'Sách 47', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 169283, '2024-08-02 09:07:25', NULL, NULL, 392, 1, 'Charlie'),
(49, 'Sách 48', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 116276, '2024-08-02 09:07:25', NULL, NULL, 807, 1, 'Jane'),
(50, 'Sách 49', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 194604, '2024-08-02 09:07:11', NULL, NULL, 499, 0, 'David');

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
(1, 'Chi nhánh Quận 7', '17 Đ. Số 10, Tân Quy, Quận 7, Hồ Chí Minh, Việt Nam', '0123456789', 'data:image/jpeg;base64,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'),
(2, 'Chi nhánh quận 1', '233 Đ. Nguyễn Trãi, Phường Nguyễn Cư Trinh, Quận 1, Hồ Chí Minh', '0987654321', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUTEhMVFhUXGB4aGRgYGR4gHhsfGSAdHRoeHx8fHCgiHholHR4eIjEhJSktLi8uGx8zODMsNygtLisBCgoKDg0OGxAQGy8mICY1LzUtMDUyNi0rLS01Mi0yLy0tLy01NS0tLS0tLS8tLy0tLS0tLS0vLS0tLS0tLS0tLf/AABEIAKgBLAMBIgACEQEDEQH/xAAcAAACAgMBAQAAAAAAAAAAAAAEBQMGAAIHAQj/xABHEAACAQIEAwUECAMECQQDAAABAhEDIQAEEjEFQVEGEyJhcTKBkaEHFCNCUrHB0TNy8BVisuEWJENzgpLC4vEXVGOiRFPS/8QAGgEAAgMBAQAAAAAAAAAAAAAAAgMAAQQFBv/EADERAAICAQMCAwcEAgMBAAAAAAECABEDEiExBEETUWEUIjJxobHwBYGR4cHRFSNCUv/aAAwDAQACEQMRAD8AKzGYPLiDv6hv1wE9Rv8A984RUO0eafvdTqdNMsPAu4ZRyHQnALdpMz1X/lGPPLhb0/P2nb8BpZ7/AI/kP3x41M2k77WHL34RZ/jtdKjKNMCIkdQD188MOG8UqOhYhZDBbA9N998Ow9M+Rwi8mKyKUXWeI0yPCqlVtNPxHnAmJO5g2GLVw/s81CC9JajwbgtF/JWHK2K2OLFULLTq0z4VLU6rC7aoJERplTz54J/tHM91rY1xcgMtZ4sSoJB1TJ5gj0GOni/T1oEtvdcXRmD2guSAK/zLBVyLkyKRHkAYHxk4ibh7/gb4HHnaTK1cuqVFzWZCm7BqjGBKCxEcmJvO2FlPNVXqaaWfrOCpMhn3BAAuwmZPTbDR0eLTq17fIyam8vrGX1B/wN8DjQ8PqfgPwwGv1sF1bOuumLtUcA6hO+qBgSpxHOqgfv6pUx/tH5+p/KcNT9OR605Bvxt58QS7AXpjdOG1GMBfjb88ajIsD4kJA3AP6wRiGhxa3jz1cSOTMY8IMEab+PVz2AHOce5jjJBGnO1ysGfHedMiBpG7SvlIPlg/+Ja+foYv2j0kmYysnwU3UdCZ/wCkYgbKv+E4kocXqsEP1ysBpBqEyQPDLaYW4Dwp6TiZuLuACM5WbeRYRAbqhmSALcjPlgT+ltfxfQy/H9ICMu/4GHw/Q42+qt0PwwYvFK2ifrTa9IIDaAJKsYuv4gF+exxPU4k4DH65tMSlMyREfdt7/wBDij+mMP8A0P4P+pPG9Iuq5J19pGHqI/PHtDLr98sOmlQfzIwwHFWkgZtCLXNKkBB1dQDaBI5asDjjVTQhOYoy2mR3VPwy0XsDYXJiLHymv+MfzH1/1L8YeUDNG9pjBNCpUUFUZ1B3AJA/PBNPiJIn6xl9gb06YNwDEBrXt6g4EzXH3R2Ve5cA2YIL/A4tf0zIxoEfX/UnjDym6ZJjywVS4U55YWJ2mzR1FEUQLaaDPJ6SrWwPw/t/nHqBW7oAhiSEM+FGYbt1GFv0DoGJ7cyDKDLVluAseWGVHs/G4GKFxrtnnFqZVRV0rV7+Qqi+laei8SILf1bCvJdqqxol2Z6s1qVOSWPidcxqAncCF/qMZQFK6gLjN9VGdcocNpA6dSz0kT8MHjLUxyGKp2epn60PCVPc89mII+MAifXFv7s8yBi8D611ASsq6Gq55qUbDGGt0wNWr0l9usi+rKP1wLT4zlDOiqKkWOjU+wn7oPK+G20CowNU8zj0AnzwjzXa/LUxISow8lA/xEYV5P6SKNRnGlaQWL1HF53sBy8jiiQOTLCk8CW2qpGNUpE/HFQz/b1R/DqI1t1pVDip5/t5nDUVVrkAsPABTUsBcgAjVsDgSVlgGddGSvMn3Y3+rqtz8SccZzP0p01BDCoxOxNSoIsBssrvJ254S576Q6Lj7o9zsfmq4sV/8yzYNXO7vxDLq0GrRDdNSz8JnEf9sZcSQ5PUqjEfELGPmwdr1Wp3lLUWgj2VAvH95umCk7b8QYEJ3xToJI+SWGC96+JRC0N953zM9oqAvpqt6AAfMjFZzv0kUUYr9Vcxz7wD9Djlf13ilb2MtWfrPekf4gIws4jRz1J9NbLhGiYKA2PP2j+eKo+kn8yx5ytRfMZo0ABSNFtIAgCFTVAgQNQPIeg2A1fNZU5JKYRfrAeS4AHhl/abSCxMqIkgBB7JmbHw/wCk7v2VTlUWCWBDA+wrNHsCxiMWHtF2vq5ZEdaFKpqnUI9nSASTANr+WOd76vpI3PynV9qUrYGwrv8A1KRl85lkrVPrFNXBFAgxLCGos4F4ANLXPM2EicNuzzZapVqDWiUppy0aV1CnDkL91WcMQLQDy2w54f2q8ATu1EIrEgA2ddfMcpI9BhT2ndc1RdWUC9PlvJJXYjrgseTLjKsBVd4tnXKCgG5252/NpZh9WKGl9ap6JjoSFMjxd2THoeePc1maHdhO/QqDMax1mPZ28sVHhHYHJwTXBY6EdUo+3DmJK+IwOvlgDiPYnK084MuzLoZiBuGA5SSxFrSYveBjpL1Tp8LDz4E5ns6k7rxLFxvjiPCTqBKqftWIAmCSCDYTMbeEbYZZFMtSbwZuhYG5/vNqI8K8ojfbFKzPZLLZeujUH1EWIkGda1BFtjYfPBq9i8gGpq1KouoAk6/xSIuDcR88JPUlFK3sB5DvHDEXO3J9ZauIGi+snNUvEpU6SLgxIuD0wv4pxegiEKoqGBZarSdIAFoImABtis5bsXlqldaUqoaYNi2xYeHvAT0kYbZnsDkstoqJ3hq0yraiwAJBBPh5Dyv64YOqdQCD8th+0B8WklWH1j05XJHT/rFK4k+LbyspvjTMcPyg2r0z6N+64ptHshl3raSwibkp1k82A3HPDr/04yMD/WVE/wB1RzjnUxoX9U6iq8T6QW6YLRK8+sJ4lxqnTommhVxpjSrXInUB7PWduvpDw9oFERXy5mG9CbR4VYSAB8rY54/Y6jRq0qtJ9UMCRYiVYAibYUrwqhrKPoB3WFJ1A7W1W9fLCvbsjsRqG3oOYRwhRuOfWdRq9pxTsndECPZYkWGkAahIsOX6nCvLdsx3mjuSFqMVYz4QH0hifIBQZ9b4SU/o+yzxFTZV1DRzKhreLa/MThXkuyi5XPg+3RUsCSojS1JtQblzIiNsQda9EhvpA8IWLE6s3EqTa1OYyxB3kkTqHiNjF9RG+BK3EKaIAlehZQohgT4V0jdomPLFKyGYyK1qZFLLCFbanTAnS0aiBuTAEzyxPn6GQr0WZ8vQ76AZVgJiDAhgZ3+WFv1+XHXfjsIQxKZa8h2mWpVNMtSUQza2ML7QMSW3MmB0BwdS4gjAEVcuNra425Rqgb8h+QxyLJ5bL0O+V6YakK1IqpUuI8c2WT7Ia5/XDxuLcLQU2fKhdWq3cOAwaCIIW8ctrHDfacu9fYShjU7f5lizlOnSUkVaTeSsCfz/AM8Lcjw2gStU5qigKHwSS/jVlghQYInaeWKdnKmScA00YaEIYhK0ExZjaAdU7+WLLw/sNTzyB6lbQDpVVCgm1NDqknaTERPng83X5aKuRR52Ei4l5Am9ahlDoOZq1lFFyUKL7QcLrBnoaacx7R35Qnj2VVUo5SooXvg6qxU+MkgQBqInWRe18RdoOzWXygo0aLNpqNLNUZRyXxTCgCPyxZKWV4ZT0BEysgkkjSWJAbQdV2nVHPGEOpXbiN0NfrE2b+lIGFFGrqEhWV2mDuAogXt8ML07UZwsalLK5pywH8WkdIG4MszD98b9h+ErK1XnVtBgaY2sbyTF4xas7mn0kXZyGCW+6Opvcn0wdr8Ikojc7SpPxji1f/8ADYz+HQAY6Qu3mMBJkuJmdC06YPiP2nPabNew5A4ulUafslEhVAUmQQCIIsN999h1xtkabqytUAACuZ+8TBAkzJJMc8Xv5SlAI5iaj2I4i9PW2boDlp7nWZPsyWQkC1yJjocMeP8AYqidFP63mbMA4NVRqBMWQIqhVhvu3sdsIKPH3rVHCnSpBceNmi6+HlaD+dseUs44rLKhhrUFoPNvFfyk/wCWENnKtpI3mlOnStWrb5Qnhv0Z5ZwDWrVzZSV8IuwJi6mSLTfflhmexWQy32lJGNRQ0E1JhoHIQNtR+Pliy0s8VWQ3eaiTrHS7QOvIThRmc9q1gkGVJEG0wFsOpF4wTZGIMz0uoCpQez/ZvvvtHQNTKsFk/eEb9BvfF2y/CcsjH/VaGlYBApISdYhZJWbRPXCns/nqaZemDUpgqre0wEFzPXkv543XjKxTIr0l01NTA1FEhTzlvWAJkx0xMhYsBCTSBcmzYFUpTTUqwoYBQAWKbGN4F9PVgZw54dlTTSVIYTAm1lkEAXk72wg/tvKhhqzVLTMRqFp32vy+eC6fa7IwqDMrClWA0uZ31CwmfPz54BdWmwIzMQDpuWOjWCCzKIMALAJVgYAk8pnaN8KmrE81A5A3Mepwo4r22yMotMd2qGzKlW4UQohvQfDCmp2zy1gKkQIvTfl6DE0uN5XiKABGNPhARD4yQysLkeGQfK2AeM5bMZamr1azlXOkR3bbifwdF38sMj2OXQWoVPE40kvF1mDELaw6YD4dlEVMvlsxXDU2qEbFgupHURKDZo221b9Bq2uUoYJpH9SMZKpV7tqVbSDRp2bSLabfcMc8H5XhraKiVazMSVummRpJIiUAg7XBw+zeU4dQRYzL0wNNMFabuYWdIgg28/S+GOQXL92rO9ISgJbUNXs32vP64FyQANzuPKWq2Sbi7h3DChZ2z1ZPZVZNINpWxF6figyeUavXEeb7Ohpd81XepIl2WjqG5Kz3MXmZ8rc8BZbiI0S+YrB4MgRHlecD57Oq6kd7VfoGIIsTy/ljbnONHgP6RCvvvIk4IUdn+suwWowClaV9O0lVBJAaZGPOEcBrvTWs+dqupkKpC2uR7RFrDlgTKVvtERqppprXUR90EjUdPO3Lnjoed+qNRNLLMNYjSI7sbifa0iYm2FOjA1tvHLuLAM5XXqVUztVPrDqEjS3h1X0wAwXoxv5HFk7ZlcvTp1WzeZRdekoSX70yCAZICgKrbbz6YOznBgCW0t/McxQBtvcn0+GJ+F1KSo4rtPjldRFaQVUCGSVJmRE2xeS1UGrggBm3MreX4ZSq0qdajn66pVchjK6VYCdMaARe15tHrjG7OsfZz1Zjc2iSB/wCPWTgvMaDWqmnSqspfw6Ay7WawHM/DC/MZhVsQytFtTkHkJv5g/HyweJNKkE3fHG35xFtZYHykuR4CTNRszmToZSqlxpMXhvDtbyxtm+DU4crWzGoAMPtORL+GI/CBGFVKspZQWsGUmCNgQSflg3Xl1cNQNSGmdQfmVK+175NthYYUFYGr+k0tkRmLadvK4xTgY+p1qnf5oOh8Ld80WCkeEWPPzt5Yr3DOHtrSo1Ws8BpDzpgpUFp33G4wxz+gsi1ASkyxAJAEMPaWwMkDfcjAxp5akpamDqPsktLDaQAJKiJGrnMcsGFIB3iCLMNy4ydM0mUUg2khyNP3lg29cF0c3lzU/iUSGQqFOkXEQZB9TvuMJez1GkajPADIQVIW4nUDuBytgsV0FQFz7RIRVJGoqYFljSI52E4tjQr884S4QVuxJazmrmapy6qRUNAHQwAURVDnnsLxaZ5YN4xwdlSkKa94EIszaSAumLANqB0xy+dmLVaKB6ldm7sAqddSo3tWNiSSZsI3/Ot8T4rkBDZd3DrcAq8dNyAfZLc+XngEyMWuUVAFQjibZgrFKmRrmVBIsbWhTIJ6+WNuzHB6VTvKtZnBVacJ3joDFJN4IDSbc/ZwLx3iKopy5kuuksYPOH28wRzO+FNdqGnUzhVmCwpGQRfwgv4jtMbSPKWJbCzKci6En41wRdQV31I9a4OokKgGqLkmQbRzxZAwOsLqGggSQom/Lra+BeD9nKepfG8sPFBESAZ5WvIvPTGca4imXrFO7TQI8RNySCWEabxa42kYzs/iHSN6mzHj8D42K3XEj4i1VaLPQc98GCpq0+yxANjuY/TAeQzObL0zmayqoIGk00WVtImCQux5bYyvxalXqUQpgiosQnOQOtv8sFZ5O9KOJgSL01beOWvy6YZjtBRFXKyYjmJKMWqqkjcYqgHTVAbkw0gjcDYna1vLC2vSradbZxy4uStU6tNyYVTbZumxxK2V0xccrmgvu+9vganQNOtTqQ1RSpI+zMHUHQg7rtffphoYdjENgyY1txUCzyVkZiQo8XiEGBqAiSBHMD1ONMpkWfSx9glizDVpGkiBNt78uR3w1z9N6jM9WrUUiCVFIFVIExBqTEDV7tsa5fOAZZgHZ6eooX7vxeIFidMgRHn0wJA7CQPfxNBk4dliSSFImQGeTcAR4t4N9+eDMlkcsjFgKSwR3ZBE2Bkn1wNRrhhKis0XOnKKQAOft/njzh9Lv6gVRV1GAB3aKJsDHjAgeLboJicMYbGJUys5fgrO/iGkATJi8EeHfc/piyUMqikogliygEfzGOXPB1fhndU2eqXAUidKodyF273z3xpw3ieXpU67qazVBTOjUiBQb6TIqE9JtiHJqEsLpMCzNfKJWZChYBz4goN5BO8WmRbyww/stCwqU0ZgLK4EKQQt4I6yI6g4qmWJKzN/wCjiy9lOJFqK5f731geLfwyHiPIqT78U4IFiQHznuZ4U9O50aYM2IK6dTRvBPLluLYiHD9BaHTxMWugMX0xdhtEYuebUsyagCSCCulY2F9t7tB8vfhfl+EjxBiRBgadtgT79RN+eEeNW5NRxVaizhrZ18nmKn1plNAukBKcfZb6tS6iT1BG/PCrg+UzDU6GZLFqfeJMhIgsFsNMgiYmefLDXs1XHccRRmADV61iRcFTBHW8bdcB9neIL/ZYpk+MVFMR90VAZnrKn+jhu9GLJqgIQvC61V9NRxF2WZaNO0iLG+98MafZ9F/2jWn2E57kXIAJjrgRqJkiQKgqNpcfh1HUkddIFyDBGDHNTVDMukEgAkzYuFIEWNwZ6iRE4HWexjlVN7UxjS7H1GQstWnB1EBmM2IAkAbmR7yMB8F7OLXkglQsFiPNWMbWaQBz3PTBT8TzVOktNUdwFRYUVAdhq2EX8+pwZw/KZunlg9OQGcN3YJ1jUTPhKcgYN+U4d4h84GnGAdt/tAM72UoqxP1qwJ8LEavDO/rBi2Nstxht3y2sX3I5R5T15YN4k7v3ZbKliiAanHOTJ5eXzxVkzMe1rj+60DbpGEs/rNPTY9V7eUatUFUsopMh7tzfawP7HAgyFEqkq12ALSdpEgcvljzhuY1M0MR9m16jAAAwDLGABfc9cMqmcpaNDZzJAj/5aHkPxzywzGQRvA6oaHojtFTcMpaXOlvBMm5Aibb7eeBMllwVfwAaULK2lTqIYqAZ23F/TDtuL5VFYfXaAkvGmore2IMxy2MTywmHEcmovm6f3hA8Q0sxIBBOmYIm3xwCubIIMXkRBWmpcuzHE9OTokZdGYqbjSuol2GkQLMFi56gYVdvMw1Gu5RoUlJkA2ggwTefCflgLJdsOG0qS0zWc6GLLoXaYPXqPkMJu1nanI5qslVKrJophCGps06WZpNgPvYiFtZJG3ygZAnhijv3hHHg474Egr3MrsD/ABKW4A6zB5iMVnhdFKlUI7aVO56XE+sCTHlhq3GaVdaoTxVO6Ys+grI107EfAe7CXhYBrLKl11CVBuQJLAX3icNXkxNcR8ndUqlNMvmUbWwVu73trvdmgzpg2mW2gSXX4ZWGcVaS03YUQ4arqEXaR4IE35g9cQ1qtSmKXc5GmjAIBUdFkkgCTF/am888OOAZzMGpVaotIuEWQJVbF5jeLRM29MA7Ac8Q9DRN2kr1zl9NZaSxVB+zLEH2wTLcpm2KqTbFx7SZKq1Ce7++LIxc8+iD44qWYyVVR4qdReV0YfmMTEykbQXDA7zoeczyswTTqJ07SbpKwYHICd+fTepdrac5ikmnQpUELEAAs0mLbxc+WCc12SpVK/iqMDWdjAgxZ326SIviHimROVr5ejlypDUxBqojkB3fURa1idiLb4pcfh1vL16zVS0ZPP1dUF9VSDpFt/CCBb2gGnpim8erFnE8lI+DuP6OGHfZqlVij9XOw192VkNDbCofIx6bYA4lw6qaqUUUNVZbLTmCSztbUSfniJQe6Avyjcmtks3ttB+En7ej/vU/xDF3yVdFCwzAgXMDcr6XE9f1OD8r2bFKpV05YaUKCmzIrFoIDOCwMQfFIiww9pcORaYBSkdNiY5Am86Zn1+OKzMDVRvSZRjB1Dn+5VDXVpBZiNhMCTJnyAkAjE9KiNKML6QbRNtbbDzHP1xX+0XGX+tacpVCU9A1SqgB5aV8Sb+zJ2nDHs02Zd2NdxUolSA66BqIIaPBcQXax6+7CziNWY3N1aOukAwurRrmk3fVNYI0gGQY/FtAkAQoMWFhJwn7HVytFmE/xRsCYsN45TG+F3aTtLmKbClVy1IAHWniYyLgE6HvI5H4YG4XxypRyr1aVOnqbMadJDFQDTkx4pm3XnhmklR6n87zBfvTopp1EcMjHS0gz1J3PQnw8+R94WdpVAabaFpsHBfTGxAR4IiAfDYRacVbg3aTiebqDL5ejSdypIXSwsl5lqkC8CSdyBgLiXariNJjSrUlpuN0ekZ9fEbjzFsRceUHtL8QcS2doqiaaqO5GvUBGwb2lFhtbfyjnhRS7P0xSK1HfW6idMADnAkX9cKKPHc+9Ud6ukahrJoqDBh/vCbggyOoOG9fNMTINv3wePEVFGC76jcU8ToLRAUgECwKgi0WmSZ2wy4FwdyS1KoitZvEpIv5Bh8Z5G2I+LkVKUc/yv8Al/XqRwnO9wEHOACPImPiJ/Ppg9EmubZfiHEqlY0QmXaopI2I2EkgltojFm4Vks6tOKvcKxMgLqNvPzxP2RdCr1jpFSdJYxNt4PUiB7hhpXzJJNxAkDbYGMZ3Ok0BCBvmcuyfAKLZLPPpBajUqAEiT9ndbzI/89cEvwmkOFUMyANcqdtiTDGZnkfjhfkeN0Vp5xPtqgeo7qyKdMVFKkuDsLzfpjKXFkPDhS7itqAFM1f9nZ9cb7zImOcY0ZQxr5wcRAv5QvjHDc6atU/WqiU9RZVDvZSbQAfkMbP2ar9yK1XidQJ4dy5HiE2Pe3tJ92Ds2+X7xi5qBjE6WgXAM+z6c+Qw+FKjmeHijp0wIpvuRoYAGIvOkLysTjN4oRRqFcdo0pZNfeUduCtqZPreZqBZMobEAFgQS/NRIGH/AGR7LKtU1nquV0lQtW5kqpM8rXGLJ2bqIMuWRSijVpGqTCeAeKBNlnA31hnQSSTJbr7OlfnqmfLF5MpqhIFFiF1uF5dBqVKUkwW7tPdcLO/rtj3NVqNBS+vQm0KG3JnYDfA+XqykHkbnlHtftgDiNda1CnoM6nMCCD4dQ2IB3GMotjvITZoQapxVXzTVqTvoSlIMsNomxgzvywGmYzOZpJ9arCGRQwCJLCObIhYkgg79OeDMtww93VQjSaiFNRI8Oobxz3Bi2Pez/DO7R6Rf+E2nUIE+BRMX9ffzxtA90AbSkNE6hc0zvZXhpT7FDKkHeqSRtEtSTf1wNw/snQnxZcMItdr9dziw5iiVpVHBJKIzR6D4fdxFX7Y8PTTGbUkbjQ55bWQ4XnORhSExuEYwDrr94v492Lok0NKUqIIcECJc+HTyG2N6HZjLB5CJUUzClAAsBYg6jM+LnyxtX7V0cyQcqq1Xp+2XV4hojmha6/DkMAca7QuEBrUlpqDdkWrPuVq2k4BQ/h6CTcYQtl1AqCcUySUqlXSqrOXJAXbSWXpabDDbgtfu8hQdIVu+KswpkkjVUMMZgjax2xN2d7PUc7Q+td7Uh1embBSAGg2lhPhnfniDjXDVy+UFJNTL36MCyyfGhYGVIFvT44Ym1KTvEHclhPG4VmzVvXBG8d4VOkEWACEAR92ff0W8R4hmsv4u6RhUQBlLMWMTedPMEcut8WRaurS0kkAgaQb7k87mDyxBns9QHdCpUCsEBGsWabASbTK7G+FnIW2IjAtEE3CuAZ+u3erVoJTAosdSsSJEDTBUEWPntjO0eTWsKVNzpBqT8Ecx78E8KenUaoaJBBpxZlIOwt69T1xWu0XHsvUHdvTJdSQNyA0EA8uuFjF/2hl2AgZHG4i7jITKVKdTLU+8IDMQHsukRJibEE/DG3C3fN16GYq0jCowgEAEh2AHiiQJJMdMHcR4PSpqoo0wrtUQeKdJ1HQZl72YiPPFkrcPpO6Ar4dPhgDSCfFIEWJm5G9sbwQ/B38/6mUnTuRKoaHdMGNODrPNSWBuSdLHaB6TifgjF+LZQmPYJ6+ylX9sWXLcLpq7qtPVIFkUhhJF/CAQfTAFLhNalxNKy5es1FaRGozYsHBvUMmJwDEq2knaGpDi63lu4y57mqDpupG34vD188UrM58KuXYNv3neKG9gD+Ep5gx13M+57xvjE09JplSxG7UxYGfxycVeoFh/CJO23Mn9MAHUzRoofh+0R8BFIvVqVU70s9/Ey6SCZn7JwZB2kQDixdkV7vJsZBg1DINuXkOmKzl+DV0DGWWTqtq3JvMG5i3uwbQzFWlk6VFalNWc1e81G/ibwwD4pNztg2KsCAYnSwq4/pdkaOdLNWNSaZ0jQVG8kzKnyx7xjsxRyeWBohz9sjfaMDcjQfuj7uG3ZPK1GyzhmOpivjjyvY3+IG+N+1dEtl3RFdmDoYUKCQv85A+J5YViIRVVj51DfknvK72c7RnIu5RaTuTDqfCxAJIhgZWCeh3FrTi8ZPttw7PoEzdBkI275QygnmtRZ0+p0nHHs5llWtUerTdGZ1OlypswaIC9Y3vvbY4izlCgtTwIxA5E8/UL+3ScaRpXaZsjEtcJ7QcSDuSrgQfCNcgAbC5mItfGZPN60mQbwYMi0Yr+YywBmBHn+mCuFV1RLkLLE3t0wy1raAu0d1lKmDbmp5EHkfLz5H5DZnMHR5reDy5Eg9I3Bj5CNafaWkgKOpqreNNiDygm0dRfCZuL1NYZfCoYMFF/ZIIknfbY28sWAYdzqXYvOAU6o0M5Z5sV2joWE36Y0zOcy8gVKlRWUQQGZeZ5Dn54g/tJHAmkxjYBUE+8Rf8A4TiYLlGuaeYB6ak/RMcxslsTN46XbmMuy/C6ArZ9GAC99blvTQnbzJPvPXAGR4Sv1GrlwniAqKpnkZK/JhgPs/x+u1fNU6eXQEENDMZnSFAMLzC7+exxnAeL5qvlczmFFBGQuANLH2FBInVYwAJg7Yeymt+1TOhok+cMaoEySVAF1MmqSBPsiIaLflghKNTuKas01SgBaPvaZJ/5oPuGNK1GKeXputhSQEe6CfSZwbRzS1GTcAzBI/ry2xizg61AmtEOgtF/1irQynd1HNRwsFm9pix3nUevntiHvu7K+K2kD4anfblEctxg3jmVIgNUWCQRAaYWN5W9/PAGR0K2kuW1TGr1BI9LnB5LK1KIUkBZHxCHYK6A+BnZL6SZ0ibX9ltweeBKmZCMgFPStMmEWwhtQjyEkxbBzhatQwQoZFE7WueW0hvnhdnuEVEqM7MjpUfwaWJIgTBsOYG2NPTINNtM2U0alko0l8JiJ67jYAfpgasul6xErPduRfkpXlylcE1KGrSysYEdecRsPP54iqO3erAZQdSnaSFIKmSNvEdsNbfaRABvIskSyeI2cMBB5MCD1ESduQwBlOyNNApikzAReitzG/MzN98MHzk1HTSQacMCTJYGzH4xhqjzfecc/LlyI1Azs9N0+HKmoiLM9wGtSpgugVdQJKq2mCLeLSAd/TCHjXsKfa0sDAibyNiPTF2zeYDIabkwQL+G0bQSR064W1uE0dJJrCWgj7MsfCRIlSR/5xuW3AI7zmtWNirdp72RzwXLsjOEHeWUxMOiE/A6h+uPONZJM1IDGF0EMUmWQ1ZEk3Gkg2J5HDDKZ+hSUimtTqQIAOwtN/P440zGeWqVCh1E/eA2IIIj34psbA2IrWpG8ruTzOYpqo7tSFEDUAdPUzIv+8Yiqt3zKSolZ1GQdpJNhbcnn+8CZlojvxPXR8h4By8xgDO5urTANNhJm5DAkcwDJj574QQX2MeHKC5YeylUjP1KQ9haK2/vHSzH1lj8MUfjtsxU/wB5+2G3B+PmhWrVzRJeqwJGoaQCwEAxIjVzXlhfxSnqra2U/aNOkHbYdL74ZVOBEDG2QFhxLnmaFdk15fL1arIQRpGoSNugtvvg/hKZ16warQq0REeKm0dSYmR7yMIaPbOpRXQlFhBP3mj4BbH1nFv4P2jq1Mr3wIViYMidjH3gv6DAZso6ddfJ49N4IxF9o9yeVRJlm1NHID2Z5aj1ONuOcRp5eg1RmqQAYjcGI64HyubI8QCkncm5Pvk28sTcMzrVASQsqzL7I5G246RhHSdY3UuRXHMJ8QxjaVjM9mmrkNVpu53BfQYnrY3wLV7GZYEB6VQFpAGjcxNoXlvbpjoK5l55f8v/AG4XcQzjGoQQp0nw22lRMeE9T8cdIK48orXB+znClp0NC5YU4JGnQoJjYmbk+bTiu/SF9Zp6e6Rlp6CXITwzPMojDYc9sN24rVBbnBI3b9I+cY3o5Y56iTVraUbUoAQk7lWvEXjzxYFHcXBMlpcLQpT0lgQORkHUBNvywHxHgNLQxY1WhhUguY1KZB22nlizUKdKnTA70kKu5FzpH8ovitcR7SI7d0qkBgfE0T5WE2PrgdAELxGqrlXzqZo1DFbShggPRBAno0jUJwfwxqnd1FbuKkoxnuwCSF6ybTO3XFW7R5lkrsVYi1tuambHDrsZVLUWLElhTc3OAdSFuQUTUoIo1idNSkUXm+8D0G+E2dSGiZ+XM/pjoteGQkdeYjkP3xzvif8AFf1w7CbMXkx6JAHxstTEWMjGiLnSOzyakpte6g/LFoXLqRdcc54d2uFJVBpGFAAhumHVL6RaMXp1p9R++OTkwZNR2nZx9TiC0TLVwPgNdM7mMwwRKdZFgFpYMoFiAOs3xt2U4MuXp5imaoOuq7mFMAMAI89t/PFfqcezNB6qK8rTJCqwBEAxH4gI5Ti18NgkzN1U8+YHUR88TOzqwF7GZMYBB9IRmeFrVgqzsQunUNMR7pPyGB24MysrVK2uIgPaI85/TECWOw+H6wD88Z9cbunePEoeImZE/tjPjLOah+IRQhPGuG1KgUos78+sYrzZV0GhlGvUSPGkwRFgTvffAnBK1erRUxruRLsetrE4cf2NVdZWpTpzaAsHzjz9caQpG1ywukEgXBOC0oDmqNJEXJUwAFUXBIBhPmcT8T0vUo0x7IDMSDYGRF+RkYLroqpDVKdQn7uke+66wD66d8JHYgnuwVHQf5Y0LsNzMz1sRz3hKcNdrDvHUWA+0JtttUVflh5w/gNQJHcPuTDBbbX9qf1xWRn6lI62Lldo1Eb4mzjNVIY1HKMtllyBB5+GPfOCBPaVq7mHrwGsuZWoTS0lClQNUCtEDxeIAG4B3wzyoMEaZgwWWWAPQlZXaMVulw+mq6lVQ5H3pPQ7EkDbliLP5bMGO7qqi82JAv66P2wrJgVjvNOLrXxg1Ld3Ia5eiI5O2/8AyK5HvAwozFVTIVCpBgm+kx0MA/LFWfLp/ts9PkpLe6zH8sWigU7pAhkgASQskAWO2r44fiQKukdpnzZmytqbkyGom3qMG8PEVEN/aGBM48KD/fQfFgP1wSlXSdW+m/wvgjxFLzN8yCVA0mN5YAD5AYWZzhZroVEIVIIMTPtW9owLzFuWBMx2jZhHdxz9sn8xixdmvtKIqHdiRFosTHKccrUA1idfP0+XHh9/zlHzfAMwlimpSR4k5Qwbb3Yg4kJekI5xEea8sdRalgLimWHdVDae7aDF9jhgy+8DUzYsmnGy+c5TVSb6ev3D58wcdJ7LUj/Z62+8dg4+95y39chjmZzNU7sp9UQ/9OCv9Js1SpaFZNAPs6BFzOwjnhnV9PkzIFFcgxaZVU36Ts9EWX0/rniTs6sip071+mOMUPpMzw37ogf3f88MuF/SpWpKR9XRpYsfHF2ufuHCOg6HN07ktvflJmzpkAqdrRDa35f54WcRX7Vweo6fhXr+2OfUPpi/FlT7nn9FxlX6VaTOW7ir4iCRIgQALQ/lzx1LPcGZtvOWqqnif1HIf/zg/sio+rxa1RxeJ9s9WGKIv0h5diZRxMb329xw37NduMpSpGmagE1Ha4qj2zq5JHPAlvn/AAZZF8S9Z1PsqkfgbY+R6VCPljnNUfboMWn/AE4ybKR39GSCL1AN/wCZcc643x4Um7xTrKWAUjSZtJaNvQe/A2DxJpM17RU2es4AJNth0BHLBXZriy0PsyQzVIp+A+xqIBk7SJ2E4pOd4tm82xWGhvuU1IB9eZ95jDTs1lmR6SsNLd6tjHVY8sW492jLXmwJcMzl1RSoIaGa/qTb3be7HLM801ah/vt+Zx0vtBwyvqdxmNCEFtC0l5C8mbyb45gGnFdMQboy8+rZj3nipg7hfD++qpSBjUd+kAkn4A/LAoOHnY/NJTzKvUMAK1/M2/e+NLGhEAWYypdg9ZKCsQwn7oIOnnGoGMen6Ph/7kj1p/8Adi58K4xSetaohHLxDkOk2vi0pl9QnGQZcnePONfOc54rkCa1Rg6faSVDNpNzOzWJ8pxbeFSGWZ9hfiFv5YB7ZcM71EqLoApqdU2gWgm0BRBuYAxzfiufr5Z1FKoaZgmFcMpmINiVOFvh8UijxDD6L2nVmpw59T+fp+uPcjTgH+Y/mccyyH0hV1P2tNKnmPC36j5DFp4X2/yj2ctTP94QPiJHxIwlenyY2JI2k1q3eWUIAxAAGxt/W+AOMbD1wXl87SqkvTdWWBcGRz5i2B+MeyD5j8jhqneRuIrXE1NbYFaqBuQPXGozgixJ9BPzAwwrE3I+0I+ynow/PHoqNFPSTBTkP7v8h5+YwLxZy9Mr7Oxl2AFiD1n5YBqcXoro1VqcqseEa+Ufhtg1Ir8MhuWYXpDrpHvOEXHcqpZS0+ydo6+gOAana+mqhVFRgBEgKv7n5YVZjtUxutFJ61Cz/nAGBfG7G1jMToptt41pU02VdRnaSflfFqo1W7pYQqQBIPh2HQgY5pmO1Gba3e6R0QAfpPzwtrZqo/t1Hf8AmYn8zgsWJ1vf/MvNnV6AWp0riGesA1WmsMrQWE+Fg2yz0xHT47TZ1UVCxJiyGPixH5Yo5qgYfcD4RWarRY03VGdRrKmBJAE9Jm074twwU7wcWkuL4sRs+UBJkny/ScWbs7VK0QosAxxMeyp51R7l/wC7DHh3BxTXTqLXmYxx0vvO/wDqGfFkx6UNm5i1STiHiAJp1P5G/I4ZplVGAOMV6VOm+twPCdz5HDBztOIdovzPZLIBbUniPC6VTBPMeIMLC9sc+bhq1c0MuJ0NXFO5vGsA3EXjpjpyAdxTYEEaTMdSQxnzEx/5xzzgThuJKZgCuzT/ACkn9MdkrWYre0yq2rGDOujshknnVkssPFH8BBvzlYt54pVP6O8lmczXu1CmkBVpMBdmge2rWiNuZxfslxDUR4qZiJuPIcjyF9vhGE/ZuqoXM1H1QHS6xNrnfl5b4QmRmM1ZcQQ0ZWeJfRDl1pu9LOVJUTDBG5wPZ04Cr/QvmATozdFv5kdfy1Y6NXzNM0avckvdFI6nvmWBeJ1Bl/4cPBmDN0ce4Hp0Y4cGPeJZRfuz5xz/AGTrZbOU8tWamSzqC9MllGqDeQpmDt88Xb/QAf8AuQJ60mvH8pbEfarMzxOetemIIjpYg3Hs4u0abkECDcQQATAtO1jsJMTbBqC6mue0jKEK3wZybjXDhQrd13iVPCG1KDF5/EAeXTGtPIrUKq+xIxnaipGcHTQPmzYPIjbCmMocGS5/KU8rmMqUEK2oG+5AEHbz+WPM1SUZykLAMyfmBz9MG9qWVqVIgwykMPOYsMCHhDZiotSoIAAAHXnt++E5SPE1cbTdhBfAUG5uMO1+YSmjhmDE0mIutjBAtEx798cnU4683DXAhMvUq85Qp4dxcO6yTfbp54qnFuy2ZerqXK1AhtdRI6mEJnFdPkq7ieowgUByJTZw+7IZQvWPQLfrc2jBP+jKpUXvjUp0yYLOumJmPEYG/lfB/Aez9YVKrZUJWRSFkvB2kw2nSfj0w7JlVkIG8XhxkOCTUe0MktSqaQh1UHUxggMI8EEGTBBPSRjfP5WlRYIU3UHwKI5j8QvbpiGguYosGqZbNKBqgIiuo1kMxmmSTcC5G2JaXailTZ9Wgl2Dfal0YeFVjSaZgeGffjCETVVETe2V9N2p/i/rGvbgGnkc4xEQioCeeshbdR4o92OT8Vo/wV/+NB8sda+lSoDwuqZB1VaaiOc+L9Mct4y4NdUAnTpHyxsw3Quc7JzJOH9l1rjw1tLaoAK6p2vaIufljTiPYvNUQWhXUc0PLqQYP54tXZHKqVWqZa7x+R+MfIYedo6w+rMJ9ohf+r9I9+LGY3COEVc5ZwdHSsPaQwbiQdsWulxasBDEOvRh+og/HE2S4XT+rvVKTUkkNJteIjaIn44ENPFOwcytJSKq/G6gYhVRYJEhb28zgWrxKs3tVW9xj8ox59VNTMGkCAWYwTtzPLDNOz9NSO8rkzyVP1J/TFk40q4okyu5vcE3PniGD0xacxw+lTenGoqZnWRyiNgsY8zfA1iST7yP2OC9oQAGQITuIPkOybuqu9alTVgGFyxg3FrD54YZjsrQSk7B6ruoBkjSu4m3pMXwz4B4qVAKCWus6JA7snc+YaIJHPDPiH8MqySzK8EnaxvcWgKu3PBFz2lqo5MquT4TlzspmY0mCeUE2Fp8+WPeJ8MRaNXwCRSDA85VwSRa0jljfL5/7MsiCFqQwgljJ5AczbBJAdXCtIenUTaIOlt/ORGM4dww1Tay4yh08xh2FqkZMaAgc1TqfQpaJizESMP66t3tIsWOmtTEsTzen+5xVewFb/Vx/vPzP+eHme4itOWKtC1UckX9l1PxMWHphGbfKRFpsgl+bGoGFWS7Q0KxCqxDHZWBB/b54ZLjKQRsYZNibQMUbO0GOZrwJGsT5Fhb4xi7Nin5rP8Ad5msBB1MhIn8IDD4zglNG5r6AkZDXl/kQd8pVWwVgknUF2IBhpjkDGAqXClSoWWn3Z63Bvz6ycNqvECdQAgMlQCwMF31t/8AWwwZls0rPVcmNaML85ixA9P0wfiEN8R3nUGJTZbGP4+UWq9SI7xoO0hT+k/PBnBuImgjqQtRarydY5gbdIjywec2hTSpuNe+10bqI9ojzsOmJKuRp1aMKADCeIfdZmadreV/LFJa7oagZ1xZK8VPqZK3EwAIpBfEjGGMQjBojad74ap2opzdGHwP64r2f0fdES7RBMaYVlj3OB7hidOFq1TSpIknTqvYBSOlzP6YeMuUdwYj2HpGUNuOfzvKX2qy1ermnr01aDXVlIImBrvv/eFsE8R43mKajTrXeQwJHnIZZ+fXFpHD/ASW/wBmXNvQx8Dv5HE1ThrSVZgQpVZM3kgC0bAsPjjT0/XviPwAiZ+o/TcGTjIRX56ec5L2mr/61sSQgBgcwTIx7lXzFV7IYI5j0vjqC8PIBFoBawM+yYJvynCx6I1NsLDywteps1p3isn6cqLq12PlF/D+F2GrxkWE7D0w5RgokncEX8oGIO/VZHn8oGBKHe5glKUQD4nPsrN/e3lv6b4S9sbMJSuNa4H3lh4Nm/bjlp/U/rg45lsB5HIiigRSTzJJuSdz/lggYQRvMzsWNyU5gmxAI6G+JKWZIsBA6DA+nHoGKg3DBX6431TgEHG2o4ku5TuN0TmKC0ajMKYqCoI5FQQPVYJt8IxUc52bq94aqnWTO2+0bfsTi8UXlADBhhaxgTe0T7+c4lFAMTBAgDkR+LlyuBOHplYTdkw42NkUfMSs9lqvdotNiZUey1oJiQJ+MeZwX2qzQimm1ix/4jA/wn44OfLqwBqBSGFriQd/UWjCfi/BjUgpUiBADREDa8YYuZWPvbRXsrKAU3A/n/UP4ayjKFefdlvhp/c4T4E016FJkuLH0M+YMfHC6jxciziMMRSbImTOApAueZYxn0P/AMn5jFpr0RADRc2G+wJ+d98UxswDmkcba1/QYu1SuskXLAkWF4nA9UoIF+UxkCKeNME7totqgjy38umBamfNQmVKJynf09MFdo1101CC4cHe+zX8sLadB26DzJnC8Y/6gD6x2HG54Blh7HZ7RSqLvDz8f/GHRZXYPUCCPvNteJ3tiqZDh5QE62gm8WEgTvhjlshqIaxEElnJMR5meuHHMo2modDk5YgSFGSiWSgC4mSyywMxJvYbDptic1K7j2VW49pp+Qw4qZYDRDSG6A9QLTE74aUMjTGqVBO1zIBsbb3jrfCbYm6jvZcKC2JP0lN4LwFqSaQ7NebKB+c4bVMkqzqBMfjM/mY+GG2RqBUBvuxMQIsDM3NwAItvgTiyk1Nxp3EEnmbkkm8YFiW3JmpMeNG0qv5+894RSitS82GLylI4ouTrAVqR6Otvfi/ZfPUzzj1wkC+Zn674hMNHFf412SoZhizKVY7skAnlfwmbDni2KoN1IPpjZaWGKCNxMNjvObt9HRH8LNVF/mUH/CVxC3Y3iCDwZim/82pfzD46j3OPe6w3U3eErlfhJH7zk78J4olzRSp/I6fqUxFVzucpiKuSrAeSMfmgbHXO6x73eKpTyojh1eccOfv95xepx1aZBqo9ObjWCvw1BcOcl2vpkhu9OoXkjV06T0GOm1aeoQ1x0OFWc7M5Sp/EytB/M01n4xiFEPmP3jB1+eqNH5iU6p2jBAVaqadJU8iQRpvPl+QwxpcVmSCrFnDWMwQwa19pUfDBuY7AZBtqJT+SpUX5Bo+WF9f6NcufYrZhP+JW/wASE/PE0Dsxhjrz/wCsY+0Lr56FZWEHxA3tJMm3WfP8sVTime7tmvEgGfjhvU+jquP4WdI/npn81qD8saf+n9dnDV6tOppEAeKDcmSCPPaeWKXGAbLXKydarJpCV9pX8hSfMQWJSl1+83p0Hn8OuLdk6iooVAFUbAf1vgzL9lW+9UHuX/PDXKcISmNtR6kfl0xTG5j1EmzzFQzAxsKuHfcAbCPTGpp4CpRMVBW/Ccb06Z54LzDKgl2VR1YgfnhPme0mTTeujHokt/hBxYUniCWqMywxrqxVs127y4slOo/nZR+c/LCKr2vBJPcf81Zyf0wa4GPaQ5BNc9Vq0GiopKTZxt7zy98YOyfGATqDSYje/wDVzjMZiFAU1TZgzsXCNuDJ61QNTQC7A2ne8fuN+hwZURSEJi8cr3HW2MxmFA2JuYaWAEGfKsDFmkfmcJM9wWi8wNJ8tvh+0YzGYllDayALlBDi5Vctk6ZO1wevTpi78P4BrSa7MZHsybevnjMZjcDq5nNz1ixroABPfvA+LcMQU5oNKBtLc49DzGBMuiggXIJExvjzGYzOaG06GIncE3W0sgor3elEUOTIDeK8SBe0lR06YjycqHLSCFMwdJklbAxYz5YzGYmQ7KfziKTckHvX1M1q5oaaRI5sSpbUSJXc73g/DBj8ZC+InnJJMchb4zyxmMxR+Ko0qoxEkXV/eIcx2lFKyuCOgAv5ycAPx/MVTNOkzctTTHPmYHPHuMxobGqL5zlnq8jnba/KN+zfB8xUqK9RWchgRpJCgjrYA/HHR8nwQm7tHkP3xmMwgjUd4tie8b5fIIlwt+pucEGnj3GYYAIFzAuPQBjMZi6knsYzTjMZiSTNOPNOPcZiSCasmM0Y9xmKlzXRgLNcVy9O1StSU9C4n4TOMxmLVQTLJ2inMdtMkvsuzn+4h/NoGEec+kVJIp5dj5u4HyAP549xmGeGtwCSIizPb7NNZVpUx1Cyf/sSPlhJnO0WbqTqr1I8jp+Sxj3GYYEUdoskxNXpljJJJ6m/zN8eU6bSIBPp/U4zGYI8ShzGKZFzEqff/njY8L8wPef2xmMxjfKQdo2f/9k=');
INSERT INTO `branch` (`branch_id`, `title`, `address`, `hotline`, `image`) VALUES
(3, 'Chi nhánh Quận 3', '79 Hồ Xuân Hương, Phường 6, Quận 3, Hồ Chí Minh', '02476231243', 'data:image/jpeg;base64,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'),
(4, 'Chi nhánh Quận 4', '15 Đ. Hoàng Diệu, Phường 12, Quận 4, Hồ Chí Minh', '0912342332', '');

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
(6, 3, 2, 1, 1),
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
(151, 4, 1, 1, 1),
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
(200, 4, 50, 1, 0);

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
(5, 'Truyện Tranh');

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
  `deactivate` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `codesale`
--

INSERT INTO `codesale` (`id`, `code`, `createAt`, `startAt`, `endAt`, `value`, `min`, `max`, `description`, `deactivate`) VALUES
(1, 'ABCDEF567', '2024-08-06 07:32:31', '2024-08-01 17:00:00', '2024-08-02 11:00:00', 25000, 125000, 0, 'Giảm 25k cho đơn tối thiểu 125k', 1);

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
(8, 'Very good', 1, 1, '2024-08-05 04:54:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `import`
--

CREATE TABLE `import` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `import` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `import`
--

INSERT INTO `import` (`id`, `title`, `import`, `quantity`) VALUES
(2, 'Nhập hàng ngày 08-08-2024', '2024-08-08 07:05:38', 64);

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
(6, 4, 2, 0, 596, 596),
(7, 5, 2, 1, 790, 791),
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
(52, 50, 2, 0, 499, 499);

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
(49, 36, 1, 157460, 157460, 50);

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
(50, 1, 0);

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
(1, 1, 1, 4),
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
  `transport_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `typePayment` tinyint(1) DEFAULT NULL,
  `shippedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `address` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL,
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
(11, '2024-08-08 09:48:58', NULL, '2024-08-14 17:00:00', '1234 main St United States California', 'Truc Trinh', 50, 5110940, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `plannedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `actualAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'trinhtruc', 'Trịnh Ngọc Trung Trực', '0934541496', '2003-02-04', '0934541496', '1', '2024-08-06 02:07:03', 'trungtruc201563@gmail.com', 'public/assets/img/z5560424909017_c8bb3df0db4112634d4fca60a4df59ba.jpg', 0),
(2, 'nguyenvana', 'Nguyễn Văn A', '012345678', '2002-08-06', '12345678', NULL, '2024-08-06 02:54:06', 'nguyenvana@gmail.com', NULL, 0);

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
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branchstockitem`
--
ALTER TABLE `branchstockitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `codesale`
--
ALTER TABLE `codesale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `import`
--
ALTER TABLE `import`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `import_item`
--
ALTER TABLE `import_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
