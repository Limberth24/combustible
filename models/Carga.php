<?php
class Carga
{
    public $id;
    public $fecha;
    public $kilometraje;
    public $litros;
    public $precio_total;
    public $id_vehiculo;
    public $id_surtidor;

    public function __construct($fecha = '', $kilometraje = 0, $litros = 0, $precio_total = 0, $id_vehiculo = 0, $id_surtidor = 0)
    {
        $this->fecha = $fecha;
        $this->kilometraje = $kilometraje;
        $this->litros = $litros;
        $this->precio_total = $precio_total;
        $this->id_vehiculo = $id_vehiculo;
        $this->id_surtidor = $id_surtidor;
    }
}
