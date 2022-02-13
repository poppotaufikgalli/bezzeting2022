-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 13 Feb 2022 pada 16.50
-- Versi server: 10.6.4-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpegtpinang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_bazzeting`
--

CREATE TABLE `ref_bazzeting` (
  `kunker` varchar(10) NOT NULL,
  `kkomp` varchar(4) NOT NULL,
  `jenisjab` int(11) DEFAULT NULL,
  `kjabfung` varchar(5) NOT NULL,
  `jabfung` varchar(100) NOT NULL,
  `jml` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_bazzeting`
--

INSERT INTO `ref_bazzeting` (`kunker`, `kkomp`, `jenisjab`, `kjabfung`, `jabfung`, `jml`) VALUES
('7200000000', '7200', 4, '0000', 'FUNGSIONAL UMUM', 2),
('7200000000', '7200', 2, '05000', 'PENELITI', 2),
('7201060000', '7201', 2, '06214', 'ARSIPARIS AHLI PERTAMA', 1),
('7203000000', '7203', 2, '05312', 'AUDITOR AHLI MADYA', 4),
('7203000000', '7203', 2, '05313', 'AUDITOR AHLI MUDA', 10),
('7203000000', '7203', 2, '06213', 'ARSIPARIS AHLI MUDA', 1),
('7203000000', '7203', 4, '0688', 'BENDAHARA', 1),
('7203010200', '7203', 4, '0173', 'PENGADMINISTRASI UMUM', 2),
('7206000000', '7206', 2, '05011', 'PENELITI UTAMA', 1),
('7206030000', '7206', 2, '05012', 'PENELITI MADYA', 1),
('7206030000', '7206', 2, '05100', 'PRANATA LABORATORIUM', 1),
('7207000000', '7207', 2, '06213', 'ARSIPARIS AHLI MUDA', 2),
('7207020100', '7207', 2, '07502', 'ANALIS KEPEGAWAIAN MUDA', 2),
('7207030100', '7207', 2, '07500', 'ANALIS KEPEGAWAIAN', 1),
('7212000000', '7212', 2, '05311', 'AUDITOR AHLI UTAMA', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ref_bazzeting`
--
ALTER TABLE `ref_bazzeting`
  ADD PRIMARY KEY (`kunker`,`kjabfung`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
