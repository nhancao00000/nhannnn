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

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$category = trim($_POST['category'] ?? '');
$price = (float)($_POST['price'] ?? 0);

if ($name === '' || $description === '' || $category === '' || $price <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all menu fields.'
    ]);
    exit;
}

$statement = $pdo->prepare(
    'INSERT INTO menu_items (name, description, category, price) VALUES (?, ?, ?, ?)'
);
$statement->execute([$name, $description, $category, $price]);

echo json_encode([
    'success' => true,
    'message' => 'Menu item added successfully.'
]);
