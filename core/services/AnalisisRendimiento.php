<?php
require_once 'core/strategy/IEstrategiaRendimiento.php';

class AnalisisRendimiento
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

    public function analizarCargas(array $cargas): array
    {
        $resultado = [
            'cargasConMetricas' => [],
            'rendimientos' => [],
            'promedio' => 0,
            'desviacion' => 0
        ];

        $cargaAnterior = null;
        foreach ($cargas as $carga) {
            if ($cargaAnterior !== null) {
                $kmRecorridos = $this->calcularKmRecorridos(
                    $carga->getKilometraje(),
                    $cargaAnterior->getKilometraje()
                );

                if ($kmRecorridos > 0 && $carga->getLitros() > 0) {
                    $rendimiento = $this->calcularRendimiento($kmRecorridos, $carga->getLitros());
                    $costoPorKm = $this->calcularCostoPorKm($carga->getPrecioTotal(), $kmRecorridos);

                    $carga->rendimiento = $rendimiento;
                    $carga->kmRecorridos = $kmRecorridos;
                    $carga->costoPorKm = $costoPorKm;
                    $carga->esBajoRendimiento = $this->esBajoRendimiento($rendimiento);
                    $resultado['rendimientos'][] = $rendimiento;
                }
            }
            $resultado['cargasConMetricas'][] = $carga;
            $cargaAnterior = $carga;
        }

        $resultado['promedio'] = $this->calcularPromedio($resultado['rendimientos']);
        $resultado['desviacion'] = $this->calcularDesviacionEstandar($resultado['rendimientos']);

        return $resultado;
    }

    public function analizarPorSurtidor(array $cargas): array
    {
        $rendimientoSurtidores = [];
        $cargaAnterior = null;

        foreach ($cargas as $carga) {
            if ($cargaAnterior !== null) {
                $kmRecorridos = $this->calcularKmRecorridos(
                    $carga->getKilometraje(),
                    $cargaAnterior->getKilometraje()
                );

                if ($kmRecorridos > 0 && $carga->getLitros() > 0) {
                    $rendimiento = $this->calcularRendimiento($kmRecorridos, $carga->getLitros());
                    $idSurtidor = $carga->getIdSurtidor();

                    if (!isset($rendimientoSurtidores[$idSurtidor])) {
                        $rendimientoSurtidores[$idSurtidor] = [
                            'nombre' => $carga->surtidorNombre ?? 'Desconocido',
                            'ubicacion' => $carga->ubicacion ?? '',
                            'cargas' => 0,
                            'rendimientos' => [],
                            'costoTotal' => 0
                        ];
                    }

                    $rendimientoSurtidores[$idSurtidor]['rendimientos'][] = $rendimiento;
                    $rendimientoSurtidores[$idSurtidor]['cargas']++;
                    $rendimientoSurtidores[$idSurtidor]['costoTotal'] += $carga->getPrecioTotal();
                }
            }
            $cargaAnterior = $carga;
        }

        foreach ($rendimientoSurtidores as &$surtidor) {
            $surtidor['promedio'] = $this->calcularPromedio($surtidor['rendimientos']);
            $surtidor['esBajoRendimiento'] = $this->esBajoRendimiento($surtidor['promedio']);
        }

        uasort($rendimientoSurtidores, fn($a, $b) => $b['promedio'] <=> $a['promedio']);

        return $rendimientoSurtidores;
    }
}
