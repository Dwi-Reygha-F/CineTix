-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2025 at 06:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `name`, `password`, `created_at`) VALUES
(4, 'eghanvidia@gmail.com', 'iwan', '$2y$10$oaqriEy4/hTbUdhz0hTuguEItVbXKNaI684ySlIKn93gn55.j6lja', '2025-01-23 14:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `akun_mall`
--

CREATE TABLE `akun_mall` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(231) NOT NULL,
  `nama_mall` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akun_mall`
--

INSERT INTO `akun_mall` (`id`, `email`, `password`, `nama_mall`) VALUES
(2, '', '', 'CINERE'),
(3, '', '', 'CINERE BELLEVUE XXI'),
(4, '', '', 'DEPOK XXI'),
(5, '', '', 'MARGO CITY XXI'),
(6, '', '', 'PESONA SQUARE XXI'),
(7, '', '', 'THE PARK SAWANGAN XXI'),
(8, '', '', 'TSM XXI CIBUBUR');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int NOT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(231) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `trailer` varchar(231) NOT NULL,
  `nama_film` varchar(100) NOT NULL,
  `judul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_menit` varchar(231) NOT NULL,
  `usia` varchar(231) NOT NULL,
  `genre` varchar(231) NOT NULL,
  `dimensi` varchar(231) NOT NULL,
  `Producer` varchar(231) NOT NULL,
  `Director` varchar(231) NOT NULL,
  `Writer` varchar(231) NOT NULL,
  `Cast` varchar(231) NOT NULL,
  `Distributor` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `poster`, `banner`, `trailer`, `nama_film`, `judul`, `total_menit`, `usia`, `genre`, `dimensi`, `Producer`, `Director`, `Writer`, `Cast`, `Distributor`) VALUES
(11, 'uploads/poster/paddington2.jpg', 'uploads/banner/film2.jpg', 'uploads/trailer/173528896843522.mp4', 'Paddington in Peru', 'Paddington kembali ke Peru untuk mengunjungi Bibi Lucy tercintanya. Bersama keluarga Brown, petualangan tak terduga terjadi saat sebuah misteri membawa mereka ke perjalanan tak terlupakan.', '106', 'SU', 'Family, Comedy, Adventure', '2D', 'Rosie Alison', 'Dougal Wilson', 'Mark Burton, Jon Foster, James Lamont', 'Ben Whishaw, Imelda Staunton, Antonio Banderas, Oliver Maltman, Joel Fry, Robbie Gee, Sanjeev Bhaskar, Ben Miller, Jessica Hynes, Madeleine Harris, Emily Mortimer, Hugh Bonneville, Samuel Joslin, Hayl', 'Sony Pictures'),
(12, 'uploads/poster/pos1kakak.jpg', 'uploads/banner/film4.jpg', 'uploads/trailer/173624013657939.mp4', '1 KAKAK 7 PONAKAN', 'Setelah kematian mendadak kakak-kakaknya, Hendarmoko (Chicco Kurniawan) seorang arsitek muda yang sedang berjuang, tiba-tiba menjadi orangtua tunggal bagi keponakan-keponakannya. Ketika kesempatan untuk kehidupan yang lebih baik muncul, dia harus memilih antara kehidupan cintanya, karier atau keponakan-keponakannya.', '131', 'SU', 'Drama', '2D', 'Lachman G. Samtani, Suryana Paramita, Manoj K. Samtani, Deepak G. Samtani', 'Yandy Laurens', 'Yandy Laurens', 'Chicco Kurniawan, Amanda Rawles, Fatih Unru, Freya Jkt48, Nadif H.s., Kawai Labiba, Ringgo Agus Rahman, Niken Anjani, Kiki Narendra, Maudy Koesnaedi', 'Mandela Picture, Cerita Films, Legacy Pictures');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_film`
--

CREATE TABLE `jadwal_film` (
  `id` int NOT NULL,
  `mall_id` int NOT NULL,
  `film_id` int NOT NULL,
  `studio` varchar(231) NOT NULL,
  `jam_tayang_1` time NOT NULL,
  `jam_tayang_2` time DEFAULT NULL,
  `jam_tayang_3` time DEFAULT NULL,
  `tanggal_tayang` date NOT NULL,
  `tanggal_akhir_tayang` date NOT NULL,
  `total_menit` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal_film`
--

INSERT INTO `jadwal_film` (`id`, `mall_id`, `film_id`, `studio`, `jam_tayang_1`, `jam_tayang_2`, `jam_tayang_3`, `tanggal_tayang`, `tanggal_akhir_tayang`, `total_menit`) VALUES
(1, 2, 11, 'Studio 1', '09:56:00', '10:56:00', '00:56:00', '2025-01-25', '2025-01-31', '106'),
(2, 4, 11, 'Studio 1', '11:23:00', '01:23:00', '04:23:00', '2025-01-01', '2025-01-31', '106'),
(4, 5, 11, 'Studio 1', '11:38:00', '00:38:00', '01:38:00', '2025-01-01', '2025-01-25', '106');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `created_at`) VALUES
(1, 'eghatamvanz@gmail.com', 'Reygha', '$2y$10$KPfUb8Phy1h7UB1jrDnwFOpkmtcA5vVwJ1B9bRJHsNPzApQcbwS8.', '2025-01-22 18:50:08'),
(6, 'veeltzee23@gmail.com', 'Iwan', '$2y$10$wvsDqk4peqZsvei3u1ZMv.cpmXqiSaEUDFzzVpzOsa11JRGx0OfGW', '2025-01-24 01:45:37'),
(7, 'veenevire@gmail.com', 'gw', '$2y$10$8Q4pA0YxfVbBTAx2janpMuqlmxPeZhTWOC3HbYP3VDxduiAWr1HUi', '2025-01-25 06:34:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `akun_mall`
--
ALTER TABLE `akun_mall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mall_id` (`mall_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `akun_mall`
--
ALTER TABLE `akun_mall`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  ADD CONSTRAINT `jadwal_film_ibfk_1` FOREIGN KEY (`mall_id`) REFERENCES `akun_mall` (`id`),
  ADD CONSTRAINT `jadwal_film_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
