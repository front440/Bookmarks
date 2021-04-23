<?php
require_once('DBAbstractModel.php');

class Usuario extends DBAbstractModel
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

    private $id;
    private $usuario;
    private $password;


    function getId()
    {
        return $this->id;
    }

    function getUsuario()
    {
        return $this->usuario;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setId($id): void
    {
        $this->id = $id;
    }

    function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    function setPassword($password): void
    {
        $this->password = $password;
    }


    public function set()
    {
        $this->query = "INSERT INTO usuarios(usuario, password) VALUES(:usuario, :password)";

        // $this->parametros['id'] = $this->id;
        $this->parametros['id'] = $this->id;
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['password'] = $this->password;

        $this->get_results_from_query();
        $this->mensaje = "Usuario añadido";
    }

    public function get($id = "")
    {
        if ($id != "") {
            $this->query = "SELECT * from Usuarios WHERE id = :id";

            $this->parametros["id"] = $id;

            $this->get_results_from_query();
        }
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = "Usuario encontrado";
        } else {
            $this->mensaje = "Usuario no encontrado";
        }
        return $this->rows;
    }

    public function edit($id = "")
    {
        $this->query = "UPDATE usuarios SET usuario=:usuario, password=:password WHERE id=:id";
        $this->parametros["id"] = $id;
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['password'] = $this->password;

        $this->get_results_from_query();
        $this->mensaje = "Usuario modificado";
    }

    public function delete($id = "")
    {
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';
    }

    public function getUserbyNombre($usuario = "")
    {
        $user = "";
        $this->query = "SELECT * from marcador WHERE usuario =:usuario";
        $this->parametros['usuario'] = $usuario;

        if (count($this->rows) == 1) {

            $this->mensaje = "Usuario encontrado";

            $user = $this->rows[0]["usuario"];
            
        } else {
            $user = "Usuario no encontrado";

        }

        return $user;
    }

    /**
     * 
     */
    public function login($user, $pass)
    {
        $datosLogin = array();

        $this->query = "SELECT * from Usuarios WHERE usuario =:usuario and password =:password";
        $this->parametros['usuario'] = $user;
        $this->parametros['password'] = $pass;

        $this->get_results_from_query();



        if (count($this->rows) == 1) {

            $this->mensaje = "Usuario encontrado";

            $datosLogin["id"] = $this->rows[0]["id"];
            $datosLogin["usuario"] = $this->rows[0]["usuario"];

            /* if ($this->rows[0]["bloqueado"]) {
                $datosLogin["usuario"] = "bloqueado";
            } */
        } else {
            $this->mensaje = "Usuario no encontrado";

            $datosLogin["usuario"] = "invitado";
        }

        return $datosLogin;
    }
}
