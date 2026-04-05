<?php
// Repository Pattern - GOF
require_once 'core/interface/ICargaRepositorio.php';
require_once 'models/Carga.php';

class CargaRepositorio implements ICargaRepositorio
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function buscarPorId(int $id): ?Carga
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM cargas WHERE id_carga = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            mysqli_stmt_close($stmt);
            return $this->crearCargaDesdeFila($fila);
        }
        mysqli_stmt_close($stmt);
        return null;
    }

    public function guardar(Carga $carga): bool
    {
        $stmt = mysqli_prepare($this->conn, 
            "INSERT INTO cargas (fecha, kilometraje, litros, precio_total, id_vehiculo, id_surtidor) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $fecha = $carga->getFecha();
        $kilometraje = $carga->getKilometraje();
        $litros = $carga->getLitros();
        $precioTotal = $carga->getPrecioTotal();
        $idVehiculo = $carga->getIdVehiculo();
        $idSurtidor = $carga->getIdSurtidor();
        
        mysqli_stmt_bind_param($stmt, "sddiii", $fecha, $kilometraje, $litros, $precioTotal, $idVehiculo, $idSurtidor);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function listarPorVehiculo(int $idVehiculo): array
    {
        $stmt = mysqli_prepare($this->conn, 
            "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion FROM cargas c LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor WHERE c.id_vehiculo = ? ORDER BY c.fecha ASC, c.id_carga ASC"
        );
        mysqli_stmt_bind_param($stmt, "i", $idVehiculo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        return $this->obtenerCargas($resultado);
    }

    public function listarTodos(): array
    {
        $sql = "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion FROM cargas c LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor ORDER BY c.fecha DESC";
        $resultado = mysqli_query($this->conn, $sql);
        return $this->obtenerCargas($resultado);
    }

    public function listarPorFechas(string $fechaInicio, string $fechaFin, ?int $idVehiculo = null): array
    {
        if ($idVehiculo !== null) {
            $stmt = mysqli_prepare($this->conn,
                "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion FROM cargas c LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor WHERE c.fecha BETWEEN ? AND ? AND c.id_vehiculo = ? ORDER BY c.fecha ASC"
            );
            mysqli_stmt_bind_param($stmt, "ssi", $fechaInicio, $fechaFin, $idVehiculo);
        } else {
            $stmt = mysqli_prepare($this->conn,
                "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion FROM cargas c LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor WHERE c.fecha BETWEEN ? AND ? ORDER BY c.fecha ASC"
            );
            mysqli_stmt_bind_param($stmt, "ss", $fechaInicio, $fechaFin);
        }
        
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return $this->obtenerCargas($resultado);
    }

    public function listarPorSurtidor(int $idSurtidor): array
    {
        $stmt = mysqli_prepare($this->conn,
            "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion FROM cargas c LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor WHERE c.id_surtidor = ? ORDER BY c.fecha DESC"
        );
        mysqli_stmt_bind_param($stmt, "i", $idSurtidor);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        return $this->obtenerCargas($resultado);
    }

    private function obtenerCargas($resultado): array
    {
        $cargas = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $carga = $this->crearCargaDesdeFila($fila);
            $carga->surtidorNombre = $fila['surtidor_nombre'] ?? null;
            $carga->ubicacion = $fila['ubicacion'] ?? null;
            $cargas[] = $carga;
        }
        return $cargas;
    }

    private function crearCargaDesdeFila(array $fila): Carga
    {
        return new Carga($fila['id_carga'], $fila['fecha'], (float)$fila['kilometraje'], (float)$fila['litros'], (float)$fila['precio_total'], (int)$fila['id_vehiculo'], (int)$fila['id_surtidor']);
    }
}
