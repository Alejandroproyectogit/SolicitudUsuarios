-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2025 a las 22:47:28
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
-- Base de datos: `solicitudusuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemas_de_informacion`
--

CREATE TABLE `sistemas_de_informacion` (
  `id` int(11) NOT NULL,
  `nombreSistema` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sistemas_de_informacion`
--

INSERT INTO `sistemas_de_informacion` (`id`, `nombreSistema`) VALUES
(1, 'ClinalSoft Web'),
(2, 'Clinalsoft Win'),
(3, 'Doxa'),
(4, 'Clinalsoft Nomina'),
(5, 'Portal Colaborador'),
(6, 'Aula Virtual'),
(7, 'Mejoramiso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `tipoDocumento` enum('CC','TI','CE','PP') NOT NULL,
  `documento` int(10) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` int(10) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `id_sistema` int(11) NOT NULL,
  `nombreUsuarioCopia` varchar(100) DEFAULT NULL,
  `documentoUsuCopia` int(10) DEFAULT NULL,
  `QuienSolicita` int(11) NOT NULL,
  `estado` enum('CREADO','PENDIENTE') NOT NULL,
  `fechaSolicitud` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `tipoDocumento`, `documento`, `nombres`, `apellidos`, `telefono`, `correo`, `cargo`, `id_sistema`, `nombreUsuarioCopia`, `documentoUsuCopia`, `QuienSolicita`, `estado`, `fechaSolicitud`) VALUES
(4, 'CC', 5, 'lig', 'ko', 654, 'h@gmail.com', 'dg', 1, 'zdfg', 24, 1, 'PENDIENTE', '2024-12-24 15:06:43'),
(5, 'CC', 5, 'lig', 'ko', 654, 'h@gmail.com', 'dg', 2, 'zdfg', 24, 1, 'PENDIENTE', '2024-12-01 15:06:43'),
(6, 'CC', 456547, 'GJ', 'CGHJ', 456, 'FXGJ@GMAIL.COM', 'OB', 1, 'dgj', 453, 1, 'PENDIENTE', '2025-01-02 15:14:39'),
(7, 'CC', 456547, 'GJ', 'CGHJ', 456, 'FXGJ@GMAIL.COM', 'OB', 2, 'dgj', 453, 1, 'PENDIENTE', '2025-01-02 15:14:39'),
(8, 'CC', 5445354, 'ohgb', 'sgf', 3545, 'ghjh@gmail.com', 'dg', 1, 'dg', 453, 4, 'PENDIENTE', '2025-01-02 16:02:07'),
(9, 'CC', 5445354, 'ohgb', 'sgf', 3545, 'ghjh@gmail.com', 'dg', 2, 'dg', 453, 4, 'PENDIENTE', '2025-01-02 16:02:07'),
(10, 'CC', 5246, 'oibgo', 'obo', 635463, 'h@gmail.com', 'ojb', 1, 'dfhj', 5, 3, 'PENDIENTE', '2024-09-17 16:06:42'),
(11, 'CC', 5246, 'oibgo', 'obo', 635463, 'h@gmail.com', 'ojb', 2, 'dfhj', 5, 3, 'PENDIENTE', '2025-01-02 16:06:42'),
(12, 'CC', 646, 'igfi', 'sdfg', 545, 'h@gmail.com', 'sg', 1, 'fth', 9, 3, 'PENDIENTE', '2025-01-03 14:26:57'),
(13, 'CC', 646, 'igfi', 'sdfg', 545, 'h@gmail.com', 'sg', 2, 'fth', 9, 3, 'PENDIENTE', '2025-01-03 14:26:57'),
(14, 'CC', 646, 'igfi', 'sdfg', 545, '', 'sg', 3, 'fth', 9, 3, 'PENDIENTE', '2025-01-03 14:26:57'),
(15, 'CC', 5, 'h', 'h', 4, 'h@gmail.com', 'o', 1, 'o', 9, 1, 'PENDIENTE', '2025-01-09 15:37:21'),
(16, 'CC', 5, 'h', 'h', 4, 'h@gmail.com', 'o', 2, 'o', 9, 1, 'PENDIENTE', '2025-01-09 15:37:21'),
(17, 'CC', 7895467, 'h', 'o', 564, 'l@gmail.com', 'a', 1, 'hola', 4141410, 1, 'PENDIENTE', '2025-01-09 16:00:54'),
(18, 'CC', 7895467, 'h', 'o', 564, 'l@gmail.com', 'a', 2, 'hola', 4141410, 1, 'PENDIENTE', '2025-01-09 16:00:54'),
(19, 'CC', 7895467, 'h', 'o', 564, 'l@gmail.com', 'a', 3, 'hola', 4141410, 1, 'PENDIENTE', '2025-01-09 16:00:54'),
(29, 'CC', 159, 'k', 'k', 4, 'k@gmail.com', 'k', 1, 'h', 1, 3, 'PENDIENTE', '2025-01-09 16:15:50'),
(30, 'CC', 159, 'k', 'k', 4, 'k@gmail.com', 'k', 2, 'h', 1, 3, 'PENDIENTE', '2025-01-09 16:15:50'),
(31, 'CC', 1, 'k', 'k', 2, 'k@gmail.com', 'k', 3, 'h', 2, 3, 'PENDIENTE', '2025-01-09 16:16:55'),
(32, 'CC', 1, 'k', 'k', 2, 'k@gmail.com', 'k', 4, 'h', 2, 3, 'PENDIENTE', '2025-01-09 16:16:55'),
(33, 'PP', 2147483647, 'Pepe', 'Pepito', 2147483647, 'Pe@gmail.com', 'Asistencial', 1, 'PEPA', 7474, 3, 'CREADO', '2025-01-10 07:55:01'),
(34, 'PP', 2147483647, 'Pepe', 'Pepito', 2147483647, 'Pe@gmail.com', 'Asistencial', 2, 'PEPA', 7474, 3, 'CREADO', '2025-01-10 07:55:01'),
(35, 'PP', 2147483647, 'Pepe', 'Pepito', 2147483647, 'Pe@gmail.com', 'Asistencial', 3, 'PEPA', 7474, 3, 'CREADO', '2025-01-10 07:55:01'),
(36, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 1, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(37, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 2, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(38, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 3, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(39, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 4, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(40, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 5, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(41, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 6, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(42, 'CC', 789456, 'pepito', 'perez', 2147483647, 'pepe@gmail.com', 'asistencial', 7, 'pepita', 123456, 1, 'PENDIENTE', '2025-01-13 11:08:26'),
(43, 'CC', 456, 'x', 'n', 5, 'n@gmail.com', 'c', 3, 'c', 4, 3, 'PENDIENTE', '2025-01-13 11:31:52'),
(47, 'CC', 8, 'u', 'u', 8, 'u@gmail.com', 'u', 2, NULL, NULL, 1, 'PENDIENTE', '2025-01-13 14:54:31'),
(48, 'CC', 9, 'h', 'h', 9, 'h@gmail.com', 'h', 1, NULL, NULL, 1, 'PENDIENTE', '2025-01-13 15:02:25'),
(49, 'CC', 1, 'q', 'q', 1, 'q@gmail.com', 'q', 2, NULL, NULL, 3, 'PENDIENTE', '2025-01-13 15:08:34'),
(50, 'CC', 2147483647, 'PEPE', 'PEPITO', 2147483647, 'pe@gmail.com', 'Asistencial', 1, NULL, NULL, 24, 'CREADO', '2025-01-14 10:20:41'),
(51, 'CC', 2147483647, 'PEPE', 'PEPITO', 2147483647, 'pe@gmail.com', 'Asistencial', 2, NULL, NULL, 24, 'CREADO', '2025-01-14 10:20:41'),
(52, 'CC', 7, 'h', 'o', 7, 'l@gmail.com', 'a', 1, NULL, NULL, 3, 'PENDIENTE', '2025-01-14 16:21:11'),
(53, 'CC', 8, 'Pepe', 'Pepito', 89898, 'pepe@gmail.com', 'asistencial', 1, NULL, NULL, 3, 'PENDIENTE', '2025-01-14 16:30:35'),
(54, 'CC', 8, 'Pepe', 'Pepito', 89898, 'pepe@gmail.com', 'asistencial', 2, NULL, NULL, 3, 'PENDIENTE', '2025-01-14 16:30:35'),
(55, 'CC', 8, 'Pepe', 'Pepito', 89898, 'pepe@gmail.com', 'asistencial', 3, NULL, NULL, 3, 'PENDIENTE', '2025-01-14 16:30:36'),
(56, 'CC', 8, 'Pepe', 'Pepito', 89898, 'pepe@gmail.com', 'asistencial', 4, NULL, NULL, 3, 'PENDIENTE', '2025-01-14 16:30:36'),
(57, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 1, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(58, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 2, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(59, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 3, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(60, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 4, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(61, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 5, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(62, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 6, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07'),
(63, 'CC', 456456, 'jola', 'jola', 5435, 'jo@gmail.com', 'asistente', 7, 'ola', 4447, 1, 'PENDIENTE', '2025-01-14 16:43:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipoDocumento` enum('CC','TI','CE','PP') NOT NULL,
  `documento` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `usuario` int(10) NOT NULL,
  `contrasena` varchar(70) NOT NULL,
  `cargo` varchar(70) NOT NULL,
  `area` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipoDocumento`, `documento`, `nombre`, `apellidos`, `usuario`, `contrasena`, `cargo`, `area`, `id_rol`) VALUES
(1, 'CC', 0, 'Alejo', '', 123456789, '$2y$10$5yQ/l5mHoLURcugACYgeW.lgihIXgiGxGxD0vz0S0vk3MLxDPuGK.', 'Aprendiz', 'Tics', 1),
(3, 'CC', 0, 'Kevin', '', 123321, '$2y$10$Khc0T1pYvqIurQnPue6TXeL9xpYoFT5dLXBzXj9Qv1xZuUjZMqXwS', 'Jefe', 'IMG', 2),
(4, 'CC', 0, 'Javier', '', 8967, '$2y$10$JgQb1z0A1ExRRq4hqwEsEeD3I8kWSYm8wzuf/T/L8L.V8qnkBbY52', 'Asistencial', 'IMG', 1),
(5, 'CC', 456789123, 'Carolina', 'Guarin', 125, '$2y$10$G.KrOJzHGxYtu5PVLLY7XO3kmC2EX6xfEZdKfeamRtx82G/xYRf7C', 'medica', 'img', 1),
(6, 'CC', 14297169, 'Camilo Andres', 'Diaz Muñoz', 14297169, '$2y$10$juFRmX.HRNZXkujFzpBlmenDrld7mVawqU9BGX3Uuy6FG5vYsz.Uq', 'Desarrollador N 1', 'TICS', 1),
(8, 'CC', 1654, 'fgh', 'fh', 123596, '$2y$10$GIATn2aOPf565zprwH9YcOGC3YEpNNW85w8Imu6ycSy6nxTtDRG5i', 'dg', 'dgh', 2),
(9, 'CC', 35351, 'kjbb', 'dbeb', 2, '$2y$10$c9tyqFqKMzHLKz4J7BHU6.KhfWKhZ4sCX8jF1TJ4zDHsaeGtCDPY6', 'dgb', 'sdvb', 2),
(10, 'CC', 35351, 'kjbb', 'dbeb', 2, '$2y$10$37/hqkTJ1qH8s2BvscOloOyv4aUBn95oHfq8QxYhFF0gj3jIBxHbW', 'dgb', 'sdvb', 2),
(11, 'CC', 4532, 'gjk', 'gkc', 2, '$2y$10$BhJd2k4etDNGP8.iwt7aw.MlsWmXC2iwiyK6SAqjtVtXB3hzPERQa', 'p', 'b', 1),
(12, 'CC', 42, 'hg', 'gh', 7, '$2y$10$1PERn.DY1aEUdJGGAz.7VOaoEQ/zrNnIeDNEdU09a7pW/JppQ7PHy', 'hg', 'fg', 2),
(13, 'CC', 58, 'fg', 'dfh', 7, '$2y$10$ySe/P9HA.m0NNMiZcPkJe.XgH37oRt9v9RwoqXUfkMpfwUAKIMXzK', 'g', 'gh', 1),
(14, 'CC', 654, 'G', 'B', 2, '$2y$10$hT7gEIved1YdANf90iFQRevZCdWxaKURGMzOEE5NSkibiwug4.Kj6', 'KBJ', 'H', 1),
(15, 'CC', 3213, 'DF', 'DF', 7, '$2y$10$12BLrORG7WRMBjBJQE475u3gTgyDo2m2dILFloJ7L8xqwqJOJjt1i', 'FG', 'FV', 2),
(16, 'CC', 665, 'db', 'dfvb', 8, '$2y$10$4eMPRGkHRy/pInGfBqSe5ekMOV4L6d9ZCbd2KTJrL4unnktnDDBae', 'df', 'dv', 1),
(17, 'CC', 6, 'df', 'f', 7, '$2y$10$SnQvzDY3W0LGTTc/VcZuGeVXsGbuPPEpQNpLAI/uOIvTs7dpgnabu', 'sdfh', 'fgh', 1),
(18, 'CC', 76, 'j', 'yj', 5, '$2y$10$dmdW9V/UmNf42MjT5Gmbtes5IyBhM0VdeEZ.xOhQyR0N0coU7tBZe', 'oi', 'cgjk', 1),
(19, 'CC', 5454, 'Mathew', 'Guarnizo', 5454, '$2y$10$5q/xckhAHg9oxzxPE5l1puw4bcczSdfXAGY1y2WjPojdlRqGg.jPe', 'Tics', 'Tics', 1),
(20, 'CC', 5455, 'hola', 'hola', 5454, '$2y$10$PKEX9ZqYqs9vdC82Yy5G8uSI12XBOMQ8NuPrEAojjXBDFFTAadZ/6', 'hols', 'hols', 1),
(21, 'CC', 456, 'alejandro', 'ramirez', 123456, '$2y$10$NWfXFfEOY80Yg0x0lHPfjezlvO3wLQ//XNRKmabNz6DHxKF3Azfgy', 'aprendiz', 'tics', 2),
(22, 'CC', 789789, 'n', 'n', 789789, '$2y$10$YjZDVZIUwWyF259oJ09d7uEeWwL0t.X.5VTSZIsHeZAyaD9jPQeRi', 'n', 'n', 1),
(24, 'CC', 2147483647, 'Juan', 'Sanchez', 741, '$2y$10$qxFfIA6vYZ63HjAB4zI6OucaUBrsEt2g2ZAEYDud5z9n5ZrXZKmm6', 'medico', 'IMG', 2),
(25, 'TI', 9, 'hola', 'ola', 789, '$2y$10$U8kGKOZNRnCzNVZawepZseUQb0bENM7wLJCAwppFfNpieQ1e82ScK', 'asistencial', 'img', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `sistemas_de_informacion`
--
ALTER TABLE `sistemas_de_informacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_sistema` (`id_sistema`),
  ADD KEY `QuienSolicita` (`QuienSolicita`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`id_sistema`) REFERENCES `sistemas_de_informacion` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`QuienSolicita`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
