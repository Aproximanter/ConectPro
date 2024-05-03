-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2024 a las 03:27:06
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
-- Base de datos: `conectpro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ComentarioID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL,
  `FechaComentario` timestamp NOT NULL DEFAULT current_timestamp(),
  `TextoComentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datoscontactoprofesionista`
--

CREATE TABLE `datoscontactoprofesionista` (
  `ID` int(11) NOT NULL,
  `ProfesionistaID` int(11) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Correo` varchar(100) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `FotoID` int(11) NOT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_perfil`
--

CREATE TABLE `fotos_perfil` (
  `FotoID` int(11) NOT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL,
  `FotoPerfil` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_publicacion`
--

CREATE TABLE `fotos_publicacion` (
  `FotoID` int(11) NOT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL,
  `FotoTrabajo1` blob DEFAULT NULL,
  `FotoTrabajo2` blob DEFAULT NULL,
  `FotoTrabajo3` blob DEFAULT NULL,
  `FotoTrabajo4` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `PagoID` int(11) NOT NULL,
  `UsuarioNormalID` int(11) DEFAULT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL,
  `NumeroTransaccion` varchar(50) NOT NULL,
  `Tarjeta` varchar(50) NOT NULL,
  `Cantidad` decimal(10,2) NOT NULL,
  `ClaveUnica` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesionistas`
--

CREATE TABLE `profesionistas` (
  `ProfesionistaID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Profesion` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `FotoPerfil` varchar(255) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Costo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesionistas`
--

INSERT INTO `profesionistas` (`ProfesionistaID`, `UsuarioID`, `Nombre`, `Profesion`, `Descripcion`, `FotoPerfil`, `FechaCreacion`, `Costo`) VALUES
(5, NULL, 'Julian Isaias Lopez Velazquez', 'Profesor', 'Me gusta dar clases', 'fotos_perfil/_4f1b5410-3aef-4fe2-b38f-e8f1a72dee23.jpg', '2024-04-07 18:36:26', NULL),
(6, NULL, 'Araceli Llamas', 'Ingeniero', 'Soy Ingeniera en Alimentarias ', 'fotos_perfil/IMG-20240202-WA0065.jpg', '2024-04-07 18:49:52', NULL),
(7, NULL, 'Romachaca', 'Profesor', 'Soy Maestra en el Tecnologico De Arandas Jalisco, Hola ', 'fotos_perfil/images.jpeg', '2024-04-09 13:43:42', NULL),
(27, 40, 'Victor Aguas', 'Doctor', 'Si', 'fotos_perfil/lista-verbos-pasado-participio.png', '2024-04-15 17:22:18', NULL),
(28, 38, 'Julian Isaias', 'Ingeniero', 'Ing en sis', 'fotos_perfil/lista-verbos-pasado-participio.png', '2024-04-15 17:35:56', NULL),
(29, 42, 'Alvaro', 'Ingeniero', 'ING en sistemas. Del TEC', 'fotos_perfil/lista-verbos-pasado-participio.png', '2024-04-23 13:40:04', 800.00),
(30, 43, 'Chupirilo', 'Abogado', 'Abogado. El que traigo aqui colgado', 'fotos_perfil/images.jpeg', '2024-04-23 13:56:19', -99999999.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `PublicacionID` int(11) NOT NULL,
  `ProfesionistaID` int(11) DEFAULT NULL,
  `Calificacion` int(11) DEFAULT NULL,
  `NombreProfesionista` varchar(255) DEFAULT NULL,
  `ContactoProfesionista` varchar(255) DEFAULT NULL,
  `DomicilioProfesionista` varchar(255) DEFAULT NULL,
  `ProfesionProfesionista` varchar(255) DEFAULT NULL,
  `DescripcionProfesionista` text DEFAULT NULL,
  `FotoPerfilProfesionista` int(11) DEFAULT NULL,
  `FotoTrabajo1Profesionista` int(11) DEFAULT NULL,
  `FotoTrabajo2Profesionista` int(11) DEFAULT NULL,
  `FotoTrabajo3Profesionista` int(11) DEFAULT NULL,
  `FotoTrabajo4Profesionista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `ResenaID` int(11) NOT NULL,
  `ProfesionistaID` int(11) NOT NULL,
  `UsuarioID` int(11) NOT NULL,
  `Calificacion` int(11) NOT NULL,
  `Comentario` text DEFAULT NULL,
  `FechaResena` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Nivel` varchar(50) DEFAULT 'usuario',
  `FotoPerfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `Usuario`, `Correo`, `Contrasena`, `Nombre`, `FechaCreacion`, `Nivel`, `FotoPerfil`) VALUES
(38, 'admin', 'admin@gmail.com', '$2y$10$BQLUT9CJElWTcB2qD/b2leyFfC5L2Ni/dv0dfhkJRbet7OeRmYv7a', 'admin', '2024-04-09 14:32:54', 'admin', NULL),
(40, 'Victor aguas', 'jlopez26024.22@outlook.com', '$2y$10$DXZGX3CNCF7qZO.Eu8fJUuAUwefvt3/5SjK03MR/Ho3RtNQap68.y', 'Jose Hernandez 2', '2024-04-15 16:21:00', 'usuario', NULL),
(42, 'Alvaro', 'alvaro@gmail.com', '$2y$10$O4XAh8uKDNaxvq1jeiauzOyjD1nDo6V5UkkZAZvNWVYfo9Z8O/rUq', 'Alvaro', '2024-04-23 13:38:51', 'usuario', NULL),
(43, 'pendejos1', 'amen@ju.lian', '$2y$10$lTP6buEWMm5rAu9V7DtIpeCVW4OWyb4ed.9Oo0YqOIZ9sQj4A2DDa', 'Chupirilo', '2024-04-23 13:55:43', 'usuario', NULL),
(44, 'pruebafoto', 'pruevafoto@gmail.com', '$2y$10$LdIn8kLbdO9h86gPVgPXpuWjw6JVC6mMwc5hWKysybmHEooeDJAcW', 'PruebaFoto', '2024-04-30 14:26:45', 'usuario', 'fotos_perfil/_.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ComentarioID`),
  ADD KEY `FK_UsuarioID_Comentarios` (`UsuarioID`),
  ADD KEY `FK_ProfesionistaID_Comentarios` (`ProfesionistaID`),
  ADD KEY `idx_fecha_comentario` (`FechaComentario`);

--
-- Indices de la tabla `datoscontactoprofesionista`
--
ALTER TABLE `datoscontactoprofesionista`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ProfesionistaID_DatosContacto` (`ProfesionistaID`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`FotoID`),
  ADD KEY `ProfesionistaID` (`ProfesionistaID`);

--
-- Indices de la tabla `fotos_perfil`
--
ALTER TABLE `fotos_perfil`
  ADD PRIMARY KEY (`FotoID`),
  ADD KEY `ProfesionistaID` (`ProfesionistaID`);

--
-- Indices de la tabla `fotos_publicacion`
--
ALTER TABLE `fotos_publicacion`
  ADD PRIMARY KEY (`FotoID`),
  ADD KEY `ProfesionistaID` (`ProfesionistaID`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`PagoID`),
  ADD UNIQUE KEY `ClaveUnica` (`ClaveUnica`),
  ADD KEY `FK_UsuarioNormalID_Pagos` (`UsuarioNormalID`),
  ADD KEY `FK_ProfesionistaID_Pagos` (`ProfesionistaID`),
  ADD KEY `idx_numero_transaccion` (`NumeroTransaccion`);

--
-- Indices de la tabla `profesionistas`
--
ALTER TABLE `profesionistas`
  ADD PRIMARY KEY (`ProfesionistaID`),
  ADD UNIQUE KEY `UNIQUE_UsuarioID` (`UsuarioID`),
  ADD KEY `FK_UsuarioID_Profesionistas_New` (`UsuarioID`),
  ADD KEY `idx_nombre_profesionista` (`Nombre`),
  ADD KEY `idx_profesion` (`Profesion`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`PublicacionID`),
  ADD KEY `FK_ProfesionistaID_Publicaciones` (`ProfesionistaID`),
  ADD KEY `FK_FotoPerfilProfesionista` (`FotoPerfilProfesionista`),
  ADD KEY `FK_FotoTrabajo1Profesionista` (`FotoTrabajo1Profesionista`),
  ADD KEY `FK_FotoTrabajo2Profesionista` (`FotoTrabajo2Profesionista`),
  ADD KEY `FK_FotoTrabajo3Profesionista` (`FotoTrabajo3Profesionista`),
  ADD KEY `FK_FotoTrabajo4Profesionista` (`FotoTrabajo4Profesionista`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`ResenaID`),
  ADD KEY `FK_ProfesionistaID_Resenas` (`ProfesionistaID`),
  ADD KEY `FK_UsuarioID_Resenas` (`UsuarioID`),
  ADD KEY `idx_calificacion` (`Calificacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ComentarioID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datoscontactoprofesionista`
--
ALTER TABLE `datoscontactoprofesionista`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `FotoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `PagoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesionistas`
--
ALTER TABLE `profesionistas`
  MODIFY `ProfesionistaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `PublicacionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `ResenaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_ProfesionistaID_Comentarios` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`),
  ADD CONSTRAINT `FK_UsuarioID_Comentarios` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `datoscontactoprofesionista`
--
ALTER TABLE `datoscontactoprofesionista`
  ADD CONSTRAINT `FK_ProfesionistaID_DatosContacto` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `fotos_perfil`
--
ALTER TABLE `fotos_perfil`
  ADD CONSTRAINT `fotos_perfil_ibfk_1` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `fotos_publicacion`
--
ALTER TABLE `fotos_publicacion`
  ADD CONSTRAINT `fotos_publicacion_ibfk_1` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `FK_ProfesionistaID_Pagos` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`),
  ADD CONSTRAINT `FK_UsuarioNormalID_Pagos` FOREIGN KEY (`UsuarioNormalID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`UsuarioNormalID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `profesionistas`
--
ALTER TABLE `profesionistas`
  ADD CONSTRAINT `FK_UsuarioID_Profesionistas` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `FK_FotoPerfilProfesionista` FOREIGN KEY (`FotoPerfilProfesionista`) REFERENCES `fotos_perfil` (`FotoID`),
  ADD CONSTRAINT `FK_FotoTrabajo1Profesionista` FOREIGN KEY (`FotoTrabajo1Profesionista`) REFERENCES `fotos_publicacion` (`FotoID`),
  ADD CONSTRAINT `FK_FotoTrabajo2Profesionista` FOREIGN KEY (`FotoTrabajo2Profesionista`) REFERENCES `fotos_publicacion` (`FotoID`),
  ADD CONSTRAINT `FK_FotoTrabajo3Profesionista` FOREIGN KEY (`FotoTrabajo3Profesionista`) REFERENCES `fotos_publicacion` (`FotoID`),
  ADD CONSTRAINT `FK_FotoTrabajo4Profesionista` FOREIGN KEY (`FotoTrabajo4Profesionista`) REFERENCES `fotos_publicacion` (`FotoID`),
  ADD CONSTRAINT `FK_ProfesionistaID_Publicaciones` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`),
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`);

--
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `FK_ProfesionistaID_Resenas` FOREIGN KEY (`ProfesionistaID`) REFERENCES `profesionistas` (`ProfesionistaID`),
  ADD CONSTRAINT `FK_UsuarioID_Resenas` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
