-- ==============================================================================
-- Database TaskFlow – Aplikasi Manajemen Tugas Mahasiswa
-- Skrip SQL Siap Import di phpMyAdmin / MySQL XAMPP
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS `taskflow` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `taskflow`;

-- --------------------------------------------------------
-- Struktur Tabel `tasks`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('Belum Dikerjakan','Sedang Dikerjakan','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Dikerjakan',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Data Awal (Sample Data Mahasiswa)
-- --------------------------------------------------------

INSERT INTO `tasks` (`id`, `title`, `description`, `course`, `deadline`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Implementasi Web Service & CRUD di Azure', 'Membangun aplikasi Laravel dan menghubungkan ke database MySQL serta konfigurasi Azure App Service.', 'Cloud Computing', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'Sedang Dikerjakan', NOW(), NOW()),
(2, 'Latihan Model Klasifikasi CNN', 'Melakukan fine-tuning model ResNet-50 pada dataset gambar CIFAR-10.', 'Kecerdasan Buatan', DATE_ADD(CURDATE(), INTERVAL 12 DAY), 'Belum Dikerjakan', NOW(), NOW()),
(3, 'Review Jurnal Sistem Terdistribusi', 'Membuat ringkasan 3 halaman mengenai mekanisme konsensus Raft dan Paxos.', 'Sistem Terdistribusi', DATE_SUB(CURDATE(), INTERVAL 2 DAY), 'Belum Dikerjakan', NOW(), NOW()),
(4, 'Praktikum 1: Setup Lingkungan Docker & Git', 'Konfigurasi Dockerfile dan push repositori tugas ke GitHub Classroom.', 'DevOps & Cloud', DATE_SUB(CURDATE(), INTERVAL 7 DAY), 'Selesai', NOW(), NOW()),
(5, 'Perancangan Skema Basis Data Normalisasi 3NF', 'Membuat Entity Relationship Diagram (ERD) dan skema relasional tabel tugas.', 'Basis Data Lanjut', DATE_ADD(CURDATE(), INTERVAL 20 DAY), 'Belum Dikerjakan', NOW(), NOW());

