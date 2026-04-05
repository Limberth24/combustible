<?php
class Vehiculo
{
    private $id;
    private $placa;
    private $modelo;
    private $tipoCombustible;

    public function __construct(int $id = 0, string $placa = '', string $modelo = '', string $tipoCombustible = '')
    {
        $this->id = $id;
        $this->placa = strtoupper(trim($placa));
        $this->modelo = $modelo;
        $this->tipoCombustible = $tipoCombustible;
    }

    public function getId(): int { return $this->id; }
    public function getPlaca(): string { return $this->placa; }
    public function getModelo(): string { return $this->modelo; }
    public function getTipoCombustible(): string { return $this->tipoCombustible; }
}
?>
