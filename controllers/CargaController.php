<?php
require_once 'core/factory/RepositorioFactory.php';
require_once 'core/factory/CargaCombustibleFactory.php';
require_once 'core/services/AnalisisRendimiento.php';
require_once 'core/strategy/EstrategiaRendimientoEstandar.php';
require_once 'models/Vehiculo.php';
require_once 'models/Surtidor.php';
require_once 'models/Carga.php';

class CargaController
{
    private $repositorioVehiculo;
    private $repositorioSurtidor;
    private $repositorioCarga;
    private $analisisRendimiento;

    public function __construct($conn)
    {
        $this->repositorioVehiculo = RepositorioFactory::crearVehiculoRepositorio($conn);
        $this->repositorioSurtidor = RepositorioFactory::crearSurtidorRepositorio($conn);
        $this->repositorioCarga = RepositorioFactory::crearCargaRepositorio($conn);
        $this->analisisRendimiento = new AnalisisRendimiento(
            new EstrategiaRendimientoEstandar()
        );
    }

    public function mostrarBuscarPlaca()
    {
        require_once 'views/carga/buscar.php';
    }

    public function mostrarRegistroCarga()
    {
        $placa = strtoupper(trim($_POST['placa']));
        $vehiculo = $this->repositorioVehiculo->buscarPorPlaca($placa);

        if ($vehiculo === null) {
            echo "<script>alert('No existe un vehiculo con la placa $placa'); window.location.href='index.php?action=buscarPlacaCarga';</script>";
            return;
        }

        $surtidores = $this->repositorioSurtidor->listarTodos();
        $cargas = $this->repositorioCarga->listarPorVehiculo($vehiculo->getId());
        $resultadoAnalisis = $this->analisisRendimiento->analizarCargas($cargas);
        $rendimientoPromedio = $resultadoAnalisis['promedio'];

        require_once 'views/carga/registro.php';
    }

    public function guardarCarga()
    {
        $idVehiculo = (int)$_POST['id_vehiculo'];
        $fecha = $_POST['fecha'];
        $kilometraje = (float)$_POST['kilometraje'];
        $litros = (float)$_POST['litros'];
        $precioTotal = (float)$_POST['precio_total'];
        $idSurtidor = (int)$_POST['id_surtidor'];

        $carga = CargaCombustibleFactory::crear($fecha, $kilometraje, $litros, $precioTotal, $idVehiculo, $idSurtidor);

        if ($this->repositorioCarga->guardar($carga)) {
            echo "<script>alert('Carga registrada exitosamente'); window.location.href='index.php?action=landing';</script>";
        } else {
            echo "<script>alert('Error al registrar'); window.location.href='index.php?action=buscarPlacaCarga';</script>";
        }
    }
}
