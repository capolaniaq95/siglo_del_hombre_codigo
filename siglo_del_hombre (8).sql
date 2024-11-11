-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 07:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siglo_del_hombre`
--

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `id_autor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`id_autor`, `nombre`, `imagen`) VALUES
(1, 'Gabriel Garcia Marquez', 'https://i.postimg.cc/8cMgH42t/Gabriel-garcia-marquez.jpg'),
(2, 'Isabel Allende', ''),
(3, 'Mario Vargas Llosa', ''),
(4, 'Jorge Luis Borges', ''),
(5, 'Pablo Neruda', ''),
(6, 'Jane Austen', ''),
(7, 'George Orwell', ''),
(8, 'J.K. Rowling', ''),
(9, 'Fyodor Dostoevsky', ''),
(10, 'Carlos Ruiz Zafan', ''),
(11, 'Victor Hugo', ''),
(14, 'Carlos Andres Polania', '');

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `imagen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`, `imagen`) VALUES
(1, 'Novela', ''),
(2, 'Cuento', ''),
(3, 'Poesia', ''),
(4, 'Ensayo', ''),
(5, 'Teatro', ''),
(6, 'drama', ''),
(7, 'Adultos', '');

-- --------------------------------------------------------

--
-- Table structure for table `devolucion`
--

CREATE TABLE `devolucion` (
  `id_devolucion` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` varchar(50) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `fecha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `devolucion`
--

INSERT INTO `devolucion` (`id_devolucion`, `id_pedido`, `motivo`, `descripcion`, `estado`, `referencia`, `fecha`) VALUES
(20, 90, 'libros en mal estado', 'Llegaron mojados', 'Aceptada', 'Pedido90', '2024-09-15T21:16:18'),
(21, 91, 'libros en mal estado', 'mal estado', 'Rechazada', 'Pedido91', '2024-09-15T21:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `editorial` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `libro`
--

INSERT INTO `libro` (`id_libro`, `titulo`, `descripcion`, `editorial`, `imagen`, `precio`, `id_categoria`, `id_autor`, `stock`, `estado`) VALUES
(1, 'El Aleph', 'Cuentos mï¿½gicos y surrealistas', 'Sur', 'https://i.postimg.cc/mDCJfy9L/miserables.jpg', 5500, 2, 4, 6, 'Disponible'),
(2, 'Rayuela', 'Novela experimental', 'Sudamericana', 'https://i.postimg.cc/vH3jsB4V/Rayuela.jpg', 23000, 1, 3, 7, 'Disponible'),
(3, 'Pedro Pï¿½ramo', 'Realismo mï¿½gico en la narrativa mexicana', 'Fondo de Cultura Econï¿½mica', 'https://i.postimg.cc/mkSnhZVK/pedro-paramo.jpg', 12000, 2, 7, 8, 'Disponible'),
(4, 'Crimen y Castigo', 'Novela psicolï¿½gica de Dostoievski', 'Alba Editorial', 'https://i.postimg.cc/MGhNFFv3/crimen-y-castigo.jpg', 30000, 1, 8, 25, 'Disponible'),
(5, 'Don Quijote de la Mancha', 'Obra cumbre de la literatura espaï¿½ola', 'Espasa Calpe', 'https://i.postimg.cc/sgHtpXyr/don-quijote.jpg', 50000, 2, 9, 0, 'No Disponible'),
(6, 'Orgullo y Prejuicio', 'Romance clï¿½sico de Jane Austen', 'Penguin Classics', 'https://i.postimg.cc/1th7HVjL/orgullo-prejuicio.jpg', 10000, 1, 6, 0, 'No Disponible'),
(7, '1984', 'Distopï¿½a futurista de George Orwell', 'Debolsillo', 'https://i.postimg.cc/jSSpwfpc/1984.jpg', 55000, 2, 7, 0, 'No Disponible'),
(8, 'La Sombra del Viento', 'Misterio y literatura en el Barrio Gï¿½tico de Barcelona', 'Planeta', 'https://i.postimg.cc/66VgMzwz/9221003367bb8bc334463a2556e63e24.jpg', 27000, 1, 10, 0, 'No Disponible'),
(9, 'Harry Potter y la Piedra Filosofal', 'Fantasï¿½a juvenil de J.K. Rowling', 'Salamandra', 'https://i.postimg.cc/1th7HVjL/orgullo-prejuicio.jpg', 20000, 2, 8, 0, 'Disponible'),
(10, 'Los Miserables', 'ï¿½pica novela de Victor Hugo', 'Anaya', 'https://i.postimg.cc/jSSpwfpc/1984.jpg', 36000, 1, 10, 0, 'No Disponible'),
(11, 'EnseÃ±ar a luis vagales', 'pruebas', 'panamericana', 'https://i.postimg.cc/Cx52Lg86/sombra-viento.jpg', 15000, 5, 2, 0, 'No Disponible'),
(12, 'Don don quijote', 'purbeas imagen relacional', 'panamericana', 'https://i.postimg.cc/mkfQz9Cm/aleph.jpg', 12050, 1, 1, -1, 'No Disponible');

-- --------------------------------------------------------

--
-- Table structure for table `lineas_devolucion`
--

CREATE TABLE `lineas_devolucion` (
  `id_linea_devolucion` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lineas_devolucion`
--

INSERT INTO `lineas_devolucion` (`id_linea_devolucion`, `id_devolucion`, `cantidad`, `id_libro`) VALUES
(12, 20, 1, 1),
(13, 20, 1, 4),
(14, 21, 1, 1),
(15, 21, 1, 2),
(16, 21, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `linea_de_pedido`
--

CREATE TABLE `linea_de_pedido` (
  `id_linea_de_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total_linea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `linea_de_pedido`
--

INSERT INTO `linea_de_pedido` (`id_linea_de_pedido`, `id_pedido`, `id_libro`, `cantidad`, `total_linea`) VALUES
(110, 90, 1, 2, 11000),
(111, 90, 2, 1, 23000),
(112, 90, 3, 10, 120000),
(113, 90, 4, 5, 150000),
(114, 91, 1, 1, 5500),
(115, 91, 2, 1, 23000),
(116, 91, 12, 1, 12050),
(117, 92, 7, 12, 660000),
(118, 93, 5, 3, 150000),
(119, 94, 2, 2, 46000),
(120, 95, 4, 2, 60000),
(121, 95, 2, 1, 23000),
(122, 96, 9, 4, 80000),
(123, 97, 3, 1, 12000),
(124, 97, 1, 1, 5500),
(125, 98, 8, 2, 54000),
(126, 99, 11, 3, 45000),
(127, 100, 4, 4, 120000);

-- --------------------------------------------------------

--
-- Table structure for table `linea_movimiento_inventario`
--

CREATE TABLE `linea_movimiento_inventario` (
  `id_linea_movimiento` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `linea_movimiento_inventario`
--

INSERT INTO `linea_movimiento_inventario` (`id_linea_movimiento`, `id_movimiento`, `id_libro`, `cantidad`) VALUES
(95, 83, 3, 19),
(96, 83, 1, 9),
(97, 83, 2, 10),
(98, 83, 4, 30),
(99, 84, 1, 1),
(100, 84, 2, 1),
(101, 84, 3, 1),
(102, 84, 4, 1),
(103, 85, 1, 2),
(104, 85, 2, 1),
(105, 85, 3, 10),
(106, 85, 4, 5),
(107, 86, 1, 1),
(108, 86, 4, 1),
(109, 87, 1, 1),
(110, 87, 2, 1),
(111, 87, 12, 1),
(112, 88, 7, 12),
(113, 89, 5, 3),
(114, 90, 2, 2),
(115, 91, 4, 2),
(116, 91, 2, 1),
(117, 92, 9, 4),
(118, 93, 3, 1),
(119, 93, 1, 1),
(120, 94, 8, 2),
(121, 95, 11, 3),
(122, 96, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `metodo_de_pago`
--

CREATE TABLE `metodo_de_pago` (
  `id_metodo_de_pago` int(11) NOT NULL,
  `metodo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `metodo_de_pago`
--

INSERT INTO `metodo_de_pago` (`id_metodo_de_pago`, `metodo`) VALUES
(1, 'Tarjeta de Credito Bancolombia 2'),
(2, 'PayPal'),
(3, 'Transferencia Bancaria'),
(4, 'Efectivo'),
(6, 'bitcoin');

-- --------------------------------------------------------

--
-- Table structure for table `movimiento_inventario`
--

CREATE TABLE `movimiento_inventario` (
  `id_movimiento` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `ubicacion_origen` int(11) NOT NULL,
  `ubicacion_destino` int(11) NOT NULL,
  `tipo_movimiento` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `referencia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `movimiento_inventario`
--

INSERT INTO `movimiento_inventario` (`id_movimiento`, `fecha`, `ubicacion_origen`, `ubicacion_destino`, `tipo_movimiento`, `estado`, `referencia`) VALUES
(83, '2024-09-15 21:08:27', 2, 1, 'entrada', 'Completado', 'AdministradorID'),
(84, '2024-09-15 21:11:50', 1, 3, 'salida', 'Completado', 'AdministradorID'),
(85, '2024-09-15 21:14:00', 1, 3, 'salida', 'Completado', 'Pedido90'),
(86, '2024-09-15 21:18:17', 2, 1, 'entrada', 'Completado', 'Devolucion20'),
(87, '2024-09-15 21:19:48', 1, 3, 'salida', 'Completado', 'Pedido91'),
(88, '2024-10-13 03:58:34', 1, 3, 'salida', 'Proceso', 'Pedido92'),
(89, '2024-10-13 03:59:06', 1, 3, 'salida', 'Proceso', 'Pedido93'),
(90, '2024-10-13 03:59:28', 1, 3, 'salida', 'Proceso', 'Pedido94'),
(91, '2024-10-13 04:00:00', 1, 3, 'salida', 'Proceso', 'Pedido95'),
(92, '2024-10-13 04:00:40', 1, 3, 'salida', 'Proceso', 'Pedido96'),
(93, '2024-10-13 04:01:11', 1, 3, 'salida', 'Proceso', 'Pedido97'),
(94, '2024-10-13 04:01:45', 1, 3, 'salida', 'Proceso', 'Pedido98'),
(95, '2024-10-13 04:02:03', 1, 3, 'salida', 'Proceso', 'Pedido99'),
(96, '2024-10-13 04:02:34', 1, 3, 'salida', 'Proceso', 'Pedido100');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_metodo_de_pago` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `estado` enum('publicado','cancelado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `id_metodo_de_pago`, `fecha`, `total`, `estado`) VALUES
(90, 2, 4, '2024-09-15 21:14:00', 304000, 'publicado'),
(91, 2, 4, '2024-09-15 21:19:48', 40550, 'publicado'),
(92, 2, 1, '2024-10-13 03:58:34', 660000, 'publicado'),
(93, 15, 3, '2024-10-13 03:59:06', 150000, 'publicado'),
(94, 16, 4, '2024-10-13 03:59:28', 46000, 'publicado'),
(95, 17, 6, '2024-10-13 04:00:00', 83000, 'publicado'),
(96, 18, 4, '2024-10-13 04:00:40', 80000, 'publicado'),
(97, 20, 6, '2024-10-13 04:01:11', 17500, 'publicado'),
(98, 21, 2, '2024-10-13 04:01:45', 54000, 'publicado'),
(99, 20, 4, '2024-10-13 04:02:03', 45000, 'publicado'),
(100, 15, 3, '2024-10-13 04:02:34', 120000, 'publicado');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_de_usuario`
--

CREATE TABLE `tipo_de_usuario` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tipo_de_usuario`
--

INSERT INTO `tipo_de_usuario` (`id_tipo`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Table structure for table `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL,
  `ubicacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `ubicacion`) VALUES
(1, 'Stock'),
(2, 'Virtual Vendors'),
(3, 'Virtual Customer');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `celular` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `direccion`, `password`, `rol`, `id_tipo`, `celular`) VALUES
(2, 'Maria Garcia', 'carlos@gmail.com', 'Avenida Siempre Viva 742', '123456', 1, 1, '+57 313232306'),
(15, 'Edgar Polania', 'vagales@gmail.com', 'calle 34', '123456', 2, 2, '+57 3214990480'),
(16, 'luis vagales', 'vagales111111111@gmail.com', 'calle 34', '123456', 2, 2, '+57 3214990480'),
(17, 'Edgar Polania', 'carlos_a95@gmail.com', 'calle 34', '123456', 2, 2, '+57 3214990480'),
(18, 'Carmen', 'carmen@gmail.com', 'calle 23', '12345', 2, 2, '+57 3214990480'),
(19, 'Carmen', 'carmen@gmail.com', 'calle 23', '123456', 2, 2, '+57 3214990480'),
(20, 'cristina', 'cristina@gmail.com', 'diagonal', '123456', 2, 2, '+57 3214990480'),
(21, 'luis vagales', 'cristina@gmail.com', 'dg 62 h bis', '321432', 2, 2, '+57 3214990480');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autor`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`id_devolucion`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indexes for table `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_autor` (`id_autor`);

--
-- Indexes for table `lineas_devolucion`
--
ALTER TABLE `lineas_devolucion`
  ADD PRIMARY KEY (`id_linea_devolucion`),
  ADD KEY `id_devolucion` (`id_devolucion`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `linea_de_pedido`
--
ALTER TABLE `linea_de_pedido`
  ADD PRIMARY KEY (`id_linea_de_pedido`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `linea_movimiento_inventario`
--
ALTER TABLE `linea_movimiento_inventario`
  ADD PRIMARY KEY (`id_linea_movimiento`),
  ADD KEY `id_movimiento` (`id_movimiento`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `metodo_de_pago`
--
ALTER TABLE `metodo_de_pago`
  ADD PRIMARY KEY (`id_metodo_de_pago`);

--
-- Indexes for table `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `ubicacion_origen` (`ubicacion_origen`),
  ADD KEY `ubicacion_destino` (`ubicacion_destino`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_metodo_de_pago` (`id_metodo_de_pago`);

--
-- Indexes for table `tipo_de_usuario`
--
ALTER TABLE `tipo_de_usuario`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lineas_devolucion`
--
ALTER TABLE `lineas_devolucion`
  MODIFY `id_linea_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `linea_de_pedido`
--
ALTER TABLE `linea_de_pedido`
  MODIFY `id_linea_de_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `linea_movimiento_inventario`
--
ALTER TABLE `linea_movimiento_inventario`
  MODIFY `id_linea_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `metodo_de_pago`
--
ALTER TABLE `metodo_de_pago`
  MODIFY `id_metodo_de_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tipo_de_usuario`
--
ALTER TABLE `tipo_de_usuario`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Constraints for table `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autor`);

--
-- Constraints for table `lineas_devolucion`
--
ALTER TABLE `lineas_devolucion`
  ADD CONSTRAINT `lineas_devolucion_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  ADD CONSTRAINT `lineas_devolucion_ibfk_2` FOREIGN KEY (`id_devolucion`) REFERENCES `devolucion` (`id_devolucion`);

--
-- Constraints for table `linea_de_pedido`
--
ALTER TABLE `linea_de_pedido`
  ADD CONSTRAINT `linea_de_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `linea_de_pedido_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`);

--
-- Constraints for table `linea_movimiento_inventario`
--
ALTER TABLE `linea_movimiento_inventario`
  ADD CONSTRAINT `linea_movimiento_inventario_ibfk_1` FOREIGN KEY (`id_movimiento`) REFERENCES `movimiento_inventario` (`id_movimiento`),
  ADD CONSTRAINT `linea_movimiento_inventario_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`);

--
-- Constraints for table `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD CONSTRAINT `movimiento_inventario_ibfk_1` FOREIGN KEY (`ubicacion_origen`) REFERENCES `ubicacion` (`id_ubicacion`),
  ADD CONSTRAINT `movimiento_inventario_ibfk_2` FOREIGN KEY (`ubicacion_destino`) REFERENCES `ubicacion` (`id_ubicacion`);

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_metodo_de_pago`) REFERENCES `metodo_de_pago` (`id_metodo_de_pago`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_de_usuario` (`id_tipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
