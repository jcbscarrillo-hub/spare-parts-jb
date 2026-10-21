-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2026 a las 23:24:01
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
-- Base de datos: `spare_parts_jb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Cascos'),
(2, 'Accesorios'),
(3, 'Repuestos'),
(4, 'Clientes'),
(5, 'Filtros'),
(6, 'Accesorios'),
(7, 'Eléctrico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio`) VALUES
(1, 1, 34, 1, 45000.00),
(2, 2, 35, 1, 85000.00),
(3, 2, 17, 1, 120000.00),
(4, 3, 35, 1, 85000.00),
(5, 3, 17, 1, 120000.00),
(6, 3, 21, 1, 980000.00),
(7, 4, 34, 1, 45000.00),
(8, 4, 16, 1, 38000.00),
(9, 5, 35, 1, 85000.00),
(10, 5, 17, 1, 120000.00),
(11, 6, 35, 1, 85000.00),
(12, 7, 35, 1, 85000.00),
(13, 7, 17, 1, 120000.00),
(14, 8, 16, 1, 38000.00),
(15, 9, 19, 1, 180000.00),
(16, 10, 16, 1, 38000.00),
(17, 11, 16, 1, 38000.00),
(18, 12, 20, 1, 220000.00),
(19, 13, 16, 1, 38000.00),
(20, 14, 16, 1, 38000.00),
(21, 15, 23, 1, 650000.00),
(22, 16, 20, 1, 220000.00),
(23, 17, 17, 1, 120000.00),
(24, 18, 16, 1, 38000.00),
(25, 19, 21, 1, 980000.00),
(26, 20, 20, 1, 220000.00),
(27, 21, 35, 1, 85000.00),
(28, 22, 16, 1, 38000.00),
(29, 23, 18, 1, 35000.00),
(30, 24, 35, 1, 85000.00),
(31, 24, 15, 1, 45000.00),
(32, 25, 34, 1, 45000.00),
(33, 26, 34, 1, 45000.00),
(34, 27, 35, 1, 85000.00),
(35, 28, 20, 1, 220000.00),
(36, 29, 21, 1, 980000.00),
(37, 30, 35, 1, 85000.00),
(38, 30, 17, 1, 120000.00),
(39, 31, 16, 1, 38000.00),
(40, 32, 35, 1, 85000.00),
(41, 33, 15, 1, 45000.00),
(42, 33, 18, 1, 35000.00),
(43, 34, 16, 1, 38000.00),
(44, 35, 17, 1, 120000.00),
(45, 35, 15, 1, 45000.00),
(46, 36, 17, 1, 120000.00),
(47, 37, 17, 1, 120000.00),
(48, 38, 17, 1, 120000.00),
(49, 39, 16, 1, 38000.00),
(50, 39, 19, 1, 180000.00),
(51, 40, 35, 1, 85000.00),
(52, 41, 17, 1, 120000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(1, 4, 45000.00, '2026-09-30 19:09:07'),
(2, 4, 205000.00, '2026-09-30 19:09:59'),
(3, 4, 1185000.00, '2026-09-30 19:12:47'),
(4, 4, 83000.00, '2026-09-30 19:17:32'),
(5, 4, 205000.00, '2026-09-30 19:21:10'),
(6, 4, 85000.00, '2026-09-30 19:21:25'),
(7, 4, 205000.00, '2026-09-30 19:24:08'),
(8, 4, 38000.00, '2026-09-30 19:25:04'),
(9, 4, 180000.00, '2026-09-30 19:25:15'),
(10, 4, 38000.00, '2026-09-30 19:25:48'),
(11, 4, 38000.00, '2026-09-30 19:25:57'),
(12, 4, 220000.00, '2026-09-30 19:28:33'),
(13, 4, 38000.00, '2026-09-30 19:34:37'),
(14, 4, 38000.00, '2026-09-30 19:35:18'),
(15, 4, 650000.00, '2026-09-30 19:38:05'),
(16, 4, 220000.00, '2026-09-30 19:39:36'),
(17, 6, 120000.00, '2026-09-30 19:41:22'),
(18, 4, 38000.00, '2026-09-30 19:47:17'),
(19, 4, 980000.00, '2026-09-30 19:47:33'),
(20, 4, 220000.00, '2026-09-30 19:47:48'),
(21, 4, 85000.00, '2026-09-30 19:48:59'),
(22, 4, 38000.00, '2026-09-30 19:51:22'),
(23, 4, 35000.00, '2026-09-30 19:51:28'),
(24, 4, 130000.00, '2026-09-30 19:51:47'),
(25, 4, 45000.00, '2026-09-30 19:52:48'),
(26, 4, 45000.00, '2026-09-30 19:53:02'),
(27, 4, 85000.00, '2026-09-30 19:54:14'),
(28, 4, 220000.00, '2026-09-30 19:57:34'),
(29, 4, 980000.00, '2026-09-30 20:00:19'),
(30, 4, 205000.00, '2026-09-30 20:00:52'),
(31, 4, 38000.00, '2026-09-30 20:03:39'),
(32, 4, 85000.00, '2026-09-30 20:04:57'),
(33, 5, 80000.00, '2026-10-16 19:50:03'),
(34, 5, 38000.00, '2026-10-21 19:33:55'),
(35, 5, 165000.00, '2026-10-21 19:34:02'),
(36, 9, 120000.00, '2026-10-21 19:39:16'),
(37, 5, 120000.00, '2026-10-21 19:57:22'),
(38, 5, 120000.00, '2026-10-21 19:57:45'),
(39, 5, 218000.00, '2026-10-21 19:58:16'),
(40, 5, 85000.00, '2026-10-21 20:08:57'),
(41, 5, 120000.00, '2026-10-21 20:52:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT 'default.jpg',
  `id_categoria` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `id_categoria`, `id_proveedor`) VALUES
(15, 'Pastillas de Freno Delanteras', 'Yamaha FZ 250', 45000.00, 15, 'pastillas-freno.jpg', 3, NULL),
(16, 'Aceite 10W-40 4T Semi-Sintético', 'Universal', 38000.00, 30, 'aceite-10w40.jpg', 3, NULL),
(17, 'Kit de Arrastre Racing', 'KTM Duke 200', 120000.00, 10, 'kit-arrastre.jpg', 3, NULL),
(18, 'Bujía Iridium Power', 'Universal', 35000.00, 25, 'bujia-iridium.jpg', 3, NULL),
(19, 'Llanta Pista Sport', 'Universal', 180000.00, 8, 'llanta.jpg', 3, NULL),
(20, 'Casco Integral', 'Universal - Certificación DOT/ECE', 220000.00, 12, 'casco.jpg', 1, NULL),
(21, 'Casco AGV K1 S Black', 'Casco deportivo con diseño aerodinámico derivado de MotoGP y visor antirrayones.', 980000.00, 8, 'casco_agv_k1.jpg', 1, NULL),
(22, 'Casco Shoei RF-1400 Solid', 'Casco gama alta con certificación Snell, máxima reducción de ruido y gran ventilación.', 2400000.00, 4, 'casco_shoei_rf1400.jpg', 1, NULL),
(23, 'Casco Shark Ridill 2', 'Casco integral de alta seguridad con gafas de sol internas desplegables.', 650000.00, 10, 'casco_shark_ridill.jpg', 1, NULL),
(24, 'Casco Bell Qualifier DLX', 'Casco resistente de policarbonato con visor fotocromático Transitions incluido.', 720000.00, 7, 'casco_bell_qualifier.jpg', 1, NULL),
(25, 'Casco MT Helmets Stinger 2', 'Casco accesible de excelente calidad con certificación europea ECE 22.06.', 320000.00, 15, 'casco_mt_stinger.jpg', 1, NULL),
(26, 'Casco Scorpion EXO-491', 'Casco con interior hipoalergénico KwikWick y pantalla solar regulable.', 580000.00, 6, 'casco_scorpion_exo.jpg', 1, NULL),
(27, 'Casco Nolan N80-8', 'Casco integral touring fabricado en policarbonato Lexan con Pinlock incluido.', 890000.00, 5, 'casco_nolan_n80.jpg', 1, NULL),
(34, 'Guantes Impermeables para Moto', 'Guantes térmicos e impermeables para protección en carretera', 45000.00, 15, 'guantes.jpg', 2, NULL),
(35, 'Impermeable para Motociclista', 'Traje impermeable de dos piezas con bandas reflectivas', 85000.00, 10, 'impermeable.jpg', 2, NULL),
(36, 'Intercomunicador Casco Bluetooth', 'Manos libres y radio para cascos de moto con cancelación de ruido', 180000.00, 8, 'intercomunicador.jpg', 2, NULL),
(37, 'Maletero Baúl Trasero 32L', 'Maleta trasera con base y kit de tornillería incluido', 120000.00, 5, 'maletero.jpg', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `telefono`, `direccion`, `id_rol`) VALUES
(4, 'perez\r\n\r\n', 'Brayan@gmail.com', '$2y$10$ZGwTOlpRkH/9eTBaNShsj.iuJ89IUnrIDDF4onV9OJUnC/.RUnCCy', '15485745184', '', 1),
(5, 'jacobs\r\n', 'jcbscarrillo@gmail.com', '$2y$10$MvT/tKFVk7uba8wLHJUa8.LcbQXbN0qhkyRo5KWXDDK2cX8/qYxme', '455641894', '', 1),
(9, 'Enano Baez', 'Enano@gmail.com', '$2y$10$1ni6au2uEfDGOf5w8I.8ZeZJeXoYJ5GAIaWloI4GX9YT1atM.YUpa', '45815841', '', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
