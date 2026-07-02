<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rutas de Autenticación
$route['api/login'] = 'auth/login';

// Rutas de Productos
$route['api/productos'] = 'producto_controller/index';
