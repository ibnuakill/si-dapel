-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: localhost:3306
-- Generation Time: Nov 05, 2024 at 09:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Database: `sidapel`
-- --------------------------------------------------------

-- Table structure for table `admin`
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `admin`
INSERT INTO `admin` (`id_admin`, `username`, `password`, `alamat`) VALUES 
(1, 'admin', 'admin123', 'jl baru baru'),
(3, 'farhan', '$2y$10$JAoOaMT3XwF4LMmYxs.91ubYFM/B69OFSUwKmEz3aIxLuVOggHfEO', NULL),
(4, 'ibnu', '$2y$10$pRfkHStKE3BaKwZFgaf99uLT63qrhxse3EnKZkYjhw7a1lML96EBy', NULL);

-- Table structure for table `pemilih`
CREATE TABLE `pemilih` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nkk` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `umur` int NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` enum('Belum Sinkron','Tersinkronisasi') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `pemilih`
INSERT INTO `pemilih` (`id`, `nik`, `nama`, `nkk`, `jenis_kelamin`, `umur`, `tgl_lahir`, `status`) VALUES 
(3, '3201012345678901', 'Budi Santoso', '3201011234567890', 'Laki-Laki', 53, '1964-12-12', 'Tersinkronisasi'),
(4, '3201023456789012', 'Siti Aminah', '3201022345678901', 'Perempuan', 45, '1972-12-06', 'Tersinkronisasi'),
(6, '3201034567890123', 'Joko Widodo', '3201033456789012', 'Laki-Laki', 34, '1982-02-08', 'Belum Sinkron'),
(7, '3201044567890123', 'Rina Suharti', '3201045678901234', 'Perempuan', 30, '1994-04-15', 'Tersinkronisasi'),
(8, '3209190504050002', 'farhan al haji', '3209190504050004', 'Laki-Laki', 80, '1973-12-31', 'Belum Sinkron');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `pemilih`
--
ALTER TABLE `pemilih`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pemilih`
--
ALTER TABLE `pemilih`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
