-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 06:37:07
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
-- Base de datos: `uean_bdd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `pasantía` enum('rentada','no rentada') DEFAULT NULL,
  `dni` int(11) NOT NULL,
  `carrera` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `convenio_file` varchar(255) NOT NULL,
  `es_graduado` enum('SI','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `nombres`, `apellidos`, `pasantía`, `dni`, `carrera`, `fecha_inicio`, `fecha_fin`, `observaciones`, `puesto`, `convenio_file`, `es_graduado`) VALUES
(1, 'Alfonso', 'Cuaron', 'rentada', 46543535, 'Ingenieria agronoma', '2021-04-25', '2025-04-25', 'Muy bien', 'Estudiante ', 'uploads/673e6e7a375da_concientización-ludopatía-arias-de_santo-garaglia.pdf', 'SI'),
(2, 'Lujan', 'Cuaron', 'rentada', 46543535, 'Ingenieria aeroespacial', '2021-04-25', '2025-04-25', 'Muy bien', 'Estudiante ', 'uploads/673e6e879cbe3_concientización-ludopatía-arias-de_santo-garaglia.pdf', 'SI'),
(3, 'Alfonso', 'Rocchi', 'rentada', 46543535, 'Ingenieria agronoma', '2002-04-25', '2010-02-19', 'Aca hay algo je', 'Estudiante ', 'uploads/673eae35c54d2_Evaluación Integradora.pdf.pdf', 'NO'),
(4, 'Valentina', 'Doe', 'no rentada', 46501859, 'Ingenieria agronoma', '2003-04-25', '2024-08-25', 'aaaa', 'Vendedor', 'uploads/673ec3dedf74d_Evaluación Integradora.pdf.pdf', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_graduado`
--

CREATE TABLE `alumno_graduado` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_graduado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_graduado`
--

INSERT INTO `alumno_graduado` (`id`, `id_alumno`, `id_graduado`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios_pasantia_beneficios`
--

CREATE TABLE `convenios_pasantia_beneficios` (
  `id` int(11) NOT NULL,
  `id_entidad` int(11) NOT NULL,
  `tipo_convenio` enum('pasantía','beneficio') NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `convenio_file` varchar(255) DEFAULT NULL,
  `fecha_firma_convenio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `convenios_pasantia_beneficios`
--

INSERT INTO `convenios_pasantia_beneficios` (`id`, `id_entidad`, `tipo_convenio`, `observaciones`, `convenio_file`, `fecha_firma_convenio`) VALUES
(1, 3, 'beneficio', '', NULL, '0000-00-00'),
(2, 3, 'pasantía', '', NULL, '0000-00-00'),
(3, 3, 'pasantía', '', '', '0000-00-00'),
(4, 3, 'pasantía', '', '', '0000-00-00'),
(5, 3, 'pasantía', '', '', '0000-00-00'),
(6, 3, 'pasantía', '', '', '0000-00-00'),
(7, 3, 'pasantía', '', NULL, '0000-00-00'),
(8, 3, 'pasantía', '', NULL, '0000-00-00'),
(9, 3, 'pasantía', NULL, NULL, NULL),
(10, 3, 'pasantía', NULL, NULL, NULL),
(11, 3, 'pasantía', NULL, NULL, NULL),
(12, 3, 'beneficio', NULL, NULL, NULL),
(13, 3, 'pasantía', '', NULL, '0000-00-00'),
(14, 3, 'pasantía', '', NULL, '0000-00-00'),
(15, 3, 'pasantía', '', NULL, '0000-00-00'),
(16, 3, 'pasantía', 'aaaaaaaaaaaaaa', 'uploads/concientización-ludopatía-arias-de_santo-garaglia.pdf', '5200-04-25'),
(17, 4, 'pasantía', 'Apa la papa', 'uploads/concientización-ludopatía-arias-de_santo-garaglia.pdf', '2005-04-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_otros`
--

CREATE TABLE `convenio_otros` (
  `id` int(11) NOT NULL,
  `id_entidad` int(11) NOT NULL,
  `tipo_convenio` enum('colaboración academica','accion comunitaria','pre profesional','beneficios para comunidad') NOT NULL,
  `firma_convenio` enum('si','no') NOT NULL,
  `adendas_cantidad` int(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `convenio_file` varchar(255) NOT NULL,
  `fecha_firma_convenio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `convenio_otros`
--

INSERT INTO `convenio_otros` (`id`, `id_entidad`, `tipo_convenio`, `firma_convenio`, `adendas_cantidad`, `observaciones`, `convenio_file`, `fecha_firma_convenio`) VALUES
(1, 3, 'colaboración academica', '', 1, 'aaaaaaaaaaa', 'uploads/tp9-arias.pdf', '0000-00-00'),
(2, 3, 'colaboración academica', 'si', 1, 'aaa', 'uploads/concientización-ludopatía-arias-de_santo-garaglia.pdf', '2005-04-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_otros_alumno`
--

CREATE TABLE `convenio_otros_alumno` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_convenio_otros` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `convenio_otros_alumno`
--

INSERT INTO `convenio_otros_alumno` (`id`, `id_alumno`, `id_convenio_otros`) VALUES
(1, 4, 1),
(2, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenio_pasantia_beneficio_alumno`
--

CREATE TABLE `convenio_pasantia_beneficio_alumno` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_convenio_beneficio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleo`
--

CREATE TABLE `empleo` (
  `id` int(11) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `requisitos` varchar(600) NOT NULL,
  `telefono_contacto` int(11) NOT NULL,
  `mail_contacto` varchar(255) NOT NULL,
  `beneficios` varchar(600) NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fin` time NOT NULL,
  `fecha_limite` date NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL DEFAULT 'img/placeholder-image.jpg',
  `area` enum('Administración','Hotelería','Marketing','Negocios en internet','Negocios internacionales','Recursos humanos','Tecnología') NOT NULL,
  `tipo` enum('Pasantía','Práctica no rentada','Puesto fijo','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleo`
--

INSERT INTO `empleo` (`id`, `empresa`, `puesto`, `requisitos`, `telefono_contacto`, `mail_contacto`, `beneficios`, `horario_inicio`, `horario_fin`, `fecha_limite`, `direccion`, `imagen`, `area`, `tipo`) VALUES
(1, 'Las bolas inc', 'Vendedor', 'Nivel de inglés C1, Titulo universitario', 1125438960, 'lasbolas@gmail.com', 'Buen salario y etc', '08:15:00', '16:15:00', '2024-11-30', 'La matanza 2538', 'uploads/673ea5dd4a793.png', 'Hotelería', 'Pasantía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `id_referente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`id`, `nombre`, `sector`, `direccion`, `id_referente`) VALUES
(3, 'palomo inc', 'agropecuario', 'baaatalla 1253', 1),
(4, 'INDICADOR 1', 'Agropecuario', 'Antunes 24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduados`
--

CREATE TABLE `graduados` (
  `id` int(11) NOT NULL,
  `anio_graduacion` year(4) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `estudios_posteriores` varchar(255) NOT NULL,
  `area_de_interes` varchar(255) NOT NULL,
  `observaciones` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `graduados`
--

INSERT INTO `graduados` (`id`, `anio_graduacion`, `mail`, `tel`, `estudios_posteriores`, `area_de_interes`, `observaciones`) VALUES
(1, '2005', 'alfonso@gmail.com', 1125438960, 'algunos', 'todos', 'insipido el tipo'),
(2, '2024', 'lujan@gmail.com', 112546389, 'Ninguno', 'Ninguno', 'Jejeje');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulante`
--

CREATE TABLE `postulante` (
  `id` int(11) NOT NULL,
  `Nombres` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `CV` varchar(255) NOT NULL DEFAULT 'PATH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulante`
--

INSERT INTO `postulante` (`id`, `Nombres`, `Apellidos`, `CV`) VALUES
(1, 'Alvaro', 'Ramirez', 'uploads/tp9-arias.pdf'),
(2, 'INDICADOR 1', 'Arias', 'uploads/cvs/concientización-ludopatía-arias-de_santo-garaglia.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulante_empleo`
--

CREATE TABLE `postulante_empleo` (
  `id` int(11) NOT NULL,
  `id_postulante` int(11) NOT NULL,
  `id_empleo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulante_empleo`
--

INSERT INTO `postulante_empleo` (`id`, `id_postulante`, `id_empleo`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referente`
--

CREATE TABLE `referente` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `referente`
--

INSERT INTO `referente` (`id`, `nombres`, `apellidos`, `puesto`, `email`) VALUES
(1, 'aaaa', 'Garcia', 'Instructor', 'juanelo@gmail.com'),
(2, 'Tomás', 'Arias', 'Estudiante ', 'tomasariascontacto@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referente_empleo`
--

CREATE TABLE `referente_empleo` (
  `id` int(11) NOT NULL,
  `id_referente` int(11) NOT NULL,
  `id_empleo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `referente_empleo`
--

INSERT INTO `referente_empleo` (`id`, `id_referente`, `id_empleo`) VALUES
(1, 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alumno_graduado`
--
ALTER TABLE `alumno_graduado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_graduado` (`id_graduado`);

--
-- Indices de la tabla `convenios_pasantia_beneficios`
--
ALTER TABLE `convenios_pasantia_beneficios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_entidad` (`id_entidad`);

--
-- Indices de la tabla `convenio_otros`
--
ALTER TABLE `convenio_otros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_entidad` (`id_entidad`);

--
-- Indices de la tabla `convenio_otros_alumno`
--
ALTER TABLE `convenio_otros_alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_convenio_otros` (`id_convenio_otros`);

--
-- Indices de la tabla `convenio_pasantia_beneficio_alumno`
--
ALTER TABLE `convenio_pasantia_beneficio_alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`,`id_convenio_beneficio`),
  ADD KEY `id_convenio_beneficio` (`id_convenio_beneficio`);

--
-- Indices de la tabla `empleo`
--
ALTER TABLE `empleo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_referente` (`id_referente`);

--
-- Indices de la tabla `graduados`
--
ALTER TABLE `graduados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulante`
--
ALTER TABLE `postulante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulante_empleo`
--
ALTER TABLE `postulante_empleo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_postulante` (`id_postulante`),
  ADD KEY `id_empleo` (`id_empleo`);

--
-- Indices de la tabla `referente`
--
ALTER TABLE `referente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `referente_empleo`
--
ALTER TABLE `referente_empleo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_referente` (`id_referente`),
  ADD KEY `id_empleo` (`id_empleo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `alumno_graduado`
--
ALTER TABLE `alumno_graduado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `convenios_pasantia_beneficios`
--
ALTER TABLE `convenios_pasantia_beneficios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `convenio_otros`
--
ALTER TABLE `convenio_otros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `convenio_otros_alumno`
--
ALTER TABLE `convenio_otros_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `convenio_pasantia_beneficio_alumno`
--
ALTER TABLE `convenio_pasantia_beneficio_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleo`
--
ALTER TABLE `empleo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `graduados`
--
ALTER TABLE `graduados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `postulante`
--
ALTER TABLE `postulante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `postulante_empleo`
--
ALTER TABLE `postulante_empleo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `referente`
--
ALTER TABLE `referente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `referente_empleo`
--
ALTER TABLE `referente_empleo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno_graduado`
--
ALTER TABLE `alumno_graduado`
  ADD CONSTRAINT `alumno_graduado_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `alumno_graduado_ibfk_2` FOREIGN KEY (`id_graduado`) REFERENCES `graduados` (`id`);

--
-- Filtros para la tabla `convenios_pasantia_beneficios`
--
ALTER TABLE `convenios_pasantia_beneficios`
  ADD CONSTRAINT `convenios_pasantia_beneficios_ibfk_1` FOREIGN KEY (`id_entidad`) REFERENCES `entidad` (`id`);

--
-- Filtros para la tabla `convenio_otros`
--
ALTER TABLE `convenio_otros`
  ADD CONSTRAINT `convenio_otros_ibfk_1` FOREIGN KEY (`id_entidad`) REFERENCES `entidad` (`id`);

--
-- Filtros para la tabla `convenio_otros_alumno`
--
ALTER TABLE `convenio_otros_alumno`
  ADD CONSTRAINT `convenio_otros_alumno_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `convenio_otros_alumno_ibfk_2` FOREIGN KEY (`id_convenio_otros`) REFERENCES `convenio_otros` (`id`);

--
-- Filtros para la tabla `convenio_pasantia_beneficio_alumno`
--
ALTER TABLE `convenio_pasantia_beneficio_alumno`
  ADD CONSTRAINT `convenio_pasantia_beneficio_alumno_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `convenio_pasantia_beneficio_alumno_ibfk_2` FOREIGN KEY (`id_convenio_beneficio`) REFERENCES `convenios_pasantia_beneficios` (`id`);

--
-- Filtros para la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD CONSTRAINT `entidad_ibfk_1` FOREIGN KEY (`id_referente`) REFERENCES `referente` (`id`);

--
-- Filtros para la tabla `postulante_empleo`
--
ALTER TABLE `postulante_empleo`
  ADD CONSTRAINT `postulante_empleo_ibfk_1` FOREIGN KEY (`id_empleo`) REFERENCES `empleo` (`id`),
  ADD CONSTRAINT `postulante_empleo_ibfk_2` FOREIGN KEY (`id_postulante`) REFERENCES `postulante` (`id`);

--
-- Filtros para la tabla `referente_empleo`
--
ALTER TABLE `referente_empleo`
  ADD CONSTRAINT `referente_empleo_ibfk_1` FOREIGN KEY (`id_empleo`) REFERENCES `empleo` (`id`),
  ADD CONSTRAINT `referente_empleo_ibfk_2` FOREIGN KEY (`id_referente`) REFERENCES `referente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
