<?php
class Carga
{
    private $id;
    private $fecha;
    private $kilometraje;
    private $litros;
    private $precioTotal;
    private $idVehiculo;
    private $idSurtidor;
    
    public $surtidorNombre;
    public $ubicacion;
    public $rendimiento;
    public $kmRecorridos;

    public function __construct(int $id = 0, string $fecha = '', float $kilometraje = 0, float $litros = 0, float $precioTotal = 0, int $idVehiculo = 0, int $idSurtidor = 0)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->kilometraje = $kilometraje;
        $this->litros = $litros;
        $this->precioTotal = $precioTotal;
        $this->idVehiculo = $idVehiculo;
        $this->idSurtidor = $idSurtidor;
    }

    public function getId(): int { return $this->id; }
    public function getFecha(): string { return $this->fecha; }
    public function getKilometraje(): float { return $this->kilometraje; }
    public function getLitros(): float { return $this->litros; }
    public function getPrecioTotal(): float { return $this->precioTotal; }
    public function getIdVehiculo(): int { return $this->idVehiculo; }
    public function getIdSurtidor(): int { return $this->idSurtidor; }
}
?>
