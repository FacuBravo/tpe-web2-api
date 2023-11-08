-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2023 a las 23:34:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreria`
--
CREATE DATABASE IF NOT EXISTS `libreria` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `libreria`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Mario Vargas Llosa', 'Jorge Mario Pedro Vargas Llosa, conocido como Mario Vargas Llosa, es un escritor peruano que cuenta también con la nacionalidad española desde 1993 y la dominicana desde junio de 2023.​'),
(2, 'Julio Cortazar', 'Julio Florencio Cortázar fue un escritor y profesor argentino. También trabajó como traductor, oficio que desempeñó para la Unesco y varias editoriales.'),
(3, 'Isabell Allende', 'Isabel Angélica Allende Llona ​ es una escritora chilena. Desde 2004 es miembro de la Academia Estadounidense de las Artes y las Letras.​ Obtuvo el Premio Nacional de Literatura de Chile en 2010.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `genero`, `id_autor`, `descripcion`, `precio`) VALUES
(1, 'Las mil y una noches', 'Drama', 1, 'Las mil y una noches ​ es una recopilación medieval de cuentos orientales tradicionales. La obra fue tomando forma durante el transcurso de varios siglos con las contribuciones de diferentes escritores y traductores del Oriente Próximo.', 5000),
(2, 'Casa tomada', 'Ficcion', 2, 'Casa tomada es un cuento del escritor argentino Julio Cortázar. Se publicó por primera vez en 1946, en el número 11 de la revista dirigida por Jorge Luis Borges Los Anales de Buenos Aires;​ y después fue recogido en el volumen Bestiario, de 1951.', 7999),
(3, 'Rayuela', 'Ficcion', 2, 'Rayuela es la segunda novela del escritor argentino Julio Cortázar. Escrita en París y publicada por primera vez el 28 de junio de 1963, constituye una de las obras centrales del boom latinoamericano y de la literatura en español.​​​Narra la historia de Horacio Oliveira, su protagonista, y su relación con «la Maga».', 11299),
(4, 'La ciudad de los perros', 'Ficcion', 1, 'La ciudad y los perros es la primera novela del escritor peruano Mario Vargas Llosa. Ganadora del Premio Biblioteca Breve en 1962, fue publicada en octubre de 1963​ y obtuvo también el Premio de la Crítica Española. Originalmente el autor la tituló \"La morada del héroe\" y luego \"Los impostores\".', 3999),
(5, 'La casa de los espíritus', 'Realismo mágico', 3, 'La casa de los espíritus es la primera novela de la escritora chilena Isabel Allende, publicada en Barcelona por la editorial Plaza & Janés en 1982.', 8499);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `contrasenia` varchar(200) NOT NULL,
  `rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`, `rol`) VALUES
(1, 'webadmin', '$2y$10$bnJLox/0kaLwrNBoP4LCFuaCyXeCkCPz1y8cUGY5s8d.vz8SshMAG', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
