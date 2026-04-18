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

$users = $pdo->query('SELECT id, full_name, email, phone, role, created_at FROM users ORDER BY id DESC')->fetchAll();
$menuItems = $pdo->query('SELECT id, name, description, category, price, created_at FROM menu_items ORDER BY id DESC')->fetchAll();
$orders = $pdo->query(
    'SELECT orders.id, users.full_name, users.email, orders.total_amount, orders.status, orders.delivery_status,
            orders.payment_method, orders.payment_status, orders.created_at
     FROM orders
     INNER JOIN users ON users.id = orders.user_id
     ORDER BY orders.id DESC'
)->fetchAll();

$sales = $pdo->query(
    "SELECT
        COUNT(*) AS total_orders,
        COALESCE(SUM(total_amount), 0) AS total_revenue,
        COALESCE(SUM(CASE WHEN status = 'Completed' THEN total_amount ELSE 0 END), 0) AS completed_revenue,
        COALESCE(AVG(total_amount), 0) AS average_order_value
     FROM orders"
)->fetch();

echo json_encode([
    'success' => true,
    'stats' => [
        'users' => count($users),
        'menu_items' => count($menuItems),
        'orders' => count($orders),
        'total_revenue' => (float)$sales['total_revenue'],
        'completed_revenue' => (float)$sales['completed_revenue'],
        'average_order_value' => (float)$sales['average_order_value']
    ],
    'users_data' => $users,
    'menu_data' => $menuItems,
    'orders_data' => $orders
]);
