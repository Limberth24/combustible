<?php
require_once 'core/interface/ISurtidorRepositorio.php';
require_once 'models/Surtidor.php';

class SurtidorRepositorio implements ISurtidorRepositorio
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function buscarPorId(int $id): ?Surtidor
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM surtidores WHERE id_surtidor = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            mysqli_stmt_close($stmt);
            return new Surtidor($fila['id_surtidor'], $fila['nombre'], $fila['ubicacion']);
        }
        mysqli_stmt_close($stmt);
        return null;
    }

    public function guardar(Surtidor $surtidor): bool
    {
        $stmt = mysqli_prepare($this->conn, "INSERT INTO surtidores (nombre, ubicacion) VALUES (?, ?)");
        $nombre = $surtidor->getNombre();
        $ubicacion = $surtidor->getUbicacion();
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $ubicacion);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function actualizar(Surtidor $surtidor): bool
    {
        $stmt = mysqli_prepare($this->conn, "UPDATE surtidores SET nombre = ?, ubicacion = ? WHERE id_surtidor = ?");
        $nombre = $surtidor->getNombre();
        $ubicacion = $surtidor->getUbicacion();
        $id = $surtidor->getId();
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $ubicacion, $id);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function eliminar(int $id): bool
    {
        $stmt = mysqli_prepare($this->conn, "DELETE FROM surtidores WHERE id_surtidor = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function listarTodos(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM surtidores ORDER BY nombre");
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $surtidores = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $surtidores[] = new Surtidor($fila['id_surtidor'], $fila['nombre'], $fila['ubicacion']);
        }
        mysqli_stmt_close($stmt);
        return $surtidores;
    }
}
