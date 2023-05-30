-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 30-05-2023 a las 02:26:12
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `preguntear`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_preguntas`
--

CREATE TABLE `categoria_preguntas` (
  `idCategoria` int(11) NOT NULL,
  `descipcion` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dificultad`
--

CREATE TABLE `dificultad` (
  `idDificultad` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas_jugadores`
--

CREATE TABLE `estadisticas_jugadores` (
  `idEstadistica` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idPartida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadisticas_jugadores`
--

INSERT INTO `estadisticas_jugadores` (`idEstadistica`, `idUsuario`, `idPartida`) VALUES
(2, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pregunta`
--

CREATE TABLE `estado_pregunta` (
  `idEstado` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `idPartida` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `cantidadDeRespuestasAcertadas` int(11) NOT NULL,
  `duracion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL,
  `pregunta` varchar(100) DEFAULT NULL,
  `idDificultad` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idRespuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_respondida`
--

CREATE TABLE `pregunta_respondida` (
  `idPreguntaRespondida` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE `ranking` (
  `idRanking` int(11) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idPartida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ranking`
--

INSERT INTO `ranking` (`idRanking`, `puntaje`, `idUsuario`, `idPartida`) VALUES
(1, 100, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `idRespuesta` int(11) NOT NULL,
  `respuestaA` varchar(100) DEFAULT NULL,
  `respuestaB` varchar(100) DEFAULT NULL,
  `respuestaC` varchar(100) DEFAULT NULL,
  `respuestaD` varchar(100) DEFAULT NULL,
  `respuestaCorrecta` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombreCompleto` varchar(100) NOT NULL,
  `fechaDeNacimiento` date NOT NULL,
  `genero` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `nombreDeUsuario` varchar(50) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `fotoDePerfil` varchar(255) NOT NULL,
  `idRol` int(11) DEFAULT NULL,
  `mailValidado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombreCompleto`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `mail`, `nombreDeUsuario`, `contrasenia`, `fotoDePerfil`, `idRol`, `mailValidado`) VALUES
(1, 'Juan Ignacio', '2023-06-01', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'juan@mail.com', 'joliva', 'Asd123&&&', 'public/image/joliva.jpg', NULL, 0),
(2, 'Juan Ignacio', '2023-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'juan@mail.com', 'juoliva', 'Asd123&&&', 'public/image/juoliva.png', NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_preguntas`
--
ALTER TABLE `categoria_preguntas`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  ADD PRIMARY KEY (`idDificultad`);

--
-- Indices de la tabla `estadisticas_jugadores`
--
ALTER TABLE `estadisticas_jugadores`
  ADD PRIMARY KEY (`idEstadistica`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idPartida` (`idPartida`);

--
-- Indices de la tabla `estado_pregunta`
--
ALTER TABLE `estado_pregunta`
  ADD PRIMARY KEY (`idEstado`),
  ADD KEY `FK_Estado_Pregunta` (`idPregunta`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`idPartida`),
  ADD KEY `FK_Partida_Usuario` (`idUsuario`),
  ADD KEY `FK_Partida_Pregunta` (`idPregunta`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`idPregunta`),
  ADD KEY `FK_Pregunta_Dificultad` (`idDificultad`),
  ADD KEY `FK_Pregunta_Categoria_Preguntas` (`idCategoria`),
  ADD KEY `FK_Pregunta_Usuario` (`idUsuario`),
  ADD KEY `FK_Pregunta_Respuesta` (`idRespuesta`);

--
-- Indices de la tabla `pregunta_respondida`
--
ALTER TABLE `pregunta_respondida`
  ADD PRIMARY KEY (`idPreguntaRespondida`),
  ADD KEY `FK_Pregunta_Respondida_Pregunta` (`idPregunta`),
  ADD KEY `FK_Pregunta_Respondida_Usuario` (`idUsuario`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`idRanking`),
  ADD KEY `FK_Ranking_Usuario` (`idUsuario`),
  ADD KEY `FK_Ranking_Partida` (`idPartida`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`idRespuesta`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `FK_Usuario_Roles` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_preguntas`
--
ALTER TABLE `categoria_preguntas`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  MODIFY `idDificultad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadisticas_jugadores`
--
ALTER TABLE `estadisticas_jugadores`
  MODIFY `idEstadistica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_pregunta`
--
ALTER TABLE `estado_pregunta`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `idPartida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta_respondida`
--
ALTER TABLE `pregunta_respondida`
  MODIFY `idPreguntaRespondida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ranking`
--
ALTER TABLE `ranking`
  MODIFY `idRanking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `idRespuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estadisticas_jugadores`
--
ALTER TABLE `estadisticas_jugadores`
  ADD CONSTRAINT `estadisticas_jugadores_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `estadisticas_jugadores_ibfk_2` FOREIGN KEY (`idPartida`) REFERENCES `partida` (`idPartida`);

--
-- Filtros para la tabla `estado_pregunta`
--
ALTER TABLE `estado_pregunta`
  ADD CONSTRAINT `FK_Estado_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `FK_Partida_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`),
  ADD CONSTRAINT `FK_Partida_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_Pregunta_Categoria_Preguntas` FOREIGN KEY (`idCategoria`) REFERENCES `categoria_preguntas` (`idCategoria`),
  ADD CONSTRAINT `FK_Pregunta_Dificultad` FOREIGN KEY (`idDificultad`) REFERENCES `dificultad` (`idDificultad`),
  ADD CONSTRAINT `FK_Pregunta_Respuesta` FOREIGN KEY (`idRespuesta`) REFERENCES `respuesta` (`idRespuesta`),
  ADD CONSTRAINT `FK_Pregunta_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `pregunta_respondida`
--
ALTER TABLE `pregunta_respondida`
  ADD CONSTRAINT `FK_Pregunta_Respondida_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`),
  ADD CONSTRAINT `FK_Pregunta_Respondida_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `FK_Ranking_Partida` FOREIGN KEY (`idPartida`) REFERENCES `partida` (`idPartida`),
  ADD CONSTRAINT `FK_Ranking_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_Usuario_Roles` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
