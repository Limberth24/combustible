<?php
// Factory Method - GOF
require_once 'models/Carga.php';
require_once 'models/Vehiculo.php';
require_once 'models/Surtidor.php';

class CargaCombustibleFactory
{
    public static function crear(string $fecha, float $kilometraje, float $litros, float $precioTotal, int $idVehiculo, int $idSurtidor): Carga
    {
        if (empty($fecha) || $kilometraje < 0 || $litros <= 0 || $idVehiculo <= 0) {
            throw new InvalidArgumentException("Datos inválidos para crear carga");
        }
        return new Carga(0, $fecha, $kilometraje, $litros, $precioTotal, $idVehiculo, $idSurtidor);
    }

    public static function crearVehiculo(string $placa, string $modelo, string $tipoCombustible): Vehiculo
    {
        return new Vehiculo(0, $placa, $modelo, $tipoCombustible);
    }

    public static function crearSurtidor(string $nombre, string $ubicacion): Surtidor
    {
        return new Surtidor(0, $nombre, $ubicacion);
    }
}
?>
