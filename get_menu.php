<?php

header('Content-Type: application/json');
require_once 'db.php';

$statement = $pdo->query('SELECT id, name, description, category, price, image_url FROM menu_items ORDER BY id DESC');
$items = $statement->fetchAll();

echo json_encode($items);
