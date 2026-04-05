<?php
class ConexionBD
{
    private static $instancia = null;
    private $conn;
    private $host = 'localhost';
    private $dbname = 'combustible';
    private $user = 'root';
    private $pass = '';

    private function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        if (!$this->conn) {
            die("Error de conexion: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->conn, "utf8");
    }

    public static function obtenerInstancia()
    {
        if (self::$instancia === null) {
            self::$instancia = new ConexionBD();
        }
        return self::$instancia;
    }

    public function obtenerConexion()
    {
        return $this->conn;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new Exception("No se puede serializar el singleton");
    }
}
