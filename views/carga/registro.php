<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Carga</title>
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
                <li><a href="index.php?action=buscarPlacaCarga" class="active">Registro</a></li>
                <li><a href="index.php?action=buscarPlacaHistorial">Historial</a></li>
                <li><a href="index.php?action=listarSurtidores">Surtidores</a></li>
            </ul>
        </div>
    </nav>
    <div class="form-card">
        <h2>Registrar Carga</h2>
        
        <div class="vehiculo-card">
            <h3>🚗 <?php echo htmlspecialchars($vehiculo->getPlaca()); ?></h3>
            <div class="vehiculo-info">
                <div class="vehiculo-info-item">
                    <label>Modelo</label><br>
                    <span><?php echo htmlspecialchars($vehiculo->getModelo()); ?></span>
                </div>
                <div class="vehiculo-info-item">
                    <label>Tipo Combustible</label><br>
                    <span><?php echo htmlspecialchars($vehiculo->getTipoCombustible()); ?></span>
                </div>
            </div>
            <?php if ($rendimientoPromedio !== null): ?>
                <div class="rendimiento-badge">
                    <div class="label">Rendimiento Promedio Histórico</div>
                    <div class="value"><?php echo number_format($rendimientoPromedio, 2); ?> km/L</div>
                </div>
            <?php endif; ?>
        </div>
        
        <form action="index.php?action=guardarCarga" method="POST">
            <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo->getId(); ?>">
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha" required value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label>Kilometraje (km)</label>
                <input type="number" name="kilometraje" required step="1">
            </div>
            <div class="form-group">
                <label>Litros</label>
                <input type="number" name="litros" required step="0.01">
            </div>
            <div class="form-group">
                <label>Precio Total (Bs)</label>
                <input type="number" name="precio_total" required step="0.01">
            </div>
            <div class="form-group">
                <label>Surtidor</label>
                <div class="surtidor-group">
                    <select name="id_surtidor" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($surtidores as $s): ?>
                            <option value="<?php echo $s->getId(); ?>"><?php echo htmlspecialchars($s->getNombre()); ?> - <?php echo htmlspecialchars($s->getUbicacion()); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="index.php?action=nuevoSurtidor" class="btn-add-surtidor" title="Agregar nuevo surtidor">➕</a>
                </div>
            </div>
            <button type="submit" class="btn-submit">Registrar</button>
        </form>
    </div>
    <footer class="footer">
        <div class="container">
            <p>2026 Sistema de Control de Consumo de Combustible</p>
        </div>
    </footer>
</body>

</html>
