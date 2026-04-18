<?php

session_start();
header('Content-Type: application/json');
require_once 'db.php';

$orderId = (int)($_GET['order_id'] ?? 0);

if (!isset($_SESSION['user_id']) || $orderId <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid tracking request.'
    ]);
    exit;
}

$statement = $pdo->prepare(
    'SELECT id, user_id, total_amount, status, payment_method, payment_status, delivery_address,
            customer_note, driver_name, driver_phone, delivery_status, tracking_lat, tracking_lng, created_at
     FROM orders
     WHERE id = ? LIMIT 1'
);
$statement->execute([$orderId]);
$order = $statement->fetch();

if (!$order || (int)$order['user_id'] !== (int)$_SESSION['user_id']) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'You cannot view this order.'
    ]);
    exit;
}

$createdAt = strtotime($order['created_at']);
$minutes = max(0, (int)floor((time() - $createdAt) / 60));

if ($minutes < 2) {
    $deliveryStatus = 'Preparing';
    $status = 'Pending';
    $latOffset = 0.0000;
    $lngOffset = 0.0000;
} elseif ($minutes < 5) {
    $deliveryStatus = 'Driver Assigned';
    $status = 'Confirmed';
    $latOffset = 0.0032;
    $lngOffset = 0.0028;
} elseif ($minutes < 10) {
    $deliveryStatus = 'On the Way';
    $status = 'Delivering';
    $latOffset = 0.0068;
    $lngOffset = 0.0051;
} else {
    $deliveryStatus = 'Delivered';
    $status = 'Completed';
    $latOffset = 0.0094;
    $lngOffset = 0.0070;
}

$latitude = (float)$order['tracking_lat'] + $latOffset;
$longitude = (float)$order['tracking_lng'] + $lngOffset;
$eta = max(0, 15 - $minutes);

echo json_encode([
    'success' => true,
    'order' => [
        'id' => (int)$order['id'],
        'status' => $status,
        'delivery_status' => $deliveryStatus,
        'payment_method' => $order['payment_method'],
        'payment_status' => $order['payment_status'],
        'delivery_address' => $order['delivery_address'],
        'customer_note' => $order['customer_note'],
        'driver_name' => $order['driver_name'],
        'driver_phone' => $order['driver_phone'],
        'tracking_lat' => round($latitude, 6),
        'tracking_lng' => round($longitude, 6),
        'eta_minutes' => $eta
    ]
]);
