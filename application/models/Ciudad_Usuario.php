<?php
//Verificacion para no acceder desde URL para mas seguridad
defined('BASEPATH') OR exit('No se permite el acceso directo al script');
//creamos clase ciudad
class Ciudad_Usuario extends CI_Model {
    
    public function Guardar_Ciudad_Usuario($IdUsuario, $IdCiudad) {
        $datos = [
            'IdUsuario' => $IdUsuario,
            'IdCiudad' => $IdCiudad
        ];
        return $this->db->insert('usuario_ciudad', $datos);   //para insertar en usuario ciudad
    } 
    //Para mostrar las actualizaciones 
    public function obtenerCiudadUsuario() {
        $this->db->select('u.id AS IdUsuario, u.nombre AS NombreUsuario, uc.IdCiudad, c.Ciudad AS NombreCiudad');
        $this->db->from('usuario_ciudad uc');
        $this->db->join('Usuario u', 'uc.IdUsuario = u.Id');
        $this->db->join('Ciudad c', 'uc.IdCiudad = c.IdCiudad');
        //INNER JOIN RESULTADO
        $query = $this->db->get();
        return $query->result_array(); 
    }

}