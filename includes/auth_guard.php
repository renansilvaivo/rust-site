<?php
// includes/auth_guard.php
if (empty($_SESSION['user'])) {
    header('Location: /public/login.php');
    exit;
}
?>
