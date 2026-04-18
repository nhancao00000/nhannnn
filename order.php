<?php

session_start();
header('Content-Type: application/json');
require_once 'db.php';

$payload = json_decode(file_get_contents('php://input'), true);
$userId = (int)($payload['user_id'] ?? 0);
$items = $payload['items'] ?? [];
$paymentMethod = trim($payload['payment_method'] ?? 'Cash on Delivery');
$deliveryAddress = trim($payload['delivery_address'] ?? '');
$customerNote = trim($payload['customer_note'] ?? '');

if ($userId <= 0 || empty($items)) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu đơn hàng không hợp lệ.'
    ]);
    exit;
}

if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_id'] !== $userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.'
    ]);
    exit;
}

$totalAmount = 0;
foreach ($items as $item) {
    $price = (float)($item['price'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 0);
    $totalAmount += $price * $quantity;
}

if ($totalAmount <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Tổng tiền đơn hàng không hợp lệ.'
    ]);
    exit;
}

try {
    $pdo->beginTransaction();

    $orderStatement = $pdo->prepare(
        'INSERT INTO orders (
            user_id, total_amount, status, payment_method, payment_status,
            delivery_address, customer_note, driver_name, driver_phone,
            delivery_status, tracking_lat, tracking_lng
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $paymentStatus = $paymentMethod === 'Cash on Delivery' ? 'Unpaid' : 'Paid';
    $orderStatement->execute([
        $userId,
        $totalAmount,
        'Pending',
        $paymentMethod,
        $paymentStatus,
        $deliveryAddress,
        $customerNote,
        'Driver A',
        '0901234567',
        'Preparing',
        10.776889,
        106.700806
    ]);
    $orderId = $pdo->lastInsertId();

    $detailStatement = $pdo->prepare(
        'INSERT INTO order_items (order_id, menu_item_id, item_name, quantity, price) VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($items as $item) {
        $detailStatement->execute([
            $orderId,
            (int)$item['id'],
            $item['name'],
            (int)$item['quantity'],
            (float)$item['price']
        ]);
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Đặt hàng thành công. Mã đơn của bạn là #' . $orderId,
        'order_id' => (int)$orderId
    ]);
} catch (PDOException $exception) {
    $pdo->rollBack();

    echo json_encode([
        'success' => false,
        'message' => 'Không thể lưu đơn hàng: ' . $exception->getMessage()
    ]);
}
