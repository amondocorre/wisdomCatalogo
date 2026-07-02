<?php
require_once 'application/helpers/jwt_helper.php';
$payload = [
    'id' => 1,
    'username' => 'admin',
    'rol' => 'admin',
    'iat' => time(),
    'exp' => time() + 3600
];
echo jwt_encode($payload);
?>
