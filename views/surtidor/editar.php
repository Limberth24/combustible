<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Surtidor</title>
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
                <li><a href="index.php?action=buscarPlacaHistorial">Historial</a></li>
                <li><a href="index.php?action=listarSurtidores">Surtidores</a></li>
            </ul>
        </div>
    </nav>
    <div class="form-card">
        <h2>Editar Surtidor</h2>
        <form action="index.php?action=actualizarSurtidor" method="POST">
            <input type="hidden" name="id" value="<?php echo $surtidor->getId(); ?>">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" required value="<?php echo htmlspecialchars($surtidor->getNombre()); ?>">
            </div>
            <div class="form-group">
                <label>Ubicación</label>
                <input type="text" name="ubicacion" required value="<?php echo htmlspecialchars($surtidor->getUbicacion()); ?>">
            </div>
            <button type="submit" class="btn-submit">Actualizar</button>
        </form>
        <div class="form-actions">
            <a href="index.php?action=listarSurtidores" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p>2026 Sistema de Control de Consumo de Combustible</p>
        </div>
    </footer>
</body>

</html>
