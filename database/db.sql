-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2021 at 01:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$4IDLRWJHD17qZnAhDOw92.T.KWXkmrxa95ARbd45bhQ2gb/l1US3S'),
(2, 'admin2', '$2y$10$7uncCHVKpVWWoztznVQIuuzOF.kmeoSaJAOvNrI1VbFDmQMZ/LF0e');

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

CREATE TABLE `bom` (
  `bom_id` int(11) NOT NULL,
  `bom_item_id` varchar(255) NOT NULL,
  `bom_material_id` varchar(255) DEFAULT NULL,
  `bom_quantity` float NOT NULL DEFAULT 0,
  `bom_divisi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`bom_id`, `bom_item_id`, `bom_material_id`, `bom_quantity`, `bom_divisi_id`) VALUES
(7, 'item1', 'material2', 0.6, 2),
(8, 'item1', 'material3', 0.7, 3),
(9, 'item1', 'material1', 0.9, 2),
(10, 'item1', 'material2', 0.89, 1);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `divisi_id` int(11) NOT NULL,
  `divisi_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`divisi_id`, `divisi_nama`) VALUES
(1, 'WW'),
(2, 'GESSO'),
(3, 'PACKING');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` varchar(255) NOT NULL,
  `item_nama` varchar(255) NOT NULL,
  `item_panjang` float NOT NULL,
  `item_lebar` float NOT NULL,
  `item_tebal` float NOT NULL,
  `item_kubikasi` float NOT NULL,
  `item_uom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_nama`, `item_panjang`, `item_lebar`, `item_tebal`, `item_kubikasi`, `item_uom_id`) VALUES
('item1', 'item1', 11, 12, 13, 0.0017, 12),
('item2', 'item2', 10, 20, 30, 400, 9),
('item3', 'item3', 11, 12, 13, 0.0017, 2);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` varchar(255) NOT NULL,
  `material_nama` varchar(255) NOT NULL,
  `material_harga` int(11) NOT NULL,
  `material_uom_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `material_nama`, `material_harga`, `material_uom_id`) VALUES
('material1', 'material1', 25000, 6),
('material2', 'material2', 12000, 2),
('material3', 'material3', 50000, 8);

-- --------------------------------------------------------

--
-- Table structure for table `so`
--

CREATE TABLE `so` (
  `so_id` int(11) NOT NULL,
  `so_no_po` varchar(255) NOT NULL,
  `so_bom_id` int(11) NOT NULL,
  `so_qty_order` float NOT NULL,
  `so_lot_number` varchar(255) NOT NULL,
  `so_realisasi` float NOT NULL,
  `so_ba` float NOT NULL,
  `so_tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so`
--

INSERT INTO `so` (`so_id`, `so_no_po`, `so_bom_id`, `so_qty_order`, `so_lot_number`, `so_realisasi`, `so_ba`, `so_tanggal`) VALUES
(23, 'PO1', 7, 2000, 'sft', 0, 0, '0000-00-00'),
(24, 'PO1', 8, 2000, 'sft', 0, 0, '0000-00-00'),
(25, 'PO1', 9, 2000, 'sft', 1400, 1499, '2021-12-18'),
(26, 'PO1', 10, 2000, 'sft', 0, 0, '0000-00-00'),
(28, 'PO2', 7, 3000, 'sft', 0, 0, '0000-00-00'),
(29, 'PO2', 8, 3000, 'sft', 0, 0, '0000-00-00'),
(30, 'PO2', 9, 3000, 'sft', 2699, 2799, '2021-12-18'),
(31, 'PO2', 10, 3000, 'sft', 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `uom_id` int(11) NOT NULL,
  `uom_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`uom_id`, `uom_nama`) VALUES
(2, 'KG'),
(4, 'GR'),
(5, 'PCS'),
(6, 'M3'),
(7, 'MTR'),
(8, 'ROL'),
(9, 'M2'),
(10, 'LTR'),
(12, 'SHEET');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bom`
--
ALTER TABLE `bom`
  ADD PRIMARY KEY (`bom_id`),
  ADD KEY `fk_bom_item` (`bom_item_id`),
  ADD KEY `fk_bom_material` (`bom_material_id`),
  ADD KEY `fk_bom_divisi` (`bom_divisi_id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`divisi_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_uom` (`item_uom_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `fk_material_uom` (`material_uom_id`);

--
-- Indexes for table `so`
--
ALTER TABLE `so`
  ADD PRIMARY KEY (`so_id`),
  ADD KEY `fk_so_bom` (`so_bom_id`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`uom_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bom`
--
ALTER TABLE `bom`
  MODIFY `bom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `divisi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `so`
--
ALTER TABLE `so`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `uom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bom`
--
ALTER TABLE `bom`
  ADD CONSTRAINT `fk_bom_divisi` FOREIGN KEY (`bom_divisi_id`) REFERENCES `divisi` (`divisi_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bom_item` FOREIGN KEY (`bom_item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bom_material` FOREIGN KEY (`bom_material_id`) REFERENCES `material` (`material_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_uom` FOREIGN KEY (`item_uom_id`) REFERENCES `uom` (`uom_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `fk_material_uom` FOREIGN KEY (`material_uom_id`) REFERENCES `uom` (`uom_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `so`
--
ALTER TABLE `so`
  ADD CONSTRAINT `fk_so_bom` FOREIGN KEY (`so_bom_id`) REFERENCES `bom` (`bom_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
