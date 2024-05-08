-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 08:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_responsi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_produk` (IN `p_nama_produk` VARCHAR(100), IN `p_harga` DECIMAL(10,2), IN `p_stock` INT)   BEGIN
    INSERT INTO produk (nama_produk, harga, stock) VALUES (p_nama_produk, p_harga, p_stock);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_produk` (IN `p_id_produk` INT, IN `p_nama_produk` VARCHAR(100), IN `p_harga` DECIMAL(10,2), IN `p_stock` INT)   BEGIN
    UPDATE produk 
    SET nama_produk = p_nama_produk,
        harga = p_harga,
        stock = p_stock
    WHERE id_produk = p_id_produk;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hapus_produk` (`p_id_produk` INT) RETURNS INT(11)  BEGIN
    DECLARE rows_affected INT;
    
    DELETE FROM produk WHERE id_produk = p_id_produk;
    SET rows_affected = ROW_COUNT();
    
    RETURN rows_affected;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', 'admin', 'administrator'),
(2, 'cadeck', '12cadeck,.', 'Cadeck Cristian Harati'),
(3, 'cristian ', 'cristian', 'cadeck cristian'),
(5, 'cristian12', 'admin', 'cadeck cristian'),
(6, 'admin123', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`) VALUES
(1, 'John Doe', 'Jl. Raya No. 123'),
(2, 'Jane Smith', 'Jl. Jendral Sudirman No. 456'),
(3, 'Michael Johnson', 'Jl. Gatot Subroto No. 78'),
(4, 'Cadeck Cristian ', 'Jl. kakatua no.13'),
(6, 'Yedija Tarigan ', 'Lingkar Luar');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `id_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `stock`, `id_transaksi`) VALUES
(1, 'laptop asus ', 700.00, 10, NULL),
(2, 'Laptop Lenovo', 700.00, 50, NULL),
(3, 'Smartphone Samsung', 400.00, 96, NULL),
(4, 'Mouse Logitech', 25.00, 200, NULL),
(9, 'laptop hp', 700.00, 50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksipenjualan`
--

CREATE TABLE `transaksipenjualan` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `tanggal_transaksi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksipenjualan`
--

INSERT INTO `transaksipenjualan` (`id_transaksi`, `id_pelanggan`, `id_produk`, `kuantitas`, `total_harga`, `tanggal_transaksi`) VALUES
(1, 1, 2, 5, 3500.00, '2024-05-08 14:30:00'),
(2, 1, 2, 3, 450000.00, '2024-05-08 14:30:00'),
(3, 1, 2, 3, 450000.00, '2024-05-08 14:30:00'),
(10, 3, 3, 5, 2000.00, '2024-05-08 16:40:24'),
(11, 1, 4, 5, 125.00, '2024-05-08 16:40:37');

--
-- Triggers `transaksipenjualan`
--
DELIMITER $$
CREATE TRIGGER `delete_stok_produk` AFTER DELETE ON `transaksipenjualan` FOR EACH ROW BEGIN
    DECLARE produk_stock INT;
    
    -- untuk mengambil stok produk dari tabel produk berdasarkan id_produk yang dihapus dari transaksi penjualan
    SELECT stock INTO produk_stock FROM produk WHERE id_produk = OLD.id_produk;
    
    -- mengupdate stok produk dengan menambahkan jumlah kuantitas yang dihapus dari transaksi penjualan
    UPDATE produk SET stock = produk_stock + OLD.kuantitas WHERE id_produk = OLD.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `transaksipenjualan` FOR EACH ROW BEGIN
    DECLARE produk_stok INT;

    -- mengambil stok produk dari tabel produk
    SELECT stock INTO produk_stok FROM produk WHERE id_produk = NEW.id_produk;

    -- megnurangi stok produk dengan jumlah kuantitas transaksi
    UPDATE produk SET stock = produk_stok - NEW.kuantitas WHERE id_produk = NEW.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_produk` AFTER UPDATE ON `transaksipenjualan` FOR EACH ROW BEGIN
    DECLARE produk_stock INT;
    
    -- Ambil stok produk dari tabel produk berdasarkan id_produk yang baru diupdate
    SELECT stock INTO produk_stock FROM produk WHERE id_produk = NEW.id_produk;
    
    -- Update stok produk dengan mengurangi jumlah kuantitas yang diupdate pada transaksi penjualan
    UPDATE produk SET stock = produk_stock - (NEW.kuantitas - OLD.kuantitas) WHERE id_produk = NEW.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_harga` BEFORE UPDATE ON `transaksipenjualan` FOR EACH ROW BEGIN
    DECLARE produk_harga DECIMAL(10,2);
    
    -- mengammbil harga produk dari tabel produk berdasarkan id_produk pada transaksi yang diupdate
    SELECT harga INTO produk_harga FROM produk WHERE id_produk = NEW.id_produk;
    
    -- mengupdate total harga dengan mengalikan kuantitas baru dengan harga produk
    SET NEW.total_harga = NEW.kuantitas * produk_harga;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_pelanggan`
-- (See below for the actual view)
--
CREATE TABLE `view_pelanggan` (
`id_pelanggan` int(11)
,`nama_pelanggan` varchar(50)
,`alamat` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_produk`
-- (See below for the actual view)
--
CREATE TABLE `view_produk` (
`id_produk` int(11)
,`nama_produk` varchar(100)
,`harga` decimal(10,2)
,`stock` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi_penjualan`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi_penjualan` (
`id_transaksi` int(11)
,`tanggal_transaksi` datetime
,`nama_pelanggan` varchar(50)
,`nama_produk` varchar(100)
,`kuantitas` int(11)
,`total_harga` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Structure for view `view_pelanggan`
--
DROP TABLE IF EXISTS `view_pelanggan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pelanggan`  AS SELECT `pelanggan`.`id_pelanggan` AS `id_pelanggan`, `pelanggan`.`nama_pelanggan` AS `nama_pelanggan`, `pelanggan`.`alamat` AS `alamat` FROM `pelanggan` ;

-- --------------------------------------------------------

--
-- Structure for view `view_produk`
--
DROP TABLE IF EXISTS `view_produk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_produk`  AS SELECT `produk`.`id_produk` AS `id_produk`, `produk`.`nama_produk` AS `nama_produk`, `produk`.`harga` AS `harga`, `produk`.`stock` AS `stock` FROM `produk` ;

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi_penjualan`
--
DROP TABLE IF EXISTS `view_transaksi_penjualan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_transaksi_penjualan`  AS SELECT `tp`.`id_transaksi` AS `id_transaksi`, `tp`.`tanggal_transaksi` AS `tanggal_transaksi`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `pr`.`nama_produk` AS `nama_produk`, `tp`.`kuantitas` AS `kuantitas`, `tp`.`total_harga` AS `total_harga` FROM ((`transaksipenjualan` `tp` join `pelanggan` `p` on(`tp`.`id_pelanggan` = `p`.`id_pelanggan`)) join `produk` `pr` on(`tp`.`id_produk` = `pr`.`id_produk`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `fk_transaksi` (`id_transaksi`);

--
-- Indexes for table `transaksipenjualan`
--
ALTER TABLE `transaksipenjualan`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksipenjualan`
--
ALTER TABLE `transaksipenjualan`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksipenjualan`
--
ALTER TABLE `transaksipenjualan`
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `transaksipenjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
