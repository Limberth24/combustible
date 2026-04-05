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
            <div class="logo"><h1>CombustibleControl</h1></div>
            <ul class="nav-menu">
                <li><a href="index.php?action=landing">Inicio</a></li>
                <li><a href="index.php?action=nuevoRegistro">Nuevo Registro</a></li>
                <li><a href="index.php?action=buscarPlacaCarga" class="active">Registro</a></li>
                <li><a href="index.php?action=buscarPlacaHistorial">Historial</a></li>
            </ul>
        </div>
    </nav>
    <div class="form-card">
        <h2>Registrar Carga</h2>
        <div class="alert alert-success">Vehiculo: <?php echo $vehiculo['placa']; ?> - <?php echo $vehiculo['modelo']; ?></div>
        <form action="index.php?action=guardarCarga" method="POST">
            <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
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
                <select name="id_surtidor" required>
                    <option value="">Seleccione</option>
                    <?php while($s = mysqli_fetch_assoc($surtidores)): ?>
                        <option value="<?php echo $s['id_surtidor']; ?>"><?php echo $s['nombre']; ?> - <?php echo $s['ubicacion']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn-submit">Registrar</button>
        </form>
    </div>
    <footer class="footer"><div class="container"><p>2024 Sistema de Control de Consumo de Combustible</p></div></footer>
</body>
</html>