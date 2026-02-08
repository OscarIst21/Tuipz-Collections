-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2025 a las 23:52:02
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
-- Base de datos: `catalogo_tuipz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` enum('Pines','Kit lienzos','Kit figuras yeso','Figuras de yeso') NOT NULL,
  `stock` int(11) DEFAULT 0,
  `imagen` varchar(500) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `precio`, `categoria`, `stock`, `imagen`, `fecha_creacion`) VALUES
(1, 'PIN001', 'Sin Rostro 1', 'Hermoso pin decorativo de Sin Rostro de Un Viaje de Chihiro.', 50.00, 'Pines', 50, 'img/pines/sinRostro_01.jpg', '2025-07-22 17:19:29'),
(2, 'PIN002', 'Sin Rostro 2', 'Hermoso pin decorativo de Sin Rostro de Un Viaje de Chihiro.', 50.00, 'Pines', 35, 'img/pines/sinRostro_02.jpg', '2025-07-22 17:19:29'),
(3, 'PIN003', 'Sin Rostro 3', 'Hermoso pin decorativo de Sin Rostro de Un Viaje de Chihiro.', 50.00, 'Pines', 25, 'img/pines/sinRostro_03.jpg', '2025-07-22 17:19:29'),
(4, 'PIN004', 'Spiderman 1', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 40, 'img/pines/spiderman_01.jpg', '2025-07-22 17:19:29'),
(5, 'PIN005', 'Spiderman 2', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 30, 'img/pines/spiderman_02.jpg', '2025-07-22 17:19:29'),
(6, 'PIN006', 'Spiderman 3', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 45, 'img/pines/spiderman_03.jpg', '2025-07-22 17:19:29'),
(7, 'PIN007', 'Spiderman 4', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 55, 'img/pines/spiderman_04.jpg', '2025-07-22 17:19:29'),
(8, 'PIN008', 'Spiderman 5', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 20, 'img/pines/spiderman_05.jpg', '2025-07-22 17:19:29'),
(9, 'PIN009', 'Spiderman 6', '¡El héroe favorito de Nueva York ahora en un pin! Perfecto para mochilas, gorras o tu colección Marvel.', 50.00, 'Pines', 35, 'img/pines/spiderman_03.jpg', '2025-07-22 17:19:29'),
(10, 'PIN010', 'Pac-man', 'Pin de Pac-Man. Ideal para los amantes de videojuegos retro.', 50.00, 'Pines', 15, 'img/pines/pacman.jpg', '2025-07-22 17:19:29'),
(11, 'PIN011', 'Fantasma de Pac-man 1', 'Pin de fantasma rosa de Pac-Man. Ideal para los amantes de videojuegos retro.', 50.00, 'Pines', 25, 'img/pines/pacmanRosa.jpg', '2025-07-22 17:19:29'),
(12, 'PIN012', 'Fantasma de Pac-man 2', 'Pin de fantasma rojo de Pac-Man. Ideal para los amantes de videojuegos retro.', 50.00, 'Pines', 15, 'img/pines/pacmanRojo.jpg', '2025-07-22 17:19:29'),
(13, 'PIN013', 'Fantasma de Pac-man 3', 'Pin de fantasma azul de Pac-Man. Ideal para los amantes de videojuegos retro.', 50.00, 'Pines', 20, 'img/pines/pacmanAzul.jpg', '2025-07-22 17:19:29'),
(14, 'PIN014', 'Fantasma de Pac-man 4', 'Pin de fantasma naranja de Pac-Man. Ideal para los amantes de videojuegos retro.', 50.00, 'Pines', 10, 'img/pines/pacmanNaranja.jpg', '2025-07-22 17:19:29'),
(15, 'PIN015', 'Stitch 1', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 30, 'img/pines/stitch_01.jpg', '2025-07-22 17:19:29'),
(16, 'PIN016', 'Stitch 2', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 18, 'img/pines/stitch_02.jpg', '2025-07-22 17:19:29'),
(17, 'PIN017', 'Stitch 3', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 12, 'img/pines/stitch_03.jpg', '2025-07-22 17:19:29'),
(18, 'PIN018', 'Stitch 4', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 22, 'img/pines/stitch_04.jpg', '2025-07-22 17:19:29'),
(19, 'PIN019', 'Stitch 5', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 28, 'img/pines/stitch_05.jpg', '2025-07-22 17:19:29'),
(20, 'PIN020', 'Stitch 6', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 8, 'img/pines/stitch_06.jpg', '2025-07-22 17:19:29'),
(21, 'PIN021', 'Stitch 7', 'Adorable pin de Stitch. Ideal para mochilas.', 50.00, 'Pines', 1, 'img/pines/stitch_07.jpg', '2025-07-23 05:05:19'),
(22, 'PIN022', 'Hello Kitty 1', 'Tierno pin de Hello Kitty, elegante para mochilas, ropas y accesorios.', 50.00, 'Pines', 1, 'img/pines/helloKitty_1.png', '2025-07-23 05:06:45'),
(23, 'PIN023', 'Hello Kitty 2', 'Tierno pin de Hello Kitty, elegante para mochilas, ropas y accesorios.', 50.00, 'Pines', 1, 'img/pines/helloKitty_02.png', '2025-07-23 05:06:45'),
(24, 'PIN024', 'Hello Kitty 3', 'Tierno pin de Hello Kitty, elegante para mochilas, ropas y accesorios.', 50.00, 'Pines', 1, 'img/pines/helloKitty_03.png', '2025-07-23 05:08:13'),
(25, 'PIN025', 'Hello Kitty 4', 'Tierno pin de Hello Kitty, elegante para mochilas, ropas y accesorios.', 50.00, 'Pines', 1, 'img/pines/helloKitty_04.png', '2025-07-23 05:08:30'),
(26, 'PIN026', 'Hello Kitty 5', 'Tierno pin de Hello Kitty, elegante para mochilas, ropas y accesorios.', 50.00, 'Pines', 1, 'img/pines/helloKitty_05.png', '2025-07-23 05:08:41'),
(27, 'PIN027', 'Kuromi 1', 'Pin con colgante de Kuromi, el mix perfecto entre ternura y travesura. Ideal para mochilas, chamarras o tu estante kawaii.', 50.00, 'Pines', 1, 'img/pines/kuromi_01.jpg', '2025-07-23 05:09:19'),
(28, 'PIN028', 'Kuromi 2', 'Pin con colgante de Kuromi, el mix perfecto entre ternura y travesura. Ideal para mochilas, chamarras o tu estante kawaii.', 50.00, 'Pines', 1, 'img/pines/kuromi_02.jpg', '2025-07-23 05:10:52'),
(29, 'PIN029', 'Kuromi 3', 'Pin con colgante de Kuromi, el mix perfecto entre ternura y travesura. Ideal para mochilas, chamarras o tu estante kawaii.', 50.00, 'Pines', 1, 'img/pines/kuromi_03.jpg', '2025-07-23 05:10:52'),
(30, 'PIN030', 'Kuromi 4', 'Pin con colgante de Kuromi, el mix perfecto entre ternura y travesura. Ideal para mochilas, chamarras o tu estante kawaii.', 50.00, 'Pines', 1, 'img/pines/kuromi_04.jpg', '2025-07-23 05:10:52'),
(31, 'PIN031', 'Kuromi 5', 'Pin con colgante de Kuromi, el mix perfecto entre ternura y travesura. Ideal para mochilas, chamarras o tu estante kawaii.', 50.00, 'Pines', 1, 'img/pines/kuromi_05.jpg', '2025-07-23 05:10:52'),
(32, 'PIN032', 'Gojo 1', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_01.jpg', '2025-07-23 05:14:57'),
(33, 'PIN033', 'Gojo 2', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_02.jpg', '2025-07-23 05:14:57'),
(34, 'PIN034', 'Gojo 3', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_03.jpg', '2025-07-23 05:14:57'),
(35, 'PIN035', 'Gojo 4', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_04.jpg', '2025-07-23 05:14:57'),
(36, 'PIN036', 'Gojo 5', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_05.jpg', '2025-07-23 05:14:57'),
(37, 'PIN037', 'Gojo 6', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_06.jpg', '2025-07-23 05:14:57'),
(38, 'PIN038', 'Gojo 7', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_07.jpg', '2025-07-23 05:14:57'),
(39, 'PIN039', 'Gojo 8', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_08.jpg', '2025-07-23 05:14:57'),
(40, 'PIN040', 'Gojo 9', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_09.jpg', '2025-07-23 05:14:57'),
(41, 'PIN041', 'Gojo 10', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_10.jpg', '2025-07-23 05:14:57'),
(42, 'PIN042', 'Gojo 11', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_11.jpg', '2025-07-23 05:14:57'),
(43, 'PIN043', 'Gojo 12', 'Pin metálico de Satoru Gojo. Perfecto para darle estilo a tu mochila, ropa o colección. ¡Edición limitada para fans de Jujutsu Kaisen!', 50.00, 'Pines', 1, 'img/pines/gojo_12.jpg', '2025-07-23 05:14:57'),
(45, 'YESO002', 'Kit Osito 01', 'Incluye una figura de osito grande y 2 figuras mini de vehículos, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 25, 'img/yesos/oso.jpg', '2025-07-22 17:19:29'),
(46, 'YESO003', 'Kit Osito 02', 'Incluye una figura de osito grande y 2 figuras mini de vehículos, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 15, 'img/yesos/oso2.jpg', '2025-07-22 17:19:29'),
(47, 'YESO004', 'Kit princesa', 'Incluye una corona y 2 figuras mini de naturaleza, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 30, 'img/yesos/corona2.jpg', '2025-07-22 17:19:29'),
(48, 'YESO005', 'Kit Hello Kitty', 'Incluye una figura de Hello kitty, 3 mini figuras variadas, hasta 3 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 35, 'img/yesos/hellokitty.jpg', '2025-07-22 17:19:29'),
(61, 'YESO006', 'Kit León', 'Incluye una figura de león, 2 figuras mini, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 1, 'img/yesos/leon.jpg', '2025-07-24 17:59:42'),
(63, 'YESO007', 'Kit Hipopótamo', 'Incluye una figura de hipopótamo, 2 figuras mini, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 1, 'img/yesos/hipopotamo.jpg', '2025-07-24 18:02:52'),
(64, 'YESO008', 'Kit Unicornio', 'Incluye una figura de unicornio, 2 figuras mini, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 1, 'img/yesos/unicornio.jpg', '2025-07-24 18:02:52'),
(65, 'YESO009', 'Kit Lego', 'Incluye una figura grande de Lego, 2 figuras mini, hasta 4 pinturas lavables y un pincel.', 40.00, 'Kit figuras yeso', 1, 'img/yesos/lego.jpg', '2025-07-24 18:02:52'),
(66, 'YESO010', 'Kit Dinosaurio', 'Incluye una figura grande de dinosaurio, 2 figuras mini, hasta 4 pinturas lavables y un pincel.', 60.00, 'Kit figuras yeso', 1, 'img/yesos/dinosaurio.jpg', '2025-07-24 18:02:52'),
(67, 'PIN044', 'Pines de Animales', 'Variedad de pines de animales. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/animales.png', '2025-07-24 18:23:55'),
(69, 'PIN046', 'Pines de Frutas', 'Variedad de pines de frutas. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/frutas.png', '2025-07-24 18:26:01'),
(70, 'PIN047', 'Pines de Bebidas', 'Variedad de pines de bebidas. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/bebidas.png', '2025-07-24 18:26:01'),
(71, 'PIN048', 'Pines de Plantas', 'Variedad de pines de plantas. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/plantas.png', '2025-07-24 18:26:01'),
(72, 'PIN049', 'Pines de Naturaleza', 'Variedad de pines de naturaleza. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/naturaleza.png', '2025-07-24 18:26:01'),
(73, 'PIN051', 'Pines de Accesorios', 'Variedad de pines de accesorios. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/accesorios.png', '2025-07-24 18:26:01'),
(74, 'PIN050', 'Pines variados', 'Variedad de pines. Se venden por separado.', 40.00, 'Pines', 1, 'img/pines/varios.png', '2025-07-24 18:26:01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idx_categoria` (`categoria`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_codigo` (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
