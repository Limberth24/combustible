<?php
interface IEstrategiaRendimiento
{
    public function calcular(float $kilometrosRecorridos, float $litros): float;
    public function getNombre(): string;
}
