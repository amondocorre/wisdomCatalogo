<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthToken {

    private $protected_routes = [
        'producto_controller'
    ];

    public function validateToken() {
        $CI =& get_instance();
        
        // CORS Headers (Permitir peticiones desde React)
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        
        // Si es una petición OPTIONS (Preflight de CORS), terminamos con 200 OK
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $class = $CI->router->fetch_class();

        // Si la clase actual está protegida, validamos el token
        if (in_array($class, $this->protected_routes)) {
            $headers = $CI->input->request_headers();
            $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : null);
            
            if (!$auth_header) {
                $this->denyAccess('Token no proveído');
            }

            // Formato esperado: Bearer <token>
            list($jwt) = sscanf($auth_header, 'Bearer %s');

            if (!$jwt) {
                $this->denyAccess('Formato de token inválido');
            }

            $CI->load->helper('jwt');
            $decoded = jwt_decode($jwt);

            if (!$decoded) {
                $this->denyAccess('Token inválido o expirado');
            }

            // Opcional: Pasar los datos del usuario al controlador
            $CI->current_user = $decoded;
        }
    }

    private function denyAccess($message) {
        $CI =& get_instance();
        $CI->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'error', 'message' => $message]));
        $CI->output->_display();
        exit();
    }
}
