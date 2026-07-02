<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
*/

// Hook para verificar token de autorización y configurar CORS
$hook['post_controller_constructor'] = array(
    'class'    => 'AuthToken',
    'function' => 'validateToken',
    'filename' => 'AuthToken.php',
    'filepath' => 'hooks'
);
