<?php
require_once 'core/factory/RepositorioFactory.php';
require_once 'models/Surtidor.php';

class SurtidorController
{
    private $repositorioSurtidor;

    public function __construct($conn)
    {
        $this->repositorioSurtidor = RepositorioFactory::crearSurtidorRepositorio($conn);
    }

    public function mostrarListado()
    {
        $surtidores = $this->repositorioSurtidor->listarTodos();
        require_once 'views/surtidor/listado.php';
    }

    public function eliminarSurtidor()
    {
        $id = (int)$_GET['id'];
        
        if ($this->repositorioSurtidor->eliminar($id)) {
            echo "<script>alert('Surtidor eliminado exitosamente'); window.location.href='index.php?action=listarSurtidores';</script>";
        } else {
            echo "<script>alert('Error al eliminar. Verifique que no tenga cargas asociadas.'); window.location.href='index.php?action=listarSurtidores';</script>";
        }
    }

    public function mostrarFormularioRegistro()
    {
        require_once 'views/surtidor/registro.php';
    }

    public function guardarSurtidor()
    {
        $nombre = trim($_POST['nombre']);
        $ubicacion = trim($_POST['ubicacion']);

        if (empty($nombre) || empty($ubicacion)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index.php?action=nuevoSurtidor';</script>";
            return;
        }

        $surtidor = new Surtidor(0, $nombre, $ubicacion);
        
        if ($this->repositorioSurtidor->guardar($surtidor)) {
            echo "<script>alert('Surtidor registrado exitosamente'); window.location.href='index.php?action=listarSurtidores';</script>";
        } else {
            echo "<script>alert('Error al registrar'); window.location.href='index.php?action=nuevoSurtidor';</script>";
        }
    }

    public function mostrarFormularioEditar()
    {
        $id = (int)$_GET['id'];
        $surtidor = $this->repositorioSurtidor->buscarPorId($id);
        
        if ($surtidor === null) {
            echo "<script>alert('Surtidor no encontrado'); window.location.href='index.php?action=listarSurtidores';</script>";
            return;
        }
        
        require_once 'views/surtidor/editar.php';
    }

    public function actualizarSurtidor()
    {
        $id = (int)$_POST['id'];
        $nombre = trim($_POST['nombre']);
        $ubicacion = trim($_POST['ubicacion']);

        if (empty($nombre) || empty($ubicacion)) {
            echo "<script>alert('Todos los campos son obligatorios'); window.location.href='index.php?action=editarSurtidor&id=$id';</script>";
            return;
        }

        $surtidor = new Surtidor($id, $nombre, $ubicacion);
        
        if ($this->repositorioSurtidor->actualizar($surtidor)) {
            echo "<script>alert('Surtidor actualizado exitosamente'); window.location.href='index.php?action=listarSurtidores';</script>";
        } else {
            echo "<script>alert('Error al actualizar'); window.location.href='index.php?action=editarSurtidor&id=$id';</script>";
        }
    }
}
?>
