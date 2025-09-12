-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2025 a las 05:16:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemadeventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen`
--

CREATE TABLE `tb_almacen` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `stock_maximo` int(11) DEFAULT NULL,
  `precio_compra` varchar(255) NOT NULL,
  `precio_venta` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `imagen` text DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_almacen`
--

INSERT INTO `tb_almacen` (`id_producto`, `codigo`, `nombre`, `descripcion`, `stock`, `stock_minimo`, `stock_maximo`, `precio_compra`, `precio_venta`, `fecha_ingreso`, `imagen`, `id_usuario`, `id_categoria`, `fyh_creacion`, `fyh_actualizacion`, `activo`) VALUES
(1, 'P-00001', 'COCA ESPUMA', 'De 3 litros y mas ', 26, 10, 100, '7800', '10500', '2025-08-19', '2025-08-18-10-50-36__Captura de pantalla 2025-07-23 002515.png', 2, 1, '2025-08-18 22:50:36', '2025-09-03 22:21:39', 1),
(2, 'P-00002', 'Manzana ', 'Manzana verde, de la familia rosáceas ', 97, 10, 200, '1200', '2000', '2025-08-18', '2025-08-18-11-38-05__manzana-verde-aislada-blanco_2829-9403.avif', 2, 2, '2025-08-18 23:38:05', '2025-08-26 12:40:15', 0),
(3, 'P-00003', 'Motor YAZUKI #15', 'Motor a disel ', 10, 1, 10, '17000000', '220000', '2025-08-18', '2025-08-19-12-32-51__D_NQ_NP_797229-MCO44113928986_112020-O.webp', 2, 12, '2025-08-19 00:32:51', '2025-09-03 21:21:18', 1),
(4, 'P-00004', 'Acetaminofen', 'Acetaminofen por tableta', 10, 5, 20, '759', '1000', '2025-08-18', '2025-08-19-12-33-48__7702057732905.webp', 2, 6, '2025-08-19 00:33:48', '2025-09-03 21:21:18', 0),
(5, 'P-00005', 'BAFLE 1500W', 'Bafle de alta potencia', 3, 2, 20, '18000', '25000', '2025-08-18', '2025-08-19-12-37-58__bafle-de-8-1-100-w-pmpo-bluetooth-true-wireless-link-con-bateria-recargable.jpg', 2, 4, '2025-08-19 00:37:58', NULL, 0),
(8, 'P-00006', 'SPRITE', 'Sprite, si te la tomas sin eructar, te regalamos otra GRATIS.', 100, 10, 200, '1250', '2500', '2025-09-03', '2025-09-03-09-50-21__360_F_286268644_FJxZ9RW8bXWWiaZgKajwnwEZ61ynkfOp.jpg', 2, 1, '2025-09-03 21:50:21', NULL, 0),
(9, 'P-00007', 'PERA', 'PERA ', 11, 5, 100, '1000', '2000', '2025-09-03', '2025-09-03-09-51-18__pera.jpg', 2, 2, '2025-09-03 21:51:18', NULL, 0),
(10, 'P-00008', 'SPRITE', 'Te la comes ', 100, 10, 200, '1250', '2000', '2025-09-03', '2025-09-03-09-57-45__360_F_286268644_FJxZ9RW8bXWWiaZgKajwnwEZ61ynkfOp.jpg', 2, 1, '2025-09-03 21:57:45', NULL, 0),
(11, 'P-00009', 'pera', 'pera', 12, 5, 100, '1250', '2000', '2025-09-03', '2025-09-03-09-58-10__pera.jpg', 2, 2, '2025-09-03 21:58:10', NULL, 0),
(12, 'P-00010', 'Audifonos', 'de 60 watsssssss', 78, 10, 1000, '60000', '100000', '2025-09-03', '68c26cdda7244.jpeg', 2, 4, '2025-09-03 23:46:20', '2025-09-11 01:31:57', 1),
(15, 'P-00013', 'Café Premium 500g', 'Café colombiano de alta calidad, molido, presentación de 500 gramos.', 22, 5, 100, '12000', '18000', '2025-09-08', '68c26cd35fa4b.jpeg', 2, 4, '2025-09-08 23:38:42', '2025-09-11 01:31:47', 1),
(16, 'P-00014', 'BAFLE 1500W', '1500 WASTTTT', 10, 5, 1000, '50000', '100000', '2025-09-11', '68c38ec8b0c7c.jpeg', 2, 4, '2025-09-11 22:08:41', '2025-09-11 22:08:56', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_carrito`
--

CREATE TABLE `tb_carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nro_venta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_carrito`
--

INSERT INTO `tb_carrito` (`id_carrito`, `id_producto`, `nro_venta`, `cantidad`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(10, 2, 1, 2, '2025-08-20 01:49:31', '0000-00-00 00:00:00'),
(11, 5, 1, 3, '2025-08-20 01:49:36', '0000-00-00 00:00:00'),
(16, 2, 2, 2, '2025-08-21 02:39:09', '0000-00-00 00:00:00'),
(17, 1, 2, 2, '2025-08-21 02:39:16', '0000-00-00 00:00:00'),
(18, 5, 2, 2, '2025-08-21 22:35:22', '0000-00-00 00:00:00'),
(20, 4, 3, 5, '2025-08-22 03:18:36', '0000-00-00 00:00:00'),
(21, 1, 4, 2, '2025-08-22 19:48:38', '0000-00-00 00:00:00'),
(22, 5, 4, 1, '2025-08-22 19:49:50', '0000-00-00 00:00:00'),
(23, 1, 5, 1, '2025-08-22 22:27:19', '0000-00-00 00:00:00'),
(24, 1, 5, 40, '2025-08-23 01:37:06', '0000-00-00 00:00:00'),
(25, 1, 6, 40, '2025-08-23 01:38:28', '0000-00-00 00:00:00'),
(26, 4, 7, 5, '2025-08-24 01:04:07', '0000-00-00 00:00:00'),
(27, 2, 7, 5, '2025-08-24 01:04:16', '0000-00-00 00:00:00'),
(28, 5, 8, 2, '2025-08-24 01:23:32', '0000-00-00 00:00:00'),
(29, 2, 8, 5, '2025-08-24 01:23:45', '0000-00-00 00:00:00'),
(30, 2, 9, 1, '2025-08-25 20:21:18', '0000-00-00 00:00:00'),
(31, 2, 9, 2, '2025-08-25 20:32:44', '0000-00-00 00:00:00'),
(49, 3, 14, 1, '2025-09-09 01:04:30', '2025-09-09 01:04:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categorias`
--

CREATE TABLE `tb_categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_categorias`
--

INSERT INTO `tb_categorias` (`id_categoria`, `nombre_categoria`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'LIQUIDOS', '2023-01-24 22:25:10', '2023-01-24 22:25:10'),
(2, 'FRUTAS', '2023-01-25 14:39:50', '2023-01-25 15:09:07'),
(4, 'ELECTRODOMESTICOS', '2023-01-25 14:41:14', NULL),
(6, 'MEDICAMENTOS Y COMIDAS', '2023-01-25 14:44:51', '2023-01-25 15:09:22'),
(11, 'ELECTRONICOS', '2023-01-29 23:01:42', NULL),
(12, 'MOTORES', '2025-08-19 00:31:40', NULL),
(26, 'Hola mundo=Hello world', '2025-09-11 21:43:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_clientes`
--

CREATE TABLE `tb_clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `nit_ci_cliente` varchar(255) NOT NULL,
  `celular_cliente` varchar(50) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_clientes`
--

INSERT INTO `tb_clientes` (`id_cliente`, `nombre_cliente`, `nit_ci_cliente`, `celular_cliente`, `email_cliente`, `fyh_creacion`, `fyh_actualizacion`, `direccion`) VALUES
(1, 'Julian Salazar', '1045606685', '3128741170', 'salazar@gmail.com', '2025-08-20 08:21:22', '2025-08-20 08:21:22', NULL),
(2, 'Alberto CORDOBA', '122384324', '3123127361', 'alberto@gmail.com', '2025-08-20 08:21:22', '2025-08-20 08:21:22', NULL),
(4, 'Daniel', '1045606685', '3128741170', 'ariasdanielvasquez8599@gmail.com', '2025-08-23 01:37:41', '0000-00-00 00:00:00', NULL),
(9999, 'Consumidor Final', '0', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10000, 'Alberto', '2423432', '4321423', 'alberto@gmail.com', '2025-09-10 02:09:22', '2025-09-10 02:09:22', 'El huevo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compras`
--

CREATE TABLE `tb_compras` (
  `id_compra` int(11) NOT NULL,
  `nro_compra` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `total_compra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `comprobante` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_compras`
--

INSERT INTO `tb_compras` (`id_compra`, `nro_compra`, `fecha_compra`, `id_proveedor`, `total_compra`, `comprobante`, `id_usuario`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(2, 2, '2025-08-23', 12, 8000.00, '03', 2, '2025-08-24 00:37:03', NULL),
(3, 3, '2025-08-22', 10, 10000.00, '00034', 2, '2025-08-24 00:59:30', NULL),
(14, 5, '2025-08-26', 11, 600000.00, '09', 2, '2025-08-26 01:15:27', NULL),
(15, 6, '2025-08-26', 10, 78000.00, '00034', 2, '2025-08-26 01:20:38', NULL),
(24, 7, '2025-09-04', 11, 8000.00, 'Factura', 2, '0000-00-00 00:00:00', NULL),
(25, 8, '2025-09-04', 11, 8000.00, 'Factura', 2, '0000-00-00 00:00:00', NULL),
(26, 9, '2025-09-04', 11, 8000.00, 'Factura', 2, '0000-00-00 00:00:00', NULL),
(28, 10, '2025-09-04', 11, 8000.00, 'Factura', 2, '0000-00-00 00:00:00', NULL),
(29, 11, '2025-09-04', 11, 8000.00, 'Factura', 2, '0000-00-00 00:00:00', NULL),
(30, 12, '2025-09-05', 12, 1759.00, '', 2, '0000-00-00 00:00:00', NULL),
(43, 14, '2025-09-08', 10, 1700000.00, '53423', 2, '0000-00-00 00:00:00', NULL),
(45, 15, '2025-09-11', 10, 1700000.00, '123453', 2, '0000-00-00 00:00:00', NULL),
(52, 16, '2025-09-11', 10, 12000.00, '234234', 2, '2025-09-11 02:59:54', NULL),
(53, 17, '2025-09-11', 12, 78000.00, '333333', 2, '2025-09-11 03:09:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_compras`
--

CREATE TABLE `tb_detalle_compras` (
  `id_detalle_compra` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_detalle_compras`
--

INSERT INTO `tb_detalle_compras` (`id_detalle_compra`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(2, 2, 2, 4, 2000.00, 8000.00),
(3, 3, 4, 10, 1000.00, 10000.00),
(12, 15, 1, 10, 7800.00, 78000.00),
(14, 14, 12, 10, 60000.00, 600000.00),
(19, 43, 3, 10, 170000.00, 1700000.00),
(22, 52, 15, 1, 12000.00, 12000.00),
(23, 45, 3, 10, 170000.00, 1700000.00),
(25, 53, 1, 10, 7800.00, 78000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalle_ventas`
--

CREATE TABLE `tb_detalle_ventas` (
  `id_detalle_venta` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_detalle_ventas`
--

INSERT INTO `tb_detalle_ventas` (`id_detalle_venta`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(19, 21, 1, 3, 10500.00, 31500.00),
(20, 22, 3, 2, 220000.00, 440000.00),
(21, 22, 4, 1, 1000.00, 1000.00),
(22, 23, 15, 1, 18000.00, 18000.00),
(23, 25, 3, 3, 220000.00, 660000.00),
(24, 26, 12, 10, 100000.00, 1000000.00),
(25, 27, 15, 1, 18000.00, 18000.00),
(26, 28, 12, 1, 100000.00, 100000.00),
(27, 29, 12, 10, 100000.00, 1000000.00),
(28, 30, 15, 1, 18000.00, 18000.00),
(29, 31, 15, 1, 18000.00, 18000.00),
(30, 32, 15, 1, 18000.00, 18000.00),
(36, 38, 12, 1, 100000.00, 100000.00),
(37, 39, 12, 1, 100000.00, 100000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estados_venta`
--

CREATE TABLE `tb_estados_venta` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `fyh_creacion` datetime DEFAULT current_timestamp(),
  `fyh_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_estados_venta`
--

INSERT INTO `tb_estados_venta` (`id_estado`, `nombre_estado`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'Pendiente', '2025-08-26 01:03:07', '2025-08-26 01:03:07'),
(2, 'Pagado', '2025-08-26 01:03:07', '2025-08-26 01:03:07'),
(3, 'Anulado', '2025-08-26 01:03:07', '2025-08-26 01:03:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_formas_pago`
--

CREATE TABLE `tb_formas_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `nombre_forma_pago` varchar(50) NOT NULL,
  `fyh_creacion` datetime DEFAULT current_timestamp(),
  `fyh_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_formas_pago`
--

INSERT INTO `tb_formas_pago` (`id_forma_pago`, `nombre_forma_pago`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'Efectivo', '2025-08-26 01:03:06', '2025-08-26 01:03:06'),
(2, 'Tarjeta', '2025-08-26 01:03:06', '2025-08-26 01:03:06'),
(3, 'Transferencia', '2025-08-26 01:03:06', '2025-08-26 01:03:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_movimientos_inventario`
--

CREATE TABLE `tb_movimientos_inventario` (
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `tipo_movimiento` enum('ENTRADA','SALIDA','AJUSTE') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_movimiento` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_movimientos_inventario`
--

INSERT INTO `tb_movimientos_inventario` (`id_movimiento`, `id_producto`, `tipo_movimiento`, `cantidad`, `descripcion`, `fecha_movimiento`, `id_usuario`) VALUES
(1, 3, 'ENTRADA', 5, 'Compra de Motor YAZUKI #15 (compra #1)', '2025-08-20 23:52:02', 2),
(2, 2, 'ENTRADA', 4, 'Compra de Manzana (compra #2)', '2025-08-24 00:37:03', 2),
(3, 4, 'ENTRADA', 10, 'Compra de Acetaminofen (compra #3)', '2025-08-24 00:59:30', 2),
(4, 5, 'ENTRADA', 10, 'Compra de BAFLE 1500W (compra #4)', '2025-08-24 01:22:21', 2),
(5, 3, 'SALIDA', 1, 'Venta de Motor YAZUKI #15 (venta #10)', '2025-08-25 20:41:01', 2),
(6, 2, 'SALIDA', 2, 'Venta de Manzana (venta #11)', '2025-08-25 20:48:01', 2),
(7, 1, 'ENTRADA', 10, 'Entrada por compra #6 (Producto: COCA ESPUMA)', '2025-08-26 01:20:38', 2),
(14, 1, 'SALIDA', 1, 'Salida por venta #14 (Producto: COCA ESPUMA)', '2025-08-26 03:45:19', 2),
(15, 1, 'SALIDA', 1, 'Salida por venta #15 (Producto: COCA ESPUMA)', '2025-08-26 03:46:22', 2),
(16, 2, 'SALIDA', 2, 'Salida por venta #11 (Producto: Manzana )', '2025-08-26 04:13:30', 2),
(17, 2, 'SALIDA', 12, 'Salida por venta #12 (Producto: Manzana )', '2025-08-26 04:30:33', 2),
(18, 2, 'SALIDA', 3, 'Salida por venta #11 (Producto: Manzana )', '2025-08-26 12:40:15', 2),
(19, 1, 'SALIDA', 1, 'Salida por venta #11 (Producto: COCA ESPUMA)', '2025-08-26 12:40:15', 2),
(20, 1, 'SALIDA', 3, 'Salida por venta #12 (Producto: COCA ESPUMA)', '2025-08-26 20:23:11', 2),
(21, 3, 'SALIDA', 2, 'Salida por venta #13 (Producto: Motor YAZUKI #15)', '2025-09-03 21:21:18', 2),
(22, 4, 'SALIDA', 1, 'Salida por venta #13 (Producto: Acetaminofen)', '2025-09-03 21:21:18', 2),
(24, 2, 'ENTRADA', 4, 'Compra N° ', '2025-09-04 23:47:05', 2),
(25, 2, 'ENTRADA', 4, 'Compra N° 7', '2025-09-04 23:56:52', 2),
(26, 2, 'ENTRADA', 4, 'Compra de  (compra #8)', '2025-09-05 00:17:48', 2),
(27, 2, 'ENTRADA', 4, 'Compra de  (compra #9)', '2025-09-05 00:18:21', 2),
(28, 2, 'ENTRADA', 4, 'Compra de  (compra #10)', '2025-09-05 00:26:47', 2),
(29, 2, 'ENTRADA', 4, 'Compra de Manzana  (compra #11)', '2025-09-05 00:27:49', 2),
(30, 4, 'ENTRADA', 1, 'Compra de Acetaminofen (compra #12)', '2025-09-05 01:13:41', 2),
(31, 9, 'ENTRADA', 1, 'Compra de PERA (compra #12)', '2025-09-05 01:13:41', 2),
(32, 12, 'SALIDA', 10, 'Venta ID 29 (Nro: 19)', '2025-09-10 01:38:54', 2),
(33, 15, 'SALIDA', 1, NULL, '2025-09-10 01:41:52', 2),
(34, 15, 'SALIDA', 1, NULL, '2025-09-10 01:41:58', 2),
(35, 15, 'SALIDA', 1, 'Salida por venta #22', '2025-09-10 01:42:28', 2),
(36, 12, 'SALIDA', 1, 'Salida por venta #23', '2025-09-11 01:25:36', 11),
(37, 12, 'SALIDA', 1, 'Salida por venta #24', '2025-09-11 01:29:02', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_proveedores`
--

CREATE TABLE `tb_proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `empresa` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_proveedores`
--

INSERT INTO `tb_proveedores` (`id_proveedor`, `nombre_proveedor`, `celular`, `telefono`, `empresa`, `email`, `direccion`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(10, 'Jose Quente', '75657007', '27736632', 'CASCADA', 'daniel@gmail.com', 'Av. del Maestro S/N', '2023-02-12 18:27:10', '2025-08-20 23:50:34'),
(11, 'Maria Quispe Montes', '74664754', '28837773', 'COPELMEXX', 'maria@gmail.com', 'av. panamerica nro 540', '2023-02-14 16:23:39', '2025-09-09 00:30:07'),
(12, 'Juan', '3132242', '312312324', 'ColpatriSAS', 'cilpa@gmail.com', '12-211', '2025-08-24 01:20:16', '2025-09-09 00:29:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_roles`
--

CREATE TABLE `tb_roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(255) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_roles`
--

INSERT INTO `tb_roles` (`id_rol`, `rol`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'ADMINISTRADOR', '2023-01-23 23:15:19', '2025-09-02 22:09:19'),
(3, 'VENDEDOR', '2023-01-23 19:11:28', '2023-01-23 20:13:35'),
(5, 'ALMACEN', '2023-01-24 08:28:24', NULL),
(8, 'VENDEDOR', '2025-09-02 20:34:47', NULL),
(9, 'CONTADOR', '2025-09-11 21:23:19', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_user` text NOT NULL,
  `token` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`id_usuario`, `nombres`, `email`, `password_user`, `token`, `id_rol`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(2, 'Daniel', 'daniel@gmail.com', '$2y$10$jy5p.R97n35F3nnOBmb4tOjVmhvgm4f9wDSrgry.ftIuzClU9xqqO', '', 1, '2025-08-14 23:28:42', NULL),
(11, 'petro', 'petro@gmail.com', '$2y$10$WvNWIy09WxCMUVVDUCToMOLHuZoC.VHNlGKJxilJhiOMc9uu73AcS', '', 3, '2025-08-25 00:43:15', '2025-08-30 00:49:00'),
(33, 'Jose Arias', 'jose@gmail.com', '$2y$10$3hLppsHdCFrxxvGMAVciuO2M.I4s.HzZG0a2EW4VeOPmgK6zBs7hS', '', 5, '0000-00-00 00:00:00', '2025-09-11 21:21:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventas`
--

CREATE TABLE `tb_ventas` (
  `id_venta` int(11) NOT NULL,
  `nro_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_forma_pago` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `total_pagado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventas`
--

INSERT INTO `tb_ventas` (`id_venta`, `nro_venta`, `id_cliente`, `id_forma_pago`, `id_estado`, `total_pagado`, `id_usuario`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(21, 12, 2, 1, 1, 31500, 0, '2025-08-26 20:23:11', '2025-08-26 20:23:11'),
(22, 13, 1, 1, 1, 441000, 0, '2025-09-03 21:21:18', '2025-09-03 21:21:18'),
(23, 14, 1, 1, 2, 21420, 0, '2025-09-09 23:22:28', '2025-09-09 23:22:28'),
(25, 15, 1, 1, 2, 660000, 0, '2025-09-09 23:34:09', '2025-09-09 23:34:09'),
(26, 16, 9999, 1, 2, 1000000, 0, '2025-09-09 23:37:51', '2025-09-09 23:37:51'),
(27, 17, 9999, NULL, 2, 18000, 0, '2025-09-10 00:47:40', '2025-09-10 00:47:40'),
(28, 18, 2, NULL, 2, 100000, 0, '2025-09-10 01:24:24', '2025-09-10 01:24:24'),
(29, 19, 9999, 1, 2, 1000000, 0, '2025-09-10 01:38:54', '2025-09-10 01:38:54'),
(30, 20, 9999, NULL, 2, 18000, 0, '2025-09-10 01:41:52', '2025-09-10 01:41:52'),
(31, 21, 9999, 1, 2, 18000, 0, '2025-09-10 01:41:58', '2025-09-10 01:41:58'),
(32, 22, 9999, 1, 2, 18000, 0, '2025-09-10 01:42:28', '2025-09-10 01:42:28'),
(38, 23, 9999, 1, 2, 100000, 11, '2025-09-11 01:25:36', '2025-09-11 01:25:36'),
(39, 24, 9999, 1, 2, 100000, 2, '2025-09-11 01:29:02', '2025-09-11 01:29:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `tb_carrito`
--
ALTER TABLE `tb_carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `nro_venta` (`nro_venta`);

--
-- Indices de la tabla `tb_categorias`
--
ALTER TABLE `tb_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `tb_compras`
--
ALTER TABLE `tb_compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD UNIQUE KEY `nro_compra` (`nro_compra`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tb_detalle_compras`
--
ALTER TABLE `tb_detalle_compras`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `fk_detallecompra_compra` (`id_compra`),
  ADD KEY `fk_detallecompra_producto` (`id_producto`);

--
-- Indices de la tabla `tb_detalle_ventas`
--
ALTER TABLE `tb_detalle_ventas`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD UNIQUE KEY `idx_venta_producto` (`id_venta`,`id_producto`),
  ADD KEY `fk_detalleventa_venta` (`id_venta`),
  ADD KEY `fk_detalleventa_producto` (`id_producto`);

--
-- Indices de la tabla `tb_estados_venta`
--
ALTER TABLE `tb_estados_venta`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`),
  ADD UNIQUE KEY `nombre_estado_2` (`nombre_estado`);

--
-- Indices de la tabla `tb_formas_pago`
--
ALTER TABLE `tb_formas_pago`
  ADD PRIMARY KEY (`id_forma_pago`),
  ADD UNIQUE KEY `nombre_forma_pago` (`nombre_forma_pago`),
  ADD UNIQUE KEY `nombre_forma_pago_2` (`nombre_forma_pago`);

--
-- Indices de la tabla `tb_movimientos_inventario`
--
ALTER TABLE `tb_movimientos_inventario`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `fk_movproducto` (`id_producto`),
  ADD KEY `fk_movusuario` (`id_usuario`);

--
-- Indices de la tabla `tb_proveedores`
--
ALTER TABLE `tb_proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `nro_venta` (`nro_venta`),
  ADD KEY `fk_venta_forma` (`id_forma_pago`),
  ADD KEY `fk_venta_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tb_carrito`
--
ALTER TABLE `tb_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tb_categorias`
--
ALTER TABLE `tb_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10001;

--
-- AUTO_INCREMENT de la tabla `tb_compras`
--
ALTER TABLE `tb_compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compras`
--
ALTER TABLE `tb_detalle_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ventas`
--
ALTER TABLE `tb_detalle_ventas`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tb_estados_venta`
--
ALTER TABLE `tb_estados_venta`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_formas_pago`
--
ALTER TABLE `tb_formas_pago`
  MODIFY `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_movimientos_inventario`
--
ALTER TABLE `tb_movimientos_inventario`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tb_proveedores`
--
ALTER TABLE `tb_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD CONSTRAINT `tb_almacen_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `tb_categorias` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_almacen_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_carrito`
--
ALTER TABLE `tb_carrito`
  ADD CONSTRAINT `tb_carrito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tb_almacen` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tb_compras`
--
ALTER TABLE `tb_compras`
  ADD CONSTRAINT `tb_compras_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_compras_ibfk_4` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedores` (`id_proveedor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_detalle_compras`
--
ALTER TABLE `tb_detalle_compras`
  ADD CONSTRAINT `fk_detallecompra_compra` FOREIGN KEY (`id_compra`) REFERENCES `tb_compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallecompra_producto` FOREIGN KEY (`id_producto`) REFERENCES `tb_almacen` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_detalle_ventas`
--
ALTER TABLE `tb_detalle_ventas`
  ADD CONSTRAINT `fk_detalleventa_producto` FOREIGN KEY (`id_producto`) REFERENCES `tb_almacen` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalleventa_venta` FOREIGN KEY (`id_venta`) REFERENCES `tb_ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_movimientos_inventario`
--
ALTER TABLE `tb_movimientos_inventario`
  ADD CONSTRAINT `fk_movproducto` FOREIGN KEY (`id_producto`) REFERENCES `tb_almacen` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movusuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tb_roles` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  ADD CONSTRAINT `fk_venta_estado` FOREIGN KEY (`id_estado`) REFERENCES `tb_estados_venta` (`id_estado`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_venta_forma` FOREIGN KEY (`id_forma_pago`) REFERENCES `tb_formas_pago` (`id_forma_pago`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_ventas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
