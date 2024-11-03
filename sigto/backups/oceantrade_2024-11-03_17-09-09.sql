-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: oceantrade
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `idad` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) NOT NULL,
  PRIMARY KEY (`idad`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrito` (
  `idcarrito` int(11) NOT NULL AUTO_INCREMENT,
  `idus` int(11) NOT NULL,
  `sku` int(11) NOT NULL,
  `fechacrea` date NOT NULL,
  `fechamod` date NOT NULL CHECK (`fechamod` >= `fechacrea`),
  `total` int(5) NOT NULL CHECK (`total` >= 0),
  `cantidad` tinyint(2) NOT NULL CHECK (`cantidad` >= 0),
  PRIMARY KEY (`idcarrito`),
  UNIQUE KEY `idus` (`idus`),
  UNIQUE KEY `sku` (`sku`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idcat` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idcat`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'vehículos','Productos relacionados con vehículos y transporte'),(2,'electrodomésticos','Aparatos eléctricos para el hogar'),(3,'hogar','Productos para el hogar y decoración'),(4,'oficina','Equipos y suministros para la oficina'),(5,'librería','Artículos de librería y papelería'),(6,'belleza','Productos para el cuidado personal y belleza'),(7,'bebés','Artículos para el cuidado de bebés'),(8,'juguetes','Juguetes y entretenimiento para niños'),(9,'deportes','Equipos y accesorios deportivos'),(10,'música','Instrumentos musicales y accesorios'),(11,'tecnología','Artículos tecnológicos y dispositivos electrónicos'),(12,'celulares','Teléfonos móviles y accesorios'),(13,'herramientas','Herramientas y equipos de construcción');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centrorecibo`
--

DROP TABLE IF EXISTS `centrorecibo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centrorecibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telefono` varchar(18) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefono` (`telefono`),
  CONSTRAINT `centrorecibo_ibfk_1` FOREIGN KEY (`id`) REFERENCES `compra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centrorecibo`
--

LOCK TABLES `centrorecibo` WRITE;
/*!40000 ALTER TABLE `centrorecibo` DISABLE KEYS */;
/*!40000 ALTER TABLE `centrorecibo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cierra`
--

DROP TABLE IF EXISTS `cierra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cierra` (
  `idpago` int(11) NOT NULL,
  `idcarrito` int(11) NOT NULL,
  PRIMARY KEY (`idpago`,`idcarrito`),
  KEY `idcarrito` (`idcarrito`),
  CONSTRAINT `cierra_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`),
  CONSTRAINT `cierra_ibfk_2` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cierra`
--

LOCK TABLES `cierra` WRITE;
/*!40000 ALTER TABLE `cierra` DISABLE KEYS */;
/*!40000 ALTER TABLE `cierra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `idus` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `apellido` varchar(15) NOT NULL,
  `fecnac` date NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` varchar(18) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `activo` enum('sí','no') DEFAULT 'sí',
  PRIMARY KEY (`idus`),
  UNIQUE KEY `telefono` (`telefono`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpago` int(11) NOT NULL,
  `estado` enum('Completado','Pendiente','Cancelado') NOT NULL,
  `direccion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idpago` (`idpago`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contiene`
--

DROP TABLE IF EXISTS `contiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contiene` (
  `sku` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`sku`,`url`),
  KEY `url` (`url`),
  CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contiene`
--

LOCK TABLES `contiene` WRITE;
/*!40000 ALTER TABLE `contiene` DISABLE KEYS */;
/*!40000 ALTER TABLE `contiene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crea`
--

DROP TABLE IF EXISTS `crea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crea` (
  `sku` int(11) NOT NULL,
  `idcarrito` int(11) NOT NULL,
  PRIMARY KEY (`sku`,`idcarrito`),
  KEY `idcarrito` (`idcarrito`),
  CONSTRAINT `crea_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  CONSTRAINT `crea_ibfk_2` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crea`
--

LOCK TABLES `crea` WRITE;
/*!40000 ALTER TABLE `crea` DISABLE KEYS */;
/*!40000 ALTER TABLE `crea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elige`
--

DROP TABLE IF EXISTS `elige`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elige` (
  `sku` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `favorito` enum('Si','No') DEFAULT NULL,
  PRIMARY KEY (`sku`,`idus`),
  KEY `idus` (`idus`),
  CONSTRAINT `elige_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  CONSTRAINT `elige_ibfk_2` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elige`
--

LOCK TABLES `elige` WRITE;
/*!40000 ALTER TABLE `elige` DISABLE KEYS */;
/*!40000 ALTER TABLE `elige` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `idemp` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` int(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `cuentabanco` int(15) NOT NULL,
  `activo` enum('sí','no') DEFAULT 'sí',
  PRIMARY KEY (`idemp`),
  UNIQUE KEY `telefono` (`telefono`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cuentabanco` (`cuentabanco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `envio`
--

DROP TABLE IF EXISTS `envio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `envio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idv` int(11) NOT NULL,
  `fecsa` date NOT NULL,
  `fecen` date NOT NULL CHECK (`fecen` >= `fecsa`),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idv` (`idv`),
  CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`idv`) REFERENCES `vehiculo` (`idv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envio`
--

LOCK TABLES `envio` WRITE;
/*!40000 ALTER TABLE `envio` DISABLE KEYS */;
/*!40000 ALTER TABLE `envio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestiona`
--

DROP TABLE IF EXISTS `gestiona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestiona` (
  `idad` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`idad`,`url`),
  KEY `url` (`url`),
  CONSTRAINT `gestiona_ibfk_1` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestiona`
--

LOCK TABLES `gestiona` WRITE;
/*!40000 ALTER TABLE `gestiona` DISABLE KEYS */;
/*!40000 ALTER TABLE `gestiona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_login`
--

DROP TABLE IF EXISTS `historial_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_login` (
  `idLogin` int(11) NOT NULL AUTO_INCREMENT,
  `idus` int(11) DEFAULT NULL,
  `idemp` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idLogin`),
  KEY `idus` (`idus`),
  KEY `idemp` (`idemp`),
  KEY `url` (`url`),
  CONSTRAINT `historial_login_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  CONSTRAINT `historial_login_ibfk_2` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  CONSTRAINT `historial_login_ibfk_3` FOREIGN KEY (`url`) REFERENCES `pagina` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_login`
--

LOCK TABLES `historial_login` WRITE;
/*!40000 ALTER TABLE `historial_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inicia`
--

DROP TABLE IF EXISTS `inicia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inicia` (
  `id` int(11) NOT NULL,
  `idpago` int(11) NOT NULL,
  PRIMARY KEY (`id`,`idpago`),
  KEY `idpago` (`idpago`),
  CONSTRAINT `inicia_ibfk_1` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`),
  CONSTRAINT `inicia_ibfk_2` FOREIGN KEY (`id`) REFERENCES `compra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inicia`
--

LOCK TABLES `inicia` WRITE;
/*!40000 ALTER TABLE `inicia` DISABLE KEYS */;
/*!40000 ALTER TABLE `inicia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodopago`
--

DROP TABLE IF EXISTS `metodopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metodopago` (
  `idpago` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(40) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL,
  PRIMARY KEY (`idpago`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodopago`
--

LOCK TABLES `metodopago` WRITE;
/*!40000 ALTER TABLE `metodopago` DISABLE KEYS */;
INSERT INTO `metodopago` VALUES (1,'Tarjeta de Crédito','activo'),(2,'Tarjeta de Débito','activo'),(3,'PayPal','activo'),(4,'Mercado Pago','activo'),(5,'Centros de Pago Local','activo');
/*!40000 ALTER TABLE `metodopago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `idof` int(11) NOT NULL,
  `sku` int(11) DEFAULT NULL,
  `porcentaje_oferta` decimal(4,2) DEFAULT NULL,
  `preciooferta` decimal(10,2) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  KEY `sku` (`sku`),
  CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagina`
--

DROP TABLE IF EXISTS `pagina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagina` (
  `url` varchar(255) NOT NULL,
  `estado` enum('activo','mantenimiento') DEFAULT 'activo',
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagina`
--

LOCK TABLES `pagina` WRITE;
/*!40000 ALTER TABLE `pagina` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pertenece`
--

DROP TABLE IF EXISTS `pertenece`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pertenece` (
  `sku` int(11) NOT NULL,
  `idcat` int(11) NOT NULL,
  PRIMARY KEY (`sku`,`idcat`),
  KEY `idcat` (`idcat`),
  CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`),
  CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`idcat`) REFERENCES `categoria` (`idcat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pertenece`
--

LOCK TABLES `pertenece` WRITE;
/*!40000 ALTER TABLE `pertenece` DISABLE KEYS */;
/*!40000 ALTER TABLE `pertenece` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `sku` int(11) NOT NULL AUTO_INCREMENT,
  `idemp` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` enum('Nuevo','Usado') NOT NULL,
  `origen` enum('Nacional','Internacional') NOT NULL,
  `precio` int(10) NOT NULL DEFAULT 1 CHECK (`precio` > 0),
  `stock` tinyint(3) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `tipo_stock` enum('unidad','cantidad') DEFAULT NULL,
  PRIMARY KEY (`sku`),
  KEY `idemp` (`idemp`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_unitario`
--

DROP TABLE IF EXISTS `producto_unitario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_unitario` (
  `idunid` int(11) NOT NULL AUTO_INCREMENT,
  `sku` int(11) DEFAULT NULL,
  `codigo_unidad` varchar(50) DEFAULT NULL,
  `estado` enum('Disponible, Vendido') DEFAULT NULL,
  PRIMARY KEY (`idunid`),
  KEY `sku` (`sku`),
  CONSTRAINT `producto_unitario_ibfk_1` FOREIGN KEY (`sku`) REFERENCES `producto` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_unitario`
--

LOCK TABLES `producto_unitario` WRITE;
/*!40000 ALTER TABLE `producto_unitario` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_unitario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recibe`
--

DROP TABLE IF EXISTS `recibe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recibe` (
  `idus` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idus`,`id`),
  KEY `id` (`id`),
  CONSTRAINT `recibe_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  CONSTRAINT `recibe_ibfk_2` FOREIGN KEY (`id`) REFERENCES `compra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recibe`
--

LOCK TABLES `recibe` WRITE;
/*!40000 ALTER TABLE `recibe` DISABLE KEYS */;
/*!40000 ALTER TABLE `recibe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retira`
--

DROP TABLE IF EXISTS `retira`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retira` (
  `idus` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`idus`,`id`),
  KEY `id` (`id`),
  CONSTRAINT `retira_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  CONSTRAINT `retira_ibfk_2` FOREIGN KEY (`id`) REFERENCES `compra` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retira`
--

LOCK TABLES `retira` WRITE;
/*!40000 ALTER TABLE `retira` DISABLE KEYS */;
/*!40000 ALTER TABLE `retira` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiene`
--

DROP TABLE IF EXISTS `tiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiene` (
  `idus` int(11) NOT NULL,
  `idpago` int(11) NOT NULL,
  PRIMARY KEY (`idus`,`idpago`),
  KEY `idpago` (`idpago`),
  CONSTRAINT `tiene_ibfk_1` FOREIGN KEY (`idus`) REFERENCES `cliente` (`idus`),
  CONSTRAINT `tiene_ibfk_2` FOREIGN KEY (`idpago`) REFERENCES `metodopago` (`idpago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiene`
--

LOCK TABLES `tiene` WRITE;
/*!40000 ALTER TABLE `tiene` DISABLE KEYS */;
/*!40000 ALTER TABLE `tiene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporta`
--

DROP TABLE IF EXISTS `transporta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transporta` (
  `id` int(11) NOT NULL,
  `idv` int(11) NOT NULL,
  PRIMARY KEY (`id`,`idv`),
  KEY `idv` (`idv`),
  CONSTRAINT `transporta_ibfk_1` FOREIGN KEY (`id`) REFERENCES `compra` (`id`),
  CONSTRAINT `transporta_ibfk_2` FOREIGN KEY (`idv`) REFERENCES `vehiculo` (`idv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporta`
--

LOCK TABLES `transporta` WRITE;
/*!40000 ALTER TABLE `transporta` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehiculo` (
  `idv` int(11) NOT NULL AUTO_INCREMENT,
  `capacidad` int(6) NOT NULL CHECK (`capacidad` > 0),
  `modelo` varchar(20) NOT NULL,
  `tipo` enum('electrico','hibrido','termico') NOT NULL,
  `marca` varchar(20) NOT NULL,
  `estado` enum('disponible','mantenimiento','uso') DEFAULT 'disponible',
  `hcarbono` int(6) DEFAULT 0 CHECK (`hcarbono` >= 0),
  PRIMARY KEY (`idv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-03 13:09:10
