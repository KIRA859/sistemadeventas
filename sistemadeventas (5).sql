-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2025 a las 23:20:44
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
(19, 'P-00001', 'Manzana ', 'Verde', 14, 3, 1000, '1250', '2000', '2025-11-11', NULL, 2, 2, '2025-11-11 00:24:15', NULL, 0),
(20, 'P-00002', 'Manzana ', 'Verde', 13, 1, 1000, '1250', '2000', '2025-11-11', NULL, 2, 4, '2025-11-11 00:25:18', NULL, 0),
(21, 'P-00003', 'Manzana ', 'Roja', 12, 1, 1000, '1250', '2000', '2025-11-11', NULL, 2, 2, '2025-11-11 00:26:39', NULL, 0),
(22, 'P-00004', 'Audifonos', 'si', 10, 5, 1000, '3000', '50000', '2025-12-08', NULL, 2, 4, '2025-12-06 20:54:19', NULL, 0),
(23, 'P-00005', 'dasdsaf', 'sfSD', 12, 1, 1000, '12323', '3244534', '2025-12-15', NULL, 2, 4, '2025-12-06 21:18:31', NULL, 0),
(24, 'P-00006', 'Manzana', 'Verde', 20, 1, 1000, '2000', '4000', '2025-12-06', NULL, 2, 2, '2025-12-06 23:34:03', NULL, 0),
(25, 'P-00007', 'Computadora', 'sdasd', 7, 3, 1000, '1250', '3000', '2025-12-23', NULL, 2, 4, '2025-12-08 23:37:30', NULL, 1),
(26, 'P-00008', 'daniel', 'dqwed', 118, 3, 1000, '4500', '10000', '2025-12-15', NULL, 2, 4, '2025-12-09 00:22:09', NULL, 1);

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
(6, 'LIQUIDOS', '2023-01-25 14:44:51', '2025-09-12 02:25:06'),
(12, 'MOTORES', '2025-08-19 00:31:40', NULL),
(36, 'MECATO', '2025-09-15 18:31:56', '2025-09-15 18:31:56');

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
(9999, 'Consumidor Final', '0', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

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
(58, 1, '2025-12-06', 17, 20000.00, 'yr5ert', 2, '2025-12-06 23:58:21', NULL);

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
(32, 58, 24, 10, 2000.00, 20000.00);

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
(50, 52, 26, 2, 10000.00, 20000.00);

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
(47, 25, 'SALIDA', 2, 'Salida por venta #1', '2025-12-12 18:04:07', 2),
(48, 26, 'SALIDA', 2, 'Salida por venta #2', '2025-12-12 18:04:33', 2),
(49, 25, 'SALIDA', 3, 'Salida por venta #3', '2025-12-12 18:17:38', 2),
(50, 26, 'SALIDA', 2, 'Salida por venta #1004', '2025-12-12 21:34:54', 2);

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
(17, 'Juan', '312841170', '3128741178', 'TIENDAS D1', 'daniel@gmail.com', 'La loma', '2025-12-06 22:43:21', NULL);

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
(3, 'VENDEDOR', '2023-01-23 19:11:28', '2023-01-23 20:13:35');

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
(37, 'Juan', 'juan@gmail.com', '$2y$10$xeudJM5tUjAcogW7oOGG8.U.ecOyrSGr0RC4RXVpOmSV.chL8VV7q', '', 1, '0000-00-00 00:00:00', NULL),
(38, 'petro', 'jairo@gmail.com', '$2y$10$CG4U2E2snwh224IiA7S58uUzacDNZsnK1Nv/DOb9Ca0q/y9nvxc1m', '', 1, '0000-00-00 00:00:00', NULL);

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
(49, 1001, 9999, 1, 2, 25000, 2, '2025-01-05 10:15:00', '2025-12-12 19:57:47'),
(50, 1002, 9999, 1, 2, 48000, 2, '2025-01-12 16:40:00', '2025-12-12 19:57:47'),
(51, 1003, 9999, 1, 2, 32000, 2, '2025-01-25 19:10:00', '2025-12-12 19:57:47'),
(52, 1004, 9999, 1, 2, 20000, 2, '2025-12-12 21:34:54', '2025-12-12 21:34:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_diarias`
--

CREATE TABLE `ventas_diarias` (
  `id_venta_diaria` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad_ventas` int(11) NOT NULL DEFAULT 0,
  `total_vendido` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_diarias`
--

INSERT INTO `ventas_diarias` (`id_venta_diaria`, `fecha`, `cantidad_ventas`, `total_vendido`, `created_at`, `updated_at`) VALUES
(2, '2025-12-12', 1, 20000.00, '2025-12-13 02:34:54', '2025-12-13 02:34:54');

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
-- Indices de la tabla `ventas_diarias`
--
ALTER TABLE `ventas_diarias`
  ADD PRIMARY KEY (`id_venta_diaria`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tb_carrito`
--
ALTER TABLE `tb_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_categorias`
--
ALTER TABLE `tb_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT de la tabla `tb_compras`
--
ALTER TABLE `tb_compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_compras`
--
ALTER TABLE `tb_detalle_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `tb_detalle_ventas`
--
ALTER TABLE `tb_detalle_ventas`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `tb_proveedores`
--
ALTER TABLE `tb_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tb_ventas`
--
ALTER TABLE `tb_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `ventas_diarias`
--
ALTER TABLE `ventas_diarias`
  MODIFY `id_venta_diaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
