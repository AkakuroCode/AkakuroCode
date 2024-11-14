-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2024 a las 09:43:02
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oceantrade`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `idad` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idad`, `email`, `passw`) VALUES
(1, 'torrescristian661@gmail.com', '$2y$10$9x/7gMvf/dDi0wl4jsgfLODefiV/Wx7uoblbYwidWzOlGp8V9i/Zi'),
(3, 'alfredoacordate@gmail.com', '$2y$10$AyrlDu7guUKEXqjJu6reSue47K0dKxypB8l7cx/k58zLSzKSofp4K');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idcarrito` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `fechacrea` date NOT NULL,
  `fechamod` date NOT NULL CHECK (`fechamod` >= `fechacrea`),
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idcarrito`, `idus`, `fechacrea`, `fechamod`, `estado`, `total`) VALUES
(37, 9, '2024-11-02', '2024-11-02', 'Activo', 0.00),
(40, 10, '2024-11-04', '2024-11-04', 'Activo', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcat` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcat`, `nombre`, `descripcion`) VALUES
(1, 'vehículos', 'Productos relacionados con vehículos y transporte'),
(2, 'electrodoméstico', 'Aparatos eléctricos para el hogar'),
(3, 'hogar', 'Productos para el hogar y decoración'),
(4, 'oficina', 'Equipos y suministros para la oficina'),
(5, 'librería', 'Artículos de librería y papelería'),
(6, 'belleza', 'Productos para el cuidado personal y belleza'),
(7, 'bebés', 'Artículos para el cuidado de bebés'),
(8, 'juguetes', 'Juguetes y entretenimiento para niños'),
(9, 'deportes', 'Equipos y accesorios deportivos'),
(10, 'música', 'Instrumentos musicales y accesorios'),
(11, 'tecnología', 'Artículos tecnológicos y dispositivos electrónicos'),
(12, 'celulares', 'Teléfonos móviles y accesorios'),
(13, 'herramientas', 'Herramientas y equipos de construcción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centrorecibo`
--

CREATE TABLE `centrorecibo` (
  `idrecibo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centrorecibo`
--

INSERT INTO `centrorecibo` (`idrecibo`, `nombre`, `telefono`) VALUES
(11, 'Centro de Recibo - Tres Cruces', '+598 2901 1234'),
(12, 'Centro de Recibo - Unión', '+598 2506 5678'),
(13, 'Centro de Recibo - Portones Shopping', '+598 2604 9876'),
(14, 'Centro de Recibo - Prado', '+598 2336 1122'),
(15, 'Centro de Recibo - Ciudad Vieja', '+598 2915 4455');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierra`
--

CREATE TABLE `cierra` (
  `idpago` int(11) NOT NULL,
  `idcarrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cierra`
--

INSERT INTO `cierra` (`idpago`, `idcarrito`) VALUES
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 37),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40),
(3, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idus` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `apellido` varchar(15) NOT NULL,
  `fecnac` date NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` varchar(18) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) DEFAULT NULL,
  `activo` enum('si','no') NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idus`, `nombre`, `apellido`, `fecnac`, `direccion`, `telefono`, `email`, `passw`, `activo`) VALUES
(9, 'Cristian', 'Torres', '2001-03-08', 'Ernesto Pinto S162', '25149513', 'crisberon33@gmail.com', '$2y$10$QjdKfuCrhFTUxray02br0.eXMIWMXaXPQ/czeZOaBa8l987U2JgRW', 'si'),
(10, 'Ceci', 'Gimeno', '1999-07-22', 'Juan Rosas 4479', '092567464', 'cris@gmail.com', '$2y$10$v/Aw8/gc4XJFt1kpC9816u45yiraFCYzdjEHUrpfxUc1uDjO5j69u', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idpago` int(11) NOT NULL,
  `estado` enum('Completado','Pendiente','Cancelado') NOT NULL,
  `tipo_entrega` enum('Envio','Recibo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idpago`, `estado`, `tipo_entrega`) VALUES
(12, 3, 'Pendiente', 'Recibo'),
(13, 3, 'Pendiente', 'Recibo'),
(14, 3, 'Completado', 'Recibo'),
(15, 3, 'Completado', 'Recibo'),
(16, 3, 'Completado', 'Recibo'),
(17, 3, 'Completado', 'Recibo'),
(18, 3, 'Completado', 'Envio'),
(19, 3, 'Completado', 'Envio'),
(20, 3, 'Completado', 'Recibo'),
(21, 3, 'Completado', 'Recibo'),
(22, 3, 'Completado', 'Recibo'),
(23, 3, 'Completado', 'Recibo'),
(24, 3, 'Completado', 'Recibo'),
(25, 3, 'Completado', 'Recibo'),
(26, 3, 'Completado', 'Envio'),
(27, 3, 'Completado', 'Envio'),
(28, 3, 'Completado', 'Envio'),
(29, 3, 'Completado', 'Envio'),
(30, 3, 'Completado', 'Envio'),
(31, 3, 'Completado', 'Envio'),
(32, 3, 'Completado', 'Recibo'),
(33, 3, 'Completado', 'Recibo'),
(34, 3, 'Completado', 'Recibo'),
(35, 3, 'Completado', 'Recibo'),
(36, 3, 'Completado', 'Recibo'),
(37, 3, 'Completado', 'Recibo'),
(38, 3, 'Completado', 'Recibo'),
(39, 3, 'Completado', 'Recibo'),
(40, 3, 'Completado', 'Recibo'),
(41, 3, 'Completado', 'Recibo'),
(42, 3, 'Completado', 'Recibo'),
(43, 3, 'Completado', 'Recibo'),
(44, 3, 'Completado', 'Recibo'),
(45, 3, 'Completado', 'Recibo'),
(46, 3, 'Completado', 'Recibo'),
(47, 3, 'Completado', 'Recibo'),
(48, 3, 'Completado', 'Recibo'),
(49, 3, 'Completado', 'Recibo'),
(50, 3, 'Completado', 'Recibo'),
(51, 3, 'Completado', 'Recibo'),
(52, 3, 'Completado', 'Recibo'),
(53, 3, 'Completado', 'Recibo'),
(54, 3, 'Completado', 'Recibo'),
(55, 3, 'Completado', 'Recibo'),
(56, 3, 'Completado', 'Recibo'),
(57, 3, 'Completado', 'Envio'),
(58, 3, 'Completado', 'Envio'),
(59, 3, 'Completado', 'Envio'),
(60, 3, 'Completado', 'Recibo'),
(61, 3, 'Completado', 'Recibo'),
(62, 3, 'Completado', 'Recibo'),
(63, 3, 'Completado', 'Recibo'),
(64, 3, 'Completado', 'Recibo'),
(65, 3, 'Completado', 'Recibo'),
(66, 3, 'Completado', 'Recibo'),
(67, 3, 'Completado', 'Recibo'),
(68, 3, 'Completado', 'Recibo'),
(69, 3, 'Completado', 'Recibo'),
(70, 3, 'Completado', 'Recibo'),
(71, 3, 'Completado', 'Recibo'),
(72, 3, 'Completado', 'Recibo'),
(73, 3, 'Completado', 'Recibo'),
(74, 3, 'Completado', 'Recibo'),
(75, 3, 'Completado', 'Recibo'),
(76, 3, 'Completado', 'Recibo'),
(77, 3, 'Completado', 'Recibo'),
(78, 3, 'Completado', 'Recibo'),
(79, 3, 'Completado', 'Recibo'),
(80, 3, 'Completado', 'Envio'),
(81, 3, 'Completado', 'Envio'),
(82, 3, 'Completado', 'Recibo'),
(83, 3, 'Completado', 'Recibo'),
(84, 3, 'Completado', 'Recibo'),
(85, 3, 'Completado', 'Recibo'),
(86, 3, 'Completado', 'Recibo'),
(87, 3, 'Completado', 'Recibo'),
(88, 3, 'Completado', 'Recibo'),
(89, 3, 'Completado', 'Recibo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `sku` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crea`
--

CREATE TABLE `crea` (
  `sku` int(11) NOT NULL,
  `idcarrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `iddetalle` int(11) NOT NULL,
  `idcarrito` int(11) NOT NULL,
  `sku` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_envio`
--

CREATE TABLE `detalle_envio` (
  `idcompra` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Completado') NOT NULL,
  `total_compra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_envio`
--

INSERT INTO `detalle_envio` (`idcompra`, `direccion`, `estado`, `total_compra`) VALUES
(18, 'Ernesto Pinto, S162, Leandro Gomez', 'Completado', 40.06),
(19, 'Ernesto Pinto, S162, Teniente Galeano', 'Completado', 40.06),
(26, 'Cmo Maldonado, 2030, Libia', 'Completado', 200.00),
(27, 'Gral Flores, 4479, Corrales', 'Completado', 40.00),
(28, 'Juan Rosas, 4479, Cotopaxi', 'Completado', 430.00),
(29, 'Juan Rosas, 4479, Cotopaxi', 'Completado', 430.00),
(30, 'Juan Rosas, 4479, Cotopaxi', 'Completado', 430.00),
(31, 'Juan Rosas, 4479, Cotopaxi', 'Completado', 400.00),
(57, 'Cmo Maldonado, 2030, Libia', 'Completado', 430.00),
(58, 'Cmo Maldonado, 2030, Libia', 'Completado', 430.00),
(59, 'Cmo Maldonado, 2030, Libia', 'Completado', 430.00),
(80, 'Cmo Maldonado, 2030, Libia', 'Completado', 520.00),
(81, 'Paganini, 71, Juan de Dios Cabrera', 'Completado', 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_historial`
--

CREATE TABLE `detalle_historial` (
  `idregistrocompra` int(11) NOT NULL,
  `idhistorial` int(11) DEFAULT NULL,
  `sku` int(11) DEFAULT NULL,
  `estado` enum('Completado','Pendiente','Cancelado') DEFAULT NULL,
  `codigo_unidad` varchar(50) DEFAULT 'N/A',
  `precio_actual` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_historial`
--

INSERT INTO `detalle_historial` (`idregistrocompra`, `idhistorial`, `sku`, `estado`, `codigo_unidad`, `precio_actual`) VALUES
(67, 4, 18, 'Completado', '50AKAQM', 400.00),
(68, 4, 19, 'Completado', '50KAQW2', 500.00),
(70, 5, 18, 'Completado', 'QKDMO54', 400.00),
(79, 5, 19, 'Completado', '10QWNAS', 500.00),
(80, 5, 19, 'Completado', '60PGASN', 500.00),
(81, 5, 19, 'Completado', '8EJQ7213', 500.00),
(82, 5, 19, 'Completado', 'QMDAS4H9', 500.00),
(85, 5, 14, 'Completado', NULL, 40.00),
(86, 5, 19, 'Completado', '6AHE5NB9', 500.00),
(87, 5, 19, 'Completado', NULL, 500.00),
(88, 5, 14, 'Completado', NULL, 40.00),
(100, 5, 19, 'Completado', '1SADAK4K', 500.00),
(101, 5, 14, 'Completado', NULL, 40.00),
(102, 5, 14, 'Completado', NULL, 40.00),
(103, 5, 19, 'Completado', 'QPKLM23K', 500.00),
(106, 5, 17, 'Completado', NULL, 400.00),
(107, 5, 14, 'Completado', NULL, 40.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibo`
--

CREATE TABLE `detalle_recibo` (
  `idcompra` int(11) NOT NULL,
  `estado` enum('Pendiente','Completado') NOT NULL,
  `total_compra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_recibo`
--

INSERT INTO `detalle_recibo` (`idcompra`, `estado`, `total_compra`) VALUES
(14, 'Completado', 40.06),
(15, 'Completado', 40.06),
(16, 'Completado', 40.06),
(17, 'Completado', 40.06),
(20, 'Completado', 800.00),
(21, 'Completado', 480.00),
(22, 'Completado', 500.00),
(23, 'Completado', 500.00),
(24, 'Completado', 500.00),
(25, 'Completado', 500.00),
(32, 'Completado', 400.00),
(33, 'Completado', 400.00),
(34, 'Completado', 400.00),
(35, 'Completado', 400.00),
(36, 'Completado', 400.00),
(37, 'Completado', 400.00),
(38, 'Completado', 400.00),
(39, 'Completado', 400.00),
(40, 'Completado', 500.00),
(41, 'Completado', 500.00),
(42, 'Completado', 400.00),
(43, 'Completado', 400.00),
(44, 'Completado', 400.00),
(45, 'Completado', 430.00),
(46, 'Completado', 30.00),
(47, 'Completado', 430.00),
(48, 'Completado', 430.00),
(49, 'Completado', 40.00),
(50, 'Completado', 500.00),
(51, 'Completado', 860.00),
(52, 'Completado', 620.00),
(53, 'Completado', 550.00),
(54, 'Completado', 530.00),
(55, 'Completado', 530.00),
(56, 'Completado', 590.00),
(60, 'Completado', 530.00),
(61, 'Completado', 710.00),
(62, 'Completado', 400.00),
(63, 'Completado', 400.00),
(64, 'Completado', 400.00),
(65, 'Completado', 400.00),
(66, 'Completado', 400.00),
(67, 'Completado', 400.00),
(68, 'Completado', 400.00),
(69, 'Completado', 400.00),
(70, 'Completado', 400.00),
(71, 'Completado', 440.00),
(72, 'Completado', 440.00),
(73, 'Completado', 40.00),
(74, 'Completado', 40.00),
(75, 'Completado', 40.00),
(76, 'Completado', 40.00),
(77, 'Completado', 40.00),
(78, 'Completado', 540.00),
(79, 'Completado', 540.00),
(82, 'Completado', 1120.00),
(83, 'Completado', 1120.00),
(84, 'Completado', 1120.00),
(85, 'Completado', 1120.00),
(86, 'Completado', 1120.00),
(87, 'Completado', 580.00),
(88, 'Completado', 580.00),
(89, 'Completado', 440.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `idventa` int(11) NOT NULL,
  `sku` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`idventa`, `sku`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(3, 14, 6, 40.00, 240.00),
(3, 19, 2, 500.00, 1000.00),
(4, 17, 1, 400.00, 400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elige`
--

CREATE TABLE `elige` (
  `sku` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `favorito` enum('Si','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elige`
--

INSERT INTO `elige` (`sku`, `idus`, `favorito`) VALUES
(8, 9, 'Si'),
(8, 10, 'Si'),
(14, 9, 'Si'),
(14, 10, 'No'),
(16, 9, 'No'),
(17, 9, 'No'),
(17, 10, 'Si'),
(18, 9, 'No'),
(18, 10, 'Si'),
(19, 9, 'No'),
(19, 10, 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idemp` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` int(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `cuentabanco` int(15) NOT NULL,
  `activo` enum('si','no') NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idemp`, `nombre`, `direccion`, `telefono`, `email`, `passw`, `cuentabanco`, `activo`) VALUES
(3, 'AkakuroCode', 'Ernesto Pinto S162', 9988776, 'empresa@gmail.com', '$2y$10$Nz2YDWiiwJMQk4503FAyce.4UYXgsopkZkKDxgnrLtEbuBpGC9eMG', 512345, 'si'),
(4, 'PeladoCode', 'Ernesto Pinto S162', 95555230, 'empresa3@gmail.com', '$2y$10$VQa5sOQHvgXsOHvaUsHx1emLZ4ppClJwopaCSfQ4L.09oYeKg6h8e', 111111, 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `idenvio` int(11) NOT NULL,
  `fecsa` date NOT NULL,
  `fecen` date NOT NULL CHECK (`fecen` >= `fecsa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`idenvio`, `fecsa`, `fecen`) VALUES
(1, '2024-11-02', '2024-11-09'),
(2, '2024-11-04', '2024-11-11'),
(3, '2024-11-04', '2024-11-11'),
(4, '2024-11-04', '2024-11-11'),
(5, '2024-11-04', '2024-11-11'),
(6, '2024-11-04', '2024-11-11'),
(7, '2024-11-04', '2024-11-11'),
(8, '2024-11-04', '2024-11-11'),
(9, '2024-11-04', '2024-11-11'),
(10, '2024-11-04', '2024-11-11'),
(11, '2024-11-05', '2024-11-12'),
(12, '2024-11-05', '2024-11-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especifica`
--

CREATE TABLE `especifica` (
  `idcompra` int(11) NOT NULL,
  `idrecibo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especifica`
--

INSERT INTO `especifica` (`idcompra`, `idrecibo`) VALUES
(16, 14),
(17, 14),
(20, 14),
(21, 12),
(22, 13),
(23, 13),
(24, 13),
(25, 13),
(32, 14),
(33, 12),
(34, 12),
(35, 12),
(36, 15),
(37, 15),
(38, 15),
(39, 15),
(40, 12),
(41, 12),
(42, 14),
(43, 12),
(44, 13),
(45, 13),
(46, 13),
(47, 12),
(48, 15),
(49, 15),
(50, 15),
(51, 13),
(52, 13),
(53, 13),
(54, 14),
(55, 13),
(56, 14),
(60, 15),
(61, 12),
(62, 12),
(63, 15),
(64, 12),
(65, 12),
(66, 13),
(67, 12),
(68, 13),
(69, 12),
(70, 15),
(71, 13),
(72, 12),
(73, 11),
(74, 13),
(75, 15),
(76, 15),
(77, 12),
(78, 12),
(79, 12),
(82, 12),
(83, 12),
(84, 12),
(85, 12),
(86, 12),
(87, 12),
(88, 12),
(89, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiona`
--

CREATE TABLE `gestiona` (
  `idad` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compra`
--

CREATE TABLE `historial_compra` (
  `idhistorial` int(11) NOT NULL,
  `idus` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `stock` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_compra`
--

INSERT INTO `historial_compra` (`idhistorial`, `idus`, `fecha`, `stock`) VALUES
(4, 10, '2024-11-05', 3),
(5, 9, '2024-11-06', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_login`
--

CREATE TABLE `historial_login` (
  `idlogin` int(11) NOT NULL,
  `idus` int(11) DEFAULT NULL,
  `idemp` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_login`
--

INSERT INTO `historial_login` (`idlogin`, `idus`, `idemp`, `fecha`, `hora`, `url`) VALUES
(2, 9, NULL, '2024-10-12', '18:05:00', '/sigto/index.php?action=login'),
(3, NULL, 3, '2024-10-12', '18:24:03', '/sigto/index.php?action=login'),
(4, 9, NULL, '2024-10-12', '18:25:36', '/sigto/index.php?action=login'),
(5, 9, NULL, '2024-10-14', '17:49:49', '/sigto/index.php?action=login'),
(6, 9, NULL, '2024-10-14', '20:25:57', '/sigto/index.php?action=login'),
(7, 9, NULL, '2024-10-16', '00:00:33', '/sigto/index.php?action=login'),
(8, NULL, 3, '2024-10-16', '20:43:52', '/sigto/index.php?action=login'),
(9, NULL, 3, '2024-10-17', '03:26:18', '/sigto/index.php?action=login'),
(10, NULL, 3, '2024-10-17', '09:38:13', '/sigto/index.php?action=login'),
(11, NULL, 3, '2024-10-19', '00:56:01', '/sigto/index.php?action=login'),
(12, NULL, 3, '2024-10-19', '00:56:12', '/sigto/index.php?action=login'),
(13, NULL, 3, '2024-10-19', '01:02:22', '/sigto/index.php?action=login'),
(14, NULL, 3, '2024-10-19', '01:49:00', '/sigto/index.php?action=login'),
(15, NULL, 3, '2024-10-19', '13:41:23', '/sigto/index.php?action=login'),
(16, NULL, 3, '2024-10-21', '14:35:28', '/sigto/index.php?action=login'),
(17, NULL, 3, '2024-10-21', '14:49:13', '/sigto/index.php?action=login'),
(18, NULL, 3, '2024-10-22', '16:21:45', '/sigto/index.php?action=login'),
(19, NULL, 4, '2024-10-26', '17:06:49', '/sigto/index.php?action=login'),
(20, NULL, 4, '2024-10-26', '18:26:56', '/sigto/index.php?action=login'),
(21, NULL, 3, '2024-10-26', '23:11:40', '/sigto/index.php?action=login'),
(22, NULL, 3, '2024-11-01', '02:46:35', '/sigto/index.php?action=login'),
(23, NULL, 3, '2024-11-03', '13:19:35', '/sigto/index.php?action=login'),
(24, NULL, 3, '2024-11-04', '16:33:06', '/sigto/index.php?action=login'),
(25, NULL, 3, '2024-11-05', '18:43:36', '/sigto/index.php?action=login'),
(26, NULL, 3, '2024-11-05', '18:52:34', '/sigto/index.php?action=login'),
(27, NULL, 4, '2024-11-05', '23:44:36', '/sigto/index.php?action=login'),
(28, NULL, 4, '2024-11-06', '00:34:45', '/sigto/index.php?action=login'),
(29, NULL, 3, '2024-11-06', '01:26:42', '/sigto/index.php?action=login'),
(30, NULL, 3, '2024-11-06', '03:04:06', '/sigto/index.php?action=login'),
(31, NULL, 3, '2024-11-06', '03:20:37', '/sigto/index.php?action=login'),
(32, NULL, 3, '2024-11-06', '03:29:29', '/sigto/index.php?action=login'),
(33, NULL, 3, '2024-11-06', '03:35:25', '/sigto/index.php?action=login'),
(34, NULL, 3, '2024-11-06', '03:53:59', '/sigto/index.php?action=login'),
(35, NULL, 3, '2024-11-06', '03:56:23', '/sigto/index.php?action=login'),
(36, NULL, 3, '2024-11-06', '04:03:17', '/sigto/index.php?action=login'),
(37, NULL, 3, '2024-11-06', '04:27:12', '/sigto/index.php?action=login'),
(38, NULL, 3, '2024-11-06', '04:29:18', '/sigto/index.php?action=login'),
(39, NULL, 3, '2024-11-06', '05:34:12', '/sigto/index.php?action=login');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicia`
--

CREATE TABLE `inicia` (
  `idcompra` int(11) NOT NULL,
  `idpago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inicia`
--

INSERT INTO `inicia` (`idcompra`, `idpago`) VALUES
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3),
(89, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maneja`
--

CREATE TABLE `maneja` (
  `idcompra` int(11) NOT NULL,
  `idenvio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `maneja`
--

INSERT INTO `maneja` (`idcompra`, `idenvio`) VALUES
(19, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(57, 1),
(58, 1),
(59, 1),
(80, 1),
(81, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodopago`
--

CREATE TABLE `metodopago` (
  `idpago` int(11) NOT NULL,
  `proveedor` varchar(40) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodopago`
--

INSERT INTO `metodopago` (`idpago`, `proveedor`, `estado`) VALUES
(1, 'Tarjeta de Crédito', 'activo'),
(3, 'PayPal', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `idof` int(11) NOT NULL,
  `sku` int(11) DEFAULT NULL,
  `porcentaje_oferta` decimal(4,2) DEFAULT NULL,
  `preciooferta` decimal(10,2) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`idof`, `sku`, `porcentaje_oferta`, `preciooferta`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 8, 45.00, 16.50, '2024-10-05', '2024-10-10'),
(2, 14, 50.00, 20.00, '2024-10-05', '2024-10-10'),
(3, 16, 99.00, 0.03, '2024-10-10', '2024-11-20'),
(4, 17, 50.00, 200.00, '2024-10-16', '2024-10-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina`
--

CREATE TABLE `pagina` (
  `url` varchar(255) NOT NULL,
  `estado` enum('activo','mantenimiento') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`url`, `estado`) VALUES
('/sigto/index.php?action=login', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenece`
--

CREATE TABLE `pertenece` (
  `sku` int(11) NOT NULL,
  `idcat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pertenece`
--

INSERT INTO `pertenece` (`sku`, `idcat`) VALUES
(8, 6),
(14, 2),
(16, 3),
(17, 2),
(18, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `sku` int(11) NOT NULL,
  `idemp` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` enum('Nuevo','Usado') NOT NULL,
  `origen` enum('Nacional','Internacional') NOT NULL,
  `precio` int(10) NOT NULL DEFAULT 1 CHECK (`precio` > 0),
  `stock` tinyint(3) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `tipo_stock` enum('unidad','cantidad') NOT NULL DEFAULT 'cantidad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`sku`, `idemp`, `nombre`, `descripcion`, `estado`, `origen`, `precio`, `stock`, `imagen`, `visible`, `tipo_stock`) VALUES
(8, 3, 'Zapatos', 'nike', 'Nuevo', 'Nacional', 30, 122, 'nike-revolution-7-nike-revolution-7.jpg', 1, 'cantidad'),
(14, 4, 'Heladera', 'samsung', 'Nuevo', 'Internacional', 40, 25, 'imagen_2024-09-30_155828256.png', 1, 'cantidad'),
(16, 4, 'Harina', 'nose', 'Usado', 'Internacional', 3, 28, 'harina.jpg', 1, 'cantidad'),
(17, 3, 'Lavaropas', 'En buen estado, marca Samsung', 'Nuevo', 'Internacional', 400, 19, '0003412_lavarropas-automatico-eldom-fl6k1000rpm-6k-glz_600.png', 1, 'cantidad'),
(18, 3, 'Heladera', 'En buen funcionamiento', 'Usado', 'Internacional', 400, NULL, 'imagen_2024-09-30_155828256.png', 1, 'unidad'),
(19, 4, 'Laptop', 'Lenovo', 'Usado', 'Nacional', 500, NULL, 'laptop.png', 1, 'unidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_unitario`
--

CREATE TABLE `producto_unitario` (
  `idunid` int(11) NOT NULL,
  `sku` int(11) DEFAULT NULL,
  `codigo_unidad` varchar(50) NOT NULL DEFAULT 'N/A',
  `estado` enum('Disponible','Vendido') DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_unitario`
--

INSERT INTO `producto_unitario` (`idunid`, `sku`, `codigo_unidad`, `estado`) VALUES
(1, 18, '50AKAQM', 'Vendido'),
(2, 18, 'QKDMO54', 'Vendido'),
(4, 18, '45AQED', 'Disponible'),
(5, 19, '50KAQW2', 'Vendido'),
(6, 19, '10QWNAS', 'Vendido'),
(7, 19, '60PGASN', 'Vendido'),
(8, 19, '8EJQ7213', 'Vendido'),
(9, 19, 'QMDAS4H9', 'Vendido'),
(10, 19, '6AHE5NB9', 'Vendido'),
(11, 19, '1SADAK4K', 'Vendido'),
(12, 19, 'QPKLM23K', 'Vendido'),
(13, 19, 'QP12JNCR', 'Disponible'),
(14, 19, '2EK2345N', 'Disponible'),
(15, 19, '19JW3NAP', 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibe`
--

CREATE TABLE `recibe` (
  `idus` int(11) NOT NULL,
  `idenvio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retira`
--

CREATE TABLE `retira` (
  `idus` int(11) NOT NULL,
  `idrecibo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene`
--

CREATE TABLE `tiene` (
  `idus` int(11) NOT NULL,
  `idpago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idemp` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `stock` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idemp`, `fecha`, `stock`) VALUES
(3, 4, '2024-11-06', 2),
(4, 3, '2024-11-06', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idad`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idcarrito`),
  ADD KEY `idus` (`idus`) USING BTREE;

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcat`);

--
-- Indices de la tabla `centrorecibo`
--
ALTER TABLE `centrorecibo`
  ADD PRIMARY KEY (`idrecibo`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- Indices de la tabla `cierra`
--
ALTER TABLE `cierra`
  ADD KEY `idcarrito` (`idcarrito`),
  ADD KEY `idpago` (`idpago`,`idcarrito`) USING BTREE;

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idus`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `idpago` (`idpago`) USING BTREE;

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`sku`,`url`),
  ADD KEY `url` (`url`);

--
-- Indices de la tabla `crea`
--
ALTER TABLE `crea`
  ADD PRIMARY KEY (`sku`,`idcarrito`),
  ADD KEY `idcarrito` (`idcarrito`);

--
-- Indices de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `idcarrito` (`idcarrito`),
  ADD KEY `sku` (`sku`);

--
-- Indices de la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD PRIMARY KEY (`idregistrocompra`),
  ADD KEY `idhistorial` (`idhistorial`),
  ADD KEY `sku` (`sku`),
  ADD KEY `codigo_unidad` (`codigo_unidad`);

--
-- Indices de la tabla `detalle_recibo`
--
ALTER TABLE `detalle_recibo`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`idventa`,`sku`),
  ADD KEY `sku` (`sku`);

--
-- Indices de la tabla `elige`
--
ALTER TABLE `elige`
  ADD PRIMARY KEY (`sku`,`idus`),
  ADD KEY `idus` (`idus`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idemp`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cuentabanco` (`cuentabanco`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`idenvio`);

--
-- Indices de la tabla `especifica`
--
ALTER TABLE `especifica`
  ADD PRIMARY KEY (`idcompra`,`idrecibo`),
  ADD KEY `idrecibo` (`idrecibo`);

--
-- Indices de la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD PRIMARY KEY (`idad`,`url`),
  ADD KEY `url` (`url`);

--
-- Indices de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  ADD PRIMARY KEY (`idhistorial`),
  ADD UNIQUE KEY `idus` (`idus`) USING BTREE;

--
-- Indices de la tabla `historial_login`
--
ALTER TABLE `historial_login`
  ADD PRIMARY KEY (`idlogin`),
  ADD KEY `idus` (`idus`) USING BTREE,
  ADD KEY `url` (`url`) USING BTREE,
  ADD KEY `idemp` (`idemp`) USING BTREE;

--
-- Indices de la tabla `inicia`
--
ALTER TABLE `inicia`
  ADD PRIMARY KEY (`idcompra`,`idpago`),
  ADD KEY `idpago` (`idpago`);

--
-- Indices de la tabla `maneja`
--
ALTER TABLE `maneja`
  ADD PRIMARY KEY (`idcompra`,`idenvio`),
  ADD KEY `idenvio` (`idenvio`);

--
-- Indices de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`idof`),
  ADD KEY `sku` (`sku`);

--
-- Indices de la tabla `pagina`
--
ALTER TABLE `pagina`
  ADD PRIMARY KEY (`url`);

--
-- Indices de la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`sku`,`idcat`),
  ADD KEY `idcat` (`idcat`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`sku`),
  ADD KEY `idemp` (`idemp`) USING BTREE;

--
-- Indices de la tabla `producto_unitario`
--
ALTER TABLE `producto_unitario`
  ADD PRIMARY KEY (`idunid`),
  ADD UNIQUE KEY `codigo_unidad` (`codigo_unidad`),
  ADD KEY `sku` (`sku`);

--
-- Indices de la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD PRIMARY KEY (`idus`,`idenvio`),
  ADD KEY `recibe_ibfk_2` (`idenvio`);

--
-- Indices de la tabla `retira`
--
ALTER TABLE `retira`
  ADD PRIMARY KEY (`idus`,`idrecibo`),
  ADD KEY `retira_ibfk_2` (`idrecibo`);

--
-- Indices de la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD PRIMARY KEY (`idus`,`idpago`),
  ADD KEY `idpago` (`idpago`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `idemp` (`idemp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `idad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idcarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `centrorecibo`
--
ALTER TABLE `centrorecibo`
  MODIFY `idrecibo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  MODIFY `idregistrocompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idemp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `idenvio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `idhistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historial_login`
--
ALTER TABLE `historial_login`
  MODIFY `idlogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `metodopago`
--
ALTER TABLE `metodopago`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `idof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `sku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `producto_unitario`
--
ALTER TABLE `producto_unitario`
  MODIFY `idunid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`);

--
-- Filtros para la tabla `cierra`
--
ALTER TABLE `cierra`
  ADD CONSTRAINT `cierra_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`),
  ADD CONSTRAINT `cierra_ibfk_2` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`);

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`);

--
-- Filtros para la tabla `crea`
--
ALTER TABLE `crea`
  ADD CONSTRAINT `crea_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  ADD CONSTRAINT `crea_ibfk_2` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`);

--
-- Filtros para la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`),
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`);

--
-- Filtros para la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD CONSTRAINT `detalle_envio_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`);

--
-- Filtros para la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD CONSTRAINT `detalle_historial_ibfk_1` FOREIGN KEY (`idhistorial`) REFERENCES `historial_compra` (`idhistorial`),
  ADD CONSTRAINT `detalle_historial_ibfk_2` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  ADD CONSTRAINT `detalle_historial_ibfk_3` FOREIGN KEY (`codigo_unidad`) REFERENCES `producto_unitario` (`codigo_unidad`);

--
-- Filtros para la tabla `detalle_recibo`
--
ALTER TABLE `detalle_recibo`
  ADD CONSTRAINT `detalle_recibo_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`) ON DELETE CASCADE;

--
-- Filtros para la tabla `elige`
--
ALTER TABLE `elige`
  ADD CONSTRAINT `elige_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  ADD CONSTRAINT `elige_ibfk_2` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`);

--
-- Filtros para la tabla `especifica`
--
ALTER TABLE `especifica`
  ADD CONSTRAINT `especifica_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `detalle_recibo` (`idcompra`),
  ADD CONSTRAINT `especifica_ibfk_2` FOREIGN KEY (`idrecibo`) REFERENCES `centrorecibo` (`idrecibo`);

--
-- Filtros para la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD CONSTRAINT `gestiona_ibfk_1` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`);

--
-- Filtros para la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  ADD CONSTRAINT `historial_compra_ibfk_2` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`);

--
-- Filtros para la tabla `historial_login`
--
ALTER TABLE `historial_login`
  ADD CONSTRAINT `historial_login_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  ADD CONSTRAINT `historial_login_ibfk_2` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `historial_login_ibfk_3` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`);

--
-- Filtros para la tabla `inicia`
--
ALTER TABLE `inicia`
  ADD CONSTRAINT `inicia_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`),
  ADD CONSTRAINT `inicia_ibfk_2` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`);

--
-- Filtros para la tabla `maneja`
--
ALTER TABLE `maneja`
  ADD CONSTRAINT `maneja_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `detalle_envio` (`idcompra`),
  ADD CONSTRAINT `maneja_ibfk_2` FOREIGN KEY (`idenvio`) REFERENCES `envio` (`idenvio`);

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`);

--
-- Filtros para la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  ADD CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`idcat`) REFERENCES `categoria` (`idcat`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`);

--
-- Filtros para la tabla `producto_unitario`
--
ALTER TABLE `producto_unitario`
  ADD CONSTRAINT `producto_unitario_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recibe`
--
ALTER TABLE `recibe`
  ADD CONSTRAINT `recibe_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  ADD CONSTRAINT `recibe_ibfk_2` FOREIGN KEY (`idenvio`) REFERENCES `envio` (`idenvio`);

--
-- Filtros para la tabla `retira`
--
ALTER TABLE `retira`
  ADD CONSTRAINT `retira_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  ADD CONSTRAINT `retira_ibfk_2` FOREIGN KEY (`idrecibo`) REFERENCES `centrorecibo` (`idrecibo`);

--
-- Filtros para la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD CONSTRAINT `tiene_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  ADD CONSTRAINT `tiene_ibfk_2` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
