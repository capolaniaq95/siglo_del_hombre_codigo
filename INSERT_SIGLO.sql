INSERT INTO `autor` (`nombre`) VALUES
('Gabriel Garcia Marquez'),
('Isabel Allende'),
('Mario Vargas Llosa'),
('Jorge Luis Borges'),
('Pablo Neruda'),
('Jane Austen'),
('George Orwell'),
('J.K. Rowling'),
('Fyodor Dostoevsky'),
('Carlos Ruiz Zafón'),
('Victor Hugo');


INSERT INTO `categoria` (`categoria`) VALUES
('Novela'),
('Cuento'),
('Poesía'),
('Ensayo'),
('Teatro');


INSERT INTO `tipo_de_usuario` (`tipo`) VALUES
('Administrador'),
('Cliente');


INSERT INTO `usuario` (`nombre`, `correo`, `direccion`, `password`, `rol`, `id_tipo`) VALUES
('Juan Perez', 'juan.perez@example.com', 'Calle Falsa 123', 'password123', 1, 1),
('Maria Garcia', 'maria.garcia@example.com', 'Avenida Siempre Viva 742', 'password456', 2, 2);


INSERT INTO `metodo_de_pago` (`metodo`) VALUES
('Tarjeta de Credito'),
('PayPal'),
('Transferencia Bancaria'),
('Efectivo');



INSERT INTO `ubicacion` (`ubicacion`) VALUES
('Almacén Central'),
('Sucursal Norte'),
('Sucursal Sur'),
('Sucursal Este'),
('Sucursal Oeste');


INSERT INTO `devolucion` (`id_linea_de_pedido`, `motivo`) VALUES
(1, 'Producto dañado'),
(2, 'Error en el pedido'),
(3, 'No cumple expectativas'),
(4, 'Producto defectuoso'),
(5, 'Cambio de opinión');



INSERT INTO `libro` (`titulo`, `descripcion`, `editorial`, `imagen`, `stock_minimo`, `precio`, `id_categoria`, `id_autor`) VALUES
('El Aleph', 'Cuentos mágicos y surrealistas', 'Sur', 'aleph.jpg', 10, 25.99, 2, 4),            -- Jorge Luis Borges
('Rayuela', 'Novela experimental', 'Sudamericana', 'rayuela.jpg', 8, 22.50, 1, 3),             -- Mario Vargas Llosa
('Pedro Páramo', 'Realismo mágico en la narrativa mexicana', 'Fondo de Cultura Económica', 'pedro-paramo.jpg', 5, 18.75, 2, 7),  -- Juan Rulfo
('Crimen y Castigo', 'Novela psicológica de Dostoievski', 'Alba Editorial', 'crimen-castigo.jpg', 12, 30.00, 1, 8),               -- Fyodor Dostoevsky
('Don Quijote de la Mancha', 'Obra cumbre de la literatura española', 'Espasa Calpe', 'don-quijote.jpg', 15, 28.50, 2, 9),      -- Miguel de Cervantes
('Orgullo y Prejuicio', 'Romance clásico de Jane Austen', 'Penguin Classics', 'orgullo-prejuicio.jpg', 18, 15.99, 1, 6),         -- Jane Austen
('1984', 'Distopía futurista de George Orwell', 'Debolsillo', '1984.jpg', 20, 12.99, 2, 7),                                     -- George Orwell
('La Sombra del Viento', 'Misterio y literatura en el Barrio Gótico de Barcelona', 'Planeta', 'sombra-viento.jpg', 25, 26.99, 1, 10),  -- Carlos Ruiz Zafón
('Harry Potter y la Piedra Filosofal', 'Fantasía juvenil de J.K. Rowling', 'Salamandra', 'harry-potter.jpg', 30, 19.99, 2, 8),   -- J.K. Rowling
('Los Miserables', 'Épica novela de Victor Hugo', 'Anaya', 'miserables.jpg', 22, 35.50, 1, 10);                                     -- Victor Hugo


INSERT INTO `pedido` (`id_usuario`, `id_metodo_de_pago`, `fecha`, `total`, `estado`) VALUES
(1, 1, '2024-06-01', 163.23, 'publicado'),
(2, 2, '2024-06-02', 98.49, 'publicado'),
(1, 3, '2024-06-03', 82.98, 'publicado'),
(1, 1, '2024-06-04', 134.97, 'publicado'),
(2, 2, '2024-06-05', 96.99, 'publicado'),
(2, 3, '2024-06-06', 98.48, 'publicado'),
(2, 1, '2024-06-07', 61.98, 'publicado'),
(1, 2, '2024-06-08', 72.99, 'publicado'),
(1, 3, '2024-06-09', 72.99, 'publicado'),
(1, 1, '2024-06-10', 45.99, 'publicado');


INSERT INTO `linea_de_pedido` (`id_pedido`, `id_libro`, `cantidad`, `total_linea`) VALUES
(1, 1, 2, 59.98),
(1, 3, 1, 18.75),
(1, 5, 3, 85.50),
(2, 2, 1, 22.50),
(2, 4, 2, 60.00),
(2, 6, 1, 15.99),
(3, 7, 2, 37.50),
(3, 9, 1, 28.50),
(3, 10, 1, 15.99),
(4, 8, 3, 90.00),
(4, 10, 1, 15.99),
(5, 1, 1, 29.99),
(5, 3, 2, 37.50),
(5, 5, 1, 28.50),
(6, 2, 3, 67.50),
(6, 4, 1, 30.00),
(7, 6, 2, 31.98),
(7, 8, 1, 30.00),
(8, 9, 2, 57.00),
(8, 10, 1, 15.99);


INSERT INTO `movimiento_inventario` (`fecha`, `ubicacion_origen`, `ubicacion_destino`, `tipo_movimiento`) VALUES
('2024-06-01', 1, 2, 'entrada'),
('2024-06-02', 2, 3, 'salida'),
('2024-06-03', 3, 1, 'transferencia'),
('2024-06-04', 1, 2, 'entrada'),
('2024-06-05', 2, 3, 'salida'),
('2024-06-06', 3, 1, 'transferencia'),
('2024-06-07', 1, 2, 'entrada'),
('2024-06-08', 2, 3, 'salida'),
('2024-06-09', 3, 1, 'transferencia'),
('2024-06-10', 1, 2, 'entrada');


INSERT INTO `linea_movimiento_inventario` (`id_movimiento`, `id_libro`, `cantidad`) VALUES
(1, 1, 5),
(1, 3, 3),
(1, 5, 2),
(2, 2, 1),
(2, 4, 2),
(2, 6, 1),
(3, 7, 4),
(3, 9, 1),
(3, 10, 2),
(4, 8, 3),
(4, 10, 1),
(5, 1, 2),
(5, 3, 1),
(5, 5, 3),
(6, 2, 2),
(6, 4, 1),
(7, 6, 3),
(7, 8, 1),
(8, 9, 2),
(8, 10, 1),
(9, 1, 4);

