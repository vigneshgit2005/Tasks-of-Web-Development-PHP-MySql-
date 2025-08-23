<?php
require_once __DIR__ . '/../db.php';
session_start();

function current_user() {
    return $_SESSION['user'] ?? null;
}
function require_login() {
    if (!current_user()) {
        header('Location: login.php');
        exit;
    }
}
function login($user) {
    $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username']];
}
function logout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
function is_owner($post_user_id) {
    $u = current_user();
    return $u && ((int)$post_user_id === (int)$u['id']);
}
