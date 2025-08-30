-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-08-2025 a las 07:53:17
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
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_almacen`
--

INSERT INTO `tb_almacen` (`id_producto`, `codigo`, `nombre`, `descripcion`, `stock`, `stock_minimo`, `stock_maximo`, `precio_compra`, `precio_venta`, `fecha_ingreso`, `imagen`, `id_usuario`, `id_categoria`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'P-00001', 'COCA ESPUMA', 'De 3 litros', 6, 10, 100, '7800', '10500', '2025-08-19', '2025-08-18-10-50-36__Captura de pantalla 2025-07-23 002515.png', 2, 1, '2025-08-18 22:50:36', '2025-08-26 20:23:11'),
(2, 'P-00002', 'Manzana ', 'Manzana verde, de la familia rosáceas ', 85, 10, 200, '1200', '2000', '2025-08-18', '2025-08-18-11-38-05__manzana-verde-aislada-blanco_2829-9403.avif', 2, 2, '2025-08-18 23:38:05', '2025-08-26 12:40:15'),
(3, 'P-00003', 'Motor YAZUKI #15', 'Motor a disel ', 5, 1, 10, '17000000', '220000', '2025-08-18', '2025-08-19-12-32-51__D_NQ_NP_797229-MCO44113928986_112020-O.webp', 2, 12, '2025-08-19 00:32:51', '2025-08-21 01:54:31'),
(4, 'P-00004', 'Acetaminofen', 'Acetaminofen por tableta', 10, 5, 20, '759', '1000', '2025-08-18', '2025-08-19-12-33-48__7702057732905.webp', 2, 6, '2025-08-19 00:33:48', NULL),
(5, 'P-00005', 'BAFLE 1500W', 'Bafle de alta potencia', 3, 2, 20, '18000', '25000', '2025-08-18', '2025-08-19-12-37-58__bafle-de-8-1-100-w-pmpo-bluetooth-true-wireless-link-con-bateria-recargable.jpg', 2, 4, '2025-08-19 00:37:58', NULL),
(6, 'P-00006', 'Tomate', 'Tomate cherry', 10, 5, 100, '1230', '2500', '2025-08-24', '2025-08-24-01-16-45__Captura de pantalla 2024-09-25 231109.png', 2, 2, '2025-08-24 01:16:45', NULL);

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
(47, 3, 13, 1, '2025-08-29 00:34:26', '2025-08-29 00:34:26');

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
(3, 'COMIDAS', '2023-01-25 14:40:27', NULL),
(4, 'ELECTRODOMESTICOS', '2023-01-25 14:41:14', NULL),
(5, 'VERDURAS', '2023-01-25 14:43:06', NULL),
(6, 'MEDICAMENTOS Y COMIDAS', '2023-01-25 14:44:51', '2023-01-25 15:09:22'),
(8, 'algo2', '2023-01-25 17:49:21', '2023-01-25 17:54:25'),
(9, 'algo3', '2023-01-25 17:54:06', '2023-01-25 17:57:31'),
(11, 'ELECTRONICOS', '2023-01-29 23:01:42', NULL),
(12, 'MOTORES', '2025-08-19 00:31:40', NULL);

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
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_clientes`
--

INSERT INTO `tb_clientes` (`id_cliente`, `nombre_cliente`, `nit_ci_cliente`, `celular_cliente`, `email_cliente`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 'Julian Salazar', '1045606685', '3128741170', 'salazar@gmail.com', '2025-08-20 08:21:22', '2025-08-20 08:21:22'),
(2, 'Alberto CORDOBA', '122384324', '3123127361', 'alberto@gmail.com', '2025-08-20 08:21:22', '2025-08-20 08:21:22'),
(3, 'Juan', '243534e', '2423423', 'juan@gmail.com', '2025-08-21 01:12:33', '0000-00-00 00:00:00'),
(4, 'Daniel', '1045606685', '3128741170', 'ariasdanielvasquez8599@gmail.com', '2025-08-23 01:37:41', '0000-00-00 00:00:00');

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
(2, 2, '2025-08-23', 11, 8000.00, '03', 2, '2025-08-24 00:37:03', NULL),
(3, 3, '2025-08-22', 10, 10000.00, '00034', 2, '2025-08-24 00:59:30', NULL),
(13, 4, '2025-08-26', 11, 14400.00, '1023', 2, '2025-08-26 01:13:57', NULL),
(14, 5, '2025-08-26', 11, 78000.00, '09', 2, '2025-08-26 01:15:27', NULL),
(15, 6, '2025-08-26', 10, 78000.00, '00034', 2, '2025-08-26 01:20:38', NULL);

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
(5, 13, 2, 12, 1200.00, 14400.00),
(6, 14, 1, 10, 7800.00, 78000.00),
(7, 15, 1, 10, 7800.00, 78000.00);

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
(19, 21, 1, 3, 10500.00, 31500.00);

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
(20, 1, 'SALIDA', 3, 'Salida por venta #12 (Producto: COCA ESPUMA)', '2025-08-26 20:23:11', 2);

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
(11, 'Maria Quispe Montes', '74664754', '28837773', 'COPELMEX', 'maria@gmail.com', 'av. panamerica nro 540', '2023-02-14 16:23:39', NULL),
(12, 'Juan', '3132242', '312312324', 'ColpatriSAS', 'cilpa@gmail.com', '12-211', '2025-08-24 01:20:16', NULL);

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
(1, 'ADMINISTRADOR', '2023-01-23 23:15:19', '2025-08-14 23:48:57'),
(3, 'VENDEDOR', '2023-01-23 19:11:28', '2023-01-23 20:13:35'),
(4, 'CONTADOR', '2023-01-23 21:09:54', NULL),
(5, 'ALMACEN', '2023-01-24 08:28:24', NULL);

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
(3, 'Maria Cardenas', 'maria@gmail.com', '$2y$10$Nm9wPFoXQTzSX1JGniBcxufu44zc.xp/aiEJaw0A2Wnjjav/wnVSC', '', 1, '2025-08-23 23:15:37', '2025-08-30 00:53:45'),
(11, 'petro', 'petro@gmail.com', '$2y$10$WvNWIy09WxCMUVVDUCToMOLHuZoC.VHNlGKJxilJhiOMc9uu73AcS', '', 3, '2025-08-25 00:43:15', '2025-08-30 00:49:00');

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
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventas`
--

INSERT INTO `tb_ventas` (`id_venta`, `nro_venta`, `id_cliente`, `id_forma_pago`, `id_estado`, `total_pagado`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(21, 12, 2, 1, 1, 31500, '2025-08-26 20:23:11', '2025-08-26 20:23:11');

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
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_carrito`
--
ALTER TABLE `tb_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `tb_categorias`
--
ALTER TABLE `tb_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_compras`
--
ALTER TABLE `tb_compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compras`
--
ALTER TABLE `tb_detalle_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ventas`
--
ALTER TABLE `tb_detalle_ventas`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tb_proveedores`
--
ALTER TABLE `tb_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
