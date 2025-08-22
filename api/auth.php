<?php
require_once __DIR__ . '/../config/config.php';

function json_out($arr){ header('Content-Type: application/json'); echo json_encode($arr); exit; }

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? ($_GET['action'] ?? null);
    if ($action === 'login') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!$email || !$password) { json_out(['ok'=>false,'error'=>'Dados incompletos']); }
        $stmt = db()->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            log_event(null, 'login_failed', $email);
            json_out(['ok'=>false,'error'=>'Credenciais inválidas']);
        }
        $_SESSION['user'] = $user;
        log_event($user['id'], 'login_ok', null);
        header('Location: /public/dashboard.php'); exit;
    }
    if ($action === 'register') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $nickname = trim($_POST['nickname'] ?? '');
        $steam_id = trim($_POST['steam_id'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            json_out(['ok'=>false,'error'=>'E-mail inválido ou senha curta (min 6).']);
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = db()->prepare('INSERT INTO users (email, password_hash, nickname, steam_id) VALUES (?,?,?,?)');
            $stmt->execute([$email, $hash, $nickname ?: null, $steam_id ?: null]);
            $id = (int)db()->lastInsertId();
            $_SESSION['user'] = db()->query('SELECT * FROM users WHERE id='.$id)->fetch();
            log_event($id, 'register', null);
            header('Location: /public/dashboard.php'); exit;
        } catch (PDOException $e) {
            json_out(['ok'=>false,'error'=>'E-mail já cadastrado.']);
        }
    }
}
http_response_code(405); echo 'Método não suportado';
