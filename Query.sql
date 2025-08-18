use balance;

/*DANDO NOMBRE A CATEGORIA Y SUBCATEGORIA EN INGRESOS*/
SELECT 	ingresos.id,
		ingresos_categoria.descripcion AS categoria,
		ingresos_subcategoria.descripcion AS subcategoria,
		ingresos.importe
	FROM ingresos
	JOIN ingresos_categoria ON ingresos.categoria = ingresos_categoria.id
	JOIN ingresos_subcategoria ON ingresos.subcategoria = ingresos_subcategoria.id;
    
/*DANDO NOMBRE A CATEGORIA Y SUBCATEGORIA EN EGRESOS*/
SELECT 	egresos.id,
		egresos.fecha as fecha,
		egresos_categoria.descripcion AS categoria,
		egresos_subcategoria.descripcion AS subcategoria,
		egresos.importe
	FROM egresos
	JOIN egresos_categoria ON egresos.categoria = egresos_categoria.id
	JOIN egresos_subcategoria ON egresos.subcategoria = egresos_subcategoria.id
	ORDER BY id;
    
/*SUMANDO EL IMPORTE DEL ACTUAL MES*/
SELECT SUM(importe) as importe
	FROM ingresos 
	WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
	AND YEAR(fecha) = YEAR(CURRENT_DATE())
    
