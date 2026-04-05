<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de <?php echo $placa; ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        table { width:100%; border-collapse:collapse; }
        th,td { padding:10px; text-align:left; border-bottom:1px solid #ddd; }
        th { background:#2d6a4f; color:white; }
        .rendimiento-bajo { color:#e74c3c; font-weight:bold; }
        .rendimiento-bueno { color:#27ae60; font-weight:bold; }
    </style>
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
            </ul>
        </div>
    </nav>
    <div class="container" style="margin:20px auto;">
        <div class="form-card" style="max-width:100%;">
            <h2>Historial de Cargas</h2>
            <div class="alert alert-success">Vehiculo: <?php echo $vehiculo['placa']; ?> - <?php echo $vehiculo['modelo']; ?></div>
            
            <?php if(count($cargas) == 0): ?>
                <div class="alert alert-error">No hay cargas registradas</div>
            <?php else: ?>
                <table>
                    <thead><tr><th>Fecha</th><th>Surtidor</th><th>Km</th><th>Litros</th><th>Precio</th><th>Km Recorridos</th><th>Rendimiento</th></tr></thead>
                    <tbody>
                    <?php foreach($cargas as $carga): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($carga['fecha'])); ?></td>
                            <td><?php echo $carga['surtidor_nombre'] ?? 'N/A'; ?></td>
                            <td><?php echo number_format($carga['kilometraje'],0); ?> km</td>
                            <td><?php echo number_format($carga['litros'],2); ?> L</td>
                            <td><?php echo number_format($carga['precio_total'],2); ?> Bs</td>
                            <td><?php echo $carga['km_recorridos'] ? number_format($carga['km_recorridos'],0).' km' : '-'; ?></td>
                            <td>
                                <?php if($carga['rendimiento']): ?>
                                    <span class="<?php echo $carga['rendimiento'] < 8 ? 'rendimiento-bajo' : 'rendimiento-bueno'; ?>">
                                        <?php echo number_format($carga['rendimiento'],2); ?> km/l
                                    </span>
                                <?php else: ?>-<?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="btn-reporte" style="margin-top:20px; text-align:center;">
                    <form action="index.php?action=generarReporte" method="POST">
                        <input type="hidden" name="placa" value="<?php echo $placa; ?>">
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            <?php endif; ?>
            
            <div class="hero-buttons" style="margin-top:20px;">
                <a href="index.php?action=buscarPlacaHistorial" class="btn btn-secondary">Buscar otro</a>
                <a href="index.php?action=landing" class="btn btn-primary">Inicio</a>
            </div>
        </div>
    </div>
    <footer class="footer"><div class="container"><p>2024 Sistema de Control de Consumo de Combustible</p></div></footer>
</body>
</html>