<?php
$sql_formas_pago = "SELECT id_forma_pago, nombre_forma_pago FROM tb_formas_pago";
$query_formas_pago = $pdo->prepare($sql_formas_pago);
$query_formas_pago->execute();
$formas_pago_datos = $query_formas_pago->fetchAll(PDO::FETCH_ASSOC);

?>
