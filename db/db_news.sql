-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2021 a las 00:44:50
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
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `points` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_news` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `comment`, `points`, `date`, `id_news`, `id_users`) VALUES
(255, 'asxasxx', 1, '2021-11-12 20:42:20', 114, 22),
(260, 'el diegote', 4, '2021-11-13 18:19:54', 114, 22),
(280, 'JAJAJ', 2, '2021-11-16 14:15:48', 130, 22),
(281, 'xd', 1, '2021-11-16 14:21:22', 130, 22),
(283, 'a', 1, '2021-11-16 14:25:57', 130, 22),
(284, 'aaa', 4, '2021-11-16 14:31:57', 130, 54),
(285, 'ADAD', 1, '2021-11-16 14:32:18', 114, 54),
(286, 'xd', 1, '2021-11-16 18:02:05', 130, 22),
(294, 'a', 1, '2021-11-17 21:54:33', 134, 22),
(295, 'holi', 1, '2021-11-17 21:54:55', 134, 54),
(298, 'xdxdxd', 1, '2021-11-21 19:57:29', 134, 22),
(299, 'ax', 4, '2021-11-21 19:57:41', 134, 22),
(300, 'holis', 1, '2021-11-21 23:41:46', 134, 22),
(301, 'axasd', 1, '2021-11-21 23:41:49', 134, 22),
(302, 'a', 1, '2021-11-22 00:27:10', 134, 54),
(303, 'xd', 4, '2021-11-22 00:27:14', 134, 54),
(329, 'f', 1, '2021-11-22 20:35:42', 136, 22),
(330, 'a', 1, '2021-11-22 20:35:55', 136, 22),
(343, 'AA', 1, '2021-11-22 20:43:12', 136, 22),
(344, 'a', 5, '2021-11-22 20:43:19', 136, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(50) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `img`, `id_category`) VALUES
(2, 'Otra noticia', 'Porque puedo', '', 1),
(3, 'probando1', 'holi', '', 1),
(6, 'ajax', '1', '', 1),
(9, 'sad', '1', '', 4),
(12, 'tp web', '1', '', 1),
(13, 'QUIERO DORMIR', 'JUJU', '', 2),
(17, 'probando ajax con tpl', 'a', '', 3),
(20, 'Esta muy pero muy mal', 'juju', '', 3),
(68, 'aasdasdasd', '1', '', 5),
(75, 'Del potro volve', 'por favor', '', 51),
(77, 'Las dudas son laterales', 'En Ezeiza se respira más tranquilidad que nunca. Esta Selección generó y consiguió disfrutar hasta de cada entrenamiento. El domingo ante un rival durísimo como Uruguay deleitó al público que fue al Monumental y al hincha que se enganchó con este equipo campeón que va por más. Con un invicto de 24 partidos y con buena diferencia en las Eliminatorias, hay ganas de que no se corte y Argentina siga haciendo Lio.\r\n\r\nEste jueves, a las 20.30, ante Perú, será la oportunidad para extender este buen momento que generó tanta ilusión como ganas de ver a un equipo que desesperó a la gente: nuevamente agotó las entradas disponibles para ir al Monumental. Con Lionel Messi a la cabeza, el equipo será muy parecido al que goleó a la Celeste. El otro Lionel, el Scaloni que también se llevó aplausos y cantos del público, piensa en modificaciones en los laterales. Allí, donde los nombres son totalmente parejos en la consideración del DT, esta vez la oportunidad podría ser para Gonzalo Montiel y Marcos Acuña en lugar de Nahuel Molina y Nicolás Tagliafico.', '', 2),
(95, 'fa', 'a', '', 3),
(97, 'asd', 'sad', 'images/news/6185a77ad6d52.jpg', 1),
(98, 'a', 'a', 'images/news/6185a90bdc24d.jpg', 2),
(99, 'f', 'f', 'images/news/6185a9129ec1f.png', 51),
(100, 'fasdsad', 'fasdasdasd', 'images/news/6185a91b1cbe6.jpg', 3),
(101, 'as', 'a', 'images/news/6185ac37ec02d.jpg', 4),
(102, 'as', 'a', 'images/news/6185ac40b51e0.jpg', 4),
(103, 'a', 'a', 'images/news/6185ac795d823.jpg', 2),
(104, 'a', 'a', '', 1),
(109, 'a', 'a', '', 1),
(111, 'afasdasdsa', 'a', '', 5),
(112, 'A', 'A', 'images/news/6185b475b29e6.png', 2),
(113, 'F', 'A', '', 1),
(114, 'FASDAAAAA', 'SADASD', 'images/news/618ef8d0d450b.jpg', 1),
(130, 'a', 'a', '', 1),
(134, '37sur', 'a', 'images/news/619c288dad355.png', 1),
(136, 'x', 'x', '', 5);

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
(22, 'Facundo', 'Sanchez', 'facujose@gmail.com', '$2y$10$WCzd7mBr0A9GTPZumns1BuQ1wV8chfWIeH4Tf700wxSFaQbcPt.4O', 1),
(23, 'TUDAI', '2021', 'tudai@gmail.com', '$2y$10$Pm6QauIlAJxx2RR2l8ZrDuW.7d698oKRdG2WdoEgDEo.gCHNLJilS', 1),
(54, 'a', 'a', 'a@gmail.com', '$2y$10$kO7kY3MA7Qhm4XJDe02c6OFj6kBTWU2q.rWNiSdNggKNX.UgVMr.q', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_news` (`id_news`),
  ADD KEY `id_user` (`id_users`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_news`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
