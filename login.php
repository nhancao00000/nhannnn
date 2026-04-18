<?php

session_start();
header('Content-Type: application/json');
require_once 'db.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng nhập đầy đủ email và mật khẩu.'
    ]);
    exit;
}

$statement = $pdo->prepare('SELECT id, full_name, email, password, role FROM users WHERE email = ? LIMIT 1');
$statement->execute([$email]);
$user = $statement->fetch();

$isValidPassword = $user && (password_verify($password, $user['password']) || hash_equals($user['password'], $password));

if (!$user || !$isValidPassword) {
    echo json_encode([
        'success' => false,
        'message' => 'Thông tin đăng nhập không chính xác.'
    ]);
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_role'] = $user['role'];

echo json_encode([
    'success' => true,
    'message' => 'Đăng nhập thành công.',
    'user' => [
        'id' => $user['id'],
        'full_name' => $user['full_name'],
        'email' => $user['email'],
        'role' => $user['role']
    ]
]);
