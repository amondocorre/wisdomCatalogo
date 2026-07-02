<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$is_localhost = (isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || $_SERVER['HTTP_HOST'] === '127.0.0.1'));

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost', // Siempre es localhost en cPanel o hosting compartido
    'username' => $is_localhost ? 'root' : 'wisdomco_admin',
    'password' => $is_localhost ? '' : '.hackers.2026',
    'database' => $is_localhost ? 'catalogo_db' : 'wisdomco_catalogo',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
