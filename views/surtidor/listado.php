<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestionar Surtidores</title>
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
                <li><a href="index.php?action=listarSurtidores" class="active">Surtidores</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="form-card form-card-wide">
            <div class="listado-header">
                <h2>Gestionar Surtidores</h2>
                <a href="index.php?action=nuevoSurtidor" class="btn btn-primary">➕ Agregar Surtidor</a>
            </div>

            <?php if (count($surtidores) == 0): ?>
                <div class="alert alert-error">No hay surtidores registrados</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surtidores as $s): ?>
                            <tr>
                                <td><?php echo $s->getId(); ?></td>
                                <td><?php echo htmlspecialchars($s->getNombre()); ?></td>
                                <td><?php echo htmlspecialchars($s->getUbicacion()); ?></td>
                                <td class="acciones-cell">
                                    <a href="index.php?action=editarSurtidor&id=<?php echo $s->getId(); ?>" class="btn btn-accion btn-editar">✏️ Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div class="hero-buttons">
                <a href="index.php?action=landing" class="btn btn-secondary">Inicio</a>
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
