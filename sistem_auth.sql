-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 02:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user',
  `nama_lengkap` varchar(100) DEFAULT '',
  `usia` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`, `nama_lengkap`, `usia`) VALUES
(1, 'fika', 'lia@gmail.com', '$2y$10$R/h.w9iukWzTenHgU6sIZeW8C/poSbo5qc57TSN1dJfIb0gCIypTO', '2026-05-07 05:42:08', 'admin', 'Fika Febrianti', 19),
(2, 'Aditya', 'fikanishimura2812@gmail.com', '123456', '2026-05-10 12:54:52', 'user', 'Aditya Alif F', 23),
(3, 'nephintrh_', 'nephintputri@gamail.com', '$2y$10$wbFWZJdtIUzfwgmJqFL8JecREcpKtyd38wz9rGyKYOXhIaweqthhK', '2026-05-10 13:20:33', 'user', 'neysha putri arifah', 19),
(4, 'kamaliyaaaa', 'kamaliya@gmail.com', '$2y$10$WWp./AvrFH8un7qpF3KsG.gpuQpoGGwt6UNdzE9nM3QRn7rI/U8aK', '2026-05-10 13:23:55', 'user', 'Siti Kamaliyah', 19),
(5, 'iryana30', 'septiairyana@gmail.com', '$2y$10$dCaiElH9UZKwGdZ7AJ/lDeUgOIy2Yo9ozBRVYfo95Hp3sm0k4sm9O', '2026-05-10 13:32:30', 'user', 'Iryana Septia', 19),
(6, 'acaa', 'luiscaf@gmail.com', '123456', '2026-05-10 13:45:34', 'user', 'Luisca Fernanda', 19),
(7, 'mingyu', 'mingyu@gmail.com', '$2y$10$49uHv8mldIHK2t.9SpR1EOfzWCmi7/BCNN6TUj2mwiu78fAo.SfPG', '2026-05-10 14:01:42', 'user', 'Kim Mingyu', 28),
(8, 'obayimanni', 'obayimanni@gmail.com', '$2y$10$LAebGHFIZIgP9vQoVTfzhuDlzmiIeSWXp59q4Dk8Q9x.7f86ZVID2', '2026-05-12 07:12:08', 'user', 'obay imanni', 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
