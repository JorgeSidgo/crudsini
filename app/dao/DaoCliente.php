<?php

class DaoCliente extends DaoBase
{

    public function __construct() {
        parent::__construct();
        $this->objeto = new Clientes();
    }

    public function mostrarClientes() {
        $_query = "select * from clientes;";

        $resultado = $this->con->query($_query);

        $_json = '';

        while($fila = $resultado->fetch_assoc()) {

            $object = json_encode($fila);
            
            $btnEditar = '<button id=\"'.$fila["codigoCliente"].'\" class=\"ui btnEditar icon blue small button\"><i class=\"edit icon\"></i></button>';
            $btnEliminar = '<button id=\"'.$fila["codigoCliente"].'\" class=\"ui btnEliminar icon negative small button\"><i class=\"trash icon\"></i></button>';

           // $acciones = ', "Acciones": "'.$btnEditar.' '.$btnEliminar.'"';

           // $object = substr_replace($object, $acciones, strlen($object) -1, 0);

            $_json .= $object.',';
        }

        $_json = substr($_json,0, strlen($_json) - 1);

        echo '{"data": ['.$_json .']}';
    }

}

?>