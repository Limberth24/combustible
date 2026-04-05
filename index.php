<?php
session_start();
require_once 'core/singleton/ConexionBD.php';

$conexionBD = ConexionBD::obtenerInstancia();
$conn = $conexionBD->obtenerConexion();

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
    case 'listarSurtidores':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->mostrarListado();
        break;
    case 'nuevoSurtidor':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->mostrarFormularioRegistro();
        break;
    case 'guardarSurtidor':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->guardarSurtidor();
        break;
    case 'editarSurtidor':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->mostrarFormularioEditar();
        break;
    case 'actualizarSurtidor':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->actualizarSurtidor();
        break;
    case 'eliminarSurtidor':
        require_once 'controllers/SurtidorController.php';
        $controller = new SurtidorController($conn);
        $controller->eliminarSurtidor();
        break;
    case 'landing':
    default:
        require_once 'views/landing.php';
        break;
}
