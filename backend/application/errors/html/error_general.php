<?php
header('Content-Type: application/json');
echo json_encode([
    'status' => 'error',
    'message' => "Error [$heading]: $message"
]);
exit;
?>
