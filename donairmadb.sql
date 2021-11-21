-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2021 at 12:38 AM
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
-- Database: `donairmadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `idArticulo` int(100) NOT NULL,
  `nombreArticulo` varchar(100) NOT NULL,
  `precioArticulo` float NOT NULL,
  `imagenArticulo` text NOT NULL,
  `fechaanadido` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidadArticulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`idArticulo`, `nombreArticulo`, `precioArticulo`, `imagenArticulo`, `fechaanadido`, `cantidadArticulo`) VALUES
(9, 'Tortillas de Harina (1 Kg)', 22, 'tortillasdeharina.jpg', '2021-11-20 06:21:26', 50),
(10, 'Tortillas de Harina (1/2 Kg)', 12, 'tortillasdeharina.jpg', '2021-11-20 06:21:26', 50),
(11, 'Tortillas de Maíz ( 1 Kg)\r\n', 25, 'tortillasdemaiz.jpg', '2021-11-20 06:23:10', 50),
(12, 'Tortillas de Maíz ( 1/2 Kg)', 13, 'tortillasdemaiz.jpg', '2021-11-20 06:23:10', 50),
(13, 'Tortillas de Harina Integral (1 Kg)\r\n', 28, 'tortillaharinaintegral.jpg', '2021-11-20 06:24:43', 50),
(14, 'Tortillas de Harina Integral (1/2 Kg)', 15, 'tortillaharinaintegral.jpg', '2021-11-20 06:24:43', 50),
(15, 'Tortillas de Nopal (1 Kg)', 30, 'tortillanopal.jpg', '2021-11-20 06:25:35', 50),
(16, 'Tortillas de Nopal (1/2 Kg)', 15, 'tortillanopal.jpg', '2021-11-20 06:25:35', 50),
(17, 'Tortillas de Maíz Integral (1 Kg)\r\n', 28, 'tortillamaizintegral.jpg', '2021-11-20 06:26:52', 50),
(18, 'Tortillas de Maíz Integral (1/2 Kg)', 15, 'tortillamaizintegral.jpg', '2021-11-20 06:26:52', 50),
(19, 'Gorditas (1 Kg)', 22, 'gorditas.jpg', '2021-11-20 06:27:56', 50),
(20, 'Gorditas (1/2 Kg)', 12, 'gorditas.jpg', '2021-11-20 06:27:56', 50);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombreCliente` int(11) NOT NULL,
  `apellidosCliente` int(11) NOT NULL,
  `direccionCliente` int(11) NOT NULL,
  `telefonoCliente` int(11) NOT NULL,
  `correoCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `Folio` int(11) NOT NULL,
  `nombreCliente` text NOT NULL,
  `descripcion` text NOT NULL,
  `importePedido` float NOT NULL,
  `direccionPedido` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`Folio`, `nombreCliente`, `descripcion`, `importePedido`, `direccionPedido`) VALUES
(6, 'Arturo ', 'Tortillas de Maíz ( 1/2 Kg) Cantidad= 2 \\nTortillas de Maíz Integral (1 Kg)\r\n Cantidad= 1 \\n', 54, 'Cera Alta Roja'),
(7, 'Daniel', 'Tortillas de Harina Integral (1 Kg)\r\n || Cantidad= 3 ||Gorditas (1 Kg) || Cantidad= 1 ||', 106, 'Avenida Diamante #104'),
(8, 'Carmen', 'Gorditas (1/2 Kg) || Cantidad= 3 ||', 36, 'Cerradas Aciendas de San Miguel #104'),
(9, 'Arturo', 'Tortillas de Maíz Integral (1 Kg)\r\n || Cantidad= 3 ||', 84, 'Cerradas Aciendas de San Miguel #107');

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombreProveedor` int(11) NOT NULL,
  `direccionProveedor` int(11) NOT NULL,
  `telefonoProveedor` int(11) NOT NULL,
  `correoProveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reporte`
--

CREATE TABLE `reporte` (
  `idReporte` int(11) NOT NULL,
  `fechaReporte` date NOT NULL,
  `idPedido` int(11) NOT NULL,
  `articuloPedido` text NOT NULL,
  `importePedido` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idArticulo`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD UNIQUE KEY `idCliente` (`idCliente`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD UNIQUE KEY `folio` (`Folio`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD UNIQUE KEY `idProveedor` (`idProveedor`);

--
-- Indexes for table `reporte`
--
ALTER TABLE `reporte`
  ADD UNIQUE KEY `idReporte` (`idReporte`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulos`
--
ALTER TABLE `articulos`
  MODIFY `idArticulo` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporte`
--
ALTER TABLE `reporte`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
