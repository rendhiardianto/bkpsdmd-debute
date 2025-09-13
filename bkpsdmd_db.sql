-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2025 at 03:21 AM
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
-- Database: `bkpsdmd_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`, `created_by`, `thumbnail`, `attachment`) VALUES
(13, 'Pengumuman Pembatalan Status Afirmasi Eks THK II PPPK Merangin 2024', 'Pengumuman Nomor 810/040/BKPSDMD/2025 tentang Pembatalan Status / Afirmasi Sebagai Eks Tenaga Honorer Kategori II Seleksi Pegawai Pemerintah Dengan Perjanjian Kerja Kabupaten Merangin Formasi Tahun 2024.', '2025-09-08 06:12:42', 'Rendhi A. Sani', 'thumb_68be73d9e8cbc.PNG', 'file_68be73da11008.pdf'),
(14, 'Pengumuman Pembatalan Kelulusan PPPK Merangin 2024', 'Pengumuman Nomor 810/039/BKPSDMD/2025 tentang Pembatalan Kelulusan Pelamar Seleksi Pegawai Pemerintah Dengan Perjanjian Kerja Kabupaten Merangin Formasi Tahun 2024.', '2025-09-08 06:14:03', 'Rendhi A. Sani', 'thumb_68c04561d6ea2.PNG', 'file_68be742b36842.pdf'),
(15, 'Pengumuman Pembatalan Kelulusan PPPK Merangin 2024', 'Pengumuman Nomor 810/038/BKPSDMD/2025 tentang Pembatalan Kelulusan Pelamar Seleksi Pegawai Pemerintah Dengan Perjanjian Kerja Kabupaten Merangin Formasi Tahun 2024.', '2025-09-08 06:16:29', 'Rendhi A. Sani', 'thumb_68be74bd5ce94.PNG', 'file_68be74bd7b094.pdf'),
(21, 'Revisi Pengumuman Akhir Seleksi PPPK Guru 2024', 'Berdasarkan Surat Kepala Badan Kepegawaian Negara Nomor: 8373/BKS.04.03/SD/K/2025, tanggal 26 Agustus 2025, telah disampaikan revisi nama, nilai, prioritas dan status kelulusan semua peserta Seleksi Kompetensi PPPK Jabatan Fungsional Guru Formasi Tahun 2024.', '2025-09-09 12:21:06', 'Rendhi A. Sani', 'thumb_68c0453a18440.png', 'file_68c01bb24171f.pdf'),
(24, 'Pengumuman Alokasi PPPK Paruh Waktu di Lingkungan Pemerintah Kabupaten Merangin Formasi Tahun 2024', 'Berdasarkan Surat Kepala Badan Kepegawaian Negara Nomor: 13451/B-SI.01.01/SD/K/2025, tanggal 6 September 2025, Perihal Penyampaian Daftar Peserta Alokasi PPPK Paruh Waktu, telah disampaikan daftar peserta yang telah disetujui untuk alokasi PPPK Paruh Waktu untuk Kabupaten Merangin.', '2025-09-13 01:06:37', 'Rindi Ardianto', 'thumb_68c4c39d1d822.png', 'file_68c4c39d66587.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `divisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id`, `nip`, `fullname`, `jabatan`, `divisi`) VALUES
(1, '197106261992011002', 'Ferdi Firdaus', 'Kepala BKPSDMD', 'PEMKAB MERANGIN'),
(2, '197401122005011006', 'Joni Setiawan', 'Sekretaris BKPSDMD', 'SEKRETARIAT'),
(3, '199507192017082001', 'Marissa Yuliyani', 'Kasubbag Umum & Kepegawaian', 'SEKRETARIAT'),
(4, '199303042015072001', 'Yesi Refinalisya Ds', 'Kasubbag Program & Keuangan', 'SEKRETARIAT'),
(6, '198502232011011004', 'Affan Febriandi', 'Kabid Kepegawaian', 'BIDANG KEPEGAWAIAN'),
(7, '199609062025061006', 'Rindi Ardianto', 'Pranata Komputer Ahli Pertama', 'BIDANG KEPEGAWAIAN'),
(8, '199811182025062013', 'Safhira Shalsyabila', 'Pranata SDM Aparatur Terampil', 'BIDANG KEPEGAWAIAN'),
(9, '199501082018081002', 'Deni Rahmad Wijayanto', 'Penyusun Rencana Mutasi', 'BIDANG KEPEGAWAIAN'),
(10, '199003192025061003', 'Ahmad Luthfi', 'Pranata Komputer Ahli Pertama', 'BIDANG PENGEMBANGAN SDM'),
(11, '199003312025061008', 'Rhivki Habibiansyah', 'Pranata Komputer Ahli Pertama', 'BIDANG KEPEGAWAIAN'),
(12, '197808132005011003', 'August Joko Sutrisno', 'Analis SDM Aparatur Ahli Madya', 'BIDANG KEPEGAWAIAN'),
(13, '197901032000122002', 'Iren Sopia', 'Penyusun Rencana Kebutuhan Sarana & Prasarana', 'SEKRETARIAT'),
(14, '198701282010011000', 'Enda Ekocitra', 'Pranata Kearsipan', 'SEKRETARIAT'),
(15, '199702192021082001', 'Fitri Panisyariska', 'Penyusun Rencana Kebutuhan Sarana & Prasarana', 'SEKRETARIAT'),
(16, '198109062010012015', 'Custi Eli Septriani', 'Analis SDM Aparatur Ahli Muda', 'SEKRETARIAT'),
(17, '198302182011012004', 'Rusi Oktavia', 'Analis SDM Aparatur Ahli Muda', 'SEKRETARIAT'),
(18, '197606092011011002', 'Welly Cahyadi', 'Penata Laporan Keuangan', 'SEKRETARIAT'),
(19, '198303192010011011', 'Dwi Anto', 'Pranata Sumber Daya Manusia Aparatur Mahir', 'SEKRETARIAT'),
(20, '198210152012122002', 'Yusi Zuraida', 'Bendahara', 'SEKRETARIAT'),
(21, '198209202006042010', 'Dian Damayanti', 'Analis SDM Aparatur Ahli Madya', 'BIDANG KEPEGAWAIAN'),
(22, '198103142005011007', 'Irdamansyah', 'Subkoor Mutasi dan Promosi Jabatan', 'BIDANG KEPEGAWAIAN'),
(23, '197709272006042002', 'Herlina', 'Analis SDM Aparatur Ahli Muda', 'BIDANG KEPEGAWAIAN'),
(24, '198402092006042006', 'Dian Febrianti', 'Pranata Sumber Daya Manusia Aparatur Penyelia', 'BIDANG KEPEGAWAIAN'),
(25, '197502152006041009', 'Wahyudi', 'Pengelola Kepegawaian', 'BIDANG KEPEGAWAIAN'),
(26, '199709042020081002', 'Ahmad Berri Seftiawan', 'Analis SDM Aparatur Ahli Pertama', 'BIDANG KEPEGAWAIAN'),
(27, '198306272003121005', 'Hartanto', 'Pranata SDM Aparatur Mahir', 'BIDANG KEPEGAWAIAN'),
(28, '199310312015071001', 'Tegar Arya Manggala', 'Subkoor Kepangkatan', 'BIDANG KEPEGAWAIAN'),
(29, '197505212006042007', 'Hermayana', 'Pengelola Kepegawaian', 'BIDANG KEPEGAWAIAN'),
(30, '197008061996012001', 'Yusnawati', 'Analis SDM Aparatur Ahli Muda', 'BIDANG KEPEGAWAIAN'),
(31, '198608232010011005', 'Hadi Agustian', 'Pranata SDM Aparatur Mahir', 'BIDANG KEPEGAWAIAN'),
(32, '197608302003121004', 'Budiansyah', 'Pranata SDM Aparatur Mahir', 'BIDANG KEPEGAWAIAN'),
(33, '198105292006041005', 'Hendi', 'Subkoor Perencanaan dan Informasi Kepegawaian', 'BIDANG KEPEGAWAIAN'),
(34, '199506222025062002', 'Anggun Susantri', 'Pranata SDM Aparatur Terampil', 'BIDANG KEPEGAWAIAN'),
(35, '197910232010011009', 'Erlangga', 'Kabid PSDM', 'BIDANG PENGEMBANGAN SDM'),
(36, '197809032009011006', 'Hermansah', 'Subkoor Pembinaan Disiplin dan Penilaian Kinerja', 'BIDANG PENGEMBANGAN SDM'),
(37, '197208091993031003', 'Joko Purwanto', 'Analis SDM Aparatur Ahli Madya', 'BIDANG PENGEMBANGAN SDM'),
(38, '198112052011011004', 'Arizona', 'Analis SDM Aparatur Ahli Muda', 'BIDANG PENGEMBANGAN SDM'),
(39, '199003122015031005', 'Zamel Dani', 'Analis Penegakan Integritas dan Disiplin SDM Aparatur', 'BIDANG PENGEMBANGAN SDM'),
(40, '197909142003122007', 'Irhayu Musfiroh', 'Subkoor Pengembangan Karier dan Kesejahteraan', 'BIDANG PENGEMBANGAN SDM'),
(41, '198602152019031003', 'Harmoko Bambang K', 'Asesor SDM Aparatur Ahli Pertama', 'BIDANG PENGEMBANGAN SDM'),
(42, '199511282025062006', 'Saufa Isra', 'Asesor SDM Aparatur Ahli Pertama', 'BIDANG PENGEMBANGAN SDM'),
(43, '200210192025062002', 'Yana Oktavia', 'Asesor SDM Aparatur Ahli Pertama', 'BIDANG PENGEMBANGAN SDM'),
(44, '198410122012122002', 'Meri Oktavia', 'Analis Kesejahteraan SDM Aparatur', 'BIDANG PENGEMBANGAN SDM'),
(45, '198703202011011004', 'David Reinaldo', 'Pranata SDM Aparatur Terampil', 'BIDANG PENGEMBANGAN SDM'),
(46, '197512292003122000', 'Eni Pusparini', 'Analis Diklat', 'BIDANG PENGEMBANGAN SDM'),
(47, '199601232018082001', 'Ulva Syari Ramadona', 'Analis Diklat', 'BIDANG PENGEMBANGAN SDM'),
(48, '198312302006041008', 'Miksen', 'Pranata Diklat', 'BIDANG PENGEMBANGAN SDM'),
(49, '199310242025062003', 'Vinia Dayanti Purba', 'Analis Pengembangan Kompetensi ASN Ahli Pertama', 'BIDANG PENGEMBANGAN SDM'),
(50, '199902132025062009', 'Ratih Elvirawati', 'Analis Pengembangan Kompetensi ASN Ahli Pertama', 'BIDANG PENGEMBANGAN SDM');

-- --------------------------------------------------------

--
-- Table structure for table `infografis`
--

CREATE TABLE `infografis` (
  `id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infografis`
--

INSERT INTO `infografis` (`id`, `images`, `caption`, `created_at`) VALUES
(1, 'uploads/images/1.png', 'Kantor BKPSDMD Kab. Merangin', '2025-09-09 01:35:54'),
(2, 'uploads/images/2.png', 'Banner Pelaksanaan Evaluasi Kinerja PPT Pratama Tahun 2025', '2025-09-09 01:36:49'),
(3, 'uploads/images/3.png', 'Pelaksanaan Evaluasi Kinerja PPT Pratama Tahun 2025', '2025-09-09 01:44:53'),
(4, 'uploads/images/4.png', 'MoU BKPSDMD dengan UNAJA - Penyelenggaraan Pendidikan Bagi ASN', '2025-09-09 01:45:36'),
(5, 'uploads/images/5.png', 'Pelantikan CPNS Angkatan 2024', '2025-09-09 02:38:26'),
(6, 'uploads/images/6.png', 'Penyerahan SK CPNS Angkatan 2024', '2025-09-09 02:46:44'),
(7, 'uploads/images/7.png', 'Pengangkatan PPPK Jabatan Fungsional di Lingkungan Pemkab Merangin.', '2025-09-09 02:47:18'),
(8, 'uploads/images/8.png', 'Pengangkatan PPPK Jabatan Fungsional di Lingkungan Pemkab Merangin.', '2025-09-09 02:47:52'),
(9, 'uploads/images/9.png', 'Perayaan HUT RI Ke-80', '2025-09-09 02:58:35'),
(10, 'uploads/images/10.png', 'Perayaan HUT RI Ke-80', '2025-09-09 03:06:03'),
(11, 'uploads/images/11.png', 'Perayaan HUT RI Ke-80', '2025-09-09 03:07:47'),
(12, 'uploads/images/12.png', 'Banner Pelantikan PPT Pratama 2025', '2025-09-09 04:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `category`, `created_by`, `created_at`) VALUES
(1, 'First News', 'This is the first news content.', 'uploads/bkpsdm sosmed profil foto.jpg', 'Politics', 'Rendhi A. Sani', '2025-09-08 11:16:58'),
(2, 'Second News', 'This is another news article.', 'uploads/Screenshot (106).png', 'Economy', 'Rendhi A. Sani', '2025-09-08 11:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `verified` tinyint(1) DEFAULT 0,
  `verify_token` varchar(255) DEFAULT NULL,
  `last_resend` timestamp NULL DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nip`, `fullname`, `email`, `password`, `created_at`, `remember_token`, `reset_token`, `reset_expiry`, `role`, `verified`, `verify_token`, `last_resend`, `profile_pic`) VALUES
(1, '199609062025061006', 'Rindi Ardianto', 'ardianto.rendhi@gmail.com', '$2y$10$K5RZbogZkJqyDU.TugbeBOICsLaq5lb4up9Pq1gmErBS21AF.iHsS', '2025-09-07 10:42:07', NULL, 'd755b526f39fa8b77a6cc8f93b89813d', NULL, 'admin', 1, NULL, NULL, '199609062025061006_Rendhi_A__Sani.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `infografis`
--
ALTER TABLE `infografis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `infografis`
--
ALTER TABLE `infografis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
