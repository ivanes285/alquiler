-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2021 a las 16:21:26
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alquilerv2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_due_list` ()  NO SQL
SELECT I.issue_id, M.email, B.isbn, B.title
FROM book_issue_log I INNER JOIN member M on I.member = M.username INNER JOIN book B ON I.book_isbn = B.isbn
WHERE DATEDIFF(CURRENT_DATE, I.due_date) >= 0 AND DATEDIFF(CURRENT_DATE, I.due_date) % 5 = 0 AND (I.last_reminded IS NULL OR DATEDIFF(I.last_reminded, CURRENT_DATE) <> 0)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos`
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
-- Volcado de datos para la tabla `autos`
--

INSERT INTO `autos` (`idauto`, `placa`, `marca`, `modelo`, `tipo`, `precio`, `disponibilidad`) VALUES
(1, 'AFD-2546', 'Great Wall', 'M4', 'Auto', 62, 0),
(2, 'AFD-2578', 'Ford', 'Edge', 'Camioneta', 160, 0),
(3, 'AFD-2584', 'Mitsubishi', 'L200', 'Camioneta', 170, 1),
(4, 'AKR-2867', 'Volswagen', 'Tiguan', 'Camioneta', 90, 0),
(5, 'ASF-5689', 'Chevrolet', 'Spark Gt', 'Auto', 65, 1),
(6, 'CDF-4526', 'Ford', 'Fiesta', 'Auto', 150, 1),
(7, 'CFR-5976', 'Hino', 'FD', 'Pesado', 240, 0),
(8, 'EAD-5682', 'Nissa', 'Sentra', 'Auto', 75, 1),
(9, 'ETG-6359', 'Renault', 'Sandero', 'Camioneta', 145, 0),
(10, 'GDS-2667', 'Kia', 'Rio', 'Auto', 85, 1),
(11, 'GSA-7992', 'Kia', 'Pikanto', 'Auto', 65, 0),
(12, 'IBA-1526', 'GreatWall \r\n', 'Wingle 7', 'Camioneta', 120, 1),
(13, 'IBA-1558', 'Mitsubishi', 'Oultander', 'Auto', 250, 1),
(14, 'JAP-1576', 'Hino', 'GH full', 'Pesado', 230, 1),
(15, 'JAP-1585', 'Chevrolet', 'Spark', 'Auto', 50, 1),
(16, 'MBV-5846', 'Ford', 'Explorer', 'Camioneta', 170, 1),
(17, 'MFW-5865', 'John Deer', 'Tractor 6125', 'Pesado', 150, 1),
(18, 'PAQ-4863', 'Chevrolet', 'Aveo', 'Auto', 75, 1),
(19, 'PCA-2397', 'Skoda', 'Fabia', 'Auto', 85, 1),
(20, 'PDF-4526', 'Chevrolet', 'Dimax', 'Camioneta', 80, 0),
(21, 'PDF-4529', 'Mazda', 'Cx-5', 'Camioneta', 60, 1),
(22, 'TDA-2836', 'Kia', 'Sportage', 'Auto', 90, 1),
(23, 'TDA-2866', 'Hyundai', 'HD 55', 'Pesado', 300, 1),
(24, 'TDL-2866', 'Caterpillar', 'RetroExcabadora 428F', 'Pesado', 250, 1),
(25, 'THP-6856', 'Renault', 'Captur', 'Auto', 60, 1),
(26, 'AZA-156', 'Toyota', 'NOVA', 'Auto', 100, 1),
(27, 'AZZ-156', 'Toyota', 'AGT', 'Auto', 100, 1),
(28, 'test1', 'test1', 'test1', 'Camioneta', 45, 0),
(29, 'XXX-000', 'Toyota', 'BLR', 'Auto', 100, 1),
(30, 'ZZZ-999', 'Toyota', 'RDK', 'Auto', 100, 1),
(31, 'HJU-678', 'Chevrolet', 'GH8', 'Camioneta', 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `book_issue_log`
--

CREATE TABLE `book_issue_log` (
  `issue_id` int(11) NOT NULL,
  `member` varchar(20) NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `due_date` date NOT NULL,
  `last_reminded` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `book_issue_log`
--

INSERT INTO `book_issue_log` (`issue_id`, `member`, `book_isbn`, `due_date`, `last_reminded`) VALUES
(42, 'anita', 'AKR-2867', '0000-00-00', NULL),
(43, 'ivan', 'ETG-6359', '0000-00-00', NULL),
(45, 'pepe', 'GSA-7992', '0000-00-00', NULL),
(46, 'marce', 'AFD-2584', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenphp`
--

CREATE TABLE `imagenphp` (
  `id` int(11) NOT NULL,
  `urlPhoto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagenphp`
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
(28, 'imagenes/eclipse-cross-camionetas-suv.jpg'),
(29, 'imagenes/IMAGEN-BP-1.jpg'),
(30, 'imagenes/0d2b299490a10f364fc833f2bce3be36.jpg'),
(31, 'imagenes/07a8b79ea04a17e811923e6bcd82f171.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librarian`
--

CREATE TABLE `librarian` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `librarian`
--

INSERT INTO `librarian` (`id`, `username`, `password`) VALUES
(1, 'grupo4', 'grupo4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `name`, `email`, `edad`) VALUES
(1, 'Roxana', '12345678', 'Roxana Rios', 'atdelacruzm@utn.edu.ec', 0),
(2, 'Anita', '12345678', 'Ana', 'delacruztaty176@gmail.com', 0),
(3, 'ivan', '12345678', 'Ivan', 'ivanes285@gmail.com', 0),
(4, 'pepe', '12345678', 'Jose', 'afcastrop@utn.edu.ec', 0),
(5, 'juan', '123412345678', 'Juan', 'dfb@gmail.com', 0),
(6, 'marce', '123412345678', 'marce', 'afc@gmail.com', 0);

--
-- Disparadores `member`
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
-- Estructura de tabla para la tabla `pending_book_requests`
--

CREATE TABLE `pending_book_requests` (
  `request_id` int(11) NOT NULL,
  `member` varchar(20) NOT NULL,
  `book_isbn` varchar(13) NOT NULL,
  `time` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pending_book_requests`
--

INSERT INTO `pending_book_requests` (`request_id`, `member`, `book_isbn`, `time`, `estado`) VALUES
(1, 'anita', 'AKR-2867', '01/27/2021 - 02/23/2021', 'Aprobada'),
(2, 'ivan', 'ETG-6359', '01/24/2021 - 01/24/2021', 'Aprobada'),
(3, 'pepe', 'GSA-7992', '01/24/2021 - 01/24/2021', 'Aprobada'),
(4, 'juan', 'AFD-2578', '02/15/2021 - 02/19/2021', 'Aprobada'),
(5, 'marce', 'AFD-2578', '01/25/2021 - 01/25/2021', 'Aprobada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pending_registrations`
--

CREATE TABLE `pending_registrations` (
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`idauto`);

--
-- Indices de la tabla `book_issue_log`
--
ALTER TABLE `book_issue_log`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indices de la tabla `imagenphp`
--
ALTER TABLE `imagenphp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indices de la tabla `pending_registrations`
--
ALTER TABLE `pending_registrations`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autos`
--
ALTER TABLE `autos`
  MODIFY `idauto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `book_issue_log`
--
ALTER TABLE `book_issue_log`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `librarian`
--
ALTER TABLE `librarian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `pending_book_requests`
--
ALTER TABLE `pending_book_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
