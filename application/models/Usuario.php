<?php
//Verificacion para no acceder desde URL para mas seguridad
defined('BASEPATH') OR exit('No se permite el acceso directo al script');
//creamos clase usuario
class Usuario extends CI_Model {
    //metodo para obetener lista de usuarios
    public function get_usuarios() {
        return $this->db->get('usuario')->result(); //usuario nombre de tabla
    }
}