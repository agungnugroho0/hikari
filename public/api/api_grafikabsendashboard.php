<?php
require_once __DIR__."/../../autoloader.php";
use app\controller\grafikcontroller;
$controller = new grafikcontroller;
if (isset($_GET['laporan'])) {
    $controller->grafikabsenlaporan();
} else {
    $controller->grafikabsendashboard();
}
