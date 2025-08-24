<?php
// Incluir la librería TCPDF y configuración
require_once('../app/TCPDF-main/tcpdf.php');
include('../app/config.php');

// Obtener el ID de la venta desde la URL
$id_venta = $_GET['id_venta'] ?? 0;

// Crear nuevo documento PDF
$pdf = new TCPDF('P', 'mm', array(80, 200), true, 'UTF-8', false);

// Información del documento
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Sistema de ventas Daniel Arias');
$pdf->setTitle('Factura de venta');
$pdf->setSubject('Factura electrónica');
$pdf->setKeywords('TCPDF, PDF, factura, venta');

// Configuración
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->setMargins(5, 5, 5);
$pdf->setAutoPageBreak(true, 5);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Agregar página
$pdf->AddPage();

// Datos fijos de la empresa
$empresa_nombre = "SISTEMA DE VENTAS DANIEL ARIAS";
$empresa_direccion = "Zona Yali Antioquia barrio el calvario cl#21 21-118";
$empresa_telefono = "3128741170 - 3071147821";
$empresa_ciudad = "YALI - COLOMBIA";
$empresa_nit = "1045606685";

// Consulta para obtener datos de la venta
$query_venta = $pdo->prepare("
   SELECT v.*, c.nombre_cliente, c.nit_ci_cliente, c.celular_cliente
FROM tb_ventas v 
JOIN tb_clientes c ON v.id_cliente = c.id_cliente 
WHERE v.id_venta = :id_venta
    
");
$query_venta->execute(['id_venta' => $id_venta]);
$venta = $query_venta->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
    die("No se encontró la venta con ID $id_venta");
}

// Consulta para obtener los detalles de la venta
$query_detalles = $pdo->prepare("
    SELECT c.*, a.nombre, a.precio_venta 
    FROM tb_carrito c 
    JOIN tb_almacen a ON c.id_producto = a.id_producto 
    WHERE c.nro_venta = :nro_venta
");
$query_detalles->execute(['nro_venta' => $venta['nro_venta']]);
$detalles = $query_detalles->fetchAll(PDO::FETCH_ASSOC);

// Calcular subtotal
$subtotal = 0;
foreach ($detalles as $detalle) {
    $subtotal += $detalle['cantidad'] * $detalle['precio_venta'];
}

// Calcular total + impuestos, descuentos, etc.
$descuento = 0;
$total = $subtotal - $descuento;

// Función para convertir número a letras
function numeroALetras($numero) {
    //Necesito una librería, por ahora algo fijo
    return "CIEN PESOS 00/100";
}

$importe_literal = numeroALetras($total);

// Contenido en HTML
$html = '
<style>
    .titulo { font-size: 12px; font-weight: bold; text-align: center; }
    .empresa { font-size: 10px; text-align: center; }
    .detalle { font-size: 9px; }
    .total { font-size: 10px; font-weight: bold; }
    .footer { font-size: 7px; text-align: center; }
    .bordered { border: 0.3px solid #000; padding: 3px; }
</style>

<table cellpadding="2">
    <tr><td colspan="2" class="titulo">'.$empresa_nombre.'</td></tr>
    <tr><td colspan="2" class="empresa">'.$empresa_direccion.'</td></tr>
    <tr><td colspan="2" class="empresa">'.$empresa_telefono.'</td></tr>
    <tr><td colspan="2" class="empresa">'.$empresa_ciudad.'</td></tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle">
        <td><b>NIT:</b> '.$empresa_nit.'</td>
        <td style="text-align: right;"><b>Fecha:</b> '.date('d/m/Y H:i:s').'</td>
    </tr>
    <tr class="detalle">
        <td><b>Factura N°:</b> '.$venta['nro_venta'].'</td>
        <td style="text-align: right;"><b>Autorización:</b> 1035495754</td>
    </tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle"><td colspan="2"><b>Cliente:</b> '.$venta['nombre_cliente'].'</td></tr>
    <tr class="detalle"><td colspan="2"><b>NIT/CI:</b> '.$venta['nit_ci_cliente'].'</td></tr>
    <tr class="detalle"><td colspan="2"><b>Teléfono:</b> '.$venta['celular_cliente'].'</td></tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle">
        <td class="bordered" width="60%"><b>Descripción</b></td>
        <td class="bordered" width="20%" style="text-align: center;"><b>Cant.</b></td>
        <td class="bordered" width="20%" style="text-align: right;"><b>Importe</b></td>
    </tr>';

// Agregar detalles de productos
foreach ($detalles as $detalle) {
    $importe = $detalle['cantidad'] * $detalle['precio_venta'];
    $html .= '
    <tr class="detalle">
        <td class="bordered">'.$detalle['nombre'].'</td>
        <td class="bordered" style="text-align: center;">'.$detalle['cantidad'].'</td>
        <td class="bordered" style="text-align: right;">$'.number_format($importe, 2).'</td>
    </tr>';
}

$html .= '
    <tr><td colspan="3"><hr></td></tr>
    <tr class="detalle">
        <td colspan="2" style="text-align: right;"><b>Subtotal:</b></td>
        <td style="text-align: right;">$'.number_format($subtotal, 2).'</td>
    </tr>
    <tr class="detalle">
        <td colspan="2" style="text-align: right;"><b>Descuento:</b></td>
        <td style="text-align: right;">$'.number_format($descuento, 2).'</td>
    </tr>
    <tr class="total">
        <td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="text-align: right;">$'.number_format($total, 2).'</td>
    </tr>
    <tr class="detalle"><td colspan="3"><b>Son:</b> '.$importe_literal.'</td></tr>
    <tr><td colspan="3"><hr></td></tr>
    <tr class="footer"><td colspan="3">¡Gracias por su compra!</td></tr>
    <tr class="footer"><td colspan="3">Esta factura es un documento electrónico</td></tr>
</table>';

// Escribir HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Texto para el código QR
$QR = "FACTURA: ".$venta['nro_venta']."\n";
$QR .= "CLIENTE: ".$venta['nombre_cliente']."\n";
$QR .= "NIT/CI: ".$venta['nit_ci_cliente']."\n";
$QR .= "FECHA: ".date('d/m/Y H:i:s')."\n";
$QR .= "TOTAL: $".number_format($total, 2)."\n";
$QR .= "SISTEMA DE VENTAS DANIEL ARIAS";

// Estilo para el código QR
$style = array(
    'border' => 0,
    'vpadding' => 3,
    'hpadding' => 3,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false,
    'module_width' => 1,
    'module_height' => 1
    
);

// Posición actual en Y (después de todo el contenido)
$y = $pdf->GetY() + 10;  

// Ancho de la página
$pageWidth = $pdf->getPageWidth();   

// Tamaño del QR
$qrSize = 30;  

// Coordenada X para centrar horizontalmente
$x = ($pageWidth - $qrSize) / 2;  

// Insertar QR
$pdf->write2DBarcode($QR, 'QRCODE,L', $x, $y, $qrSize, $qrSize, $style);

// Cerrar y mostrar PDF
$pdf->Output('factura_'.$venta['nro_venta'].'.pdf', 'I');
?>
