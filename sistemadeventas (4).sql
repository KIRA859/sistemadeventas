-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2025 a las 07:40:48
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
(1, 'P-00001', 'COCA ESPUMA', 'De 3 litros', 3, 10, 100, '7800', '10500', '2025-08-19', '2025-08-18-10-50-36__Captura de pantalla 2025-07-23 002515.png', 2, 1, '2025-08-18 22:50:36', NULL),
(2, 'P-00002', 'Manzana ', 'Manzana verde, de la familia rosáceas ', 90, 10, 200, '1200', '2000', '2025-08-18', '2025-08-18-11-38-05__manzana-verde-aislada-blanco_2829-9403.avif', 2, 2, '2025-08-18 23:38:05', NULL),
(3, 'P-00003', 'Motor YAZUKI #15', 'Motor a disel ', 5, 1, 10, '17000000', '220000', '2025-08-18', '2025-08-19-12-32-51__D_NQ_NP_797229-MCO44113928986_112020-O.webp', 2, 12, '2025-08-19 00:32:51', '2025-08-21 01:54:31'),
(4, 'P-00004', 'Acetaminofen', 'Acetaminofen por tableta', 10, 5, 20, '759', '1000', '2025-08-18', '2025-08-19-12-33-48__7702057732905.webp', 2, 6, '2025-08-19 00:33:48', NULL),
(5, 'P-00005', 'BAFLE 1500W', 'Bafle de alta potencia', 13, 2, 20, '18000', '25000', '2025-08-18', '2025-08-19-12-37-58__bafle-de-8-1-100-w-pmpo-bluetooth-true-wireless-link-con-bateria-recargable.jpg', 2, 4, '2025-08-19 00:37:58', NULL),
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
(29, 2, 8, 5, '2025-08-24 01:23:45', '0000-00-00 00:00:00');

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
  `id_producto` int(11) NOT NULL,
  `nro_compra` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `comprobante` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio_compra` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_compras`
--

INSERT INTO `tb_compras` (`id_compra`, `id_producto`, `nro_compra`, `fecha_compra`, `id_proveedor`, `comprobante`, `id_usuario`, `precio_compra`, `cantidad`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 3, 1, '2025-08-20', 10, '09', 2, '100000', 5, '2025-08-20 23:52:02', NULL),
(2, 2, 2, '2025-08-23', 11, '03', 2, '200000', 4, '2025-08-24 00:37:03', NULL),
(3, 4, 3, '2025-08-22', 10, '00034', 2, '100000', 10, '2025-08-24 00:59:30', NULL),
(4, 5, 4, '2025-08-24', 12, '000345', 2, '200000', 10, '2025-08-24 01:22:21', NULL);

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
(3, 'Maria Cardenas', 'maria@gmail.com', '$2y$10$Nm9wPFoXQTzSX1JGniBcxufu44zc.xp/aiEJaw0A2Wnjjav/wnVSC', '', 3, '2025-08-23 23:15:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventas`
--

CREATE TABLE `tb_ventas` (
  `id_venta` int(11) NOT NULL,
  `nro_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total_pagado` int(11) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventas`
--

INSERT INTO `tb_ventas` (`id_venta`, `nro_venta`, `id_cliente`, `total_pagado`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(1, 1, 2, 79000, '2025-08-21 01:52:32', '0000-00-00 00:00:00'),
(2, 2, 2, 75000, '2025-08-22 00:51:54', '0000-00-00 00:00:00'),
(3, 3, 3, 5000, '2025-08-22 03:18:47', '0000-00-00 00:00:00'),
(4, 4, 2, 46000, '2025-08-22 19:50:11', '0000-00-00 00:00:00'),
(5, 5, 4, 430500, '2025-08-23 01:37:48', '0000-00-00 00:00:00'),
(6, 6, 4, 420000, '2025-08-23 01:38:34', '0000-00-00 00:00:00'),
(7, 7, 1, 15000, '2025-08-24 01:04:44', '0000-00-00 00:00:00'),
(8, 8, 2, 60000, '2025-08-24 01:24:10', '0000-00-00 00:00:00');

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
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `nro_venta` (`nro_venta`);

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
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `tb_compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tb_almacen` (`id_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_compras_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_compras_ibfk_4` FOREIGN KEY (`id_proveedor`) REFERENCES `tb_proveedores` (`id_proveedor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tb_roles` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  ADD CONSTRAINT `tb_ventas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `tb_clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tb_ventas_ibfk_3` FOREIGN KEY (`nro_venta`) REFERENCES `tb_carrito` (`nro_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
