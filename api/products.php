<?php
require_once __DIR__ . '/../config/config.php';
header('Content-Type: application/json');
$rows = db()->query('SELECT id, name, description, price FROM products WHERE is_active=1')->fetchAll();
echo json_encode(['ok'=>true,'products'=>$rows]);
