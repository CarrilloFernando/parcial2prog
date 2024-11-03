-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 06:29:59
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
-- Base de datos: `foro_virtual`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id_estado`, `nombre_estado`) VALUES
(1, 'Habilitado'),
(2, 'Eliminado'),
(3, 'Suspendido'),
(4, 'Pendiente de verificación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verificado` tinyint(1) DEFAULT 0,
  `token_verificacion` varchar(255) DEFAULT NULL,
  `fecha_verificacion` datetime DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `fecha_eliminacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email`, `password`, `verificado`, `token_verificacion`, `fecha_verificacion`, `fecha_registro`, `fecha_eliminacion`, `fecha_modificacion`, `id_estado`) VALUES
(7, 'UsuarioPrueba', 'usuario@example.com', '$2y$10$SuJvFE45j3skiLTZJCk41OCrVxmHfaMzBxOHlpbWhmz.XnHG0UNqO', 1, '91247c53059821c9fdfb0621eb0fe562', '2024-11-01 19:15:14', '2024-11-01 18:21:11', NULL, NULL, 1),
(14, 'blanco', 'blanco07062001@gmail.com', '$2y$10$9SK.LlFDR1CTDhKUzyU5dOtHEMsVwep1nWzk2VuOPKm7V6Id1MLdO', 1, 'b7a5cc06e756888aa6202595e7824064', '2024-11-01 19:16:29', '2024-11-01 19:14:13', NULL, NULL, 1),
(29, 'adm_fernando', 'fjc07062001@gmail.com', '$2y$10$CRmJcoMGT9yysr8N1Q2HbuazDs.KCIqiyeXKvF.YUlaPAHEcO7tDC', 1, '667f5037d8321ee35e0cd43a5624d28c', '2024-11-03 02:16:29', '2024-11-03 02:04:11', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado_usuario` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
