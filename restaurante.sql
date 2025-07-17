-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2023 a las 22:11:41
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

CREATE DATABASE restaurante;
USE restaurante;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `direccion` text NOT NULL,
  `mensaje` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `nombre`, `telefono`, `email`, `direccion`, `mensaje`) VALUES
(1, 'Café Buenísimo', '957847894', 'CafeBuenisimo@gmail.com', 'Tacna', 'Gracias por la compra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `nombre`, `precio`, `cantidad`, `id_pedido`) VALUES
(1, 'CAFE MOCHA', '10.00', 1, 1),
(2, 'TORTA DE CHOCOLATE', '25.00', 1, 1),
(3, 'CAFE AMERICANO', '8.00', 3, 1),
(4, 'TORTA DE CHOCOLATE', '25.00', 1, 2),
(5, 'CAFE AMERICANO', '8.00', 1, 2),
(6, 'CAFE MOCHA', '10.00', 1, 3),
(7, 'TORTA DE CHOCOLATE', '25.00', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `num_mesa` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `observacion` text DEFAULT NULL,
  `estado` enum('PENDIENTE','FINALIZADO') NOT NULL DEFAULT 'PENDIENTE',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_sala`, `num_mesa`, `fecha`, `total`, `observacion`, `estado`, `id_usuario`) VALUES
(1, 1, 1, '2023-05-25 20:03:27', '59.00', '', 'FINALIZADO', 1),
(2, 3, 3, '2023-05-25 20:03:43', '33.00', '', 'FINALIZADO', 1),
(3, 3, 5, '2023-05-25 20:04:17', '10.00', '', 'FINALIZADO', 1),
(4, 2, 10, '2023-05-25 20:03:11', '25.00', '', 'PENDIENTE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL ,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `platos`
--

-- Primero, añadimos el campo 'categoria' a la tabla 'platos'
ALTER TABLE `platos`
  ADD COLUMN `categoria` int(11) NOT NULL DEFAULT 1;

-- Ahora, creamos la nueva tabla 'categorias'
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Insertamos algunos valores en la tabla 'categorias'
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Bebidas', 'Bebidas calientes y frías'),
(2, 'Postres', 'Postres y dulces'),
(3, 'Comidas', 'Comidas y platos principales');

-- Insertamos algunos valores de ejemplo en la tabla 'platos', con la categoría asignada
INSERT INTO `platos` (`id`, `nombre`, `precio`, `imagen`, `fecha`, `estado`, `categoria`) VALUES
(1, 'CAFE MOCHA', '10.00', '', NULL, 1, 1),
(2, 'TORTA DE CHOCOLATE', '25.00', '', NULL, 1, 2),
(3, 'CAFE AMERICANO', '8.00', '', NULL, 1, 1),
(4, 'CAFÉ CAPPUCCINO', '12.00', '', NULL, 1, 1),
(5, 'LATTE VAINILLA', '15.00', '', NULL, 1, 1),
(6, 'MOKACCINO', '14.00', '', NULL, 1, 1),
(7, 'TÉ VERDE', '10.00', '', NULL, 1, 1),
(8, 'SANDWICH CLUB', '18.00', '', NULL, 1, 3),
(9, 'MUFFIN DE ARÁNDANOS', '8.00', '', NULL, 1, 2),
(10, 'CROISSANT DE MANTEQUILLA', '10.00', '', NULL, 1, 2),
(11, 'JUGO DE NARANJA NATURAL', '12.00', '', NULL, 1, 1),
(12, 'CHOCOLATE CALIENTE', '14.00', '', NULL, 1, 1),
(13, 'TARTA DE LIMÓN', '20.00', '', NULL, 1, 2),
(14, 'EMPANADA DE POLLO', '15.00', '', NULL, 1, 3),
(15, 'PANQUEQUES CON MIEL', '22.00', '', NULL, 1, 3),
(16, 'FRAPPUCCINO DE CARAMELLO', '16.00', '', NULL, 1, 1),
(17, 'TARTA DE MANZANA', '18.00', '', NULL, 1, 2),
(18, 'BAGEL CON QUESO CREMA', '14.00', '', NULL, 1, 3),
(19, 'ENSALADA DE FRUTAS', '15.00', '', NULL, 1, 3),
(20, 'MOUSSE DE CHOCOLATE', '22.00', '', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `mesas` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`id`, `nombre`, `mesas`, `estado`) VALUES
(1, 'SEDE PRINCIPAL', 15, 1),
(2, 'SEDE SANTA ROSA', 10, 1),
(3, 'SEDE NATIVIDAD', 8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_pedidos`
--

CREATE TABLE `temp_pedidos` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `pass`, `rol`, `estado`) VALUES
(1, 'Marcos Huayna', 'admin@gmail.com', 'admin123', 1, 1),
(2, 'Bryan Huanacuni', 'Huanacuni@gmail.com', 'huanacuni123', 5, 1);
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sala` (`id_sala`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`);

CREATE TABLE links_pago (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_plato INT NOT NULL,
  url VARCHAR(255) NOT NULL,
  FOREIGN KEY (id_plato) REFERENCES platos(id)
);

INSERT INTO links_pago (id_plato, url) VALUES
(1, 'https://buy.stripe.com/test_dRm7sE4kK4CY9IUbeCc7u01'),
(2, 'https://buy.stripe.com/test_bJecMYeZoc5qaMY0zYc7u02'),
(3, 'https://buy.stripe.com/test_fZu5kweZob1m2gseqOc7u03'),
(4, 'https://buy.stripe.com/test_9B65kw8B04CY3kwbeCc7u04'),
(5, 'https://buy.stripe.com/test_00w28kcRg4CYaMYeqOc7u05'),
(6, 'https://buy.stripe.com/test_cNi4gs7wW7PaaMY96uc7u06'),
(7, 'https://buy.stripe.com/test_3cI28k5oO5H23kwbeCc7u07'),
(8, 'https://buy.stripe.com/test_cNi7sE2cC3yU6wI6Ymc7u08'),
(9, 'https://buy.stripe.com/test_fZu4gs4kKedyaMY82qc7u09'),
(10, 'https://buy.stripe.com/test_3cI3co3gGb1m08kaayc7u0a'),
(11, 'https://buy.stripe.com/test_28E28k4kK4CYdZa2I6c7u0b'),
(12, 'https://buy.stripe.com/test_9B6cMY8B0b1m4oA2I6c7u0c'),
(13, 'https://buy.stripe.com/test_00w00c2cC8Teg7ibeCc7u0d'),
(14, 'https://buy.stripe.com/test_7sY8wI7wWedy08kbeCc7u0e'),
(15, 'https://buy.stripe.com/test_cNi7sEaJ89Xi5sE82qc7u0f'),
(16, 'https://buy.stripe.com/test_3cI6oAg3s9Xif3e4Qec7u0g'),
(17, 'https://buy.stripe.com/test_eVq8wIaJ83yUaMYgyWc7u0h'),
(18, 'https://buy.stripe.com/test_7sY8wI18y4CYaMYdmKc7u0i'),
(19, 'https://buy.stripe.com/test_fZubIUcRg1qM9IU4Qec7u0j'),
(20, 'https://buy.stripe.com/test_fZuaEQ4kK2uQf3e4Qec7u00');


--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temp_pedidos`
--
ALTER TABLE `temp_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);


-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Reajustamos los AUTO_INCREMENT para las nuevas tablas
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Reajustamos los AUTO_INCREMENT de las tablas modificadas
ALTER TABLE `platos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `temp_pedidos`
--
ALTER TABLE `temp_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Añadimos una clave foránea a la tabla 'platos' que referencia la tabla 'categorias'
ALTER TABLE `platos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`);


-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
