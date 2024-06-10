-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2024 a las 15:33:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comunidad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES
(1, 'administrador'),
(2, 'publico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `id` int(11) NOT NULL,
  `Nfamilia` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libreria_calle`
--

CREATE TABLE `libreria_calle` (
  `id` int(250) NOT NULL,
  `nombreCalle` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libreria_calle`
--

INSERT INTO `libreria_calle` (`id`, `nombreCalle`) VALUES
(4, 'Calle Mangles'),
(5, 'Calle Palma'),
(6, 'Calle Piña y Yaque'),
(20, 'calle lirios'),
(26, 'bolivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libreria_ciudadano`
--

CREATE TABLE `libreria_ciudadano` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellido` varchar(250) NOT NULL,
  `cedu` int(250) NOT NULL,
  `N_tlf` varchar(250) NOT NULL,
  `acotaciones` varchar(250) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `idcalle` int(250) NOT NULL,
  `id_familia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libreria_usuarios`
--

CREATE TABLE `libreria_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libreria_usuarios`
--

INSERT INTO `libreria_usuarios` (`id`, `usuario`, `password`, `correo`, `id_cargo`) VALUES
(15, 'antox', '123', 'javier.valor22@gmail.com', 1),
(17, 'admin97', '123', 'mili99@gmail.com', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_familia`
--

CREATE TABLE `miembros_familia` (
  `id` int(11) NOT NULL,
  `familia_id` int(11) NOT NULL,
  `ciudadano_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libreria_calle`
--
ALTER TABLE `libreria_calle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libreria_ciudadano`
--
ALTER TABLE `libreria_ciudadano`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcalle` (`idcalle`),
  ADD KEY `id_familia` (`id_familia`);

--
-- Indices de la tabla `libreria_usuarios`
--
ALTER TABLE `libreria_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Indices de la tabla `miembros_familia`
--
ALTER TABLE `miembros_familia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `familia_id` (`familia_id`,`ciudadano_id`),
  ADD KEY `ciudadano_id` (`ciudadano_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `familia`
--
ALTER TABLE `familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `libreria_calle`
--
ALTER TABLE `libreria_calle`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `libreria_ciudadano`
--
ALTER TABLE `libreria_ciudadano`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `libreria_usuarios`
--
ALTER TABLE `libreria_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `miembros_familia`
--
ALTER TABLE `miembros_familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libreria_ciudadano`
--
ALTER TABLE `libreria_ciudadano`
  ADD CONSTRAINT `libreria_ciudadano_ibfk_1` FOREIGN KEY (`idcalle`) REFERENCES `libreria_calle` (`id`),
  ADD CONSTRAINT `libreria_ciudadano_ibfk_2` FOREIGN KEY (`id_familia`) REFERENCES `familia` (`id`);

--
-- Filtros para la tabla `libreria_usuarios`
--
ALTER TABLE `libreria_usuarios`
  ADD CONSTRAINT `libreria_usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `miembros_familia`
--
ALTER TABLE `miembros_familia`
  ADD CONSTRAINT `miembros_familia_ibfk_1` FOREIGN KEY (`familia_id`) REFERENCES `familia` (`id`),
  ADD CONSTRAINT `miembros_familia_ibfk_2` FOREIGN KEY (`ciudadano_id`) REFERENCES `libreria_ciudadano` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
