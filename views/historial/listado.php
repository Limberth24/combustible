<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de <?php echo $vehiculo->getPlaca(); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><h1>CombustibleControl</h1></div>
            <ul class="nav-menu">
                <li><a href="index.php?action=landing">Inicio</a></li>
                <li><a href="index.php?action=nuevoRegistro">Nuevo Registro</a></li>
                <li><a href="index.php?action=buscarPlacaCarga">Registro</a></li>
                <li><a href="index.php?action=buscarPlacaHistorial" class="active">Historial</a></li>
                <li><a href="index.php?action=listarSurtidores">Surtidores</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="form-card form-card-wide">
            <h2>Historial de Cargas</h2>
            <div class="alert alert-success">Vehículo: <?php echo $vehiculo->getPlaca(); ?> - <?php echo $vehiculo->getModelo(); ?></div>

            <?php if (count($cargasConMetricas) == 0): ?>
                <div class="alert alert-error">No hay cargas registradas</div>
            <?php else: ?>
                <!-- Resumen de métricas -->
                <?php
                $rendimientosValidos = array_filter(array_map(function ($c) {
                    return $c->rendimiento ?? null;
                }, $cargasConMetricas));
                $rendimientoPromedio = count($rendimientosValidos) > 0 ? array_sum($rendimientosValidos) / count($rendimientosValidos) : 0;
                ?>
                
                <div class="resumen-container">
                    <div class="resumen-card">
                        <div class="label">Total Cargas</div>
                        <div class="value"><?php echo count($cargasConMetricas); ?></div>
                    </div>
                    <div class="resumen-card">
                        <div class="label">Rendimiento Promedio</div>
                        <div class="value"><?php echo number_format($rendimientoPromedio, 2); ?> km/L</div>
                    </div>
                    <div class="resumen-card">
                        <div class="label">Mejor Rendimiento</div>
                        <div class="value"><?php echo count($rendimientosValidos) > 0 ? number_format(max($rendimientosValidos), 2) : '-'; ?> km/L</div>
                    </div>
                    <div class="resumen-card">
                        <div class="label">Surtidores Visitados</div>
                        <div class="value"><?php echo count(array_unique(array_map(function ($c) {
                            return $c->surtidorNombre ?? '';
                        }, $cargasConMetricas))); ?></div>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Surtidor</th>
                                <th>Kilometraje</th>
                                <th>Litros</th>
                                <th>Precio</th>
                                <th>Km Recorridos</th>
                                <th>Rendimiento</th>
                                <th>Costo/Km</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php foreach ($cargasConMetricas as $carga): ?>
                            <?php
                            // Determinar clase de rendimiento
                            $claseRendimiento = 'rendimiento-normal';
                            if ($carga->rendimiento) {
                                if ($carga->esBajoRendimiento) {
                                    $claseRendimiento = 'rendimiento-bajo';
                                } elseif ($carga->rendimiento >= 8) {
                                    $claseRendimiento = 'rendimiento-bueno';
                                }
                            }
                            $costoPorKm = $carga->costoPorKm ?? 0;
                            ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($carga->getFecha())); ?></td>
                                <td><?php echo htmlspecialchars($carga->surtidorNombre ?? 'N/A'); ?></td>
                                <td><?php echo number_format($carga->getKilometraje(), 0); ?> km</td>
                                <td><?php echo number_format($carga->getLitros(), 2); ?> L</td>
                                <td><?php echo number_format($carga->getPrecioTotal(), 2); ?> Bs</td>
                                <td><?php echo $carga->kmRecorridos ? number_format($carga->kmRecorridos, 0) . ' km' : '-'; ?></td>
                                <td>
                                    <span class="<?php echo $claseRendimiento; ?>">
                                        <?php echo $carga->rendimiento ? number_format($carga->rendimiento, 2) . ' km/L' : '-'; ?>
                                    </span>
                                </td>
                                <td><?php echo $costoPorKm > 0 ? 'Bs ' . number_format($costoPorKm, 2) : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>

                <!-- Análisis de desviación -->
                <?php if ($desviacionEstandar > 0): ?>
                    <div class="alerta-anomalia">
                        <span>📊 <strong>Análisis:</strong> Rendimiento promedio = <?php echo number_format($rendimientoPromedio, 2); ?> km/L 
                        (Desviación: ±<?php echo number_format($desviacionEstandar, 2); ?>)</span>
                    </div>
                <?php endif; ?>

                <div class="btn-reporte">
                    <form action="index.php?action=generarReporte" method="POST">
                        <input type="hidden" name="placa" value="<?php echo $vehiculo->getPlaca(); ?>">
                        <button type="submit" class="btn btn-primary">📊 Generar Reporte Completo</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="hero-buttons">
                <a href="index.php?action=buscarPlacaHistorial" class="btn btn-secondary">Buscar otro</a>
                <a href="index.php?action=landing" class="btn btn-primary">Inicio</a>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container"><p>2026 Sistema de Control de Consumo de Combustible</p></div>
    </footer>
</body>

</html>
