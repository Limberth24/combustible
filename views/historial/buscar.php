<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial</title>
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
    <div class="form-card">
        <h2>Ver Historial</h2>
        <p>Ingrese la placa del vehículo</p>
        <form action="index.php?action=verHistorial" method="POST">
            <div class="form-group">
                <label>Placa</label>
                <input type="text" name="placa" required placeholder="Ej: HDK2034">
            </div>

            <div class="form-group">
                <label>Filtrar por Fecha (Desde)</label>
                <input type="date" name="fecha_inicio">
            </div>

            <div class="form-group">
                <label>Filtrar por Fecha (Hasta)</label>
                <input type="date" name="fecha_fin">
            </div>

            <div class="form-group">
                <label>Filtrar por Estacion de Servicio</label>
                <select name="id_surtidor">
                    <option value="">Todas las estaciones</option>
                    <?php foreach ($surtidores as $s): ?>
                        <option value="<?php echo $s->getId(); ?>"><?php echo htmlspecialchars($s->getNombre() . ' - ' . $s->getUbicacion()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">Ver Historial</button>
        </form>
    </div>
    <footer class="footer">
        <div class="container">
            <p>2026 Sistema de Control de Consumo de Combustible</p>
        </div>
    </footer>
</body>

</html>