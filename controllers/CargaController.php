<?php
require_once 'models/Vehiculo.php';
require_once 'models/Surtidor.php';
require_once 'models/Carga.php';

class CargaController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function mostrarBuscarPlaca() {
        require_once 'views/carga/buscar.php';
    }
    
    public function mostrarRegistroCarga() {
        $placa = strtoupper(trim($_POST['placa']));
        
        $sql = "SELECT * FROM vehiculos WHERE placa = '$placa'";
        $resultado = mysqli_query($this->conn, $sql);
        
        if(mysqli_num_rows($resultado) == 0) {
            echo "<script>alert('No existe un vehiculo con la placa $placa'); window.location.href='index.php?action=buscarPlacaCarga';</script>";
            return;
        }
        
        $vehiculo = mysqli_fetch_assoc($resultado);
        $sql = "SELECT * FROM surtidores ORDER BY nombre";
        $surtidores = mysqli_query($this->conn, $sql);
        
        require_once 'views/carga/registro.php';
    }
    
    public function guardarCarga() {
        $id_vehiculo = $_POST['id_vehiculo'];
        $fecha = $_POST['fecha'];
        $kilometraje = $_POST['kilometraje'];
        $litros = $_POST['litros'];
        $precio_total = $_POST['precio_total'];
        $id_surtidor = $_POST['id_surtidor'];
        
        $sql = "INSERT INTO cargas (fecha, kilometraje, litros, precio_total, id_vehiculo, id_surtidor) 
                VALUES ('$fecha', $kilometraje, $litros, $precio_total, $id_vehiculo, $id_surtidor)";
        
        if(mysqli_query($this->conn, $sql)) {
            echo "<script>alert('Carga registrada exitosamente'); window.location.href='index.php?action=landing';</script>";
        } else {
            echo "<script>alert('Error al registrar: " . mysqli_error($this->conn) . "'); window.location.href='index.php?action=buscarPlacaCarga';</script>";
        }
    }
}
?>