<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Simple JWT Helper para CodeIgniter sin dependencias externas
// NOTA: Para producción se recomienda usar firebase/php-jwt
if (!function_exists('jwt_encode')) {
    function jwt_encode($payload, $secret = 'secret_key_change_me') {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
}

if (!function_exists('jwt_decode')) {
    function jwt_decode($jwt, $secret = 'secret_key_change_me') {
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) != 3) {
            return false;
        }
        
        $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[0]));
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1]));
        $signature_provided = $tokenParts[2];
        
        // Verificar firma
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        if (hash_equals($base64UrlSignature, $signature_provided)) {
            $payloadObj = json_decode($payload);
            // Validar expiración si existe
            if (isset($payloadObj->exp) && $payloadObj->exp < time()) {
                return false;
            }
            return $payloadObj;
        }
        
        return false;
    }
}
