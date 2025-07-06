<?php
require_once __DIR__ . '/../../autoloader.php';
use app\controller\siswacontroller;

$controller = new siswacontroller();
$controller->insertsiswa($_POST, $_FILES);