<?php

header('Content-Type: application/json');
require_once 'db.php';

$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';

if ($fullName === '' || $email === '' || $phone === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng điền đầy đủ thông tin đăng ký.'
    ]);
    exit;
}

$checkStatement = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$checkStatement->execute([$email]);

if ($checkStatement->fetch()) {
    echo json_encode([
        'success' => false,
        'message' => 'Email này đã được sử dụng.'
    ]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insertStatement = $pdo->prepare(
    'INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)'
);
$insertStatement->execute([$fullName, $email, $phone, $hashedPassword, 'customer']);

echo json_encode([
    'success' => true,
    'message' => 'Đăng ký thành công. Đang chuyển sang trang đăng nhập.'
]);
