<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reporte - <?php echo htmlspecialchars($vehiculo->getPlaca()); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <h1>CombustibleControl</h1>
            </div>
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
        <div class="form-card">
            <h2>Reporte de Rendimiento</h2>
            <div class="alert alert-success">Vehículo: <?php echo htmlspecialchars($vehiculo->getPlaca()); ?> - <?php echo htmlspecialchars($vehiculo->getModelo()); ?></div>
            <div class="resumen-grid">
                <div class="resumen-card">
                    <div class="label">Rendimiento Promedio</div>
                    <div class="value"><?php echo number_format($rendimientoPromedio, 2); ?> km/L</div>
                </div>
                <div class="resumen-card">
                    <div class="label">Total Cargas</div>
                    <div class="value"><?php echo count($cargas); ?></div>
                </div>
                <div class="resumen-card">
                    <div class="label">Surtidores Visitados</div>
                    <div class="value"><?php echo count($rendimientoSurtidores); ?></div>
                </div>
            </div>
            <h3>Ranking de Surtidores</h3>
            <?php if ($esBajoRendimiento): ?>
                <div class="alert alert-error">⚠️ ALERTA: El rendimiento promedio (<?php echo number_format($rendimientoPromedio, 2); ?> km/L) está por debajo del umbral</div>
            <?php endif; ?>
            <div class="ranking-container">
                <?php $pos = 1;
                foreach ($rendimientoSurtidores as $surtidor): ?>
                    <div class="ranking-item <?php echo $pos <= 3 ? 'posicion-' . $pos : ''; ?> <?php echo $surtidor['esBajoRendimiento'] ? 'alerta' : ''; ?>">
                        <div class="ranking-info">
                            <h4><?php echo $pos; ?>. <?php echo htmlspecialchars($surtidor['nombre']); ?></h4>
                            <p><?php echo htmlspecialchars($surtidor['ubicacion']); ?> - <?php echo $surtidor['cargas']; ?> cargas</p>
                        </div>
                        <div class="ranking-metricas">
                            <div class="rendimiento-valor <?php echo $surtidor['esBajoRendimiento'] ? 'rendimiento-bajo' : ''; ?>"><?php echo number_format($surtidor['promedio'], 2); ?> km/L</div>
                            <div class="costo-badge">Bs <?php echo number_format($surtidor['costoTotal'], 2); ?></div>
                        </div>
                    </div>
                <?php $pos++;
                endforeach; ?>
            </div>
            <div class="hero-buttons">
                <a href="index.php?action=buscarPlacaHistorial" class="btn btn-secondary">Volver</a>
                <a href="index.php?action=landing" class="btn btn-primary">Inicio</a>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>2026 Sistema de Control de Consumo de Combustible</p>
        </div>
    </footer>
</body>

</html>