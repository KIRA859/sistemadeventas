<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">
<h1 style="color:brown">Modulo en construcción</h1>
    <!-- HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">
                <i class="fas fa-chart-line mr-2"></i> Reportes de Ventas
            </h1>
        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="content">
        <div class="container-fluid">

            <!-- FILTROS -->
            <div class="card card-outline card-secondary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tipo de Reporte</label>
                            <select id="tipo-reporte" class="form-control">
                                <option value="mes">Ventas del Mes</option>
                                <option value="anio">Ventas Anuales</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Año</label>
                            <select id="anio" class="form-control">
                                <?php for ($i = date('Y'); $i >= 2020; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button id="btn-generar" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Generar Reporte
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPIs -->
            <div class="row mt-3">
                <div class="col-lg-4 col-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-ventas">0</h3>
                            <p>Total Ventas</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="monto-total">COP$ 0.00</h3>
                            <p>Total Vendido</p>
                        </div>
                        <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="promedio-venta">COP$ 0.00</h3>
                            <p>Promedio por Venta</p>
                        </div>
                        <div class="icon"><i class="fas fa-chart-pie"></i></div>
                    </div>
                </div>
            </div>

            <!-- GRÁFICO -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i> Gráfico de Ventas
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoVentas" height="100"></canvas>
                </div>
            </div>

            <!-- TABLA -->
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-1"></i> Resumen de Ventas
                    </h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Periodo</th>
                                <th class="text-center">Cantidad Ventas</th>
                                <th class="text-right">Total Vendido</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-reportes">
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Genere un reporte
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../layout/parte2.php'); ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let grafico;

    function renderGrafico(labels, data) {
        if (grafico) grafico.destroy();

        grafico = new Chart(document.getElementById('graficoVentas'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventas',
                    data: data
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    $("#btn-generar").click(() => {
        const tipo = $("#tipo-reporte").val();
        const anio = $("#anio").val();

        const url = tipo === "mes" ?
            `../api/reportes/ventas_mes.php?anio=${anio}` :
            `../api/reportes/ventas_anio.php`;

        fetch(url)
            .then(res => res.json())
            .then(data => {

                let labels = [];
                let valores = [];
                let totalVentas = 0;
                let totalMonto = 0;

                $("#tabla-reportes").empty();

                data.forEach(row => {
                    const periodo = tipo === "mes" ?
                        `Mes ${row.mes}` :
                        row.anio;

                    labels.push(periodo);
                    valores.push(row.total_vendido);

                    totalVentas += parseInt(row.total_ventas);
                    totalMonto += parseFloat(row.total_vendido);

                    $("#tabla-reportes").append(`
                    <tr>
                        <td>${periodo}</td>
                        <td class="text-center">${row.total_ventas}</td>
                        <td class="text-right">COP$ ${parseFloat(row.total_vendido).toFixed(2)}</td>
                    </tr>
                `);
                });

                $("#total-ventas").text(totalVentas);
                $("#monto-total").text("COP$ " + totalMonto.toFixed(2));
                $("#promedio-venta").text(
                    "COP$ " + (totalVentas ? (totalMonto / totalVentas).toFixed(2) : "0.00")
                );

                renderGrafico(labels, valores);
            });
    });
</script>