<?php
define('BASEPATH', __DIR__ . '/system/');
require_once 'application/helpers/jwt_helper.php';
$payload = [
    'id' => 1,
    'username' => 'admin',
    'rol' => 'admin',
    'iat' => time(),
    'exp' => time() + 3600
];
$token = jwt_encode($payload);

$ch = curl_init('http://localhost/wisdom/backend/api/productos');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token"
]);
$response = curl_exec($ch);
echo "HTTP_CODE: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
echo "RESPONSE:\n$response\n";
?>
