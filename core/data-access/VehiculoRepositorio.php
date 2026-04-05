<?php
require_once 'core/interface/IVehiculoRepositorio.php';
require_once 'models/Vehiculo.php';

class VehiculoRepositorio implements IVehiculoRepositorio
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function buscarPorPlaca(string $placa): ?Vehiculo
    {
        $placaUpper = strtoupper(trim($placa));
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vehiculos WHERE placa = ?");
        mysqli_stmt_bind_param($stmt, "s", $placaUpper);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            mysqli_stmt_close($stmt);
            return new Vehiculo($fila['id_vehiculo'], $fila['placa'], $fila['modelo'], $fila['tipo_combustible']);
        }
        mysqli_stmt_close($stmt);
        return null;
    }

    public function buscarPorId(int $id): ?Vehiculo
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vehiculos WHERE id_vehiculo = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            mysqli_stmt_close($stmt);
            return new Vehiculo($fila['id_vehiculo'], $fila['placa'], $fila['modelo'], $fila['tipo_combustible']);
        }
        mysqli_stmt_close($stmt);
        return null;
    }

    public function guardar(Vehiculo $vehiculo): bool
    {
        $stmt = mysqli_prepare($this->conn, "INSERT INTO vehiculos (placa, modelo, tipo_combustible) VALUES (?, ?, ?)");
        $placa = $vehiculo->getPlaca();
        $modelo = $vehiculo->getModelo();
        $tipoCombustible = $vehiculo->getTipoCombustible();
        mysqli_stmt_bind_param($stmt, "sss", $placa, $modelo, $tipoCombustible);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function listarTodos(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vehiculos ORDER BY placa");
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $vehiculos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $vehiculos[] = new Vehiculo($fila['id_vehiculo'], $fila['placa'], $fila['modelo'], $fila['tipo_combustible']);
        }
        mysqli_stmt_close($stmt);
        return $vehiculos;
    }

    public function obtenerRendimientoPromedio(int $idVehiculo): ?float
    {
        $stmt = mysqli_prepare($this->conn, "SELECT c.kilometraje, c.litros FROM cargas c WHERE c.id_vehiculo = ? ORDER BY c.fecha ASC, c.id_carga ASC");
        mysqli_stmt_bind_param($stmt, "i", $idVehiculo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $rendimientos = [];
        $cargaAnterior = null;

        while ($fila = mysqli_fetch_assoc($resultado)) {
            if ($cargaAnterior !== null) {
                $kmRecorridos = $fila['kilometraje'] - $cargaAnterior['kilometraje'];
                if ($kmRecorridos > 0 && $fila['litros'] > 0) {
                    $rendimientos[] = $kmRecorridos / $fila['litros'];
                }
            }
            $cargaAnterior = $fila;
        }
        mysqli_stmt_close($stmt);

        return count($rendimientos) > 0 ? array_sum($rendimientos) / count($rendimientos) : null;
    }
}
