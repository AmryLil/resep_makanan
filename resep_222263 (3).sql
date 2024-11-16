-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2024 at 02:01 PM
-- Server version: 8.0.32
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resep_222263`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_222263`
--

CREATE TABLE `admin_222263` (
  `id` int NOT NULL,
  `username_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_222263`
--

INSERT INTO `admin_222263` (`id`, `username_222263`, `password_222263`) VALUES
(1, 'admin123', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `categories_222263`
--

CREATE TABLE `categories_222263` (
  `id` int NOT NULL,
  `name_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at_222263` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at_222263` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_222263`
--

INSERT INTO `categories_222263` (`id`, `name_222263`, `created_at_222263`, `updated_at_222263`) VALUES
(22, 'Kue Basah', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(23, 'Kue Kering', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(24, 'Kue Tradisional', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(25, 'Kue Modern', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(26, 'Kue Ulang Tahun', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(27, 'Kue Ekonomis', '2024-10-27 14:52:45', '2024-10-27 14:52:45'),
(28, 'Kue Premium', '2024-10-27 14:52:45', '2024-10-27 14:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `comments_222263`
--

CREATE TABLE `comments_222263` (
  `id_222263` int NOT NULL,
  `resep_id_222263` int NOT NULL,
  `user_id_222263` int NOT NULL,
  `comment_text_222263` text NOT NULL,
  `created_at_222263` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments_222263`
--

INSERT INTO `comments_222263` (`id_222263`, `resep_id_222263`, `user_id_222263`, `comment_text_222263`, `created_at_222263`) VALUES
(4, 352, 19, 'manisnyee', '2024-11-03 10:48:42'),
(5, 347, 19, 'lapis berapa ini', '2024-11-03 10:49:30'),
(6, 351, 19, 'hahaha', '2024-11-03 10:54:10'),
(7, 347, 19, 'Resepnya sangat enak, keluarga saya suka!', '2024-11-10 12:54:36'),
(8, 347, 20, 'Mudah dibuat dan rasanya mantap!', '2024-11-10 12:54:36'),
(9, 347, 21, 'Terima kasih resepnya, sangat membantu.', '2024-11-10 12:54:36'),
(10, 348, 22, 'Resep ini mengingatkan saya pada masakan ibu.', '2024-11-10 12:54:36'),
(11, 348, 23, 'Rasanya lezat, cocok untuk hidangan keluarga.', '2024-11-10 12:54:36'),
(12, 348, 19, 'Suka sekali! Akan saya buat lagi.', '2024-11-10 12:54:36'),
(13, 349, 20, 'Saya tambahkan sedikit bumbu, makin mantap!', '2024-11-10 12:54:36'),
(14, 349, 21, 'Anak-anak suka, resepnya simpel dan enak.', '2024-11-10 12:54:36'),
(15, 349, 22, 'Terima kasih sudah berbagi resepnya.', '2024-11-10 12:54:36'),
(16, 350, 23, 'Resepnya sangat jelas, hasilnya enak sekali!', '2024-11-10 12:54:36'),
(17, 350, 19, 'Saya coba buat kemarin, hasilnya bagus.', '2024-11-10 12:54:36'),
(18, 350, 20, 'Resep yang mudah diikuti, rasanya top.', '2024-11-10 12:54:36'),
(19, 351, 21, 'Pasti akan saya buat lagi, sangat enak!', '2024-11-10 12:54:36'),
(20, 351, 22, 'Saya suka dengan rasa bumbunya.', '2024-11-10 12:54:36'),
(21, 351, 23, 'Terima kasih, keluargaku suka resep ini.', '2024-11-10 12:54:36'),
(22, 352, 19, 'Resepnya simpel, cocok untuk pemula.', '2024-11-10 12:54:36'),
(23, 352, 20, 'Penyajian yang praktis dan mudah dibuat.', '2024-11-10 12:54:36'),
(24, 352, 21, 'Rasanya pas, tidak terlalu asin.', '2024-11-10 12:54:36'),
(25, 353, 22, 'Resep ini luar biasa, lezat dan gampang.', '2024-11-10 12:54:36'),
(26, 353, 23, 'Suka banget! Ini favorit keluarga sekarang.', '2024-11-10 12:54:36'),
(27, 353, 19, 'Membuatnya sangat mudah dan rasanya enak.', '2024-11-10 12:54:36'),
(28, 354, 20, 'Resep yang luar biasa, simpel dan lezat!', '2024-11-10 12:54:36'),
(29, 354, 21, 'Hasilnya sangat enak, terima kasih.', '2024-11-10 12:54:36'),
(30, 354, 22, 'Resepnya bagus, saya rekomendasikan.', '2024-11-10 12:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `favorites_222263`
--

CREATE TABLE `favorites_222263` (
  `id` int NOT NULL,
  `user_id_222263` int NOT NULL,
  `resep_id_222263` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorites_222263`
--

INSERT INTO `favorites_222263` (`id`, `user_id_222263`, `resep_id_222263`, `created_at`) VALUES
(5, 19, 352, '2024-11-03 10:48:32'),
(6, 19, 350, '2024-11-03 10:48:53'),
(7, 19, 353, '2024-11-03 10:49:13'),
(8, 19, 349, '2024-11-10 13:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `reseps_222263`
--

CREATE TABLE `reseps_222263` (
  `id` int NOT NULL,
  `judul_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_222263` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_222263` int NOT NULL,
  `cover_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at_222263` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id_222263` int DEFAULT NULL,
  `bahan_222263` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `langkah_pembuatan_222263` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reseps_222263`
--

INSERT INTO `reseps_222263` (`id`, `judul_222263`, `kategori_222263`, `deskripsi_222263`, `jumlah_222263`, `cover_222263`, `created_at_222263`, `user_id_222263`, `bahan_222263`, `langkah_pembuatan_222263`) VALUES
(347, 'Kue Lapis', '22', 'Kue lapis dengan tekstur kenyal dan manis.', 20, 'inna-safa-jKtc6vHbnxU-unsplash.jpg', '2024-10-27 14:52:45', 1, '1. 1. 1. 500 gram tepung beras\n, 2. 2. 300 gram gula pasir\n, 3. 3. 500 ml santan\n, 4. 4. Pewarna makanan secukupnya', '1. 1. 1. Campur semua bahan\r, 2. 2. aduk hingga rata.\r, 3. 2. Panaskan loyang\r, 4. 3. tuang adonan bergantian sesuai warna lapisannya.\r, 5. 3. Kukus hingga matang.'),
(348, 'Kue Nastar', '22', 'Kue kering isi nanas yang lembut dan renyah.', 50, 'inna-safa-saTHWyeTGQQ-unsplash.jpg', '2024-10-27 14:52:45', 1, '1. 1. 500 gram tepung terigu\r, 2. 250 gram mentega\r, 3. 100 gram gula halus\r, 4. Selai nanas secukupnya', '1. 1. Campur mentega dan gula\r, 2. aduk hingga lembut.\r, 2. Tambahkan tepung terigu\r, 3. uleni hingga kalis.\r, 3. Bentuk adonan\r, 4. isi dengan selai nanas.\r, 4. Panggang dalam oven hingga matang.'),
(349, 'Kue Putu Ayu', '24', 'Kue basah lembut dengan rasa pandan dan taburan kelapa parut.', 15, 'rizky-rahmat-hidayat--_myPHSmJG4-unsplash.jpg', '2024-10-27 14:52:45', 1, '1. 1. 1. 300 gram tepung terigu\r, 2. 2. 200 gram gula pasir\r, 3. 3. 200 ml santan\r, 4. 4. Kelapa parut secukupnya\r, 5. 5. Pewarna hijau pandan', '1. 1. 1. Campur tepung\r, 2. 2. gula\r, 3. 3. dan santan\r, 4. 4. aduk rata.\r, 5. 2. Tambahkan pewarna pandan.\r, 6. 3. Masukkan adonan ke cetakan dan tambahkan kelapa parut di atasnya.\r, 7. 4. Kukus selama 15 menit.'),
(350, 'Brownies Kukus', '22', 'Brownies kukus yang lembut dan moist.', 12, 'Oreo Brownies (Made fom Scratch) _ Plated Cravings.jpg', '2024-10-27 14:52:45', 1, '1. 1. 250 gram tepung terigu\r, 2. 200 gram cokelat batang\r, 3. 200 gram gula pasir\r, 4. 100 ml minyak sayur\r, 5. 5 butir telur', '1. 1. Lelehkan cokelat batang dan campur dengan minyak.\r, 2. Kocok telur dan gula hingga mengembang.\r, 3. Campur adonan cokelat dan tepung terigu.\r, 4. Tuang ke loyang dan kukus selama 30 menit.'),
(351, 'Cheesecake', '25', 'Cheesecake lembut dengan rasa keju yang dominan.', 8, 'Kitchen\'s Whispers.jpg', '2024-10-27 14:52:45', 1, '1. 1. 1. 250 gram krim keju\r, 2. 2. 200 ml krim cair\r, 3. 3. 100 gram gula pasir\r, 4. 4. 200 gram biskuit untuk base\r, 5. 5. 100 gram mentega cair', '1. 1. 1. Hancurkan biskuit dan campur dengan mentega\r, 2. 2. tekan di dasar loyang.\r, 3. 2. Kocok krim keju dan gula hingga lembut.\r, 4. 3. Tambahkan krim cair dan aduk hingga rata.\r, 5. 4. Tuang di atas base dan dinginkan di kulkas.'),
(352, 'Kue Tart', '22', 'Kue tart untuk ulang tahun dengan dekorasi buttercream.', 1, 'download.jpg', '2024-10-27 14:52:45', 1, '1. 1. 500 gram tepung terigu\r, 2. 300 gram mentega\r, 3. 300 gram gula pasir\r, 4. 8 butir telur\r, 5. Buttercream untuk hiasan', '1. 1. Kocok mentega dan gula hingga lembut.\r, 2. Masukkan telur satu per satu\r, 2. aduk rata.\r, 3. Tambahkan tepung terigu dan aduk rata.\r, 4. Panggang dalam oven hingga matang\r, 3. hias dengan buttercream.'),
(353, 'Kue Lumpur', '22', 'Kue basah yang lembut dan lezat dengan aroma vanila.', 15, 'Kue Lumpur Labu Kuning Lembut dan Simpel - Resep _ ResepKoki.jpg', '2024-10-27 14:52:45', 1, '1. 1. 200 gram tepung terigu\r, 2. 250 ml santan\r, 3. 150 gram gula pasir\r, 4. 100 gram kentang kukus\r, 2. haluskan\r, 5. 2 butir telur\r, 6. 1 sdt vanili', '1. 1. Campur semua bahan dan aduk hingga rata.\r, 2. Panaskan cetakan kue lumpur dan tuang adonan.\r, 3. Panggang hingga matang dan bagian atasnya mengeras sedikit.'),
(354, 'Chiffon Cake', '25', 'Chiffon cake yang ringan dan lembut dengan tekstur empuk.', 8, 'Mango Chiffon Cake.jpg', '2024-10-27 14:52:45', 1, '1. 1. 1. 250 gram tepung terigu\r, 2. 2. 200 gram gula pasir\r, 3. 3. 5 butir telur\r, 4. 4. 200 ml minyak sayur\r, 5. 5. 1 sdt baking powder\r, 6. 6. 1 sdt vanila', '1. 1. 1. Kocok telur dan gula hingga mengembang.\r, 2. 2. Tambahkan minyak\r, 3. 2. tepung\r, 4. 3. baking powder\r, 5. 4. dan vanila\r, 6. 5. aduk rata.\r, 7. 3. Tuang ke loyang chiffon dan panggang hingga matang.');

-- --------------------------------------------------------

--
-- Table structure for table `users_222263`
--

CREATE TABLE `users_222263` (
  `id` int NOT NULL,
  `username_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullname_222263` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_222263`
--

INSERT INTO `users_222263` (`id`, `username_222263`, `email_222263`, `password_222263`, `fullname_222263`) VALUES
(19, 'gita', 'gita123@gmail.com', 'gita1234', 'GItaaaa'),
(20, 'budi123', 'budi123@example.com', 'password123', 'Budi Santoso'),
(21, 'siti456', 'siti456@example.com', 'passw0rd!', 'Siti Aminah'),
(22, 'agus789', 'agus789@example.com', 'mysecurepassword', 'Agus Wijaya'),
(23, 'lia321', 'lia321@example.com', 'qwerty1234', 'Lia Kurniawati');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_222263`
--
ALTER TABLE `admin_222263`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_222263`
--
ALTER TABLE `categories_222263`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments_222263`
--
ALTER TABLE `comments_222263`
  ADD PRIMARY KEY (`id_222263`),
  ADD KEY `resep_id_222263` (`resep_id_222263`),
  ADD KEY `user_id_222263` (`user_id_222263`);

--
-- Indexes for table `favorites_222263`
--
ALTER TABLE `favorites_222263`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_222263` (`user_id_222263`),
  ADD KEY `resep_id_222263` (`resep_id_222263`);

--
-- Indexes for table `reseps_222263`
--
ALTER TABLE `reseps_222263`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_222263`
--
ALTER TABLE `users_222263`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_222263` (`username_222263`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_222263`
--
ALTER TABLE `admin_222263`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories_222263`
--
ALTER TABLE `categories_222263`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comments_222263`
--
ALTER TABLE `comments_222263`
  MODIFY `id_222263` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `favorites_222263`
--
ALTER TABLE `favorites_222263`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reseps_222263`
--
ALTER TABLE `reseps_222263`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `users_222263`
--
ALTER TABLE `users_222263`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments_222263`
--
ALTER TABLE `comments_222263`
  ADD CONSTRAINT `comments_222263_ibfk_1` FOREIGN KEY (`resep_id_222263`) REFERENCES `reseps_222263` (`id`),
  ADD CONSTRAINT `comments_222263_ibfk_2` FOREIGN KEY (`user_id_222263`) REFERENCES `users_222263` (`id`);

--
-- Constraints for table `favorites_222263`
--
ALTER TABLE `favorites_222263`
  ADD CONSTRAINT `favorites_222263_ibfk_1` FOREIGN KEY (`user_id_222263`) REFERENCES `users_222263` (`id`),
  ADD CONSTRAINT `favorites_222263_ibfk_2` FOREIGN KEY (`resep_id_222263`) REFERENCES `reseps_222263` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
