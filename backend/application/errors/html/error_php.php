<?php
header('Content-Type: application/json');
echo json_encode([
    'status' => 'error',
    'message' => "PHP Error [$severity]: $message in $filepath on line $line"
]);
exit;
?>
