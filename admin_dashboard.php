<?php

session_start();
header('Content-Type: application/json');
require_once 'db.php';

if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Bạn không có quyền truy cập trang admin.'
    ]);
    exit;
}

$users = $pdo->query('SELECT id, full_name, email, phone, role, created_at FROM users ORDER BY id DESC')->fetchAll();
$menuItems = $pdo->query('SELECT id, name, category, price, created_at FROM menu_items ORDER BY id DESC')->fetchAll();
$orders = $pdo->query(
    'SELECT orders.id, users.full_name, users.email, orders.total_amount, orders.status, orders.created_at
     FROM orders
     INNER JOIN users ON users.id = orders.user_id
     ORDER BY orders.id DESC'
)->fetchAll();

echo json_encode([
    'success' => true,
    'stats' => [
        'users' => count($users),
        'menu_items' => count($menuItems),
        'orders' => count($orders)
    ],
    'users_data' => $users,
    'menu_data' => $menuItems,
    'orders_data' => $orders
]);
