-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-09-2026 a las 21:31:03
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
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT 'default.jpg',
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `id_categoria`) VALUES
(15, 'Pastillas de Freno Delanteras', 'Yamaha FZ 250', 45000.00, 15, 'pastillas-freno.jpg', 3),
(16, 'Aceite 10W-40 4T Semi-Sintético', 'Universal', 38000.00, 30, 'aceite-10w40.jpg', 3),
(17, 'Kit de Arrastre Racing', 'KTM Duke 200', 120000.00, 10, 'kit-arrastre.jpg', 3),
(18, 'Bujía Iridium Power', 'Universal', 35000.00, 25, 'bujia-iridium.jpg', 3),
(19, 'Llanta Pista Sport', 'Universal', 180000.00, 8, 'llanta.jpg', 3),
(20, 'Casco Integral', 'Universal - Certificación DOT/ECE', 220000.00, 12, 'casco.jpg', 1),
(21, 'Casco AGV K1 S Black', 'Casco deportivo con diseño aerodinámico derivado de MotoGP y visor antirrayones.', 980000.00, 8, 'casco_agv_k1.jpg', 1),
(22, 'Casco Shoei RF-1400 Solid', 'Casco gama alta con certificación Snell, máxima reducción de ruido y gran ventilación.', 2400000.00, 4, 'casco_shoei_rf1400.jpg', 1),
(23, 'Casco Shark Ridill 2', 'Casco integral de alta seguridad con gafas de sol internas desplegables.', 650000.00, 10, 'casco_shark_ridill.jpg', 1),
(24, 'Casco Bell Qualifier DLX', 'Casco resistente de policarbonato con visor fotocromático Transitions incluido.', 720000.00, 7, 'casco_bell_qualifier.jpg', 1),
(25, 'Casco MT Helmets Stinger 2', 'Casco accesible de excelente calidad con certificación europea ECE 22.06.', 320000.00, 15, 'casco_mt_stinger.jpg', 1),
(26, 'Casco Scorpion EXO-491', 'Casco con interior hipoalergénico KwikWick y pantalla solar regulable.', 580000.00, 6, 'casco_scorpion_exo.jpg', 1),
(27, 'Casco Nolan N80-8', 'Casco integral touring fabricado en policarbonato Lexan con Pinlock incluido.', 890000.00, 5, 'casco_nolan_n80.jpg', 1),
(34, 'Guantes Impermeables para Moto', 'Guantes térmicos e impermeables para protección en carretera', 45000.00, 15, 'guantes.jpg', 2),
(35, 'Impermeable para Motociclista', 'Traje impermeable de dos piezas con bandas reflectivas', 85000.00, 10, 'impermeable.jpg', 2),
(36, 'Intercomunicador Casco Bluetooth', 'Manos libres y radio para cascos de moto con cancelación de ruido', 180000.00, 8, 'intercomunicador.jpg', 2),
(37, 'Maletero Baúl Trasero 32L', 'Maleta trasera con base y kit de tornillería incluido', 120000.00, 5, 'maletero.jpg', 2);

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
(2, 'pepe', 'psanchez@gmail.com', '$2y$10$JO7vzyCm3zubexqnX5XFqeoKcd7ecPkEEQv6mRwtTxIS6OF9Z1XCW', '26563246542', 'dssgvdvdbfdbf', 2),
(3, 'jacobsgab', 'jcbsgab@gmail.com', '$2y$10$HGCJ7S.00ACRwPi15LacDejD2mhL3.C3UuQiTdTWxAnSNgDjeQE3q', '', '', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

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
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
