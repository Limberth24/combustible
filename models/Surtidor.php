
<?php
class Surtidor {
    public $id;
    public $nombre;
    public $ubicacion;
    
    public function __construct($nombre = '', $ubicacion = '') {
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
    }
}
?>