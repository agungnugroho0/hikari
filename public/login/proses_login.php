<?php
session_start();
require_once __DIR__.'/../../autoloader.php';

use app\core\Database;
use app\controller\Authentication;

$auth = new Authentication();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// validasi input karakter tertentu
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || !preg_match('/^[a-zA-Z0-9_]+$/', $password)) {
    header("Location: ../../index.php?pesan=gagal");
    exit;
}

$level = $auth->login($username,$password);

if ($level === 'admin') {
    header("Location: ../../public/admin/index.php");
} elseif ($level === 'guru') {
    header("Location: ../../public/guru/index.php");
} else {
    header("Location: ../../index.php?pesan=gagal");
}
exit;