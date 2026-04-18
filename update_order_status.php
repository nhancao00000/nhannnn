<?php

session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Access denied.'
    ]);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
$orderId = (int)($payload['order_id'] ?? 0);
$status = trim($payload['status'] ?? '');
$deliveryStatus = trim($payload['delivery_status'] ?? '');
$paymentStatus = trim($payload['payment_status'] ?? '');

if ($orderId <= 0 || $status === '' || $deliveryStatus === '' || $paymentStatus === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid update payload.'
    ]);
    exit;
}

$statement = $pdo->prepare(
    'UPDATE orders SET status = ?, delivery_status = ?, payment_status = ? WHERE id = ?'
);
$statement->execute([$status, $deliveryStatus, $paymentStatus, $orderId]);

echo json_encode([
    'success' => true,
    'message' => 'Order updated successfully.'
]);
