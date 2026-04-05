<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Vehiculo</title>
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
        <p>Ingrese la placa del vehiculo</p>
        <form action="index.php?action=mostrarRegistroCarga" method="POST">
            <div class="form-group">
                <label>Placa</label>
                <input type="text" name="placa" required placeholder="Ej: 1234ABC">
            </div>
            <button type="submit" class="btn-submit">Buscar</button>
        </form>
        <div style="text-align:center; margin-top:20px;"><a href="index.php?action=nuevoRegistro">Registrar nuevo vehiculo</a></div>
    </div>
    <footer class="footer"><div class="container"><p>2024 Sistema de Control de Consumo de Combustible</p></div></footer>
</body>
</html>