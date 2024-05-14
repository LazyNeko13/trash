-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 04:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sampah_collection`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id_agen` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `latitude` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `block_reason` text DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agen`
--

INSERT INTO `agen` (`id_agen`, `nama`, `alamat`, `latitude`, `longitude`, `status`, `block_reason`, `create_by`, `create_date`) VALUES
(1, 'Agen 1', 'Jl. Kalianyar Buring No.9, Buring, Kec. Kedungkandang, Kota Malang, Jawa Timur 65135', '-8.0127232', '112.6416621', 'Y', NULL, NULL, '2024-05-14 15:39:49'),
(2, 'Agen 2', 'Aliyan Business Centre, Jl. Hasanuddin No.66 Building A 5th Floor, Plipir, Sekardangan, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61215', '-7.4637711', '112.7214832', 'N', 'Renovasi', NULL, '2024-05-14 15:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `agen_member`
--

CREATE TABLE `agen_member` (
  `id_agen` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agen_member`
--

INSERT INTO `agen_member` (`id_agen`, `id_user`) VALUES
(2, 5),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `penukaran`
--

CREATE TABLE `penukaran` (
  `id_penukaran` int(11) NOT NULL,
  `id_agen` int(11) DEFAULT NULL,
  `id_pengirim` int(11) DEFAULT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `poin` double DEFAULT 0,
  `jumlah` double DEFAULT NULL,
  `bukti_kirim` varchar(200) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penukaran`
--

INSERT INTO `penukaran` (`id_penukaran`, `id_agen`, `id_pengirim`, `id_penerima`, `poin`, `jumlah`, `bukti_kirim`, `create_by`, `create_date`) VALUES
(2, 1, 7, 4, 40, 3, '66435f720ef23.png', NULL, '2024-05-14 19:56:18'),
(3, 1, 7, 4, 40, 1, '6643602c8460d.jpg', NULL, '2024-05-14 19:59:24'),
(4, 1, 7, 4, 30, 3, '6643612968f78.jpg', NULL, '2024-05-14 20:03:37'),
(6, 1, 9, 4, 20, 2, '66436218ddead.png', NULL, '2024-05-14 20:07:36'),
(7, 1, 10, 4, 40, 4, '66437840dc50f.png', 4, '2024-05-14 21:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `poin`
--

CREATE TABLE `poin` (
  `id_poin` int(11) NOT NULL,
  `jumlah_minimal` double DEFAULT NULL,
  `jumlah_maximal` double DEFAULT NULL,
  `poin` double DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poin`
--

INSERT INTO `poin` (`id_poin`, `jumlah_minimal`, `jumlah_maximal`, `poin`, `create_by`, `create_date`) VALUES
(7, 1, 2, 10, 1, '2024-05-14 18:19:19'),
(8, 2, 3, 20, 1, '2024-05-14 18:19:29'),
(9, 3, 4, 30, 1, '2024-05-14 18:19:40'),
(10, 4, 5, 40, 1, '2024-05-14 18:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `password` varchar(200) DEFAULT NULL,
  `role` tinyint(4) DEFAULT NULL COMMENT '1 = admin, 2 = user, 3 = pengepul',
  `block_reason` text DEFAULT NULL,
  `poin` double DEFAULT 0,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `nama`, `status`, `password`, `role`, `block_reason`, `poin`, `create_by`, `create_date`) VALUES
(1, 'jjeje1303@gmail.com', 'Sidatata Al Jennar', 'Y', '7103162c6797cb0a579e961fecdd42f690891ccf2369c23641a862161a5af95b', 1, NULL, 0, NULL, '2024-05-14 05:38:52'),
(4, 'pengepul1@gmail.com', 'Pengepul 1', 'Y', '49105992f8ce154225d00d0f128aac20c8ef063ec9a2e536e5c28060b27a1cfe', 3, NULL, 0, 1, '2024-05-14 16:37:30'),
(5, 'pengepul2@gmail.com', 'Pengepul 2', 'Y', '89c6f8f55f77a53fca1fb386f29c64f0d6304711989977579f7ab2ad103a4ba7', 3, NULL, 0, 1, '2024-05-14 16:37:58'),
(6, 'pengepul3@gmail.com', 'Pengepul 3', 'Y', '38c52966558c2d3232b3c017f0da8f2266c6814da69a87e96ba4fb9561375c4d', 3, NULL, 0, 1, '2024-05-14 17:44:49'),
(7, 'user1@gmail.com', 'User 1', 'Y', '72797cb37f9900545fcd58be1001d0f69af810cdc3d4006bc90674c32a21b27d', 2, NULL, 70, 1, '2024-05-14 19:33:28'),
(9, 'user2@gmail.com', 'user 2', 'Y', '420bc764d523b688cc0adbcde9b83a68ce2760e0d60c000e729435ace6e79209', 2, NULL, 20, NULL, '2024-05-14 20:07:36'),
(10, 'user3@gmail.com', 'User 3', 'Y', '64313b92c3b9f5130e63e018ec0ede80df189b93aec3a8ce1e253570d82d4949', 2, NULL, 40, NULL, '2024-05-14 21:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id_voucher` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `poin` double DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `block_reason` text DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id_voucher`, `nama`, `keterangan`, `poin`, `status`, `block_reason`, `create_by`, `create_date`) VALUES
(1, 'Voucher makan gratis', 'Dapatkan paket makan siang gratis senilai 100.000 di balai desa dengan menyetorkan voucher ini', 10, 'Y', NULL, 1, '2024-05-14 18:36:10'),
(3, 'Voucher mandi', 'Mandi gratis di kolam cangar', 20, 'Y', NULL, NULL, '2024-05-14 20:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_penukaran`
--

CREATE TABLE `voucher_penukaran` (
  `id_voucher` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `poin` double DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher_penukaran`
--

INSERT INTO `voucher_penukaran` (`id_voucher`, `id_user`, `poin`, `tanggal`) VALUES
(1, 7, 10, '2024-05-14 21:08:48'),
(1, 7, 10, '2024-05-14 21:10:01'),
(3, 7, 20, '2024-05-14 21:10:27'),
(1, 7, 10, '2024-05-14 21:13:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id_agen`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `agen_member`
--
ALTER TABLE `agen_member`
  ADD KEY `id_agen` (`id_agen`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `penukaran`
--
ALTER TABLE `penukaran`
  ADD PRIMARY KEY (`id_penukaran`),
  ADD KEY `create_by` (`create_by`),
  ADD KEY `id_penerima` (`id_penerima`),
  ADD KEY `id_pengirim` (`id_pengirim`),
  ADD KEY `id_agen` (`id_agen`);

--
-- Indexes for table `poin`
--
ALTER TABLE `poin`
  ADD PRIMARY KEY (`id_poin`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id_voucher`),
  ADD KEY `create_by` (`create_by`);

--
-- Indexes for table `voucher_penukaran`
--
ALTER TABLE `voucher_penukaran`
  ADD KEY `id_voucher` (`id_voucher`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agen`
--
ALTER TABLE `agen`
  MODIFY `id_agen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penukaran`
--
ALTER TABLE `penukaran`
  MODIFY `id_penukaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `poin`
--
ALTER TABLE `poin`
  MODIFY `id_poin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agen`
--
ALTER TABLE `agen`
  ADD CONSTRAINT `agen_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `agen_member`
--
ALTER TABLE `agen_member`
  ADD CONSTRAINT `agen_member_ibfk_1` FOREIGN KEY (`id_agen`) REFERENCES `agen` (`id_agen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agen_member_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penukaran`
--
ALTER TABLE `penukaran`
  ADD CONSTRAINT `penukaran_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `penukaran_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penukaran_ibfk_3` FOREIGN KEY (`id_pengirim`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penukaran_ibfk_4` FOREIGN KEY (`id_agen`) REFERENCES `agen` (`id_agen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poin`
--
ALTER TABLE `poin`
  ADD CONSTRAINT `poin_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `voucher_penukaran`
--
ALTER TABLE `voucher_penukaran`
  ADD CONSTRAINT `voucher_penukaran_ibfk_1` FOREIGN KEY (`id_voucher`) REFERENCES `voucher` (`id_voucher`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voucher_penukaran_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
