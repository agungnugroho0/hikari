<?php
require_once __DIR__."/../../autoloader.php";
use app\controller\financecontroller;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$controller = new financecontroller();
$controller->index($search);
