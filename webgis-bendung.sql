-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2024 at 10:04 AM
-- Server version: 8.0.30
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgis-bendung`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori_bendung`
--

CREATE TABLE `m_kategori_bendung` (
  `id_kategori_bendung` int NOT NULL,
  `kd_kategori_bendung` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'NULL',
  `nm_kategori_bendung` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `marker` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_kategori_bendung`
--

INSERT INTO `m_kategori_bendung` (`id_kategori_bendung`, `kd_kategori_bendung`, `nm_kategori_bendung`, `marker`) VALUES
(1, '001', 'Bendung', 'dam1.png'),
(2, '002', 'Pintu air', 'sluice1.png');

-- --------------------------------------------------------

--
-- Table structure for table `m_kecamatan`
--

CREATE TABLE `m_kecamatan` (
  `id_kecamatan` int NOT NULL,
  `kd_kecamatan` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nm_kecamatan` varchar(30) NOT NULL,
  `geojson_kecamatan` varchar(30) NOT NULL,
  `warna_kecamatan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_kecamatan`
--

INSERT INTO `m_kecamatan` (`id_kecamatan`, `kd_kecamatan`, `nm_kecamatan`, `geojson_kecamatan`, `warna_kecamatan`) VALUES
(6, '32.16.02', 'Babelan', 'BABELAN.geojson', '#009900'),
(8, '32.16.23', 'Bojongmangu', 'BOJONGMANGU.geojson', '#0de70d'),
(16, '32.16.16', 'Cabangbungin', 'CABANGBUNGIN.geojson', '#880000'),
(17, '32.16.22', 'Cibarusah', 'CIBARUSAH.geojson', '#000099'),
(18, '32.16.07', 'Cibitung', 'CIBITUNG.geojson', '#dd9900'),
(19, '32.16.08', 'Cikarang Barat', 'CIKARANG_BARAT.geojson', '#009999'),
(20, '32.16.20', 'Cikarang Pusat', 'CIKARANG_PUSAT.geojson', '#ff0099'),
(21, '32.16.19', 'Cikarang Selatan', 'CIKARANG_SELATAN.geojson', '#990099'),
(22, '32.16.11', 'Cikarang Timur', 'CIKARANG_TIMUR.geojson', '#662222'),
(23, '32.16.09', 'Cikarang Utara', 'CIKARANG_UTARA.geojson', '#000000'),
(24, '32.16.10', 'Karangbahagia', 'KARANGBAHAGIA.geojson', '#1821a5'),
(57, '32.16.12', 'Kedungwaringin', 'KEDUNGWARINGIN.geojson', '#14babd'),
(58, '32.16.17', 'Muara Gembong', 'MUARA_GEMBONG.geojson', '#c431b8'),
(59, '32.16.13', 'Pebayuran', 'PEBAYURAN.geojson', '#cec027'),
(60, '32.16.21', 'Serang Baru', 'SERANG_BARU.geojson', '#d75737'),
(61, '32.16.18', 'Setu', 'SETU.geojson', '#c91818'),
(62, '32.16.14', 'Sukakarya', 'SUKAKARYA.geojson', '#b92d69'),
(63, '32.16.15', 'Sukatani', 'SUKATANI.geojson', '#be3ca6'),
(64, '32.16.03', 'Sukawangi', 'SUKAWANGI.geojson', '#7330c5'),
(65, '32.16.04', 'Tambelang', 'TAMBELANG.geojson', '#40b3b5'),
(66, '32.16.06', 'Tambun Selatan', 'TAMBUN_SELATAN.geojson', '#49bc80'),
(67, '32.16.05', 'Tambun Utara', 'TAMBUN_UTARA.geojson', '#c4de3f'),
(68, '32.16.01', 'Tarumajaya', 'TARUMAJAYA.geojson', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nm_pengguna` varchar(20) NOT NULL,
  `kt_sandi` varchar(150) NOT NULL,
  `level` enum('Admin','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nm_pengguna`, `kt_sandi`, `level`) VALUES
(1, 'admin', '$2y$10$oNX.X8jgLhNclHBeI8ytT.1vODlml8.AN1Ieb.rSIChhCa1e7cS0S', 'Admin'),
(2, 'user', '$2y$10$oNX.X8jgLhNclHBeI8ytT.1vODlml8.AN1Ieb.rSIChhCa1e7cS0S', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `t_bendung`
--

CREATE TABLE `t_bendung` (
  `id_bendung` int NOT NULL,
  `id_kecamatan` int NOT NULL,
  `id_kategori_bendung` int NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `struktur` varchar(30) NOT NULL,
  `jumlah_pintu` int NOT NULL,
  `dimensi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jenis_pintu` varchar(30) NOT NULL,
  `lat` float(9,6) NOT NULL,
  `lng` float(9,6) NOT NULL,
  `polygon` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_bendung`
--

INSERT INTO `t_bendung` (`id_bendung`, `id_kecamatan`, `id_kategori_bendung`, `nama`, `struktur`, `jumlah_pintu`, `dimensi`, `jenis_pintu`, `lat`, `lng`, `polygon`) VALUES
(69, 16, 2, 'Pompa Cabang Bungin', 'Beton', 2, 'Tinggi : 1.5 m , Lebar : 1.5 m', 'Single As', -6.073992, 107.149086, ''),
(70, 16, 2, 'Pintu Air Cangkring', 'Batu Kali', 4, 'Tinggi : 1.8/4.1 m , Lebar : 1.55/1.45 m', '-', -6.109887, 107.183548, ''),
(71, 62, 1, 'Bendung Caringin', 'Beton', 8, 'Tinggi : 4.3 m , Lebar : 3 m', 'Double As', -6.195802, 107.213867, ''),
(72, 62, 2, 'Pintu Air Suka Makmur', 'Beton', 2, 'Tinggi : 2 m , Lebar : 1.5 m', 'Double As', -6.196381, 107.224419, ''),
(73, 62, 2, 'Pintu Air Kobak Rante', 'Beton dan Batu Kali', 2, 'Tinggi : 2.2 m , Lebar : 2 m', 'Double As', -6.131286, 107.205170, ''),
(74, 62, 2, 'Pintu Air Kali Tua', 'Batu Kali', 3, 'Tinggi : 1.7 m , Lebar : 1.7 m', 'Double As', -6.136055, 107.175247, ''),
(75, 59, 1, 'Bendung Pesiut', 'Beton', 4, 'Tinggi : 3.2 m , Lebar : 2.3 m', 'Double As', -6.196506, 107.246353, ''),
(76, 59, 1, 'Bendung Kiwing', 'Batu Kali', 1, 'Tinggi : 1.3 M , Lebar : 1 m', '-', -6.168054, 107.238785, ''),
(77, 59, 2, 'Pintu Air Jegir', 'Batu Kali', 3, 'Tinggi : 2.4 m , Lebar : 1.8 m', '-', -6.140751, 107.216003, ''),
(78, 59, 2, 'Pintu Air Teluk Bango 1', 'Batu Kali', 1, 'Tinggi : 3.7 m , Lebar : 2.4 m', '-', -6.111681, 107.206879, ''),
(79, 59, 2, 'Pintu Air Pulo Kecil', 'Batu Kali', 1, 'Tinggi : 2.6 m , Lebar : 0.5 m', '-', -6.196390, 107.239418, ''),
(80, 63, 1, 'Bendung Wates', 'Batu Kali', 3, 'Tinggi : 1.45 m , Lebar : 1,5 m', 'Single As', -6.168836, 107.154518, ''),
(81, 65, 1, 'Bendung Awih', 'Batu Kali', 2, 'Tinggi : 1.6 m , Lebar : 2 m', 'Double As', -6.195602, 107.128098, ''),
(82, 65, 2, 'Pintu Air Cemeng', 'Batu Kali', 2, 'Tinggi : 1.8 m , Lebar : 1.1 m', 'Single As', -6.180078, 107.112595, ''),
(83, 18, 2, 'Pintu Air Luwung', 'Batu Kali', 4, 'Tinggi : 2.1 m , Lebar : 1.5 m', 'Double As', -6.182514, 107.102524, ''),
(84, 24, 2, 'Pintu Air Bentengan', 'Batu Kali', 3, 'Tinggi : 2 m , Lebar : 2 m', 'Double As', -6.210376, 107.224121, ''),
(86, 24, 2, 'Pintu Air Kepuh', 'Batu Kali', 2, 'Tinggi : 3.8 m , Lebar : 2.6 m', 'Double As', -6.210353, 107.205856, ''),
(87, 24, 2, 'Pintu Air Merah', 'Batu Kali', 2, 'Tinggi : 2 m , Lebar : 2 m', 'Double As', -6.219698, 107.234200, ''),
(88, 24, 2, 'Pintu Air Belanda', 'Batu Kali', 1, 'Tinggi : 1.5 m , Lebar : 2.2 m', 'Double As', -6.194891, 107.195885, ''),
(89, 22, 2, 'Pintu Air Kalendrewak', 'Beton', 2, 'Tinggi : 1.2 m , Lebar : 2 m', 'Double As', -6.233224, 107.205620, ''),
(90, 68, 1, 'Bendung Da 3', 'Batu Kali', 3, 'Tinggi : - , Lebar : -', 'Double As', -6.115351, 107.025597, ''),
(91, 64, 2, 'Pintu Air Kedung Plasman', 'Batu Kali', 3, 'Tinggi : 2 m , Lebar : 2 m', 'Double As', -6.127059, 107.105370, ''),
(92, 64, 2, 'Pintu Air Gombang', 'Batu Kali', 3, 'Tinggi : 1.4 m , Lebar : 2.2 m', 'Double As', -6.122552, 107.113533, ''),
(93, 64, 2, 'Pintu Air Pengkolan', 'Batu Kali', 2, 'Tinggi : 1.8 m , Lebar : 2.4 m', 'Double As', -6.097065, 107.104912, ''),
(94, 18, 2, 'Pintu Air Sibah', 'Beton', 3, 'Tinggi : 4 m , Lebar : 2 m', 'Double As', -6.202595, 107.099480, ''),
(95, 22, 2, 'Pintu Air Playangan', 'Beton', 3, 'Tinggi : 2.8 m , Lebar : 2.5 m', 'Double As', -6.269124, 107.204720, ''),
(96, 22, 2, 'Pintu Air Ciparanje', 'Batu Kali', 3, 'Tinggi : 1.7 m , Lebar : 2.2 m', 'Double As', -6.299722, 107.202896, ''),
(97, 57, 2, 'Pintu Air Karang Harum', 'Batu Kali', 2, 'Tinggi : 1.6 m , Lebar : 1.9 m', 'Double As', -6.245653, 107.222984, ''),
(98, 57, 2, 'Pintu Air Pacinan', 'Beton dan Batu Kali', 3, 'Tinggi : 2.2 m , Lebar 3 m', 'Double As', -6.233413, 107.255051, ''),
(99, 57, 2, 'Pintu Air Ranggon Genteng', 'Batu Kali', 2, 'Tinggi : - , Lebar : -', 'Double As', -6.245163, 107.221245, ''),
(100, 57, 2, 'Pintu Air Posebah', 'Batu Kali', 2, 'Tinggi : 1.5 m , Lebar : 2 m', 'Double As', -6.262273, 107.247185, ''),
(101, 59, 2, 'Pintu Air Pisang Batu', 'Batu Kali', 3, 'Tinggi : - , Lebar : 2 m', 'Double As', -6.122200, 107.209808, ''),
(102, 57, 2, 'Pintu Air Kalen Pacing', 'Batu Kali', 1, 'Tinggi : 1.25 m , Lebar : 1.65 m', 'Single As', -6.266421, 107.253815, ''),
(103, 66, 2, 'Pompa Jati Mulya', 'Batu Kali', 1, 'Tinggi : 1.5 m , Lebar : 1 m', 'Single As', -6.263680, 107.018929, ''),
(104, 59, 2, 'Pintu Air Bolang', 'Beton', 1, 'Tinggi : 3.1 m , Lebar : 2 m', '-', -6.208234, 107.243187, ''),
(105, 59, 2, 'Pintu Air Ponombo', 'Batu Kali', 2, 'Tinggi : - , Lebar : -', '-', -6.109887, 107.183548, ''),
(106, 59, 2, 'Pintu Air Bakung', 'Batu Kali', 2, 'Tinggi : 1.5 m , Lebar : 2.55 m\r\n', 'Double As', -6.170468, 107.230087, ''),
(107, 59, 2, 'Pintu Air Kobak Rante Hulu', 'Batu Kali', 2, 'Tinggi : 1.8 m , Lebar : 2 m', 'Double As', -6.157131, 107.218170, ''),
(108, 59, 2, 'Pintu Air Dpn Desa Bantar Sari', 'Batu Kali', 1, 'Tinggi : 2.4 m , Lebar : 1.4 m', 'Single As', -6.210333, 107.255661, ''),
(109, 6, 2, 'Pintu Air Dt 8 Buni Bakti', 'Batu Kali', 2, 'Tinggi : - , Lebar : -', 'Double As', -6.094635, 107.040924, ''),
(110, 59, 2, 'Pintu Air Teluk Bango 2', 'Batu Kali', 2, 'Tinggi : 2.4 m , Lebar : 2,4 m', 'Double As', -6.120734, 107.205788, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_kategori_bendung`
--
ALTER TABLE `m_kategori_bendung`
  ADD PRIMARY KEY (`id_kategori_bendung`);

--
-- Indexes for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `t_bendung`
--
ALTER TABLE `t_bendung`
  ADD PRIMARY KEY (`id_bendung`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_kategori_bendung`
--
ALTER TABLE `m_kategori_bendung`
  MODIFY `id_kategori_bendung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  MODIFY `id_kecamatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_bendung`
--
ALTER TABLE `t_bendung`
  MODIFY `id_bendung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
