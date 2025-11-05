<?php
session_start();
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'library';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) { die('Database connection failed'); }
$mysqli->set_charset('utf8mb4');
function is_logged_in() { return isset($_SESSION['user']); }
function current_user() { return $_SESSION['user'] ?? null; }
function is_admin() { return isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'student') === 'admin'; }
function require_login() { if (!is_logged_in()) { header('Location: /catphp/auth/login.php'); exit; } }
function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
