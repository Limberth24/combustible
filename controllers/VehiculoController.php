<?php
require_once 'core/factory/RepositorioFactory.php';
require_once 'models/Vehiculo.php';

class VehiculoController
{
    private $repositorioVehiculo;

    public function __construct($conn)
    {
        $this->repositorioVehiculo = RepositorioFactory::crearVehiculoRepositorio($conn);
    }

    public function mostrarFormularioRegistro()
    {
        require_once 'views/vehiculo/registro.php';
    }

    public function guardarVehiculo()
    {
        $placa = strtoupper(trim($_POST['placa']));
        $modelo = trim($_POST['modelo']);
        $tipoCombustible = trim($_POST['tipo_combustible']);

        if (empty($placa) || empty($modelo) || empty($tipoCombustible)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index.php?action=nuevoRegistro';</script>";
            return;
        }

        $vehiculoExistente = $this->repositorioVehiculo->buscarPorPlaca($placa);
        if ($vehiculoExistente !== null) {
            echo "<script>alert('La placa $placa ya esta registrada'); window.location.href='index.php?action=nuevoRegistro';</script>";
            return;
        }

        $vehiculo = new Vehiculo(0, $placa, $modelo, $tipoCombustible);
        if ($this->repositorioVehiculo->guardar($vehiculo)) {
            echo "<script>alert('Vehiculo registrado exitosamente'); window.location.href='index.php?action=landing';</script>";
        } else {
            echo "<script>alert('Error al registrar'); window.location.href='index.php?action=nuevoRegistro';</script>";
        }
    }
}
?>
