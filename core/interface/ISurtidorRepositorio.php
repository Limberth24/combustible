<?php
interface ISurtidorRepositorio
{
    public function buscarPorId(int $id): ?Surtidor;
    public function guardar(Surtidor $surtidor): bool;
    public function actualizar(Surtidor $surtidor): bool;
    public function eliminar(int $id): bool;
    public function listarTodos(): array;
}
?>
