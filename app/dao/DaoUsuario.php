<?php 

class DaoUsuario extends DaoBase {

    public function __construct() {
        parent::__construct();
        $this->objeto = new Usuario();
    }


    /* public function login() {
        $_query = "select * from usuario where nomUsuario = ? and pass = ?";

        $_params = [$this->objeto->getNomUsuario(), $this->objeto->getPass()];

        $this->con->query($_query, $_params);
        
    }
 */

    public function cargarDatosUsuario() {
        $_query = "select u.*, r.descRol, a.descAuth
        from usuario u
        inner join rol r on r.codigoRol = u.codigoRol
        inner join authUsuario a on a.codigoAuth = u.codigoAuth
        where u.codigoUsuario = ".$this->objeto->getCodigoUsuario();

        $resultado = $this->con->query($_query);

        $json = json_encode($resultado->fetch_assoc());

        return $json;
    }

    public function registrar() {
        $_query = "call registrarUsuario('".$this->objeto->getNombre()."', '".$this->objeto->getApellido()."','".$this->objeto->getNomUsuario()."', '".$this->objeto->getEmail()."', '".$this->objeto->getPass()."', ".$this->objeto->getCodigoRol().")";

        $resultado = $this->con->query($_query);

        if($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function autorizar() {
        $_query = "update usuario set codigoAuth = 1 where codigoUsuario = ".$this->objeto->getCodigoUsuario();
        $resultado = $this->con->query($_query);

        if($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function editar() {
        $_query = "call editarUsuario('".$this->objeto->getNombre()."', '".$this->objeto->getApellido()."','".$this->objeto->getNomUsuario()."', '".$this->objeto->getEmail()."', ".$this->objeto->getCodigoRol().", ".$this->objeto->getCodigoUsuario().")";

        $resultado = $this->con->query($_query);

        if($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function eliminar() {
        $_query = "delete from usuario where codigoUsuario = ".$this->objeto->getCodigoUsuario();

        $resultado = $this->con->query($_query);

        if($resultado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function mostrarUsuarios() {
        $_query = "call mostrarUsuarios()";

        $resultado = $this->con->query($_query);

        $_json = '';

        while($fila = $resultado->fetch_assoc()) {

            $object = json_encode($fila);

            $btnAutorizar = '<button id=\"'.$fila["codigoUsuario"].'\" class=\"ui btnAutorizar icon yellow small button\"><i class=\"key icon\"></i></button>';
            $btnEditar = '<button id=\"'.$fila["codigoUsuario"].'\" class=\"ui btnEditar icon blue small button\"><i class=\"edit icon\"></i></button>';
            $btnEliminar = '<button id=\"'.$fila["codigoUsuario"].'\" class=\"ui btnEliminar icon negative small button\"><i class=\"trash icon\"></i></button>';

            $acciones = ', "Acciones": "'.$btnAutorizar.' '.$btnEditar.' '.$btnEliminar.'"';

            $object = substr_replace($object, $acciones, strlen($object) -1, 0);

            $_json .= $object.',';
        }

        $_json = substr($_json,0, strlen($_json) - 1);

        echo '{"data": ['.$_json .']}';
    }

}