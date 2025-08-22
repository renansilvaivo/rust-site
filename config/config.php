<?php
// config/config.php
declare(strict_types=1);

// UPDATE THESE FOR YOUR SERVER
const DB_HOST = 'localhost';
const DB_NAME = 'deepsite_rust';
const DB_USER = 'root';
const DB_PASS = '';

// PIX settings (placeholder)
const PIX_KEY = 'sua_chave_pix_aqui'; // chave aleatória/celular/email
const PIX_RECEIVER_NAME = 'Seu Servidor Rust';
const PIX_CITY = 'Cidade';

// PayPal settings (placeholder)
const PAYPAL_CLIENT_ID = 'SEU_CLIENT_ID';
const PAYPAL_SECRET = 'SEU_SECRET';
const PAYPAL_WEBHOOK_ID = 'SEU_WEBHOOK_ID';
const PAYPAL_ENV = 'sandbox'; // 'live' em produção

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function log_event(?int $user_id, string $action, ?string $meta = null): void {
    $pdo = db();
    $stmt = $pdo->prepare('INSERT INTO logs (user_id, action, meta) VALUES (?,?,?)');
    $stmt->execute([$user_id, $action, $meta]);
}

session_start();
?>
