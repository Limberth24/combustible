<?php
require_once 'core/data-access/VehiculoRepositorio.php';
require_once 'core/data-access/CargaRepositorio.php';
require_once 'core/data-access/SurtidorRepositorio.php';

class RepositorioFactory
{
    private static $vehiculosRepositorio = null;
    private static $cargasRepositorio = null;
    private static $surtidoresRepositorio = null;

    public static function crearVehiculoRepositorio($conn)
    {
        if (self::$vehiculosRepositorio === null) {
            self::$vehiculosRepositorio = new VehiculoRepositorio($conn);
        }
        return self::$vehiculosRepositorio;
    }

    public static function crearCargaRepositorio($conn)
    {
        if (self::$cargasRepositorio === null) {
            self::$cargasRepositorio = new CargaRepositorio($conn);
        }
        return self::$cargasRepositorio;
    }

    public static function crearSurtidorRepositorio($conn)
    {
        if (self::$surtidoresRepositorio === null) {
            self::$surtidoresRepositorio = new SurtidorRepositorio($conn);
        }
        return self::$surtidoresRepositorio;
    }
}
?>
