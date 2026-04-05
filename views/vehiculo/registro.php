<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Vehiculo</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><h1>CombustibleControl</h1></div>
            <ul class="nav-menu">
                <li><a href="index.php?action=landing">Inicio</a></li>
                <li><a href="index.php?action=nuevoRegistro" class="active">Nuevo Registro</a></li>
                <li><a href="index.php?action=buscarPlacaCarga">Registro</a></li>
                <li><a href="index.php?action=buscarPlacaHistorial">Historial</a></li>
            </ul>
        </div>
    </nav>
    <div class="form-card">
        <h2>Registrar Nuevo Vehiculo</h2>
        <form action="index.php?action=guardarVehiculo" method="POST">
            <div class="form-group">
                <label>Placa</label>
                <input type="text" name="placa" required placeholder="Ej: 1234ABC">
            </div>
            <div class="form-group">
                <label>Modelo</label>
                <input type="text" name="modelo" required placeholder="Ej: Toyota Corolla">
            </div>
            <div class="form-group">
                <label>Tipo Combustible</label>
                <select name="tipo_combustible" required>
                    <option value="">Seleccione</option>
                    <option value="Gasolina 95">Gasolina 95</option>
                    <option value="Gasolina 97">Gasolina 97</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Registrar</button>
        </form>
    </div>
    <footer class="footer"><div class="container"><p>2024 Sistema de Control de Consumo de Combustible</p></div></footer>
</body>
</html>