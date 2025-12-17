<?php
ob_start(); 
require_once('../app/TCPDF-main/tcpdf.php');
include('../app/config.php');

$id_venta = $_GET['id_venta'] ?? 0;
if ($id_venta <= 0) {
    die("ID de venta inválido");
}

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

// === Consulta venta ===
$query_venta = $pdo->prepare("
    SELECT v.id_venta, v.nro_venta, v.total_pagado, v.fyh_creacion,
           c.nombre_cliente, c.nit_ci_cliente, c.celular_cliente,
           fp.nombre_forma_pago
    FROM tb_ventas v
    LEFT JOIN tb_clientes c ON v.id_cliente = c.id_cliente
    LEFT JOIN tb_formas_pago fp ON v.id_forma_pago = fp.id_forma_pago
    WHERE v.id_venta = :id_venta
");
$query_venta->execute(['id_venta' => $id_venta]);
$venta = $query_venta->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
    die("No se encontró la venta con ID $id_venta");
}

// === Consulta detalles ===
$query_detalles = $pdo->prepare("
    SELECT d.cantidad, d.precio_unitario, d.subtotal, a.nombre
    FROM tb_detalle_ventas d
    INNER JOIN tb_almacen a ON d.id_producto = a.id_producto
    WHERE d.id_venta = :id_venta
");
$query_detalles->execute(['id_venta' => $id_venta]);
$detalles = $query_detalles->fetchAll(PDO::FETCH_ASSOC);

// Calcular subtotal y total
$subtotal = 0;
foreach ($detalles as $detalle) {
    $subtotal += $detalle['subtotal'];
}
$descuento = 0;
$total = $subtotal - $descuento;

// Función convertir número a letras
function numeroALetras($numero)
{
    $unidades = [
        '',
        'UNO',
        'DOS',
        'TRES',
        'CUATRO',
        'CINCO',
        'SEIS',
        'SIETE',
        'OCHO',
        'NUEVE',
        'DIEZ',
        'ONCE',
        'DOCE',
        'TRECE',
        'CATORCE',
        'QUINCE',
        'DIECISÉIS',
        'DIECISIETE',
        'DIECIOCHO',
        'DIECINUEVE',
        'VEINTE'
    ];
    $decenas = [
        2 => 'VEINTE',
        3 => 'TREINTA',
        4 => 'CUARENTA',
        5 => 'CINCUENTA',
        6 => 'SESENTA',
        7 => 'SETENTA',
        8 => 'OCHENTA',
        9 => 'NOVENTA'
    ];
    $centenas = [
        1 => 'CIENTO',
        2 => 'DOSCIENTOS',
        3 => 'TRESCIENTOS',
        4 => 'CUATROCIENTOS',
        5 => 'QUINIENTOS',
        6 => 'SEISCIENTOS',
        7 => 'SETECIENTOS',
        8 => 'OCHOCIENTOS',
        9 => 'NOVECIENTOS'
    ];

    if ($numero == 0) return "CERO PESOS";

    $entero = floor($numero);
    $decimal = round(($numero - $entero) * 100);

    $texto = convertirGrupo($entero, $unidades, $decenas, $centenas) . " PESOS";

    if ($decimal > 0) {
        $texto .= " CON " . str_pad($decimal, 2, "0", STR_PAD_LEFT) . "/100";
    }

    return $texto;
}

function convertirGrupo($numero, $unidades, $decenas, $centenas)
{
    $resultado = "";

    if ($numero >= 1000000) {
        $millones = floor($numero / 1000000);
        $resultado .= convertirGrupo($millones, $unidades, $decenas, $centenas) . " MILLONES ";
        $numero %= 1000000;
    }

    if ($numero >= 1000) {
        $miles = floor($numero / 1000);
        if ($miles == 1) {
            $resultado .= "MIL ";
        } else {
            $resultado .= convertirGrupo($miles, $unidades, $decenas, $centenas) . " MIL ";
        }
        $numero %= 1000;
    }

    if ($numero >= 100) {
        $cientos = floor($numero / 100);
        if ($numero == 100) {
            $resultado .= "CIEN ";
        } else {
            $resultado .= $centenas[$cientos] . " ";
        }
        $numero %= 100;
    }

    if ($numero > 20) {
        $d = floor($numero / 10);
        $resultado .= $decenas[$d];
        $u = $numero % 10;
        if ($u > 0) {
            $resultado .= " Y " . $unidades[$u];
        }
    } else if ($numero > 0) {
        $resultado .= $unidades[$numero];
    }

    return trim($resultado);
}

// Evitar que quede vacío
$importe_literal = numeroALetras($total);


// === Contenido HTML ===
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
    <tr><td colspan="2" class="titulo">' . $empresa_nombre . '</td></tr>
    <tr><td colspan="2" class="empresa">' . $empresa_direccion . '</td></tr>
    <tr><td colspan="2" class="empresa">' . $empresa_telefono . '</td></tr>
    <tr><td colspan="2" class="empresa">' . $empresa_ciudad . '</td></tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle">
        <td><b>NIT:</b> ' . $empresa_nit . '</td>
        <td style="text-align: right;"><b>Fecha:</b> ' . date("d/m/Y H:i:s", strtotime($venta['fyh_creacion'])) . '</td>
    </tr>
    <tr class="detalle">
        <td><b>Factura N°:</b> ' . $venta['nro_venta'] . '</td>
        <td style="text-align: right;"><b>Autorización:</b> 1035495754</td>
    </tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle"><td colspan="2"><b>Cliente:</b> ' . $venta['nombre_cliente'] . '</td></tr>
    <tr class="detalle"><td colspan="2"><b>NIT/CI:</b> ' . $venta['nit_ci_cliente'] . '</td></tr>
    <tr class="detalle"><td colspan="2"><b>Teléfono:</b> ' . $venta['celular_cliente'] . '</td></tr>
    <tr><td colspan="2"><hr></td></tr>
    <tr class="detalle">
        <td class="bordered" width="60%"><b>Descripción</b></td>
        <td class="bordered" width="20%" style="text-align: center;"><b>Cant.</b></td>
        <td class="bordered" width="20%" style="text-align: right;"><b>Importe</b></td>
    </tr>';

// === Detalle productos ===
foreach ($detalles as $detalle) {
    $html .= '
    <tr class="detalle">
        <td class="bordered">' . $detalle['nombre'] . '</td>
        <td class="bordered" style="text-align: center;">' . $detalle['cantidad'] . '</td>
        <td class="bordered" style="text-align: right;">$' . number_format($detalle['subtotal'], 2) . '</td>
    </tr>';
}

$html .= '
    <tr><td colspan="3"><hr></td></tr>
    <tr class="detalle">
        <td colspan="2" style="text-align: right;"><b>Subtotal:</b></td>
        <td style="text-align: right;">$' . number_format($subtotal, 2) . '</td>
    </tr>
    <tr class="detalle">
        <td colspan="2" style="text-align: right;"><b>Descuento:</b></td>
        <td style="text-align: right;">$' . number_format($descuento, 2) . '</td>
    </tr>
    <tr class="total">
        <td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="text-align: right;">$' . number_format($total, 2) . '</td>
    </tr>
    <tr class="detalle"><td colspan="3"><b>Son:</b> ' . $importe_literal . '</td></tr>
    <tr><td colspan="3"><hr></td></tr>
    <tr class="footer"><td colspan="3">¡Gracias por su compra!</td></tr>
    <tr class="footer"><td colspan="3">Esta factura es un documento electrónico</td></tr>
</table>';

// === Render HTML ===
$pdf->writeHTML($html, true, false, true, false, '');

// === QR con datos básicos ===
$QR = "FACTURA: " . $venta['nro_venta'] . "\n";
$QR .= "CLIENTE: " . $venta['nombre_cliente'] . "\n";
$QR .= "NIT/CI: " . $venta['nit_ci_cliente'] . "\n";
$QR .= "FECHA: " . $venta['fyh_creacion'] . "\n";
$QR .= "TOTAL: $" . number_format($total, 2) . "\n";
$QR .= "SISTEMA DE VENTAS DANIEL ARIAS";

$style = [
    'border' => 0,
    'vpadding' => 3,
    'hpadding' => 3,
    'fgcolor' => [0, 0, 0],
    'bgcolor' => false,
    'module_width' => 1,
    'module_height' => 1
];

$y = $pdf->GetY() + 5;
$x = ($pdf->getPageWidth() - 30) / 2;
$pdf->write2DBarcode($QR, 'QRCODE,L', $x, $y, 30, 30, $style);

ob_end_clean(); // <---- Limpia el buffer antes de enviar el PDF

// === Salida PDF ===
$pdf->Output('factura_' . $venta['nro_venta'] . '.pdf', 'I');
