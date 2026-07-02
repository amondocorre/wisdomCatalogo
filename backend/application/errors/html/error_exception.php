<?php
header('Content-Type: application/json');
echo json_encode([
    'status' => 'error',
    'message' => "Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine()
]);
exit;
?>
