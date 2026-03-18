-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 07:56 AM
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
-- Database: `absensi_gps`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `jarak_meter` double DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `guru_id`, `siswa_id`, `tanggal`, `jam_masuk`, `latitude`, `longitude`, `jarak_meter`, `jam_pulang`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, '2025-12-11', '03:09:33', -7.30507767, 108.26962000, 55.77, '03:09:45', 'hadir', '2025-12-10 20:09:33', '2025-12-10 20:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_akun` varchar(20) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `nama`, `email`, `password`, `status_akun`, `created_at`, `updated_at`) VALUES
(1, 'yadi', 'yadi@gmail.com', '$2y$12$xANYLw3OMaOBna2OTmPB7OCmTC.1Jv2GSY6y1YmC1/bwHIIF/eYGW', '1', '2025-12-09 01:10:06', '2025-12-09 21:30:25'),
(2, 'sutisna hartono', 'sutisna_ajah@gmail.com', '$2y$12$s4Rl7KvOLndnvPLiw0w.ueJjn4HpD4ks6U7AYBbhbH6rnguXrbiNi', '1', '2025-12-09 20:14:47', '2025-12-09 21:15:44'),
(4, 'yanti', 'yanti12@gmail.com', '$2y$12$hnVlN.zndh9yXvQl7yj4reW3c.IjjvfaQQ99MVtVRmMsu//Jh3kfi', '1', '2025-12-09 20:45:38', '2025-12-09 21:15:28'),
(5, 'cecep hartati', 'cecep@gmail.com', '$2y$12$4IpkVhCbf2cky8VPnqhGW.P/zvwq30ikODgdXc9yAaPKY4VGCQ2IC', '1', '2025-12-09 21:07:22', '2025-12-09 21:07:22'),
(6, 'maman', 'maman@gmail.com', '$2y$12$V.BOgJ./FJkcgnuu9FPEz.OVqukzLPUq8Zb3q14wxfplziN683vwK', '0', '2025-12-14 20:28:11', '2025-12-14 20:28:11'),
(7, 'cecep hartati sudoyono', 'hartati@gmail.com', '$2y$12$ndzAd3k25AMUScnU70/5Te48EJoPHdNG6BBBwqELeQ9wVXlaGx5PC', '1', '2025-12-14 20:30:29', '2025-12-14 20:30:51'),
(8, 'mantri', 'mantri@gmail.com', '$2y$12$IuUqoaWVU05b/Wpe/d4ImOUB5gfRr0ixUCSrKbkHggieJByz/ncKi', '1', '2025-12-14 20:51:30', '2025-12-14 20:51:30'),
(9, 'didin', 'didin@gmail.com', '$2y$12$YGu5MXk4kbQziTatybodZunhqGaVYT0MpauL212VqiNa4lQR012Gm', '1', '2025-12-14 21:51:31', '2025-12-14 21:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasis`
--

CREATE TABLE `lokasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasis`
--

INSERT INTO `lokasis` (`id`, `nama_lokasi`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(3, 'Kawali, Ciamis, Java, 46253, Indonesia', -7.1831527, 108.3740146, '2025-12-14 21:25:58', '2025-12-14 21:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_05_074025_add_role_to_users_table', 1),
(5, '2025_12_05_080645_create_gurus_table', 1),
(6, '2025_12_05_081959_create_siswas_table', 1),
(7, '2025_12_08_015731_create_lokasis_table', 1),
(8, '2025_12_08_035920_create_absensis_table', 1),
(9, '2025_12_09_061041_add_kelas_to_siswas_table', 1),
(10, '2025_12_09_064015_create_kelas_table', 2),
(11, '2025_12_11_030503_add_jam_masuk_pulang_to_absensis_table', 2),
(12, '2025_12_11_030800_add_lokasi_fields_to_absensis_table', 3),
(13, '2025_12_11_040406_add_nis_to_users_table', 4),
(14, '2025_12_11_040755_add_username_to_users_table', 5),
(15, '2025_12_15_043653_add_guru_id_to_absensis_table', 6),
(16, '2025_12_15_061324_add_nip_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status_akun` varchar(20) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `nis`, `nama`, `email`, `password`, `status_akun`, `created_at`, `updated_at`, `kelas`) VALUES
(1, '987656554535', 'imanudin 65', 'imanuel@gmail.com', '$2y$12$anuL/4pJG/JqYoe.1dTUzeWmRAAubCkWt72pfDGCzOPsTUkUa3GDC', 'aktif', '2025-12-09 00:51:51', '2025-12-09 01:08:04', 'XI'),
(2, '98765435675576', 'imanudin dian', 'dian@gmail.com', '$2y$12$CWzX44NV1ucnhE43DQjtk.vBCksTjSwWUOZ5SuXB1k44TA.GjblQu', 'aktif', '2025-12-09 01:07:28', '2025-12-09 01:08:26', 'XII'),
(3, '9876543567877687', 'imanudin rohmat', 'rohmat@gmail.com', '$2y$12$Ay3dI4.1oxXSynl86TrHNer4CVSvR2fYs8L.QhQTkPLfihcWoRlme', 'aktif', '2025-12-09 01:20:30', '2025-12-09 01:20:52', 'XII'),
(4, '9876543567', 'sumanto', 'hidayah@gmail.com', '$2y$12$BN/nW.ULeaIZXJKlF6Pm9eg1CX9pHNBAQ3ZnzO4zu5uWPA.lVsx2G', 'tidak_aktif', '2025-12-09 01:24:24', '2025-12-09 20:00:53', 'XII'),
(9, '232412345', 'mumut', 'muti@gmail.com', '$2y$12$NqQx8ttT0UBMYiLlDAoQe.7E9hDFPWWaT7tN7Blyp4RF9TbYNSc6W', 'aktif', '2025-12-10 21:02:17', '2025-12-10 21:02:17', 'XII'),
(10, '1234567811', 'selmi', 'selmi@gmail.com', '$2y$12$OmXoFxBMkaIEOem9P4hnJ.gYxEVFBdxJMcVwDiktqlFvw45CUk.Uy', 'aktif', '2025-12-10 21:13:00', '2025-12-14 22:58:04', 'XII'),
(12, '46162732', 'vita', 'vita@gmail.com', '$2y$12$zijAslxL1lFfS3XtUxwX2uXhW/6Y8zYArA71r1mSY1PoCLocoHjKG', 'tidak_aktif', '2025-12-14 19:41:05', '2025-12-14 20:16:00', 'XI'),
(15, '65276527', 'mila', 'mila@gmail.com', '$2y$12$auszLA75ejAwgxM4sZgMe.wxX1f5Da2qDh7YeWATjH7EQK0gKiIEC', 'tidak_aktif', '2025-12-14 19:58:57', '2025-12-14 20:15:17', 'X');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nis`, `nip`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, NULL, NULL, NULL, 'Admin Utama', 'admin@gmail.com', NULL, '$2y$12$tNr6Rj8IyzC9FXs2uVwSzO2UfBpgDSuyxKE3Gk0FhaMQU5vD3lFqi', NULL, '2025-12-08 23:17:51', '2025-12-08 23:17:51', 'admin'),
(2, NULL, NULL, NULL, 'Nama Siswa', 'siswa@example.com', NULL, '$2y$12$mHflN99y06lb3K5A6H626OyFMD6bgBkWyab1oILvVP5gakHEN7fXO', NULL, '2025-12-10 21:18:06', '2025-12-10 21:18:06', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensis_siswa_id_foreign` (`siswa_id`),
  ADD KEY `absensis_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gurus_email_unique` (`email`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasis`
--
ALTER TABLE `lokasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_nis_unique` (`nis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasis`
--
ALTER TABLE `lokasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `absensis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
