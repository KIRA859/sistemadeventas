<?php
// Usamos LEFT JOIN para unir la tabla de ventas con la de clientes
$sql_ventas = "
    SELECT 
        v.*, 
        cli.nombre_cliente, 
        cli.nit_ci_cliente, 
        cli.celular_cliente, 
        cli.email_cliente,
        v.fyh_creacion as fecha_venta  -- Añadimos un alias para la fecha de venta
    FROM 
        tb_ventas as v
    LEFT JOIN 
        tb_clientes as cli ON v.id_cliente = cli.id_cliente
    -- SE ELIMINÓ LA CLÁUSULA 'WHERE v.estado = 1' QUE CAUSABA EL ERROR
    ORDER BY
        v.id_venta DESC
";

$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute();
$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);