-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2025 a las 18:23:23
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
-- Base de datos: `cuponera`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `oferta_id` int(11) DEFAULT NULL,
  `codigo` varchar(20) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('Disponible','Canjeado','Vencido') DEFAULT 'Disponible',
  `empleado_id` int(11) DEFAULT NULL,
  `fecha_canje` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `oferta_id`, `codigo`, `fecha_compra`, `estado`, `empleado_id`, `fecha_canje`) VALUES
(1, 1, 1, 'RES123-0000001', '2025-03-25 20:52:09', 'Disponible', 2, '2025-03-25 20:52:09'),
(2, 2, 2, 'TAL456-0000002', '2025-03-25 20:52:09', 'Disponible', 2, '2025-03-25 20:52:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `direccion` text NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `rubro` varchar(50) NOT NULL,
  `porcentaje_comision` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `codigo`, `direccion`, `contacto`, `telefono`, `correo`, `rubro`, `porcentaje_comision`) VALUES
(1, 'Restaurante Delicias', 'RES123', 'Av. Central #5', 'Juan Pérez', '7890-1234', 'contacto@delicias.com', 'Restaurantes', 10.00),
(2, 'Taller Mecánico Rápido', 'TAL456', 'Calle Secundaria #12', 'Mario Gómez', '7654-5678', 'info@tallerrapido.com', 'Talleres', 12.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_contrasenas`
--

CREATE TABLE `gestion_contrasenas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gestion_contrasenas`
--

INSERT INTO `gestion_contrasenas` (`id`, `usuario_id`, `token`, `fecha_generacion`) VALUES
(1, 1, 'token123abc', '2025-03-25 20:52:09'),
(2, 2, 'token456def', '2025-03-25 20:52:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `precio_regular` decimal(10,2) NOT NULL,
  `precio_oferta` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_limite` date NOT NULL,
  `cantidad_limite` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('En espera de aprobación','Aprobada','Rechazada','Descartada') DEFAULT 'En espera de aprobación',
  `justificacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `empresa_id`, `titulo`, `precio_regular`, `precio_oferta`, `fecha_inicio`, `fecha_fin`, `fecha_limite`, `cantidad_limite`, `descripcion`, `estado`, `justificacion`) VALUES
(1, 1, '50% de descuento en almuerzos', 10.00, 5.00, '2025-03-01', '2025-03-15', '2025-04-01', 100, 'Disfruta de un almuerzo con el 50% de descuento.', 'Aprobada', 'Fecha de inicio incorrecta'),
(2, 2, 'Cambio de aceite con 30% descuento', 25.00, 17.50, '2025-03-05', '2025-03-20', '2025-04-05', 50, 'Cambia tu aceite con descuento especial.', 'En espera de aprobación', 'Oferta con información incompleta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(12) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo` enum('Cliente','Administrador','Empleado','AdminEmpresa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `empresa_id`, `nombres`, `apellidos`, `telefono`, `correo`, `usuario`, `contrasena`, `tipo`) VALUES
(1, NULL, 'Carlos López', 'Guzmán', '7123-4567', 'carlos@example.com', '', 'hashedpassword1', 'Cliente'),
(2, NULL, 'Ana Martínez', 'Hernández', '7254-7890', 'ana@example.com', '', 'hashedpassword2', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `oferta_id` (`oferta_id`),
  ADD KEY `fk_compras_empleado` (`empleado_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `gestion_contrasenas`
--
ALTER TABLE `gestion_contrasenas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `usuario_id_2` (`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `gestion_contrasenas`
--
ALTER TABLE `gestion_contrasenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`oferta_id`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_compras_empleado` FOREIGN KEY (`empleado_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `gestion_contrasenas`
--
ALTER TABLE `gestion_contrasenas`
  ADD CONSTRAINT `gestion_contrasenas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `fk_ofertas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
