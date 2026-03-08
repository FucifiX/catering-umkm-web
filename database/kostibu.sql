-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 12:09 PM
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
-- Database: `kostibu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `avatar`) VALUES
(1, 'Frederick ', 'kostibu@gmail.com', 'user_1751725295.jpg'),
(2, 'Aditya Raghil Abimanyu', 'raghil60@gmail.com', 'avatar_1751724654_587.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `map_pins`
--

CREATE TABLE `map_pins` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pos_x` int(11) DEFAULT NULL,
  `pos_y` int(11) DEFAULT NULL,
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `map_pins`
--

INSERT INTO `map_pins` (`id`, `title`, `description`, `pos_x`, `pos_y`, `images`) VALUES
(1, 'Galeri KostIBU', 'Arsip dokumentasi kegiatan jual beli KostIBU Catering, kami telah melayani berbagai kebutuhan konsumsi pelanggan, mulai dari skala kecil hingga acara besar, dengan komitmen menjaga kualitas rasa, kebersihan, dan pelayanan terbaik.... testinng', 530, 500, 'Gemini_Generated_Image_7rxbbq7rxbbq7rxb.png,Gemini_Generated_Image_forpsyforpsyforp.png,Gemini_Generated_Image_un6t7un6t7un6t7u.png,Gemini_Generated_Image_wu6xmrwu6xmrwu6x (1).png,Gemini_Generated_Image_wu6xmrwu6xmrwu6x.png,Gemini_Generated_Image_knyve9knyve9knyv.png,Gemini_Generated_Image_swg7imswg7imswg7.png');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `bahan` text NOT NULL,
  `harga` text NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `deskripsi`, `bahan`, `harga`, `gambar`) VALUES
(1, 'Paket Hemat Uduk Spesial', 'Paket Nasi Uduk Komplit ini menghadirkan nasi uduk gurih yang dimasak dengan santan dan rempah harum, dilengkapi ikan teri goreng renyah, tahu dan tempe goreng garing, mie goreng sederhana yang lezat, serta acar wortel segar yang menambah sensasi asam manis. Tak ketinggalan tahu bacem dengan cita rasa manis gurih yang meresap hingga ke dalam, menjadikan hidangan ini komplit dan memanjakan lidah. Dalam satu paket, Anda akan mendapatkan 12 box siap saji, cocok untuk acara keluarga, kantor, maupun syukuran bersama orang terdekat.', 'Nasi uduk, Teri Goreng, Mie Putih, Wortel Acar, Tahu Kecap ', '35000', '1752103760-paket-hemat-uduk-spesial.png'),
(2, 'Paket Kenyang Jumbo', 'Paket ini berisi double nasi rames, tahu dan tempe goreng renyah, serta mie bihun lezat. Tersedia dalam 12 box, cocok untuk acara besar dengan porsi yang lebih mengenyangkan.\r\n', '2x Nasi, Bihun, Tahu Goreng, Tempe Goreng, Lalapan', '35000', '1752104710-paket-kenyang-jumbo.png'),
(4, 'Paket Merakyat', 'Nasi Uduk Jumbo berisi nasi uduk gurih, ikan teri renyah, tahu dan tempe goreng, mie bihun, serta sambal pedas nikmat. Tersedia dalam 12 box, pas untuk acara besar dengan porsi lebih banyak dan rasa komplit.', 'Nasi uduk, Ikan teri, Tahu Tempe, Mie bihun, sambal merah', '20000', '1752104880-paket-merakyat.png'),
(6, 'Paket Kuning Ulang Tahun', 'Paket Nasi Kuning Ulang Tahun berisi nasi kuning gurih, mie lezat, sambal pedas, ayam goreng renyah, serta tempe dan tahu goreng. Pas untuk merayakan momen ulang tahun dengan hidangan spesial dan komplit.\r\n', 'nasi kuning, mie, sambal, ayamgoreng, tempe tahu', '38000', '1752105510-paket-kuning-ulang-tahun.png'),
(7, 'Nasi Kebuli Cihuy', 'Paket Nasi Kebuli Daging Sapi berisi nasi kebuli gurih berbumbu rempah khas, dipadukan dengan daging sapi empuk dan sambal pelengkap. Cocok untuk sajian istimewa di acara spesial bersama keluarga atau rekan kerja.\r\n', 'Nasi Kebuli, Rendang Sapi, Lalap TImun', '49000', '1752105365-nasi-kebuli-cihuy.png'),
(8, 'Paket Sarapan Western', 'Paket Sarapan Western berisi beef steak lezat, wortel acar segart sebagai pelengkap. Cocok untuk sarapan praktis bergaya Barat yang mengenyangkan dan menggugah selera.', 'Beef Steak, Wortel Sayur,Dan salad', '38000', '1752105725-paket-sarapan-western.png'),
(9, 'Paket Dumpling', 'Berikut contoh deskripsi ringkas untuk **Paket Chinese Food**:\r\n\r\nPaket ini berisi nasi hangat, lauk khas oriental, mie atau bihun goreng, ayam atau sapi saus oriental, dan tumis sayuran segar. Cocok untuk acara makan bersama dengan cita rasa Asia Timur Food yang lezat dan menggugah selera.\r\n', 'Dumpling, Noodle, Teriyaki Beef, Lounge.', '300', '1752106992-paket-dumpling.png'),
(10, 'Kue Tradisional', 'Paket Kue Tradisional berisi aneka jajanan pasar seperti kue lapis, klepon, lemper, risoles, dan pastel, disajikan dalam tampilan menarik. Cocok untuk pelengkap acara arisan, rapat, atau syukuran dengan cita rasa jajanan khas Indonesia yang manis, gurih, dan selalu bikin rindu.', 'kue lapis, klepon, lemper, risoles, dan pastel', '120000', '1752107167-kue-tradisional.png'),
(11, 'Paket Gorengan', 'Paket Gorengan berisi aneka gorengan favorit seperti bakwan, risoles, tahu isi, tempe mendoan, dan pisang goreng. Cocok sebagai camilan pendamping acara kumpul, rapat, atau santai bersama keluarga dan teman.', 'bakwan, risoles, tahu isi, tempe mendoan, dan pisang goreng', '100000', '1752107404-paket-gorengan.png'),
(12, 'Paket Hemat 1', 'pilihan menu yang praktis dan terjangkau, cocok untuk kebutuhan makan sehari-hari dengan porsi yang pas dan cita rasa rumahan. Dalam satu paket, pelanggan akan mendapatkan nasi putih hangat, lauk utama seperti ayam goreng bumbu tradisional, sayur pendamping yang segar, sambal khas yang pedasnya pas, serta kerupuk renyah sebagai pelengkap. Paket ini dirancang untuk memenuhi kebutuhan gizi dengan harga yang ramah di kantong, sangat ideal untuk makan siang di kantor, di rumah, maupun untuk acara kecil bersama keluarga.', 'Nasi, Ayam, Mie, Sambal', '120000', '1752133992-paket-hemat-1.png'),
(13, 'Paket Hemat 2', 'pilihan menu yang praktis dan terjangkau, cocok untuk kebutuhan makan sehari-hari dengan porsi yang pas dan cita rasa rumahan. Dalam satu paket, pelanggan akan mendapatkan nasi putih hangat, lauk utama seperti ayam goreng bumbu tradisional, sayur pendamping yang segar, sambal khas yang pedasnya pas, serta kerupuk renyah sebagai pelengkap. Paket ini dirancang untuk memenuhi kebutuhan gizi dengan harga yang ramah di kantong, sangat ideal untuk makan siang di kantor, di rumah, maupun untuk acara kecil bersama keluarga.', 'Nasi Ayam', '120000', '1752134098-paket-hemat-2.png'),
(14, 'Paket Besan', 'pilihan istimewa yang dirancang khusus untuk momen-momen penting seperti acara lamaran, pernikahan, atau syukuran keluarga besar. Paket ini menghadirkan hidangan lengkap dengan cita rasa tradisional yang menggugah selera, mulai dari nasi putih pulen, aneka lauk pilihan seperti ayam ungkep, rendang sapi empuk, serta sambal khas yang menambah kelezatan. Dilengkapi dengan sayur mayur segar, kerupuk, dan hidangan penutup tradisional, Paket Besan menjadi simbol kebersamaan dan penghormatan untuk para tamu terhormat. Porsi yang melimpah dan tampilan yang rapi membuat paket ini cocok untuk menjamu keluarga besar dengan penuh kehangatan dan rasa syukur.', 'Full komplit, catering box food', '499000', '1752134188-paket-besan.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `kode_pesanan`, `nama_lengkap`, `alamat`, `no_wa`, `email`, `menu_id`, `harga`, `created_at`) VALUES
(6, 'ORDER-1751197342835-26NQR', 'Siti Nur Haliza', 'AASSAS', '11234567', 'debs@gmaiil.com', 1, 30000.00, '2025-06-29 11:42:27'),
(7, 'ORDER-3698-BUV82', 'Siti Nur Haliza', 'Deo Avanzini', '0856578986', 'felix@gmail.com', 4, 20000.00, '2025-06-29 12:58:39'),
(8, 'ORDER-7652-0ETR0', 'Siti Nur Haliza', 'aaaaaaaaaaa', '0856578986', 'raghil60@gmail.com', 1, 30000.00, '2025-06-29 13:07:51'),
(9, 'ORDER-4383-1MR46', 'Siti Nur Haliza', 'dajeongz', '0856578986', 'raghil60@gmail.com', 6, 30000.00, '2025-06-29 13:30:48'),
(12, 'ORDER-4312-Z9D6S', 'Siti Nur Haliza', 'as', '0089988808', 'raghil60@gmail.com', 4, 20000.00, '2025-07-08 14:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `id` int(11) NOT NULL,
  `topbar_color` varchar(20) DEFAULT '#8cf740',
  `sidebar_color` varchar(20) DEFAULT '#66af32'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`id`, `topbar_color`, `sidebar_color`) VALUES
(0, '#8cf740', '#66af32'),
(1, '#8cf740', '#66af32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `nama_lengkap`, `role`, `admin_id`) VALUES
(1, 'admin', '$2y$10$HXEdn50WeONeBK0T3xCRTOeCjkb27kdg45XFbzgRZyjhARWFH3lyG', 'kostibu@gmail.com', 'Frederick ', 'user', NULL),
(2, 'Aditya ', '$2y$10$dBO8eI4Ajp7crBalTGMTVO0/JwwWrYCmHaxjW5w4XF5fYLCHOderW', 'raghil60@gmail.com', 'Aditya Raghil Abimanyu', 'user', NULL),
(5, 'adminweb', '$2y$10$hVqyeSX1h0oH4ZkWsVA0meeGnmOkeHwfXDWwrExu8xvguKet8UfzK', 'test@gmail.com', 'admin', 'user', NULL),
(6, 'aditya11', '$2y$10$YZF62BL5e0c1RBysZ1A2UO4My6KZbC98PLKZj8DiylS8bV9Ae6oiG', 'adityagg@gmail.com', 'aditya', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_pins`
--
ALTER TABLE `map_pins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pesanan` (`kode_pesanan`),
  ADD UNIQUE KEY `kode_pesanan_2` (`kode_pesanan`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `map_pins`
--
ALTER TABLE `map_pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
