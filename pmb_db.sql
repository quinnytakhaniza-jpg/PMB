-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2026 at 09:04 AM
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
-- Database: `pmb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `calon_mahasiswa`
--

CREATE TABLE `calon_mahasiswa` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `jalur` varchar(50) NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_ujian` varchar(20) DEFAULT 'Belum',
  `skor_ujian` int(11) DEFAULT 0,
  `nim` varchar(30) DEFAULT NULL,
  `status_daftar_ulang` varchar(30) DEFAULT 'Belum Daftar Ulang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calon_mahasiswa`
--

INSERT INTO `calon_mahasiswa` (`id`, `nama_lengkap`, `email`, `telepon`, `jurusan`, `jalur`, `tanggal_daftar`, `status_ujian`, `skor_ujian`, `nim`, `status_daftar_ulang`) VALUES
(1, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Ilmu Komunikasi', '', '2026-09-03 01:51:09', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(2, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Ilmu Komunikasi', '', '2026-09-03 02:03:22', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(3, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-09-03 02:06:05', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(4, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-09-13 23:02:47', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(5, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-09-13 23:03:06', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(6, 'khaniza ipak quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-09-13 23:07:45', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(7, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-10-06 23:22:37', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(8, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', '', '2026-10-06 23:23:16', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(9, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Ilmu Komunikasi', '', '2026-10-06 23:24:31', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(10, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Prestasi', '2026-10-06 23:55:35', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(11, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Prestasi', '2026-10-07 00:01:12', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(12, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Prestasi', '2026-10-07 01:33:16', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(13, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Luring', '2026-10-12 02:19:07', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(14, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'UTBK', '2026-10-12 03:56:39', 'Selesai', 30, NULL, 'Belum Daftar Ulang'),
(15, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'UTBK', '2026-11-04 22:44:19', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(16, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-04 22:59:23', 'Selesai', 40, NULL, 'Belum Daftar Ulang'),
(17, 'Khaniza Quinnyta', 'quinnytakhaniza@gmail.com', '088905047384', 'Sistem Informasi', 'Mandiri_Luring', '2026-11-05 00:43:43', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(18, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:06:33', 'Selesai', 100, '20260018', 'Selesai'),
(19, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:07:13', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(20, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Luring', '2026-11-05 01:11:25', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(21, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:16:56', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(22, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:17:27', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(23, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:20:21', 'Belum', 0, NULL, 'Belum Daftar Ulang'),
(24, 'zainul hisyam', 'quinnytakhaniza@gmail.com', '088905047384', 'Kepelatihan Olahraga', 'Mandiri_Daring', '2026-11-05 01:28:01', 'Belum', 0, NULL, 'Belum Daftar Ulang');

-- --------------------------------------------------------

--
-- Table structure for table `soal_ujian`
--

CREATE TABLE `soal_ujian` (
  `id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `pilihan_a` varchar(255) NOT NULL,
  `pilihan_b` varchar(255) NOT NULL,
  `pilihan_c` varchar(255) NOT NULL,
  `pilihan_d` varchar(255) NOT NULL,
  `kunci_jawaban` enum('A','B','C','D') NOT NULL,
  `prodi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soal_ujian`
--

INSERT INTO `soal_ujian` (`id`, `pertanyaan`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `kunci_jawaban`, `prodi`) VALUES
(1, 'Jika semua sarjana adalah pemikir, dan sebagian pemikir adalah seniman, maka...', 'Semua seniman adalah sarjana', 'Sebagian seniman adalah pemikir', 'Semua pemikir adalah sarjana', 'Tidak ada seniman yang sarjana', 'B', ''),
(2, '15, 18, 24, 33, 45, ... Angka selanjutnya dalam deret tersebut adalah...', '55', '58', '60', '63', 'C', ''),
(3, 'Sinonim dari kata \"Kandungan\" dalam konteks isi atau muatan suatu hal adalah...', 'Wadah', 'Esensi', 'Batas', 'Struktur', 'B', ''),
(4, 'Antonim dari kata \"Canggih\" adalah...', 'Modern', 'Kompleks', 'Sederhana', 'Mutakhir', 'C', ''),
(5, 'Jika harga 3 buah buku adalah Rp15.000, berapa harga untuk 7 buah buku yang sama?', 'Rp30.000', 'Rp35.000', 'Rp40.000', 'Rp45.000', 'B', ''),
(6, 'Manakah penulisan kata yang sesuai dengan Ejaan Yang Disempurnakan (EYD)?', 'Aktivitas', 'Aktifitas', 'Jadual', 'Analisa', 'A', ''),
(7, 'Sebuah mobil menempuh jarak 120 km dengan kecepatan rata-rata 60 km/jam. Berapa waktu yang dibutuhkan mobil tersebut?', '1 jam', '1,5 jam', '2 jam', '2,5 jam', 'C', ''),
(8, 'Pernyataan yang paling tepat untuk melengkapi kalimat sebab-akibat: \"Karena rajin belajar dan berlatih setiap hari, maka...\"', 'Ia merasa lelah di malam hari', 'Ia mendapatkan hasil ujian yang memuaskan', 'Buku pelajarannya menjadi cepat rusak', 'Waktu luangnya menjadi bertambah banyak', 'B', ''),
(9, 'Jika p = 3 dan q = 4, berapakah nilai dari 2p² - 3q ?', '6', '9', '12', '15', 'B', ''),
(10, 'Ide pokok atau gagasan utama dalam sebuah paragraf biasanya terletak di...', 'Kalimat pertama atau kalimat terakhir paragraf', 'Hanya di tengah-tengah paragraf', 'Selalu di luar teks bacaan', 'Judul teks saja', 'A', ''),
(11, 'Apa tujuan utama dari fase cooling down (pendinginan) setelah melakukan latihan fisik atau pertandingan?', 'Meningkatkan detak jantung secara drastis', 'Membantu menurunkan detak jantung secara bertahap dan mengurangi risiko cedera otot serta penumpukan asam laktat', 'Mempercepat kelelahan mental atlet', 'Menghentikan aliran darah secara mendadak', 'B', 'Kepelatihan Olahraga'),
(12, 'Komponen kondisi fisik yang berkaitan dengan kemampuan otot untuk mengatasi tahanan atau beban dalam waktu yang singkat disebut...', 'Daya Tahan (Endurance)', 'Kekuatan (Strength)', 'Kelentukan (Flexibility)', 'Kecepatan (Speed)', 'B', 'Kepelatihan Olahraga'),
(13, 'Dalam prinsip latihan fisik (training principles), apa yang dimaksud dengan Overload?', 'Memberikan latihan yang sangat ringan agar atlet tidak cedera', 'Menghentikan latihan ketika atlet merasa lelah', 'Memberikan beban latihan yang melebihi ambang batas kebiasaan sehari-hari untuk merangsang peningkatan kapasitas fisik', 'Melatih hanya satu otot saja secara berlebihan tanpa istirahat', 'C', 'Kepelatihan Olahraga'),
(14, 'Sendi pada tubuh manusia yang memungkinkan gerakan ke segala arah (seperti pada bagian bahu dan panggul) disebut...', 'Sendi engsel', 'Sendi peluru', 'Sendi putar', 'Sendi pelana', 'B', 'Kepelatihan Olahraga'),
(15, 'Cedera akut pada jaringan lunak berupa robekan atau tarikan pada otot atau tendon dinamakan...', 'Sprain', 'Strain', 'Dislokasi', 'Fraktur', 'B', 'Kepelatihan Olahraga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon_mahasiswa`
--
ALTER TABLE `calon_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon_mahasiswa`
--
ALTER TABLE `calon_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
