<?php
require_once __DIR__."/../../autoloader.php";
use app\controller\absensiswacontroller;
$nis = $_POST['nis'];
$tgl = date('Y-m-d');

$controller = new absensiswacontroller();
$controller->api_proses_absen($nis,'H');