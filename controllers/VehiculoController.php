<?php
require_once 'models/Vehiculo.php';

class VehiculoController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function mostrarFormularioRegistro() {
        require_once 'views/vehiculo/registro.php';
    }
    
    public function guardarVehiculo() {
        $placa = strtoupper(trim($_POST['placa']));
        $modelo = trim($_POST['modelo']);
        $tipo_combustible = trim($_POST['tipo_combustible']);
        
        if(empty($placa) || empty($modelo) || empty($tipo_combustible)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index.php?action=nuevoRegistro';</script>";
            return;
        }
        
        $sql = "SELECT id_vehiculo FROM vehiculos WHERE placa = '$placa'";
        $resultado = mysqli_query($this->conn, $sql);
        
        if(mysqli_num_rows($resultado) > 0) {
            echo "<script>alert('La placa $placa ya esta registrada'); window.location.href='index.php?action=nuevoRegistro';</script>";
            return;
        }
        
        $sql = "INSERT INTO vehiculos (placa, modelo, tipo_combustible) VALUES ('$placa', '$modelo', '$tipo_combustible')";
        
        if(mysqli_query($this->conn, $sql)) {
            echo "<script>alert('Vehiculo registrado exitosamente'); window.location.href='index.php?action=landing';</script>";
        } else {
            echo "<script>alert('Error al registrar: " . mysqli_error($this->conn) . "'); window.location.href='index.php?action=nuevoRegistro';</script>";
        }
    }
}
?>