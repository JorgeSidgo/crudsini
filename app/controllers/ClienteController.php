<?php

class ClienteController extends ControladorBase {

    public static function clientes()
    {
        self::loadMain();
        require_once './app/view/Sistema/clientes.php';
    }

    public function mostrarClientes() {
        $dao = new DaoCliente();

        echo $dao->mostrarClientes();
    }

}

?>