-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 04:10 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alquilerv2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_due_list` ()  NO SQL
SELECT I.issue_id, M.email, B.isbn, B.title
FROM book_issue_log I INNER JOIN member M on I.member = M.username INNER JOIN book B ON I.book_isbn = B.isbn
WHERE DATEDIFF(CURRENT_DATE, I.due_date) >= 0 AND DATEDIFF(CURRENT_DATE, I.due_date) % 5 = 0 AND (I.last_reminded IS NULL OR DATEDIFF(I.last_reminded, CURRENT_DATE) <> 0)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `autos`
--

CREATE TABLE `autos` (
  `idauto` int(11) NOT NULL,
  `placa` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `disponibilidad` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `autos`
--

INSERT INTO `autos` (`idauto`, `placa`, `marca`, `modelo`, `tipo`, `precio`, `disponibilidad`) VALUES
(1, 'AFD-2546', 'Great Wall', 'M4', 'Auto', 62, 0),
(2, 'AFD-2578', 'Ford', 'Edge', 'Camioneta', 160, 1),
(3, 'AFD-2584', 'Mitsubishi', 'L200', 'Camioneta', 170, 1),
(4, 'AKR-2867', 'Volswagen', 'Tiguan', 'Camioneta', 90, 0),
(5, 'ASF-5689', 'Chevrolet', 'Spark Gt', 'Auto', 65, 1),
(6, 'CDF-4526', 'Ford', 'Fiesta', 'Auto', 150, 1),
(7, 'CFR-5976', 'Hino', 'FD', 'Pesado', 240, 0),
(8, 'EAD-5682', 'Nissa', 'Sentra', 'Auto', 75, 1),
(9, 'ETG-6359', 'Renault', 'Sandero', 'Camioneta', 145, 0),
(10, 'GDS-2667', 'Kia', 'Rio', 'Auto', 85, 1),
(11, 'GSA-7992', 'Kia', 'Pikanto', 'Auto', 65, 1),
(12, 'IBA-1526', 'GreatWall \r\n', 'Wingle 7', 'Camioneta', 120, 1),
(13, 'IBA-1558', 'Mitsubishi', 'Oultander', 'Auto', 250, 1),
(14, 'JAP-1576', 'Hino', 'GH full', 'Pesado', 230, 1),
(15, 'JAP-1585', 'Chevrolet', 'Spark', 'Auto', 50, 1),
(16, 'MBV-5846', 'Ford', 'Explorer', 'Camioneta', 170, 1),
(17, 'MFW-5865', 'John Deer', 'Tractor 6125', 'Pesado', 150, 1),
(18, 'PAQ-4863', 'Chevrolet', 'Aveo', 'Auto', 75, 1),
(19, 'PCA-2397', 'Skoda', 'Fabia', 'Auto', 85, 1),
(20, 'PDF-4526', 'Chevrolet', 'Dimax', 'Camioneta', 80, 1),
(21, 'PDF-4529', 'Mazda', 'Cx-5', 'Camioneta', 60, 1),
(22, 'TDA-2836', 'Kia', 'Sportage', 'Auto', 90, 1),
(23, 'TDA-2866', 'Hyundai', 'HD 55', 'Pesado', 300, 1),
(24, 'TDL-2866', 'Caterpillar', 'RetroExcabadora 428F', 'Pesado', 250, 1),
(25, 'THP-6856', 'Renault', 'Captur', 'Auto', 60, 1),
(26, 'AZA-156', 'Toyota', 'NOVA', 'Auto', 100, 1),
(27, 'AZZ-156', 'Toyota', 'AGT', 'Auto', 100, 1),
(28, 'test1', 'test1', 'test1', 'Camioneta', 45, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_issue_log`
--

CREATE TABLE `book_issue_log` (
  `issue_id` int(11) NOT NULL,
  `member` varchar(20) NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `due_date` date NOT NULL,
  `last_reminded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_issue_log`
--

INSERT INTO `book_issue_log` (`issue_id`, `member`, `book_isbn`, `due_date`, `last_reminded`) VALUES
(41, 'roxana', 'CFR-5976', '0000-00-00', NULL),
(42, 'anita', 'AKR-2867', '0000-00-00', NULL),
(43, 'ivan', 'ETG-6359', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `imagenphp`
--

CREATE TABLE `imagenphp` (
  `id` int(11) NOT NULL,
  `urlPhoto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imagenphp`
--

INSERT INTO `imagenphp` (`id`, `urlPhoto`) VALUES
(1, 'imagenes/autox.jpg'),
(2, 'imagenes/0d2b299490a10f364fc833f2bce3be36.jpg'),
(3, 'imagenes/5dfc109d72500.png'),
(4, 'imagenes/2018-ford-f-250-super-duty-640x640.jpg'),
(5, 'imagenes/13217.jpg'),
(6, 'imagenes/camionetas-consumen-menos-ecuador-1.jpg'),
(7, 'imagenes/descarga (1).jpg'),
(8, 'imagenes/descarga.jpg'),
(9, 'imagenes/doble-cabina.jpg'),
(10, 'imagenes/eclipse-cross-camionetas-suv.jpg'),
(11, 'imagenes/EV5QQJAPHZFENMR236LBTO3HWM.jpg'),
(12, 'imagenes/foton_tunland_2016_diesel_foton_tunland_4170043593002127859.jpg'),
(13, 'imagenes/Volvo-XC90-2011-C01.jpg'),
(14, 'imagenes/volvo-xc40-carro-ano-europa-b.jpg'),
(15, 'imagenes/VA_821ad1f91c234625b926318449ec728b.jpg'),
(16, 'imagenes/images.jpg'),
(17, 'imagenes/IMAGEN-BP-1.jpg'),
(18, 'imagenes/high_volvo_xc40-t5-2017_r16.jpg'),
(19, 'imagenes/descarga.jpg'),
(20, 'imagenes/gmc-sierra-2014-6.jpg'),
(21, 'imagenes/camionetas-consumen-menos-ecuador-4.jpg'),
(22, 'imagenes/0d2b299490a10f364fc833f2bce3be36.jpg'),
(23, 'imagenes/07a8b79ea04a17e811923e6bcd82f171.jpg'),
(24, 'imagenes/EV5QQJAPHZFENMR236LBTO3HWM.jpg'),
(25, 'imagenes/camionetas-consumen-menos-ecuador-4.jpg'),
(26, 'imagenes/Mazdacx5.jpg'),
(27, 'imagenes/5dfc109d72500.png'),
(28, 'imagenes/141727778_2521425498160800_7953421904644812100_n.jpg'),
(29, 'imagenes/141727778_2521425498160800_7953421904644812100_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE `librarian` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`id`, `username`, `password`) VALUES
(1, 'grupo4', 'grupo4');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `name`, `email`) VALUES
(1, 'Roxana', '1234', 'Roxana Rios', 'atdelacruzm@utn.edu.ec'),
(2, 'Anita', '1234', 'Ana', 'delacruztaty176@gmail.com'),
(3, 'ivan', '1234', 'Ivan', 'ivanes285@gmail.com');

--
-- Triggers `member`
--
DELIMITER $$
CREATE TRIGGER `add_member` AFTER INSERT ON `member` FOR EACH ROW DELETE FROM pending_registrations WHERE username = NEW.username
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remove_member` AFTER DELETE ON `member` FOR EACH ROW DELETE FROM pending_book_requests WHERE member = OLD.username
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pending_book_requests`
--

CREATE TABLE `pending_book_requests` (
  `request_id` int(11) NOT NULL,
  `member` varchar(20) NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `time` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_book_requests`
--

INSERT INTO `pending_book_requests` (`request_id`, `member`, `book_isbn`, `time`, `estado`) VALUES
(1, 'anita', 'AKR-2867', '01/27/2021 - 02/23/2021', 'Aprobada'),
(2, 'ivan', 'ETG-6359', '01/24/2021 - 01/24/2021', 'Aprobada');

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`idauto`);

--
-- Indexes for table `book_issue_log`
--
ALTER TABLE `book_issue_log`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `imagenphp`
--
ALTER TABLE `imagenphp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autos`
--
ALTER TABLE `autos`
  MODIFY `idauto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `book_issue_log`
--
ALTER TABLE `book_issue_log`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `librarian`
--
ALTER TABLE `librarian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
