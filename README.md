# SIGLO DEL HOMBRE

## SISTEMA DE GESTION PARA EL INVENTARIO Y VENTAS ONLLINE DE LA LIBRERIA SIGLO DEL HOMBRE EN EL BARRIO PERDOMO.

### Este repositorio contiene el proyecto final de los estudiantes Carlos Polania, Bret Sierra y Luis Mendez, para la titulacion del Tecnico en programacion de software del SENA.

#### Este repositorio cuenta con la informacion general del proyecto, y la idea del proyecto es poner en practica cada uno de los conocimientos aprendidos durante el programa.

usuario bret agregado 

SELECT 
	libro.titulo,
   ubicacion.ubicacion AS ubicacion, SUM(linea_movimiento_inventario.cantidad) as 	cantidad
FROM
	linea_movimiento_inventario
INNER JOIN libro
	ON 
linea_movimiento_inventario.id_libro=libro.id_libro
INNER JOIN movimiento_inventario
	ON
linea_movimiento_inventario.id_movimiento=movimiento_inventario.ubicacion_destino
INNER JOIN ubicacion
	ON
movimiento_inventario.ubicacion_destino=ubicacion.id_ubicacion
GROUP BY
libro.titulo, ubicacion.ubicacion;
