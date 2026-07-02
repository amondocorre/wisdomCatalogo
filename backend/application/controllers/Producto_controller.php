<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargar el modelo de productos
        $this->load->model('Producto_model');
    }

    public function index() {
        // Obtenemos los productos activos
        $productos = $this->Producto_model->get_activos();
        
        // Estructuramos de forma jerárquica: Procedencia -> Tipo -> Producto
        // Aunque esto se puede hacer en el cliente, el backend lo envía agrupado para facilitar.
        
        $jerarquia = [];

        foreach ($productos as $p) {
            $procedencia = $p->procedencia;
            $tipo = $p->tipo;

            if (!isset($jerarquia[$procedencia])) {
                $jerarquia[$procedencia] = [];
            }

            if (!isset($jerarquia[$procedencia][$tipo])) {
                $jerarquia[$procedencia][$tipo] = [];
            }

            $jerarquia[$procedencia][$tipo][] = [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'ruta_imagen' => $p->ruta_imagen
            ];
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'data' => $jerarquia
            ]));
    }
}
