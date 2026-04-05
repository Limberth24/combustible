<?php
require_once 'core/factory/RepositorioFactory.php';
require_once 'core/services/AnalisisRendimiento.php';
require_once 'core/strategy/EstrategiaRendimientoEstandar.php';
require_once 'models/Vehiculo.php';
require_once 'models/Carga.php';
require_once 'models/Surtidor.php';

class HistorialController
{
    private $repositorioVehiculo;
    private $repositorioCarga;
    private $repositorioSurtidor;
    private $analisisRendimiento;

    public function __construct($conn)
    {
        $this->repositorioVehiculo = RepositorioFactory::crearVehiculoRepositorio($conn);
        $this->repositorioCarga = RepositorioFactory::crearCargaRepositorio($conn);
        $this->repositorioSurtidor = RepositorioFactory::crearSurtidorRepositorio($conn);
        $this->analisisRendimiento = new AnalisisRendimiento(
            new EstrategiaRendimientoEstandar()
        );
    }

    public function mostrarBuscarPlaca()
    {
        $surtidores = $this->repositorioSurtidor->listarTodos();
        require_once 'views/historial/buscar.php';
    }

    public function verHistorial()
    {
        $placa = strtoupper(trim($_POST['placa']));
        $fechaInicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
        $fechaFin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
        $idSurtidor = !empty($_POST['id_surtidor']) ? (int)$_POST['id_surtidor'] : null;

        $vehiculo = $this->repositorioVehiculo->buscarPorPlaca($placa);

        if ($vehiculo === null) {
            echo "<script>alert('No existe un vehículo con la placa $placa'); window.location.href='index.php?action=buscarPlacaHistorial';</script>";
            return;
        }

        if ($fechaInicio && $fechaFin) {
            $cargas = $this->repositorioCarga->listarPorFechas($fechaInicio, $fechaFin, $vehiculo->getId());
        } else {
            $cargas = $this->repositorioCarga->listarPorVehiculo($vehiculo->getId());
        }

        if ($idSurtidor) {
            $cargas = array_filter($cargas, fn($c) => $c->getIdSurtidor() === $idSurtidor);
        }

        $resultadoAnalisis = $this->analisisRendimiento->analizarCargas($cargas);
        $cargasConMetricas = $resultadoAnalisis['cargasConMetricas'];
        $rendimientoPromedio = $resultadoAnalisis['promedio'];
        $desviacionEstandar = $resultadoAnalisis['desviacion'];

        require_once 'views/historial/listado.php';
    }

    public function generarReporte()
    {
        $placa = $_POST['placa'];
        $vehiculo = $this->repositorioVehiculo->buscarPorPlaca($placa);
        $cargas = $this->repositorioCarga->listarPorVehiculo($vehiculo->getId());

        $resultadoAnalisis = $this->analisisRendimiento->analizarCargas($cargas);
        $rendimientoPromedio = $resultadoAnalisis['promedio'];
        $rendimientoSurtidores = $this->analisisRendimiento->analizarPorSurtidor($cargas);
        $esBajoRendimiento = $this->analisisRendimiento->esBajoRendimiento($rendimientoPromedio);

        require_once 'views/historial/reporte.php';
    }
}
