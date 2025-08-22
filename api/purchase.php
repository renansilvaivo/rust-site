<?php
require_once __DIR__ . '/../config/config.php';

function json_out($arr){ header('Content-Type: application/json'); echo json_encode($arr); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_SESSION['user'])) json_out(['ok'=>false,'error'=>'Precisa estar logado.']);
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!$data) { $data = $_POST; }

    $product_id = isset($data['product_id']) && $data['product_id'] !== '' ? (int)$data['product_id'] : null;
    $custom_amount = isset($data['custom_amount']) ? (float)$data['custom_amount'] : null;
    $payment_method = in_array(($data['payment_method'] ?? 'pix'), ['pix','paypal']) ? $data['payment_method'] : 'pix';

    if (!$product_id && !$custom_amount) json_out(['ok'=>false,'error'=>'Produto ou valor inválido.']);

    if ($product_id) {
        $stmt = db()->prepare('SELECT * FROM products WHERE id=? AND is_active=1');
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if (!$product) json_out(['ok'=>false,'error'=>'Produto não encontrado.']);
    }
    $pdo = db();
    $stmt = $pdo->prepare('INSERT INTO purchases (user_id, product_id, custom_amount, payment_method, status) VALUES (?,?,?,?, "pending")');
    $stmt->execute([$_SESSION['user']['id'], $product_id, $custom_amount, $payment_method]);
    $purchase_id = (int)$pdo->lastInsertId();
    log_event($_SESSION['user']['id'], 'purchase_created', json_encode(['purchase_id'=>$purchase_id,'method'=>$payment_method]));

    $instructions = '';
    if ($payment_method === 'pix') {
        // Placeholder de instruções PIX
        $amount = $product_id ? (float)$product['price'] : (float)$custom_amount;
        $instructions = "Pague via PIX para a chave: ".PIX_KEY." no valor de R$ ".number_format($amount,2,',','.');
    } else {
        // Placeholder PayPal
        $instructions = "Pague via PayPal. Após o pagamento, aguarde a confirmação.";
    }

    json_out(['ok'=>true,'purchase'=>['id'=>$purchase_id,'status'=>'pending'],'instructions'=>$instructions]);
}

http_response_code(405); echo 'Método não suportado';
