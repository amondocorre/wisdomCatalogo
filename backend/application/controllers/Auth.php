<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('jwt');
    }

    public function login() {
        // Leer el body (JSON)
        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
        $request = json_decode($stream_clean);

        if (!$request || !isset($request->username) || !isset($request->password)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Credenciales incompletas']));
            return;
        }

        // Sanitización y consulta a la DB
        $username = $request->username;
        $query = $this->db->get_where('usuarios', ['username' => $username, 'estado' => 1]);
        $user = $query->row();

        // Validar contraseña
        if ($user && password_verify($request->password, $user->password_hash)) {
            // Crear el token
            $payload = [
                'id' => $user->id,
                'username' => $user->username,
                'rol' => $user->rol,
                'iat' => time(), // Tiempo de emisión
                'exp' => time() + (60 * 60 * 2) // Expira en 2 horas
            ];

            $token = jwt_encode($payload);

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'token' => $token,
                    'user' => [
                        'username' => $user->username,
                        'rol' => $user->rol
                    ]
                ]));
        } else {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Credenciales inválidas']));
        }
    }
}
