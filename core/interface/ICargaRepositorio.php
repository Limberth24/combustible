<?php
interface ICargaRepositorio
{
    public function buscarPorId(int $id): ?Carga;
    public function guardar(Carga $carga): bool;
    public function listarPorVehiculo(int $idVehiculo): array;
    public function listarTodos(): array;
}
