<?php

class UsuarioController extends ControladorBase {

    // Vistas y otras mierdas

    public static function gestion() {
        self::loadMain();
        require_once './app/view/Sistema/gestion.php';
    }

    // Métodos 

    public static function login() {
        $datos = $_REQUEST["datos"];

        $datos = json_decode($datos);


        $dao = new DaoUsuario();
        $dao->objeto->setNomUsuario($datos->user);
        $dao->objeto->setPass($datos->pass);
        
        $dao->login();
    }

    public function registrar() {
        $datos = $_REQUEST["datos"];

        $datos = json_decode($datos);

        $dao = new DaoUsuario();

        $dao->objeto->setNombre($datos->nombre);
        $dao->objeto->setApellido($datos->apellido);
        $dao->objeto->setNomUsuario($datos->user);
        $dao->objeto->setEmail($datos->correo);
        $dao->objeto->setPass($datos->pass);
        $dao->objeto->setCodigoRol($datos->rol);

        echo $dao->registrar();
     
    }

    public function eliminar() {
        $datos = $_REQUEST["id"];

        $dao = new DaoUsuario();

        $dao->objeto->setCodigoUsuario($datos);

        echo $dao->eliminar();
    }

    public function mostrarUsuarios() {
        $dao = new DaoUsuario();

        echo $dao->mostrarUsuarios();
    }
}