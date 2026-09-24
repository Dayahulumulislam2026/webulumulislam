-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2026 at 01:13 PM
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
-- Database: `ulumulislam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission_settings`
--

CREATE TABLE `admission_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `requirements` longtext DEFAULT NULL,
  `required_documents` longtext DEFAULT NULL,
  `schedule_information` longtext DEFAULT NULL,
  `additional_information` text DEFAULT NULL,
  `whatsapp_template` text DEFAULT NULL,
  `steps` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`steps`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admission_settings`
--

INSERT INTO `admission_settings` (`id`, `institution_id`, `is_open`, `requirements`, `required_documents`, `schedule_information`, `additional_information`, `whatsapp_template`, `steps`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Persyaratan Uji PSB', NULL, NULL, NULL, NULL, '[{\"title\":\"Pengisian Formulir Digital\",\"description\":\"Mengisi formulir melalui link pendaftaran resmi.\",\"icon\":\"document\"},{\"title\":\"Ujian Tahfidz & Akademik\",\"description\":\"Ujian hafalan Al-Qur\'an minimal 1 juz.\",\"icon\":\"academic\"},{\"title\":\"Pengumuman Hasil Seleksi\",\"description\":\"Hasil seleksi diumumkan via portal.\",\"icon\":\"megaphone\"}]', '2026-09-04 00:29:33', '2026-09-24 01:33:40'),
(2, 3, 1, '1. Beragama Islam dan berakhlak mulia.\r\n2. Lulus SMP/MTs atau sederajat.\r\n3. Memiliki komitmen menghafal Al-Quran dan fokus akademik sains.\r\n4. Bersedia tinggal di asrama penuh dan mematuhi tata tertib pesantren.', '1. Fotokopi Ijazah / SKL SMP/MTs (3 lembar legalisir)\r\n2. Fotokopi Kartu Keluarga (KK) & Akta Kelahiran (3 lembar)\r\n3. Pas foto berwarna ukuran 3x4 (4 lembar)\r\n4. Surat Keterangan Berkelakuan Baik dari sekolah asal\r\n5. Sertifikat prestasi akademik / tahfidz (jika ada)', 'Gelombang I:\r\n- Pendaftaran: 01 Februari - 15 Maret\r\n- Ujian Potensi Akademik & Baca Quran: 20 Maret\r\n- Pengumuman Kelulusan: 25 Maret', 'Tersedia beasiswa bagi santri yang memiliki hafalan Al-Quran minimal 5 Juz atau juara olimpiade sains tingkat provinsi.', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.', NULL, '2026-09-04 00:29:33', '2026-09-24 00:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `graduation_levels` varchar(255) NOT NULL,
  `display_units` varchar(255) DEFAULT NULL,
  `career_type` varchar(255) NOT NULL DEFAULT 'student',
  `position_or_program` varchar(255) NOT NULL,
  `institution_or_company` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `is_home_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `scope` varchar(255) NOT NULL DEFAULT 'global',
  `summary` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `entity_type` varchar(255) NOT NULL,
  `entity_id` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `user_name`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'create', 'alumni', '1', 'Menambahkan data alumni: Fulan Testing Alumni.', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(2, 1, 'Super Admin', 'toggle_pin_home', 'alumni', '1', 'Pin Beranda untuk Fulan Testing Alumni berhasil dilepas.', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(3, 1, 'Super Admin', 'update', 'admission_setting', '1', 'Memperbarui setelan pendaftaran SMP Ulumul Islam (Status: DIBUKA).', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(4, 1, 'Super Admin', 'update', 'site_setting', '', 'Memperbarui konfigurasi situs global, WhatsApp, hero banner, dan SEO.', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(5, 1, 'Super Admin', 'update', 'institution', '5', 'Memperbarui profil dan media institusi Ikatan Alumni Dayah Ulumul Islam (IKADA UI).', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(6, 1, 'Super Admin', 'upload', 'gallery_media', '33', 'Mengunggah video baru \"Video Dokumentasi Pesantren\" ke album Kegiatan Tahfidz dan Muhadharah Dayah.', '127.0.0.1', '2026-09-24 03:49:20', '2026-09-24 03:49:20'),
(7, 1, 'Super Admin', 'create', 'alumni', '2', 'Menambahkan data alumni: Fulan Testing Alumni.', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23'),
(8, 1, 'Super Admin', 'toggle_pin_home', 'alumni', '2', 'Pin Beranda untuk Fulan Testing Alumni berhasil dilepas.', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23'),
(9, 1, 'Super Admin', 'update', 'admission_setting', '1', 'Memperbarui setelan pendaftaran SMP Ulumul Islam (Status: DIBUKA).', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23'),
(10, 1, 'Super Admin', 'update', 'site_setting', '', 'Memperbarui konfigurasi situs global, WhatsApp, hero banner, dan SEO.', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23'),
(11, 1, 'Super Admin', 'update', 'institution', '5', 'Memperbarui profil dan media institusi Ikatan Alumni Dayah Ulumul Islam (IKADA UI).', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23'),
(12, 1, 'Super Admin', 'upload', 'gallery_media', '34', 'Mengunggah video baru \"Video Dokumentasi Pesantren\" ke album Kegiatan Tahfidz dan Muhadharah Dayah.', '127.0.0.1', '2026-09-24 03:50:23', '2026-09-24 03:50:23');

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
-- Table structure for table `featured_alumni`
--

CREATE TABLE `featured_alumni` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alumni_id` bigint(20) UNSIGNED NOT NULL,
  `placement` enum('home','unit') NOT NULL DEFAULT 'unit',
  `sort_order` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_media`
--

CREATE TABLE `gallery_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mission`)),
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `banner_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `slug`, `type`, `short_description`, `description`, `vision`, `mission`, `phone`, `whatsapp`, `address`, `logo_path`, `banner_path`, `created_at`, `updated_at`) VALUES
(1, 'Yayasan Ulumul Islam', 'yayasan', 'foundation', 'Mendedikasikan Diri untuk Melahirkan Generasi Rabbani yang Menguasai Ilmu Agama dan Pengetahuan Umum.', 'Yayasan Pendidikan dan Pondok Pesantren Dayah Terpadu Ulumul Islam didirikan dengan tekad mulia untuk menyediakan wadah pembinaan generasi muda Islam yang komprehensif, mengintegrasikan sistem pendidikan formal berkualitas dengan nilai-nilai luhur kepesantrenan.\r\n\r\nBerdiri di atas landasan keikhlasan dan pengabdian, yayasan menaungi tiga pilar pendidikan utama: SMP Ulumul Islam, SMA Ulumul Islam, dan Pondok Pesantren Dayah Terpadu. Melalui kurikulum terintegrasi, sarana prasarana modern, serta bimbingan asatidz yang berkompeten, kami berkomitmen mencetak kader ulama dan cendekiawan muslim yang berakhlakul karimah, berwawasan global, dan siap berkontribusi nyata bagi agama, bangsa, dan ummat.', 'Terwujudnya lembaga pendidikan Islam terpadu yang unggul dan terkemuka dalam mencetak generasi Rabbani yang berilmu amaliyah, beramal ilmiah, dan berakhlakul karimah.', '[\"Menyelenggarakan pendidikan formal tingkat SMP dan SMA yang unggul, inovatif, dan berstandar nasional.\",\"Menyelenggarakan pembinaan kepesantrenan terpadu (Dayah) berbasis kitab turots dan tahfidzul Quran.\",\"Membina karakter, adab, dan kemandirian santri berlandaskan nilai-nilai Al-Quran dan As-Sunnah.\",\"Membekali santri dengan penguasaan bahasa internasional (Arab dan Inggris) serta literasi sains dan teknologi.\",\"Menjalin sinergi erat dengan masyarakat dan perguruan tinggi dalam pengembangan dakwah dan pendidikan Islam.\"]', '08111111111', '628111111111', 'Jl. Ulumul Islam No. 1, Uteunkot, Muara Dua, Lhokseumawe, Aceh', '/storage/institutions/logos/yJEzOWBS4efjCxAPpWVcVOUqnfNnZmsd5FEZZGhN.jpg', '/storage/institutions/banners/QYIDQpzdTgbPFAS2RqT4SoNQb1Vmg5KplaltR2XW.jpg', '2026-09-04 00:29:33', '2026-09-24 02:45:44'),
(2, 'SMP Ulumul Islam', 'smp', 'smp', 'Membina Generasi Unggul, Mandiri, dan Berakhlakul Karimah Berlandaskan Al-Quran dan Sunnah.', 'Sekolah Menengah Pertama (SMP) Ulumul Islam adalah institusi pendidikan formal terakreditasi yang memadukan keunggulan Kurikulum Nasional Kemendikbudristek dengan nilai-nilai luhur pesantren. Santri dididik dalam ekosistem belajar yang ramah, islami, dan kompetitif.\n\nDengan fokus pada penguatan dasar akademik, penguasaan literasi sains dan teknologi, serta penanaman adab dan tahfidz Al-Quran, SMP Ulumul Islam menyiapkan lulusan yang tidak hanya berprestasi tinggi dalam ujian akademik dan olimpiade sains, tetapi juga memiliki kepribadian santun, taat beribadah, dan siap melanjutkan ke jenjang menengah atas favorit.', 'Terwujudnya SMP Islam terpadu yang unggul dalam prestasi akademik dan non-akademik, berkarakter Qurani, berwawasan lingkungan, dan berdaya saing tinggi.', '[\"Menyelenggarakan pembelajaran kurikulum nasional secara kontekstual, aktif, dan berbasis teknologi informasi.\",\"Mengintegrasikan pendidikan karakter pesantren dalam setiap mata pelajaran dan pembiasaan adab harian.\",\"Melaksanakan bimbingan Tahfidz Al-Quran dengan target minimal 3 hingga 5 juz selama masa studi.\",\"Mengembangkan bakat, minat, dan potensi santri melalui bimbingan olimpiade sains (OSN) dan ekstrakurikuler terpadu.\",\"Mewujudkan lingkungan sekolah yang bersih, asri, nyaman, dan berbudaya islami.\"]', '08111111111', '628111111111', 'Komplek Pendidikan SMP Ulumul Islam, Aceh', NULL, NULL, '2026-09-04 00:29:33', '2026-09-21 07:23:04'),
(3, 'SMA Ulumul Islam', 'sma', 'sma', 'Membina Generasi Intelektual Muslim Unggul, Berwawasan Global, dan Siap Bersaing di Perguruan Tinggi Terkemuka.', 'Sekolah Menengah Atas (SMA) Ulumul Islam dirancang untuk mengantarkan santri menuju gerbang perguruan tinggi favorit dan kepemimpinan masa depan. Dengan kurikulum terpadu peminatan Matematika & Ilmu Alam (MIPA) serta Ilmu-Ilmu Sosial (IPS), santri dibekali kematangan berpikir kritis, kemampuan riset ilmiah, serta penguasaan bahasa asing yang fasih.\n\nDidukung program bimbingan intensif UTBK-SNBT, kelas persiapan beasiswa luar negeri (Timur Tengah, Turki, Eropa, dan Asia Tenggara), serta penguatan tahfidz lanjutan, SMA Ulumul Islam membuktikan tradisi kelulusan santri yang diterima di berbagai PTN terkemuka dan universitas internasional.', 'Menjadi SMA Islam unggulan berstandar nasional dan global yang melahirkan lulusan berintelektual tinggi, menguasai sains dan teknologi, berwawasan kebangsaan, dan berjiwa qurani.', '[\"Menyelenggarakan proses pembelajaran berkualitas tinggi dengan pemanfaatan teknologi informasi dan laboratorium sains modern.\",\"Melaksanakan bimbingan intensif persiapan Seleksi Nasional Masuk Perguruan Tinggi Negeri (SNBP, SNBT, Jalur Mandiri, dan Kedinasan).\",\"Mempersiapkan santri untuk seleksi beasiswa kuliah ke Timur Tengah (Al-Azhar Mesir, Madinah, Maroko) dan universitas luar negeri.\",\"Membina program Riset dan Karya Tulis Ilmiah Remaja (KIR) berbasis nilai keislaman dan kebutuhan masyarakat.\",\"Memperkokoh kepribadian santri dengan akhlak mulia, kemandirian kepemimpinan, dan kecintaan pada tanah air.\"]', '08111111111', '628111111111', 'Komplek Pendidikan SMA Ulumul Islam, Aceh', NULL, NULL, '2026-09-04 00:29:33', '2026-09-21 07:23:04'),
(4, 'Dayah Terpadu Ulumul Islam', 'dayah', 'dayah', 'Pusat Pengkaderan Ulama Amilin, Pembinaan Akhlakul Karimah, dan Pendalaman Kitab Kuning serta Bahasa Internasional.', 'Dayah Terpadu Ulumul Islam merupakan pondok pesantren modern berorientasi salafiyah yang mendidik santri secara intensif 24 jam. Dengan pendekatan terpadu, santri dibimbing mengkaji kitab-kitab muktabarah para ulama terdahulu (turots), menghafal Al-Quran dengan tajwid yang mutqin, serta membiasakan percakapan bahasa Arab dan Inggris dalam keseharian.\n\nDidukung lingkungan yang asri, disiplin islami yang terukur, dan keteladanan para asatidz/mursyid yang mukim bersama santri, Dayah Terpadu Ulumul Islam menanamkan kemandirian, kepemimpinan, serta kepekaan sosial tinggi agar santri menjadi pelita di tengah ummat.', 'Melahirkan ulama amilin dan pemimpin muslim yang kokoh dalam aqidah, mendalam dalam ilmu syariah, berakhlak mulia, dan tanggap terhadap tantangan zaman.', '[\"Menyelenggarakan kajian kitab turots (kuning) secara berjenjang dan bersanad dalam bidang nahwu, sharaf, fiqh, tauhid, tafsir, dan hadits.\",\"Membina program Tahfidzul Quran dengan target hafalan mutqin dan bersertifikasi.\",\"Menciptakan lingkungan berbahasa asing aktif (Bi\'ah Lughawiyyah) bahasa Arab dan bahasa Inggris 24 jam.\",\"Menanamkan pembiasaan ibadah yaumiyah, shalat berjamaah, qiyamul lail, dan adab thalabul ilmi.\",\"Melatih jiwa kepemimpinan, kemandirian, dan retorika dakwah santri melalui organisasi santri dan kegiatan muhadharah.\"]', '08111111111', '628111111111', 'Komplek Dayah Terpadu Ulumul Islam, Aceh', NULL, NULL, '2026-09-04 00:29:33', '2026-09-21 07:23:04'),
(5, 'Ikatan Alumni Dayah Ulumul Islam (IKADA UI)', 'ikada', 'ikada', NULL, NULL, NULL, '[]', NULL, NULL, NULL, '/storage/institutions/logos/ZeVVphR1ZNH4VieIwwGnMcrvYDUkES9ZJxrWyb6n.jpg', '/storage/institutions/banners/2fJnxLl6qfV0u6b2XGdLj8MabaVtumF7oJOYMHz3.jpg', '2026-09-23 05:59:04', '2026-09-24 03:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `institution_programs`
--

CREATE TABLE `institution_programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institution_programs`
--

INSERT INTO `institution_programs` (`id`, `institution_id`, `title`, `badge`, `description`, `icon`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Integrasi Tri-Pilar Pendidikan', 'Sistem Terpadu', 'Memadukan harmonis kurikulum nasional Kemendikbudristek, kurikulum Dayah Salafiyah, dan asrama 24 jam.', 'academic', 1, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(2, 1, 'Pengkaderan Ulama & Cendekiawan', 'Visi Utama', 'Mempersiapkan generasi yang kuat aqidah, faqih dalam agama, serta menguasai sains dan kepemimpinan ummat.', 'book', 2, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(3, 1, 'Beasiswa Santri Berprestasi', 'Dukungan Pendidikan', 'Program apresiasi dan keringanan biaya bagi santri berprestasi tahfidz Quran dan olimpiade sains.', 'award', 3, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(4, 1, 'Pengembangan Sarana Modern', 'Infrastruktur', 'Penyediaan sarana belajar multimedia, laboratorium sains & bahasa, serta lingkungan asri berbasis green campus.', 'building', 4, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(5, 4, 'Dirasah Islamiyah & Kitab Turots', 'Salafiyah', 'Pengkajian sistematis kitab kuning muktabarah bersanad dalam cabang ilmu alat, fiqh madzhab Syafi\'i, aqidah, dan tasawuf.', 'book', 1, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(6, 4, 'Tahfidzul Quran Mutqin', 'Al-Quran', 'Bimbingan intensif hafalan Al-Quran dengan metode talaqqi, tahsin bersanad, dan muraja\'ah teratur setiap waktu subuh dan maghrib.', 'quran', 2, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(7, 4, 'Bi\'ah Lughawiyyah (Bilingual 24 Jam)', 'Bahasa Aktif', 'Penerapan disiplin bahasa Arab dan Inggris dalam interaksi harian santri untuk membangun kepercayaan diri komunikasi global.', 'globe', 3, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(8, 4, 'Muhadharah & Khitabah 3 Bahasa', 'Retorika Dakwah', 'Latihan pidato dan public speaking berkala dalam bahasa Arab, Inggris, dan Indonesia untuk melatih mental kepemimpinan santri.', 'mic', 4, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(9, 4, 'Pengasuhan & Adab Nabawiyyah 24 Jam', 'Karakter', 'Pendampingan penuh oleh asatidz mukim asrama untuk memastikan shalat berjamaah 5 waktu di masjid, puasa sunnah, dan adab islami.', 'heart', 5, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(10, 4, 'Seni Bela Diri & Olahraga Sunnah', 'Minat & Bakat', 'Pengembangan fisik santri melalui latihan bela diri Tapak Suci, seni panahan, futsal, bulutangkis, dan kepanduan Pramuka.', 'shield', 6, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(11, 2, 'Kurikulum Nasional Terintegrasi Pesantren', 'Akademik Unggul', 'Harmonisasi kurikulum Kemendikbudristek dengan penguatan materi agama islam, fiqh ibadah, dan sirah nabawiyah.', 'academic', 1, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(12, 2, 'Tahfidz Al-Quran Juz 30 & Pilihan', 'Al-Quran', 'Target hafalan mutqin minimal 3-5 juz dengan bimbingan mualim bersertifikat dan setoran harian.', 'quran', 2, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(13, 2, 'Laboratorium Komputer & Literasi IT', 'Teknologi', 'Pembekalan keterampilan komputer dasar, aplikasi perkantoran, dan pemanfaatan teknologi digital secara positif.', 'computer', 3, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(14, 2, 'Kelas Pengayaan Sains & Matematika (OSN)', 'Prestasi', 'Bimbingan khusus santri berbakat untuk mengikuti Olimpiade Sains Nasional (IPA, Matematika, IPS) dan lomba cerdas cermat.', 'flask', 4, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(15, 2, 'Pembiasaan Adab & Shalat Berjamaah', 'Karakter', 'Penanaman adab kepada guru, orang tua, teman, shalat dhuha bersama, dan shalat fardhu berjamaah di masjid.', 'heart', 5, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(16, 2, 'Ekstrakurikuler Seni, Silat & Pramuka', 'Pengembangan Diri', 'Wadah pembentukan disiplin, kepemimpinan, dan kreativitas melalui Pramuka Gudep Pesantren, Tapak Suci, dan Kaligrafi.', 'star', 6, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(17, 3, 'Program Sukses PTN & Kedinasan (SNBT/SNBP)', 'Akademik Lanjutan', 'Bimbingan intensif tes skolastik, pemantapan materi UTBK, try out berkala, dan konsultasi peminatan jurusan universitas.', 'academic', 1, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(18, 3, 'Kelas Persiapan Studi Timur Tengah & Luar Negeri', 'Go International', 'Pembekalan seleksi Kemenag untuk studi ke Universitas Al-Azhar Kairo Mesir, universitas di Timur Tengah, dan beasiswa internasional.', 'globe', 2, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(19, 3, 'Laboratorium Sains Terpadu & Riset Ilmiah (KIR)', 'Riset & Sains', 'Praktikum fisika, kimia, biologi, serta pelatihan penulisan karya ilmiah santri yang diikutsertakan dalam kompetisi nasional.', 'flask', 3, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(20, 3, 'Tahfidz Al-Quran Lanjutan & Mutqin', 'Al-Quran', 'Program penyempurnaan hafalan dan muraja\'ah terstruktur bagi santri untuk menjaga hafalan Al-Quran hingga kelulusan.', 'quran', 4, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(21, 3, 'Pengembangan Bahasa Internasional & TOEFL/TOAFL', 'Bahasa Asing', 'Pelatihan tes kemampuan bahasa Inggris (TOEFL/IELTS preparation) dan bahasa Arab (TOAFL) bersertifikat.', 'certificate', 5, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(22, 3, 'Organisasi Santri & Kepemimpinan (ISPI)', 'Leadership', 'Latihan kepemimpinan nyata melalui kepengurusan organisasi santri, manajemen kepanitiaan acara, dan bakti sosial masyarakat.', 'award', 6, 1, '2026-09-21 07:23:04', '2026-09-21 07:23:04'),
(25, 5, 'Bursa Karir & Inkubator Usaha Alumni', 'Karir & Bisnis', 'Jejaring informasi lowongan kerja, peluang magang, kemitraan bisnis, dan pelatihan kewirausahaan bagi para alumni.', NULL, 1, 1, '2026-09-23 05:59:04', '2026-09-23 05:59:04'),
(26, 5, 'Beasiswa Santri Berprestasi IKADA', 'Sosial & Filantropi', 'Program bantuan biaya pendidikan dan asrama bagi santri yatim, dhuafa, dan penghafal Al-Quran yang bersumber dari donasi alumni.', NULL, 2, 1, '2026-09-23 05:59:04', '2026-09-23 05:59:04'),
(27, 5, 'Mentoring Masuk PTN & Kampus Luar Negeri', 'Pendidikan', 'Bimbingan berkala dari alumni yang menempuh studi di PTN unggulan dan universitas di Timur Tengah, Eropa, maupun Asia.', NULL, 3, 1, '2026-09-23 05:59:04', '2026-09-23 05:59:04'),
(28, 5, 'Reuni Akbar & Silaturahmi Nasional Tahunan', 'Ukhuwah Alumni', 'Musyawarah besar, temu kangen seluruh angkatan kelulusan, dan pengajian akbar tahunan di komplek Dayah Ulumul Islam.', NULL, 4, 1, '2026-09-23 05:59:04', '2026-09-23 05:59:04');

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
(4, '2026_09_04_000001_create_institutions_and_statistics_tables', 1),
(5, '2026_09_04_000002_create_structures_tables', 1),
(6, '2026_09_04_000003_create_news_and_announcements_tables', 1),
(7, '2026_09_04_000004_create_gallery_tables', 1),
(8, '2026_09_04_000005_create_alumni_tables', 1),
(9, '2026_09_04_000006_create_admission_and_settings_tables', 1),
(10, '2026_09_04_000007_create_audit_logs_table', 1),
(11, '2026_09_21_000001_add_logo_and_banner_to_institutions_table', 2),
(12, '2026_09_21_000002_add_image_path_to_announcements_table', 3),
(13, '2026_09_21_000003_create_institution_programs_table', 3),
(14, '2026_09_23_000001_add_ikada_and_update_enums', 4),
(15, '2026_09_23_000002_add_gallery_images_to_news_table', 5),
(16, '2026_09_24_000001_upgrade_structure_tables_to_divisions', 6),
(17, '2026_09_24_082828_add_display_units_and_pins_to_alumni_table', 7),
(18, '2026_09_24_090001_add_steps_to_admission_settings_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `scope` varchar(255) NOT NULL DEFAULT 'global',
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7h7gnfzXrClEFAWYqcdrMV4yl0NXAButine8OXVD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibE43dUZqMk96QllzRVgxa3NQQ1lPYjdCWmh2YVpGN0ppSmRYUDR4SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9nYWxlcmkva2VnaWF0YW4tdGFoZmlkei1kYW4tbXVoYWRoYXJhaCI7czo1OiJyb3V0ZSI7czoxMjoiZ2FsbGVyeS5zaG93Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1790247102);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'site_phone', '628123456789', '2026-09-04 00:29:33', '2026-09-24 03:21:32'),
(2, 'site_address', 'Aceh Utara', '2026-09-04 00:29:33', '2026-09-24 03:21:32'),
(3, 'site_gmaps', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15886.123456789!2d97.123456!3d5.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMDcnMjQuNCJOIDk3wrAwNyc0My4yIkU!5e0!3m2!1sid!2sid!4v1600000000000!5m2!1sid!2sid', '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(4, 'whatsapp_template_smp', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMP Ulumul Islam.', '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(5, 'whatsapp_template_sma', 'Assalamualaikum. Nama: [Nama], Asal: [Asal]. Saya ingin bertanya mengenai pendaftaran SMA Ulumul Islam.', '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(6, 'whatsapp_template_yayasan', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Yayasan Ulumul Islam.', '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(7, 'whatsapp_template_dayah', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.', '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(8, 'whatsapp_template_general', 'Assalamualaikum. Saya ingin bertanya mengenai informasi Dayah Terpadu Ulumul Islam.', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(9, 'whatsapp_template_ikada', 'Assalamualaikum. Saya ingin bertanya mengenai IKADA UI (Ikatan Alumni Dayah Ulumul Islam).', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(10, 'home_hero_title', 'Mencetak Generasi Qurani, Cerdas & Berakhlak Mulia', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(11, 'home_hero_subtitle', 'Pondok Pesantren Dayah Terpadu Ulumul Islam memadukan kurikulum pendidikan nasional (SMP & SMA) dengan tradisi kepesantrenan salafiyah modern.', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(12, 'site_meta_title', 'Ulumul Islam - Yayasan & Pondok Pesantren Dayah Terpadu', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(13, 'site_meta_description', 'Pondok Pesantren Dayah Terpadu Ulumul Islam, mengintegrasikan SMP, SMA, dan pengajian kitab kuning.', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(14, 'site_meta_keywords', 'dayah, pesantren, smp ulumul islam, sma ulumul islam, dayah terpadu, aceh, tahfidz', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(15, 'google_site_verification', NULL, '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(16, 'google_analytics_id', NULL, '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(17, 'home_hero_image', '/storage/settings/hero/uqI1jSTzNDGGjhWxQK34n8mYxYZzg1gKLcWQld7i.jpg', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(18, 'site_og_image', '/storage/settings/seo/sdAvpPJL31ci8ErAkSTwN5WSKvW0Y9g4480kbcIo.jpg', '2026-09-24 00:53:45', '2026-09-24 00:53:45'),
(19, 'site_stat_santri_aktif', '750', '2026-09-24 03:21:32', '2026-09-24 03:21:32'),
(20, 'site_stat_asatidz', '65', '2026-09-24 03:21:32', '2026-09-24 03:21:32'),
(21, 'site_stat_alumni', '1800', '2026-09-24 03:21:32', '2026-09-24 03:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `metric` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`id`, `institution_id`, `metric`, `value`, `created_at`, `updated_at`) VALUES
(1, 2, 'students_male', 0, '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(2, 2, 'students_female', 0, '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(3, 2, 'total_alumni', 300, '2026-09-04 00:29:33', '2026-09-21 07:30:47'),
(4, 3, 'students_male', 0, '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(5, 3, 'students_female', 0, '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(6, 3, 'total_alumni', 3, '2026-09-04 00:29:33', '2026-09-24 02:49:57'),
(7, 5, 'total_alumni', 1350, '2026-09-23 05:59:04', '2026-09-24 03:21:32'),
(9, 5, 'total_angkatan', 18, '2026-09-24 03:21:32', '2026-09-24 03:37:19'),
(10, 5, 'total_ptn', 90, '2026-09-24 03:21:32', '2026-09-24 03:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `structure_members`
--

CREATE TABLE `structure_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `member_role` varchar(255) NOT NULL DEFAULT 'member',
  `title` varchar(255) DEFAULT NULL,
  `sub_role` varchar(255) DEFAULT NULL,
  `period` varchar(255) NOT NULL DEFAULT '2024 - 2029',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `photo_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `structure_positions`
--

CREATE TABLE `structure_positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'division',
  `position_name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'ulumulislam2026@gmail.com', NULL, '$2y$12$vbFTm5YrOWWWxJo7fLKh4.OlcJhZ6s6gSv3BQ0HvK2MYZpRqhNKPu', 'super_admin', 1, NULL, '2026-09-04 00:29:33', '2026-09-04 00:29:33'),
(2, 'Co-Super Admin 1', 'cosuper1@ulumulislam.com', NULL, '$2y$12$bFYikQtSVuKaW55n/BP7OO3FVCdbo2QzP348ifUKcGWRAoT.Y6sMm', 'co_super_admin', 1, NULL, '2026-09-04 00:49:21', '2026-09-04 00:49:21'),
(3, 'Co-Super Admin 2', 'cosuper2@ulumulislam.com', NULL, '$2y$12$wHdyi7B8QCXPjN/OPgxugeC9HEXTpNuXAeGVNfUY5ipU0jqh3oecy', 'co_super_admin', 1, NULL, '2026-09-04 00:49:21', '2026-09-04 00:49:21'),
(4, 'Admin Konten', 'admin_konten@ulumulislam.com', NULL, '$2y$12$bW8Dx90nIrNeouEXh6JTBuSv9dM2dgy8R.SXDz8DT56SamaHsDRNm', 'admin', 1, 'w7HxBzer2z6fW2Y1amv4sLdknF1xjeSP3C2nveARF2p1rraETgneLRPXTcTp', '2026-09-04 00:49:21', '2026-09-04 00:49:21'),
(6, 'Admin IKADA UI', 'ikada@ulumulislam.com', NULL, '$2y$12$h94dUbsfuNn1XioTRaXTvOxMgGcEKHQd5HZvoGyGGSFuTNfYGi7um', 'admin_ikada', 1, NULL, '2026-09-23 05:59:04', '2026-09-23 05:59:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission_settings`
--
ALTER TABLE `admission_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_settings_institution_id_unique` (`institution_id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `featured_alumni`
--
ALTER TABLE `featured_alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `featured_alumni_alumni_id_placement_unique` (`alumni_id`,`placement`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gallery_albums_slug_unique` (`slug`),
  ADD KEY `gallery_albums_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `gallery_media`
--
ALTER TABLE `gallery_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_media_album_id_foreign` (`album_id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `institutions_slug_unique` (`slug`),
  ADD UNIQUE KEY `institutions_type_unique` (`type`);

--
-- Indexes for table `institution_programs`
--
ALTER TABLE `institution_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institution_programs_institution_id_foreign` (`institution_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_author_id_foreign` (`author_id`);

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
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_setting_key_unique` (`setting_key`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statistics_institution_id_metric_unique` (`institution_id`,`metric`);

--
-- Indexes for table `structure_members`
--
ALTER TABLE `structure_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `structure_members_position_id_foreign` (`position_id`);

--
-- Indexes for table `structure_positions`
--
ALTER TABLE `structure_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `structure_positions_institution_id_foreign` (`institution_id`);

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
-- AUTO_INCREMENT for table `admission_settings`
--
ALTER TABLE `admission_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `featured_alumni`
--
ALTER TABLE `featured_alumni`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_media`
--
ALTER TABLE `gallery_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `institution_programs`
--
ALTER TABLE `institution_programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `structure_members`
--
ALTER TABLE `structure_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `structure_positions`
--
ALTER TABLE `structure_positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission_settings`
--
ALTER TABLE `admission_settings`
  ADD CONSTRAINT `admission_settings_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `featured_alumni`
--
ALTER TABLE `featured_alumni`
  ADD CONSTRAINT `featured_alumni_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD CONSTRAINT `gallery_albums_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery_media`
--
ALTER TABLE `gallery_media`
  ADD CONSTRAINT `gallery_media_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `institution_programs`
--
ALTER TABLE `institution_programs`
  ADD CONSTRAINT `institution_programs_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `structure_members`
--
ALTER TABLE `structure_members`
  ADD CONSTRAINT `structure_members_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `structure_positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `structure_positions`
--
ALTER TABLE `structure_positions`
  ADD CONSTRAINT `structure_positions_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
