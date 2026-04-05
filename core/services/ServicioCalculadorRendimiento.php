<?php
require_once 'core/strategy/IEstrategiaRendimiento.php';

class ServicioCalculadorRendimiento
{
    private $estrategia;
    private const RENDIMIENTO_BAJO = 8.0;

    public function __construct(IEstrategiaRendimiento $estrategia)
    {
        $this->estrategia = $estrategia;
    }

    public function calcularKmRecorridos(float $kmActual, float $kmAnterior): float
    {
        return $kmActual - $kmAnterior;
    }

    public function calcularRendimiento(float $kmRecorridos, float $litros): float
    {
        return $this->estrategia->calcular($kmRecorridos, $litros);
    }

    public function calcularCostoPorKm(float $precioTotal, float $kmRecorridos): float
    {
        if ($kmRecorridos <= 0) return 0;
        return $precioTotal / $kmRecorridos;
    }

    public function esBajoRendimiento(float $rendimiento): bool
    {
        return $rendimiento < self::RENDIMIENTO_BAJO;
    }

    public function calcularPromedio(array $rendimientos): float
    {
        return count($rendimientos) > 0 ? array_sum($rendimientos) / count($rendimientos) : 0;
    }

    public function calcularDesviacionEstandar(array $rendimientos): float
    {
        if (count($rendimientos) < 2) return 0;
        $media = $this->calcularPromedio($rendimientos);
        $varianza = array_sum(array_map(fn($x) => pow($x - $media, 2), $rendimientos)) / count($rendimientos);
        return sqrt($varianza);
    }
}
