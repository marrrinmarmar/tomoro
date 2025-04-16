-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 03:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_daftar_menu`
--

CREATE TABLE `tb_daftar_menu` (
  `id` int(10) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `nama_menu` varchar(200) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `kategori` int(10) DEFAULT NULL,
  `harga` varchar(50) DEFAULT NULL,
  `stok` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_daftar_menu`
--

INSERT INTO `tb_daftar_menu` (`id`, `foto`, `nama_menu`, `keterangan`, `kategori`, `harga`, `stok`) VALUES
(2, 'latte.jpeg', 'Caffe Latte', 'Espresso dengan susu steamed', 2, '25000', '15'),
(3, 'croissant.jpeg', 'Croissant', 'Roti mentega khas Prancis', 1, '18000', '10'),
(4, 'nasi_goreng.jpeg', 'Nasi Goreng', 'Nasi goreng spesial dengan telur dan ayam', 4, '30000', '8'),
(5, 'matcha.jpeg', 'Matcha Latte', 'Teh hijau dengan susu steamed', 5, '28000', '12'),
(7, '972847-cncicecream.jpeg', 'Es Krim Cookies n Cream', '', 3, '16000', '55'),
(14, '479264-es kopi susu.jpeg', 'Es Cokelat Kopi Susu Creamy', 'Campuran antara Cokelat Dan kopi ditambahkan Susu Fresh Creamy', 3, '8000', '104');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori_menu`
--

CREATE TABLE `tb_kategori_menu` (
  `id` int(10) NOT NULL,
  `jenis_menu` int(10) DEFAULT NULL,
  `kategori_menu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori_menu`
--

INSERT INTO `tb_kategori_menu` (`id`, `jenis_menu`, `kategori_menu`) VALUES
(1, 1, 'Roti'),
(2, 2, 'Kopi'),
(3, 3, 'Es Krim'),
(4, 4, 'Nasi'),
(5, 5, 'Matcha'),
(6, 1, 'Kentang');

-- --------------------------------------------------------

--
-- Table structure for table `tb_list_order`
--

CREATE TABLE `tb_list_order` (
  `id_list_order` int(10) NOT NULL,
  `menu` int(10) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_list_order`
--

INSERT INTO `tb_list_order` (`id_list_order`, `menu`, `order`, `jumlah`) VALUES
(6, 5, 18, 1),
(7, 2, 20, 4),
(8, 3, 16, 5),
(9, 3, 25, 8),
(10, 2, 25, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `id_order` int(10) NOT NULL,
  `kode_order` varchar(200) DEFAULT NULL,
  `pelanggan` varchar(200) DEFAULT NULL,
  `meja` int(10) DEFAULT NULL,
  `pelayan` int(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `waktu_order` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`id_order`, `kode_order`, `pelanggan`, `meja`, `pelayan`, `status`, `waktu_order`, `catatan`) VALUES
(16, 'ORD001', 'Marin', 1, 1, 'dibayar', '2025-04-08 03:00:00', NULL),
(18, 'ORD003', 'Sakura', 3, 3, 'menunggu', '2025-04-08 03:30:00', NULL),
(20, 'ORD005', 'Aoi', 4, 2, 'proses', '2025-04-08 04:00:00', NULL),
(25, '2504160845277', 'pelanggan merin', 4, 2, 'dibayar', '2025-04-15 20:46:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `level` int(1) DEFAULT NULL,
  `nohp` varchar(15) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `nama`, `username`, `password`, `level`, `nohp`, `alamat`) VALUES
(1, 'abc1', 'abc1@abc.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, '08129129121921', NULL),
(2, 'owner', 'admin@admin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, '08129129121921', NULL),
(3, 'abc3', 'abc2@abc.com', '5f4dcc3b5aa765d61d8327deb882cf99', 3, '08129129121921', NULL),
(4, 'abc2', 'abc3@abc.com', '5f4dcc3b5aa765d61d8327deb882cf99', 4, '08129129121921', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_daftar_menu`
--
ALTER TABLE `tb_daftar_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `tb_kategori_menu`
--
ALTER TABLE `tb_kategori_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_list_order`
--
ALTER TABLE `tb_list_order`
  ADD PRIMARY KEY (`id_list_order`),
  ADD KEY `FK_tb_list_order_tb_daftar_menu` (`menu`),
  ADD KEY `FK_tb_list_order_tb_order` (`order`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `pelayan` (`pelayan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_daftar_menu`
--
ALTER TABLE `tb_daftar_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_kategori_menu`
--
ALTER TABLE `tb_kategori_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_list_order`
--
ALTER TABLE `tb_list_order`
  MODIFY `id_list_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_daftar_menu`
--
ALTER TABLE `tb_daftar_menu`
  ADD CONSTRAINT `tb_daftar_menu_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `tb_kategori_menu` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_list_order`
--
ALTER TABLE `tb_list_order`
  ADD CONSTRAINT `FK_tb_list_order_tb_daftar_menu` FOREIGN KEY (`menu`) REFERENCES `tb_daftar_menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tb_list_order_tb_order` FOREIGN KEY (`order`) REFERENCES `tb_order` (`id_order`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD CONSTRAINT `tb_order_ibfk_1` FOREIGN KEY (`pelayan`) REFERENCES `tb_user` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
