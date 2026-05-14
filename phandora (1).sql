-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307:3307
-- Tiempo de generación: 14-05-2026 a las 17:11:59
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
-- Base de datos: `phandora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_nombre` varchar(255) NOT NULL,
  `producto_precio` decimal(10,2) NOT NULL,
  `producto_imagen` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `estado` enum('activo','comprado') DEFAULT 'activo',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `tipo_entrega` varchar(30) DEFAULT NULL,
  `costo_envio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `producto_nombre`, `producto_precio`, `producto_imagen`, `cantidad`, `estado`, `fecha`, `metodo_pago`, `direccion`, `ciudad`, `codigo_postal`, `total`, `tipo_entrega`, `costo_envio`) VALUES
(1, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-05 19:24:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Hot Cakes', 95.00, 'c4.jpg', 1, 'comprado', '2026-05-05 19:25:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-05 19:34:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-06 01:45:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 2, 'comprado', '2026-05-06 02:21:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, 'Dumplings', 115.00, 'c3.jpg', 1, 'comprado', '2026-05-06 02:29:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-06 15:39:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 2, 'Soju', 120.00, 'p28.jpg', 1, 'comprado', '2026-05-06 15:39:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-11 15:17:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-11 15:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 2, 'Figura de Pikachu en empaque original', 599.00, 'p24.jpg', 1, 'comprado', '2026-05-11 15:18:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-11 16:06:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 15:15:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, 'Figura de Eevee en empaque original', 599.00, 'p25.jpg', 1, 'comprado', '2026-05-12 15:15:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 20:36:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-12 20:56:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-12 22:46:10', 'Tarjeta de crédito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 863.04, NULL, NULL),
(21, 2, 'Hot Cakes', 95.00, 'c4.jpg', 1, 'comprado', '2026-05-12 22:46:10', 'Tarjeta de crédito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 863.04, NULL, NULL),
(22, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:48:36', 'Tarjeta de crédito', '', '', '', 127.60, NULL, NULL),
(23, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:49:11', 'Tarjeta de débito', '', '', '', 127.60, NULL, NULL),
(24, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:51:14', 'Tarjeta de crédito', '', '', '', 127.60, NULL, NULL),
(25, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:52:19', 'Tarjeta de crédito', '', '', '', 127.60, NULL, NULL),
(26, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:56:11', 'Tarjeta de crédito', '', '', '', 127.60, NULL, NULL),
(27, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:56:53', 'Tarjeta de crédito', '', '', '', 127.60, NULL, NULL),
(28, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-12 22:58:23', 'Tarjeta de crédito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 752.84, NULL, NULL),
(29, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 22:58:56', 'Tarjeta de débito', '', '', '', 127.60, NULL, NULL),
(30, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 23:01:18', 'Tarjeta de débito', '', '', '', 127.60, NULL, NULL),
(31, 2, 'Crepa con helado', 110.00, 'crepa.png', 1, 'comprado', '2026-05-12 23:21:11', 'Tarjeta de débito', '', '', '', 127.60, NULL, NULL),
(32, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-12 23:42:25', 'Tarjeta de débito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 1557.88, NULL, NULL),
(33, 2, 'Figura de Pikachu en empaque original', 599.00, 'p24.jpg', 1, 'comprado', '2026-05-12 23:42:25', 'Tarjeta de débito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 1557.88, NULL, NULL),
(34, 2, 'Hot Cakes', 95.00, 'c4.jpg', 1, 'comprado', '2026-05-12 23:42:25', 'Tarjeta de débito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 1557.88, NULL, NULL),
(35, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-12 23:43:08', 'Tarjeta de débito', 'Rafael Iriarte', 'San Franciso de los Romo', '20303', 752.84, NULL, NULL),
(36, 2, 'Dumplings', 115.00, 'c3.jpg', 1, 'comprado', '2026-05-12 23:44:04', 'Tarjeta de débito', '', '', '', 133.40, NULL, NULL),
(37, 2, 'Figura de Mew en empaque original', 649.00, 'p26.jpg', 1, 'comprado', '2026-05-13 15:16:30', 'Tarjeta de débito', 'Rafael Iriarte', 'aaaaaaaaa', '20670', 752.84, NULL, NULL),
(38, 3, 'Gomitas', 35.00, 'g1.jpg', 1, 'comprado', '2026-05-13 15:22:34', 'Tarjeta de débito', '', '', '', 40.60, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `slug`) VALUES
(1, 'Bebidas', 'bebidas'),
(2, 'Comida', 'comida'),
(3, 'Postres', 'postres'),
(4, 'Dulces', 'dulces'),
(5, 'Coleccionables', 'coleccionables');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio`) VALUES
(1, 1, 3, 1, 110.00),
(2, 1, 2, 1, 95.00),
(3, 2, 3, 1, 110.00),
(4, 3, 35, 1, 649.00),
(5, 4, 35, 2, 649.00),
(6, 4, 9, 1, 115.00),
(7, 5, 35, 1, 649.00),
(8, 5, 7, 1, 120.00),
(9, 6, 3, 1, 110.00),
(10, 7, 3, 1, 110.00),
(11, 7, 33, 1, 599.00),
(12, 8, 35, 1, 649.00),
(13, 9, 3, 1, 110.00),
(14, 9, 34, 1, 599.00),
(15, 10, 3, 1, 110.00),
(16, 11, 35, 1, 649.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `calle` varchar(150) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `nombre_envio` varchar(150) DEFAULT NULL,
  `telefono_envio` varchar(30) DEFAULT NULL,
  `direccion_envio` text DEFAULT NULL,
  `ciudad_envio` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `referencias_envio` text DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `impuestos` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagado','enviado','entregado') DEFAULT 'pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `metodo_pago`, `nombre_envio`, `telefono_envio`, `direccion_envio`, `ciudad_envio`, `codigo_postal`, `referencias_envio`, `subtotal`, `impuestos`, `total`, `estado`, `fecha`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 205.00, 'pendiente', '2026-05-05 19:25:22'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 110.00, 'pendiente', '2026-05-05 19:35:01'),
(3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 649.00, 'pendiente', '2026-05-06 01:45:08'),
(4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1413.00, 'pendiente', '2026-05-06 02:29:15'),
(5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 769.00, 'pendiente', '2026-05-06 15:39:22'),
(6, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 110.00, 'pendiente', '2026-05-11 15:17:39'),
(7, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 709.00, 'pendiente', '2026-05-11 15:18:22'),
(8, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 649.00, 'pendiente', '2026-05-11 16:06:58'),
(9, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 709.00, 'pendiente', '2026-05-12 15:15:43'),
(10, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 110.00, 'pendiente', '2026-05-12 20:36:34'),
(11, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 649.00, 'pendiente', '2026-05-12 20:57:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `categoria_id` int(11) DEFAULT NULL,
  `meta_titulo` varchar(160) DEFAULT NULL,
  `meta_descripcion` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('consumible','coleccionable') NOT NULL DEFAULT 'consumible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `slug`, `descripcion`, `precio`, `imagen`, `stock`, `categoria_id`, `meta_titulo`, `meta_descripcion`, `fecha_creacion`, `tipo`) VALUES
(1, 'Crepa', 'crepa', 'Crepa artesanal con frutas frescas y leche condensada.', 89.00, 'c7.jpg', 10, 1, 'Crepa deliciosa', 'Crepa artesanal dulce', '2026-05-05 17:51:04', 'consumible'),
(2, 'Hot Cakes', 'hot-cakes', 'Hot cakes esponjosos con toppings variados.', 95.00, 'c4.jpg', 5, 1, 'Hot Cakes', 'Hot cakes esponjosos', '2026-05-05 17:51:04', 'consumible'),
(3, 'Crepa con helado', 'crepa-helado', 'Crepa dulce con helado y frutas frescas.', 110.00, 'crepa.png', 1, 1, 'Crepa con helado', 'Postre frío y dulce', '2026-05-05 17:51:04', 'consumible'),
(4, 'Jugo Chupa Chups', 'jugo-chupa-chups', 'Bebida dulce inspirada en Chupa Chups.', 45.00, 'jugo.png', 15, 2, 'Jugo Chupa Chups', 'Bebida frutal dulce', '2026-05-05 17:51:04', 'consumible'),
(5, 'Prime bebida hidratante', 'prime', 'Bebida hidratante con sabores intensos.', 65.00, 'c6.jpg', 15, 2, 'Prime bebida', 'Bebida energética', '2026-05-05 17:51:04', 'consumible'),
(6, 'Jugo sabor frutal', 'jugo-frutal', 'Jugos naturales de sabores frutales.', 38.00, 'p27.jpg', 15, 2, 'Jugo frutal', 'Bebida natural', '2026-05-05 17:51:04', 'consumible'),
(7, 'Soju', 'soju', 'Bebida coreana suave y refrescante.', 120.00, 'p28.jpg', 10, 2, 'Soju', 'Bebida alcohólica coreana', '2026-05-05 17:51:04', 'consumible'),
(8, 'Ramen', 'ramen', 'Ramen japonés con caldo profundo.', 145.00, 'c5.jpg', 10, 3, 'Ramen', 'Ramen japonés', '2026-05-05 17:51:04', 'consumible'),
(9, 'Dumplings', 'dumplings', 'Dumplings tradicionales orientales.', 115.00, 'c3.jpg', 9, 3, 'Dumplings', 'Botana oriental', '2026-05-05 17:51:04', 'consumible'),
(10, 'Ramen instantáneo', 'ramen-instantaneo', 'Ramen rápido y delicioso.', 52.00, 'c2.jpg', 20, 3, 'Ramen instantáneo', 'Rápido y práctico', '2026-05-05 17:51:04', 'consumible'),
(11, 'Gomitas', 'gomitas', 'Gomitas frutales suaves.', 35.00, 'g1.jpg', 29, 4, 'Gomitas', 'Dulces frutales', '2026-05-05 17:51:04', 'consumible'),
(12, 'Pocky', 'pocky', 'Palitos cubiertos de chocolate.', 55.00, 'g2.jpg', 30, 4, 'Pocky', 'Snack japonés', '2026-05-05 17:51:04', 'consumible'),
(13, 'Chocolate MrBeast', 'chocolate-mrbeast', 'Chocolate premium.', 78.00, 'g4.jpg', 20, 4, 'Chocolate MrBeast', 'Chocolate premium', '2026-05-05 17:51:04', 'consumible'),
(14, 'Oreo Cakesters', 'oreo-cakesters', 'Snack suave tipo pastel.', 62.00, 'g6.jpg', 20, 4, 'Oreo Cakesters', 'Snack Oreo', '2026-05-05 17:51:04', 'consumible'),
(15, 'Scooby Galletas', 'scooby-galletas', 'Galletas divertidas Scooby.', 40.00, 'g5.jpg', 25, 4, 'Scooby Galletas', 'Galletas clásicas', '2026-05-05 17:51:04', 'consumible'),
(16, 'Figura The Legend Of Zelda', 'figura-zelda', 'Figura de Link con espada maestra y escudo Hyliano. Ideal para fans de la saga y para exhibición.', 699.00, 'ejemplo.png', 10, 5, 'Figura Zelda', 'Figura coleccionable Zelda', '2026-05-05 18:03:11', 'coleccionable'),
(17, 'Figura Dragon Ball', 'figura-dragon-ball', 'Figura de Krillin con su uniforme clásico de combate y detalles inspirados en el anime.', 549.00, 'f2.png', 10, 5, 'Figura Dragon Ball', 'Figura coleccionable DB', '2026-05-05 18:03:11', 'coleccionable'),
(18, 'Figuras Kimetsu No Yaiba', 'figuras-kimetsu', 'Set de figuras de personajes de Kimetsu No Yaiba, perfecto para coleccionistas.', 799.00, 'p5.jpg', 10, 5, 'Figuras Kimetsu', 'Set coleccionable Kimetsu', '2026-05-05 18:03:11', 'coleccionable'),
(19, 'Bolsa de Pikachu', 'bolsa-pikachu', 'Bolsa inspirada en Pikachu con diseño vibrante, cómoda para uso diario.', 399.00, 'p10.jpg', 10, 5, 'Bolsa Pikachu', 'Accesorio coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(20, 'Peluche de Charizard', 'peluche-charizard', 'Peluche suave de Charizard con detalles de alas y cola, ideal para regalar.', 449.00, 'p11.jpg', 10, 5, 'Peluche Charizard', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(21, 'Peluches de Stitch', 'peluche-stitch', 'Peluches de Stitch suaves y adorables, ideales para fans de Disney.', 349.00, 'p12.jpg', 10, 5, 'Peluche Stitch', 'Coleccionable Disney', '2026-05-05 18:03:11', 'coleccionable'),
(22, 'Mochila Baphy', 'mochila-baphy', 'Mochila con diseño alternativo y acabados resistentes para uso diario.', 599.00, 'p13.jpg', 10, 5, 'Mochila Baphy', 'Coleccionable alternativo', '2026-05-05 18:03:11', 'coleccionable'),
(23, 'Peluche de Lapras', 'peluche-lapras', 'Peluche de Lapras con acabado suave y diseño inspirado en Pokémon.', 429.00, 'p14.jpg', 10, 5, 'Peluche Lapras', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(24, 'Figura de Bulbasaur', 'figura-bulbasaur', 'Figura de Bulbasaur con detalles fieles al personaje, ideal para colección.', 499.00, 'p15.jpg', 10, 5, 'Figura Bulbasaur', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(25, 'Llavero de One Piece', 'llavero-one-piece', 'Llavero inspirado en One Piece, práctico y perfecto para acompañarte a diario.', 149.00, 'p16.jpg', 10, 5, 'Llavero One Piece', 'Coleccionable anime', '2026-05-05 18:03:11', 'coleccionable'),
(26, 'Reloj de El Extraño Mundo de Jack', 'reloj-jack', 'Reloj temático con diseño de Jack Skellington y estilo distintivo.', 699.00, 'p17.jpg', 10, 5, 'Reloj Jack', 'Coleccionable Disney', '2026-05-05 18:03:11', 'coleccionable'),
(27, 'Figuras de Death Note', 'figuras-death-note', 'Figuras de L y Light Yagami inspiradas en el universo de Death Note.', 849.00, 'p18.jpg', 10, 5, 'Death Note figuras', 'Coleccionable anime', '2026-05-05 18:03:11', 'coleccionable'),
(28, 'Figuras de South Park', 'figuras-south-park', 'Set de figuras de South Park con personajes clásicos de la serie.', 749.00, 'p19.jpg', 10, 5, 'South Park figuras', 'Coleccionable serie', '2026-05-05 18:03:11', 'coleccionable'),
(29, 'Figuras de Naruto', 'figuras-naruto', 'Colección de figuras de Naruto, Sasuke y otros personajes icónicos.', 799.00, 'p20.jpg', 10, 5, 'Naruto figuras', 'Coleccionable anime', '2026-05-05 18:03:11', 'coleccionable'),
(30, 'Figura de Ryuk', 'figura-ryuk', 'Figura del shinigami Ryuk con detalles oscuros y gran presencia visual.', 649.00, 'p21.jpg', 10, 5, 'Ryuk figura', 'Coleccionable Death Note', '2026-05-05 18:03:11', 'coleccionable'),
(31, 'Cartas Pokémon', 'cartas-pokemon', 'Sobres de cartas Pokémon con variedad de cartas para jugar o coleccionar.', 129.00, 'p22.jpg', 10, 5, 'Cartas Pokémon', 'TCG coleccionable', '2026-05-05 18:03:11', 'coleccionable'),
(32, 'Figura de Gengar en empaque original', 'figura-gengar', 'Figura de Gengar en empaque original, excelente para colección.', 599.00, 'p23.jpg', 10, 5, 'Gengar figura', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(33, 'Figura de Pikachu en empaque original', 'figura-pikachu', 'Figura de Pikachu con empaque original, ideal para fans de Pokémon.', 599.00, 'p24.jpg', 9, 5, 'Pikachu figura', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(34, 'Figura de Eevee en empaque original', 'figura-eevee', 'Figura de Eevee con empaque original y detalles de colección.', 599.00, 'p25.jpg', 10, 5, 'Eevee figura', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable'),
(35, 'Figura de Mew en empaque original', 'figura-mew', 'Figura de Mew en empaque original, pieza especial para coleccionistas.', 649.00, 'p26.jpg', 2, 5, 'Mew figura', 'Coleccionable Pokémon', '2026-05-05 18:03:11', 'coleccionable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Admin', 'admin@phandora.com', '$2y$10$pkiM1lQ2dswRXKGLZVPqA.F1YH.NQqdtKN4YnJQFqA4jGUPeM0Mba', 'admin', '2026-05-05 05:17:07'),
(2, 'vane', 'vanessacr1402@gmail.com', '$2y$10$u/zuzWX1nxPAExfaS/ZvW.4mRuOvFFF7G1Hfpeunz0MlFz4M.K.BK', 'cliente', '2026-05-05 16:18:29'),
(3, 'AdanMoka', 'adanriox@gmail.com', '$2y$10$pUqZ7Vxy5VhbVrswSVxMtuNCEeQIFVKdOxMWAslr6f1Dz/Z4d5RKa', 'cliente', '2026-05-13 15:20:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
