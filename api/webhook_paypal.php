<?php
// api/webhook_paypal.php - Placeholder. Em produção valide o webhook via SDK.
require_once __DIR__ . '/../config/config.php';
$purchase_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($purchase_id > 0) {
  $stmt = db()->prepare('UPDATE purchases SET status="paid" WHERE id=?');
  $stmt->execute([$purchase_id]);
  log_event(null, 'paypal_paid', json_encode(['purchase_id'=>$purchase_id]));
  echo 'OK';
} else {
  http_response_code(400); echo 'invalid';
}
