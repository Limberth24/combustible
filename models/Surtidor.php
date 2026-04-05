<?php
class Surtidor
{
    private $id;
    private $nombre;
    private $ubicacion;

    public function __construct(int $id = 0, string $nombre = '', string $ubicacion = '')
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
    }

    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getUbicacion(): string { return $this->ubicacion; }
}
?>
