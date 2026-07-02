<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_activos() {
        // Uso de Query Builder (evita inyecciones SQL automáticamente)
        $this->db->select('id, nombre, ruta_imagen, procedencia, tipo');
        $this->db->from('productos');
        $this->db->where('estado', 1);
        $this->db->order_by('procedencia', 'ASC');
        $this->db->order_by('tipo', 'ASC');
        $this->db->order_by('nombre', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}
