<?php
require_once 'models/Vehiculo.php';
require_once 'models/Carga.php';
require_once 'models/Surtidor.php';

class HistorialController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function mostrarBuscarPlaca() {
        require_once 'views/historial/buscar.php';
    }
    
    public function verHistorial() {
        $placa = strtoupper(trim($_POST['placa']));
        
        $sql = "SELECT * FROM vehiculos WHERE placa = '$placa'";
        $resultado = mysqli_query($this->conn, $sql);
        
        if(mysqli_num_rows($resultado) == 0) {
            echo "<script>alert('No existe un vehiculo con la placa $placa'); window.location.href='index.php?action=buscarPlacaHistorial';</script>";
            return;
        }
        
        $vehiculo = mysqli_fetch_assoc($resultado);
        $id_vehiculo = $vehiculo['id_vehiculo'];
        
        $sql = "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion 
                FROM cargas c 
                LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor 
                WHERE c.id_vehiculo = $id_vehiculo 
                ORDER BY c.fecha ASC, c.id_carga ASC";
        $cargas_query = mysqli_query($this->conn, $sql);
        
        $cargas = [];
        $carga_anterior = null;
        
        while($carga = mysqli_fetch_assoc($cargas_query)) {
            if($carga_anterior) {
                $km_recorridos = $carga['kilometraje'] - $carga_anterior['kilometraje'];
                if($km_recorridos > 0 && $carga['litros'] > 0) {
                    $carga['rendimiento'] = $km_recorridos / $carga['litros'];
                    $carga['km_recorridos'] = $km_recorridos;
                } else {
                    $carga['rendimiento'] = null;
                    $carga['km_recorridos'] = null;
                }
            } else {
                $carga['rendimiento'] = null;
                $carga['km_recorridos'] = null;
            }
            $cargas[] = $carga;
            $carga_anterior = $carga;
        }
        
        require_once 'views/historial/listado.php';
    }
    
    public function generarReporte() {
        $placa = $_POST['placa'];
        
        $sql = "SELECT * FROM vehiculos WHERE placa = '$placa'";
        $resultado = mysqli_query($this->conn, $sql);
        $vehiculo = mysqli_fetch_assoc($resultado);
        $id_vehiculo = $vehiculo['id_vehiculo'];
        
        $sql = "SELECT c.*, s.nombre as surtidor_nombre, s.ubicacion 
                FROM cargas c 
                LEFT JOIN surtidores s ON c.id_surtidor = s.id_surtidor 
                WHERE c.id_vehiculo = $id_vehiculo 
                ORDER BY c.fecha ASC, c.id_carga ASC";
        $cargas_query = mysqli_query($this->conn, $sql);
        $cargas_array = [];
        
        while($carga = mysqli_fetch_assoc($cargas_query)) {
            $cargas_array[] = $carga;
        }
        
        $rendimiento_surtidores = [];
        $carga_anterior = null;
        
        foreach($cargas_array as $carga) {
            if($carga_anterior) {
                $km_recorridos = $carga['kilometraje'] - $carga_anterior['kilometraje'];
                if($km_recorridos > 0 && $carga['litros'] > 0) {
                    $rendimiento = $km_recorridos / $carga['litros'];
                    $id_surtidor = $carga['id_surtidor'];
                    $nombre_surtidor = $carga['surtidor_nombre'] ?? 'Desconocido';
                    
                    if(!isset($rendimiento_surtidores[$id_surtidor])) {
                        $rendimiento_surtidores[$id_surtidor] = [
                            'nombre' => $nombre_surtidor,
                            'ubicacion' => $carga['ubicacion'] ?? '',
                            'rendimientos' => []
                        ];
                    }
                    $rendimiento_surtidores[$id_surtidor]['rendimientos'][] = $rendimiento;
                }
            }
            $carga_anterior = $carga;
        }
        
        foreach($rendimiento_surtidores as &$surtidor) {
            $surtidor['promedio'] = count($surtidor['rendimientos']) > 0 
                ? array_sum($surtidor['rendimientos']) / count($surtidor['rendimientos']) 
                : 0;
        }
        
        uasort($rendimiento_surtidores, function($a, $b) {
            return $b['promedio'] <=> $a['promedio'];
        });
        
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte - <?php echo $placa; ?></title>
            <link rel="stylesheet" href="assets/style.css">
        </head>
        <body>
            <nav class="navbar"><div class="container"><div class="logo"><h1>CombustibleControl</h1></div>
            <ul class="nav-menu"><li><a href="index.php?action=landing">Inicio</a></li>
            <li><a href="index.php?action=nuevoRegistro">Nuevo Registro</a></li>
            <li><a href="index.php?action=buscarPlacaCarga">Registro</a></li>
            <li><a href="index.php?action=buscarPlacaHistorial">Historial</a></li></ul></div></nav>
            
            <div class="container"><div class="form-card">
                <h2>Reporte de Rendimiento</h2>
                <div class="alert alert-success">Vehiculo: <?php echo $vehiculo['placa']; ?> - <?php echo $vehiculo['modelo']; ?></div>
                
                <h3>Ranking de Surtidores</h3>
                <?php $pos=1; foreach($rendimiento_surtidores as $surtidor): ?>
                <div class="ranking-item"><strong><?php echo $pos++; ?>. <?php echo $surtidor['nombre']; ?></strong> - <?php echo number_format($surtidor['promedio'],2); ?> km/l</div>
                <?php endforeach; ?>
                
                <a href="index.php?action=buscarPlacaHistorial" class="btn btn-secondary">Volver</a>
            </div></div>
            <footer class="footer"><div class="container"><p>2024 Sistema de Control de Consumo de Combustible</p></div></footer>
        </body>
        </html>
        <?php
    }
}
?>