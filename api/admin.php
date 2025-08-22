<?php
require_once __DIR__ . '/../config/config.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403); echo 'Acesso negado.'; exit;
}

$action = $_POST['action'] ?? null;
if ($action === 'create_product') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category_slug = trim($_POST['category_slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);

    if (!$name || !$slug || !$category_slug || $price <= 0) { die('Dados inválidos'); }

    $pdo = db();
    $cat_id = $pdo->prepare('SELECT id FROM categories WHERE slug=?');
    $cat_id->execute([$category_slug]);
    $cid = $cat_id->fetchColumn();
    if (!$cid) { die('Categoria inválida'); }

    $stmt = $pdo->prepare('INSERT INTO products (category_id, name, slug, description, price, is_active) VALUES (?,?,?,?,?,1)');
    $stmt->execute([$cid, $name, $slug, $description, $price]);
    log_event($_SESSION['user']['id'], 'product_created', json_encode(['name'=>$name,'slug'=>$slug]));
    header('Location: /public/admin/index.php'); exit;
}

echo 'Ação não reconhecida';
