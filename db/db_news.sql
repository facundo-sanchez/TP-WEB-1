-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2021 a las 23:10:00
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_news`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`) VALUES
(1, 'Politica', 'Noticias sobre politica.'),
(2, 'Futbol', 'Noticias sobre todas las ligas de futbol.'),
(3, 'Local', 'Noticias de lo que sucede en la ciudad.'),
(4, 'Internacional', 'Noticias del mundo.'),
(5, 'Undefined', 'Noticia no definida'),
(51, 'Tenis', 'Noticias sobre todo lo que sucede en el mundo del tenis.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `id_category`) VALUES
(2, 'Otra noticia', 'Porque puedo', 1),
(3, 'probando1', 'holi', 1),
(6, 'ajax', '1', 1),
(9, 'sad', '1', 4),
(12, 'tp web', '1', 2),
(13, 'QUIERO DORMIR', 'JUJU', 2),
(17, 'probando ajax con tpl', 'a', 3),
(20, 'Esta muy pero muy mal', 'juju', 3),
(22, 'probando otro form', '1', 3),
(67, 'holis', '1', 2),
(68, 'aasdasdasd', '1', 5),
(69, 'sadsgf', 'axxx', 5),
(75, 'Del potro volve', 'por favor', 51),
(77, 'Las dudas son laterales', 'En Ezeiza se respira más tranquilidad que nunca. Esta Selección generó y consiguió disfrutar hasta de cada entrenamiento. El domingo ante un rival durísimo como Uruguay deleitó al público que fue al Monumental y al hincha que se enganchó con este equipo campeón que va por más. Con un invicto de 24 partidos y con buena diferencia en las Eliminatorias, hay ganas de que no se corte y Argentina siga haciendo Lio.\r\n\r\nEste jueves, a las 20.30, ante Perú, será la oportunidad para extender este buen momento que generó tanta ilusión como ganas de ver a un equipo que desesperó a la gente: nuevamente agotó las entradas disponibles para ir al Monumental. Con Lionel Messi a la cabeza, el equipo será muy parecido al que goleó a la Celeste. El otro Lionel, el Scaloni que también se llevó aplausos y cantos del público, piensa en modificaciones en los laterales. Allí, donde los nombres son totalmente parejos en la consideración del DT, esta vez la oportunidad podría ser para Gonzalo Montiel y Marcos Acuña en lugar de Nahuel Molina y Nicolás Tagliafico.', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `surname` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `role`) VALUES
(22, 'Facundo', 'Sanchez', 'facujose@gmail.com', '$2y$10$WCzd7mBr0A9GTPZumns1BuQ1wV8chfWIeH4Tf700wxSFaQbcPt.4O', 0),
(23, 'TUDAI', '2021', 'tudai@gmail.com', '$2y$10$Pm6QauIlAJxx2RR2l8ZrDuW.7d698oKRdG2WdoEgDEo.gCHNLJilS', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
