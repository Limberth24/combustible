<?php
session_start();
require_once 'config/db.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'landing';

switch ($action) {
    case 'nuevoRegistro':
        require_once 'controllers/VehiculoController.php';
        $controller = new VehiculoController($conn);
        $controller->mostrarFormularioRegistro();
        break;
    case 'guardarVehiculo':
        require_once 'controllers/VehiculoController.php';
        $controller = new VehiculoController($conn);
        $controller->guardarVehiculo();
        break;
    case 'buscarPlacaCarga':
        require_once 'controllers/CargaController.php';
        $controller = new CargaController($conn);
        $controller->mostrarBuscarPlaca();
        break;
    case 'mostrarRegistroCarga':
        require_once 'controllers/CargaController.php';
        $controller = new CargaController($conn);
        $controller->mostrarRegistroCarga();
        break;
    case 'guardarCarga':
        require_once 'controllers/CargaController.php';
        $controller = new CargaController($conn);
        $controller->guardarCarga();
        break;
    case 'buscarPlacaHistorial':
        require_once 'controllers/HistorialController.php';
        $controller = new HistorialController($conn);
        $controller->mostrarBuscarPlaca();
        break;
    case 'verHistorial':
        require_once 'controllers/HistorialController.php';
        $controller = new HistorialController($conn);
        $controller->verHistorial();
        break;
    case 'generarReporte':
        require_once 'controllers/HistorialController.php';
        $controller = new HistorialController($conn);
        $controller->generarReporte();
        break;
    case 'landing':
    default:
        require_once 'views/landing.php';
        break;
}
