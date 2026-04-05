<?php
class Vehiculo {
    public $id;
    public $placa;
    public $modelo;
    public $tipo_combustible;
    
    public function __construct($placa = '', $modelo = '', $tipo_combustible = '') {
        $this->placa = $placa;
        $this->modelo = $modelo;
        $this->tipo_combustible = $tipo_combustible;
    }
}
?>