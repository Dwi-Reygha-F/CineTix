-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 14, 2025 at 04:30 PM
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
(4, 'eghanvidia@gmail.com', 'Reygha', '$2y$10$oaqriEy4/hTbUdhz0hTuguEItVbXKNaI684ySlIKn93gn55.j6lja', '2025-01-23 14:26:01'),
(10, 'veeltzee23@gmail.com', 'Bayu Fahri P', '$2y$10$ui7z.ywWRi1jcuuAHrLAPea9zdh3uMi6LydQk7jX2EEoxaXuc3U5m', '2025-01-30 04:44:27'),
(11, 'ajanuar66@gmail.com', 'Ari Januar', '$2y$10$gPWVtvQNYG0kk4wkIuvRuO4mF9bmVl.R1AZHRwp/hxb/WZ.j51eGq', '2025-01-30 05:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `akun_mall`
--

CREATE TABLE `akun_mall` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(231) NOT NULL,
  `nama_mall` varchar(231) NOT NULL,
  `nik` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akun_mall`
--

INSERT INTO `akun_mall` (`id`, `email`, `password`, `nama_mall`, `nik`) VALUES
(2, '', '', 'CINERE', ''),
(3, '', '', 'CINERE BELLEVUE XXI', ''),
(4, '', '', 'DEPOK XXI', ''),
(5, '', '', 'MARGO CITY XXI', ''),
(6, '', '', 'PESONA SQUARE XXI', ''),
(7, '', '', 'THE PARK SAWANGAN XXI', ''),
(8, '', '', 'TSM XXI CIBUBUR', ''),
(9, '', '', 'PLAZA CIBUBUR', '');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int NOT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(231) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `trailer` varchar(231) NOT NULL,
  `nama_film` varchar(231) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `judul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_menit` varchar(231) NOT NULL,
  `usia` varchar(231) NOT NULL,
  `genre` varchar(231) NOT NULL,
  `dimensi` varchar(231) NOT NULL,
  `Producer` varchar(231) NOT NULL,
  `Director` varchar(231) NOT NULL,
  `Writer` varchar(231) NOT NULL,
  `Cast` varchar(231) NOT NULL,
  `Distributor` varchar(231) NOT NULL,
  `harga` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `poster`, `banner`, `trailer`, `nama_film`, `judul`, `total_menit`, `usia`, `genre`, `dimensi`, `Producer`, `Director`, `Writer`, `Cast`, `Distributor`, `harga`) VALUES
(15, 'uploads/poster/images.jpeg', 'uploads/banner/ikan lele.jpeg', 'uploads/trailer/videoplayback.mp4', 'Sakamoto Days', 'Berkisah tentang Taro Sakamoto, seorang pensiunan pembunuh bayaran legendaris yang telah menjalani kehidupan yang tenang dan biasa-biasa saja sebagai seorang pria berkeluarga. Namun, kehidupan damainya terganggu ketika mantan musuh dan rekan semasa menjadi pembunuh bayaran datang untuk membalas dendam. Untuk melindungi keluarga dan orang-orang yang dicintainya, Sakamoto harus menggunakan keterampilan tempurnya yang luar biasa untuk menghadapi berbagai musuh sambil mencoba mempertahankan penampilannya yang biasa.', '90', 'SU', 'Action,Comedy', '2D', 'Masaki Watanabe', 'Taku Kishimoto', 'Renka Misaki', ' Tomokazu Sugita,Nobunaga Shimazaki', 'TMS Entertainment', '30000'),
(16, 'uploads/poster/pos1kakak.jpg', 'uploads/banner/film4.jpg', 'uploads/trailer/173624013657939.mp4', '1 Kakak 7 Ponakan', 'Seorang kakak yang menafkahi 7 ponakan', '120', 'SU', 'Drama,Comedy', '2D', 'Bayu Fahri Prayogo', 'Bayu Fahri Prayogo', 'Bayu Fahri Prayogo', 'Bayu Fahri Prayogo', 'Bayu Fahri Prayogo', '30000'),
(17, 'uploads/poster/poster_trans.jpg', 'uploads/banner/Transformers-Revenge-Of-The-Fallen-Thumbnail-A.jpg', 'uploads/trailer/Transformers Revenge of the Fallen  Official Trailer  Paramount Movies - Paramount Movies (720p, h264).mp4', 'Transformers: Revenge of the Fallen', 'Transformers: Revenge of the Fallen is a 2009 American science fiction film based on Hasbro\'s Transformers toy line. The film is the second installment in the Transformers film series and the sequel to Transformers (2007). The film is directed by Michael Bay and written by Ehren Kruger, Roberto Orci, and Alex Kurtzman. Set two years after the events of Transformers, Revenge of the Fallen sees Optimus Prime (voiced by Peter Cullen), Sam Witwicky (Shia LaBeouf), and the Autobots allying once again in the war against the Decepticons, led by Megatron (voiced by Hugo Weaving). An ancient Decepticon named the Fallen (voiced by Tony Todd) seeks revenge on Earth and intends to find and activate a machine that would destroy the Sun and all life in the process.', '120', '17', 'Action,War,Sci-Fi', '2D', 'Michael Bay', 'Michael Bay', 'Michael Bay', 'Megan Fox ', 'Lorenzo di Bonaventura', '40000'),
(18, 'uploads/poster/Doraemon-Nobita\'s_Earth_Symphony.jpg', 'uploads/banner/images (1).jpeg', 'uploads/trailer/Official Trailer DORAEMON THE MOVIE NOBITA’S EARTH SYMPHONY 🎼🎶🎵 - Cinépolis Indonesia - Cinépolis Indonesia (720p, h264).mp4', 'DORAEMON EARTH SIMPONY', 'Doraemon the movie ', '120', 'SU', 'Comedy,Animation,Drama,Epic', '2D', 'Kazuaki Imai', 'Fujiko F. Fujio', 'Fujiko F. Fujio', ' Wasabi Mizuta Megumi Ohara Yumi Kakazu Subaru Kimura Tomokazu Seki', 'Toho', '35000'),
(19, 'uploads/poster/poster sweet home.jpeg', 'uploads/banner/sweet home banner.jpeg', 'uploads/trailer/videoplayback (1).mp4', 'Sweet Home', 'Hyun, a loner high school student who lost his entire family in a terrible accident, is forced to leave his home and has to face a new reality where monsters are trying to wipe out all of humanity. Now he must fight against all odds to try and race against the clock to save what is left of the human race before it\'s too late.', '90', '17', 'Drama,Fantasy,Horror', '2D', 'Bayu Fahri', ' Lee Eung-Bok', ' Kim Kan-Bi (webcomic), Hwang Young-Chan (webcomic), Heung So-Ri, Kim Hyung-Min, Park So-Ri', 'Cha Hyun-Su,Seo Yi-Kyung,Pyeon Sang-Wook', 'Netflix', '50000'),
(20, 'uploads/poster/my name poster.jpg', 'uploads/banner/my name banner.jpg', 'uploads/trailer/videoplayback (2).mp4', 'My Name', 'My Name[2] (Hangul: 마이 네임; RR: Mai Neim) adalah seri televisi streaming Korea Selatan tahun 2021 yang disutradarai oleh Kim Jin-min dan dibintangi oleh Han So-hee, Park Hee-soon, dan Ahn Bo-hyun. Seri ini berkisah tentang seorang wanita yang bergabung dengan geng untuk membalas kematian ayahnya kemudian menyamar sebagai polisi.[3] Tiga dari delapan episode diputar di Festival Film Internasional Busan ke-26 dalam bagian \'On Screen\' pada 7 Oktober 2021.[4] Seri ini dirilis di Netflix pada 15 Oktober 2021.[5]', '90', '17', 'Action,Crime,Political', '2D', 'Bae Joon-mo Choi Myung-gyu Yeom Jun-ho', 'Kim Jin-min', 'Kim Ba-da', '	 Han So-hee,Park Hee-soon,Ahn Bo-hyun', 'Netflix', '70000'),
(21, 'uploads/poster/upin ipin poster.jpg', 'uploads/banner/upin ipin banner.jpg', 'uploads/trailer/videoplayback (3).mp4', 'Upin ipin Siamang Tunggal', 'Upin & Ipin: Keris Siamang Tunggal (bahasa Inggris: Upin & Ipin: The Lone Gibbon Kris) adalah sebuah film petualangan animasi komputer Malaysia tahun 2019. Film tersebut mengisahkan petualangan sepasang saudara kembar Upin & Ipin dan keenam sahabatnya; Ehsan, Fizi, Mail, Jarjit, Mei Mei, dan Susanti dalam menyelamatkan kerajaan fantasi Inderaloka, dimana mereka menyelamatkan dan mempertahankan kerajaan tersebut dari raja yang jahat, yaitu Raja Bersiong.', '90', 'SU', '', '2D', 'Hj. Burhanuddin bin Md Radzi Hjh. Ainon binti Ariff', 'Ahmad Razuri bin Roseli Adam bin Amiruddin', 'Ahmad Razuri bin Roseli', 'Dwi  Reygha', 'Les qopaque', '60000');

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
(9, 2, 15, 'Studio 1', '07:57:00', '09:57:00', '11:57:00', '2025-02-03', '2025-02-28', '90'),
(10, 3, 16, 'Studio 2', '07:58:00', '08:58:00', '11:58:00', '2025-02-05', '2025-02-28', '120'),
(11, 4, 17, 'Studio 1', '09:58:00', '10:58:00', '00:59:00', '2025-02-03', '2025-02-28', '120'),
(12, 2, 17, 'Studio 1', '13:45:00', '16:45:00', '17:45:00', '2025-02-06', '2025-02-13', '120'),
(13, 5, 19, 'Studio 1', '08:31:00', '09:31:00', '00:31:00', '2025-02-08', '2025-02-28', '90'),
(14, 7, 20, 'Studio 1', '09:43:00', '00:43:00', '02:43:00', '2025-02-11', '2025-02-28', '90'),
(15, 6, 21, 'Studio 2', '13:10:00', '16:10:00', '18:10:00', '2025-02-28', '2025-04-05', '90');

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
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `mall_name` varchar(255) DEFAULT NULL,
  `seat_number` varchar(10) DEFAULT NULL,
  `status` enum('available','occupied') DEFAULT 'available',
  `film_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `mall_name`, `seat_number`, `status`, `film_name`) VALUES
(41, 'CINERE', 'A10', 'occupied', 'Sakamoto Days'),
(42, 'DEPOK XXI', 'A5', 'occupied', 'Transformers: Revenge of the Fallen'),
(43, 'DEPOK XXI', 'A1', 'occupied', 'Transformers: Revenge of the Fallen'),
(44, 'DEPOK XXI', 'A3', 'occupied', 'Transformers: Revenge of the Fallen'),
(45, 'CINERE', 'A2', 'occupied', 'Sakamoto Days'),
(46, 'DEPOK XXI', 'A10', 'occupied', 'Transformers: Revenge of the Fallen'),
(47, 'DEPOK XXI', 'A6', 'occupied', 'Transformers: Revenge of the Fallen'),
(48, 'CINERE BELLEVUE XXI', 'A7', 'occupied', '1 Kakak 7 Ponakan'),
(49, 'DEPOK XXI', 'A8', 'occupied', 'Transformers: Revenge of the Fallen'),
(50, 'DEPOK XXI', 'E10', 'occupied', 'Transformers: Revenge of the Fallen'),
(51, 'DEPOK XXI', 'A9', 'occupied', 'Transformers: Revenge of the Fallen'),
(52, 'DEPOK XXI', 'A4', 'occupied', 'Transformers: Revenge of the Fallen');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `amount` int NOT NULL,
  `transaction_time` datetime NOT NULL,
  `username` varchar(250) NOT NULL,
  `seat_number` varchar(250) NOT NULL,
  `nama_film` varchar(231) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `status`, `payment_type`, `amount`, `transaction_time`, `username`, `seat_number`, `nama_film`) VALUES
(17, 'TIX-1738544464', 'settlement', 'qris', 30000, '2025-02-03 08:01:10', 'veeltzee23@gmail.com', 'A10', 'Sakamoto Days'),
(18, 'TIX-1738551582', 'settlement', 'qris', 40000, '2025-02-03 09:59:45', 'nurrishqi@gmail.com', 'A5', 'Transformers: Revenge of the Fallen'),
(19, 'TIX-1738553121', 'settlement', 'qris', 40000, '2025-02-03 10:25:25', 'shellasantika33@gmail.com', 'A1', 'Transformers: Revenge of the Fallen'),
(20, 'TIX-1738556024', 'settlement', 'qris', 40000, '2025-02-03 11:13:45', 'veeltzee23@gmail.com', 'A3', 'Transformers: Revenge of the Fallen'),
(21, 'TIX-1738557572', 'settlement', 'qris', 30000, '2025-02-03 11:39:34', 'sy1226894@gmail.com', 'A2', 'Sakamoto Days'),
(22, 'TIX-1738557674', 'settlement', 'qris', 40000, '2025-02-03 11:41:20', 'sy1226894@gmail.com', 'A10', 'Transformers: Revenge of the Fallen'),
(23, 'TIX-1738563923', 'settlement', 'qris', 40000, '2025-02-03 13:25:30', 'bioskopxii@gmail.com', 'A6', 'Transformers: Revenge of the Fallen'),
(24, 'TIX-1739326834', 'settlement', 'qris', 30000, '2025-02-12 09:20:38', 'eghanvidia@gmail.com', 'A7', '1 Kakak 7 Ponakan'),
(25, 'TIX-1740119580', 'settlement', 'qris', 40000, '2025-02-21 13:33:12', 'eghatamvanz@gmail.com', 'E10', 'Transformers: Revenge of the Fallen');

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
(17, 'eghanvidia@gmail.com', 'Rehan Sanjaya', '$2y$10$FXGS1uv2Np4TCrk1i8TXhexJ/.8DCR7CYutMQdJhfGBnUxPrJgs9O', '2025-02-20 01:37:56'),
(18, 'eghatamvanz@gmail.com', 'Dwi Reygha Febryan', '$2y$10$qJCLfgCFvm5Hscwjmn8zUuRLbx5vbtYFL8g.i4RH9z3GtTSnTzevW', '2025-02-20 01:38:58'),
(19, 'bioskopxii@gmail.com', 'Rehan Sanjaya', '$2y$10$XTpFNz2.ewH.iM/GYX93IOD1LjbS6.5fiGfRsbXUzOPv.mP7BzWC.', '2025-02-20 01:40:13');

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
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `akun_mall`
--
ALTER TABLE `akun_mall`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jadwal_film`
--
ALTER TABLE `jadwal_film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
