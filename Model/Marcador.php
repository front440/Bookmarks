<?php

#Importar modelo de abstracción de base de datos
require_once('DBAbstractModel.php');

class Marcador extends DBAbstractModel
{
    /*CONSTRUCCIÓN DEL MODELO SINGLETON*/
    private static $instancia;
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación no es permitida', E_USER_ERROR);
    }

    // Atributos
    private $id;
    private $descripcion;
    private $enlace;
    private $idUsuario;
    private $created_at;
    private $updated_at;

    public function set()
    {
        $this->query = "INSERT INTO marcador(descripcion, enlace, idUsuario) VALUES(:descripcion, :enlace, :idUsuario)";

        // $this->parametros['id'] = $this->id;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['enlace'] = $this->enlace;
        $this->parametros['idUsuario'] = $this->idUsuario;
        $this->get_results_from_query();
        $this->mensaje = "descripcion añadida";
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function get($id = "")
    {
        if ($id != "") {
            $this->query = "SELECT * from marcador WHERE id = :id";

            $this->parametros["id"] = $id;

            $this->get_results_from_query();
        }
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = "marcdor encontrado";
        } else {
            $this->mensaje = "marcdor no encontrado";
        }
        return $this->rows;
    }

    public function edit($id = "")
    {
        $this->query = "UPDATE marcador SET descripcion=:descripcion, enlace=:enlace WHERE id=:id";
        $this->parametros["id"] = $id;
        $this->parametros["descripcion"] = $this->descripcion;
        $this->parametros["enlace"] = $this->enlace;

        $this->get_results_from_query();
        $this->mensaje = "descripcion modificada";
    }

    public function delete($id = "")
    {
        $this->query = "DELETE FROM marcador WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'marcador eliminado';

    }

    

    public function getAll()
    {
        $this->query = "SELECT * FROM marcador";

        $this->get_results_from_query();

        return $this->rows;
    }

    public function getMarcadorbyUser($idUsuario) {
        $this->query = "SELECT * FROM marcador WHERE idUsuario = :idUsuario";
        $this->parametros['idUsuario'] = $idUsuario;
        $this->get_results_from_query();
        $this->mensaje = 'Consulta realizada';

        return $this->rows;
    }
}
