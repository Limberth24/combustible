<?php
require_once 'IEstrategiaRendimiento.php';

class EstrategiaRendimientoEstandar implements IEstrategiaRendimiento
{
    public function calcular(float $kilometrosRecorridos, float $litros): float
    {
        if ($litros <= 0) {
            return 0;
        }
        return $kilometrosRecorridos / $litros;
    }

    public function getNombre(): string
    {
        return "Rendimiento Estandar (km/L)";
    }
}
