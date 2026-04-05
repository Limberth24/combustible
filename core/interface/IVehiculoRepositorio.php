<?php
interface IVehiculoRepositorio
{
    public function buscarPorPlaca(string $placa): ?Vehiculo;
    public function buscarPorId(int $id): ?Vehiculo;
    public function guardar(Vehiculo $vehiculo): bool;
    public function listarTodos(): array;
}
