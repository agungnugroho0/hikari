<?php
require_once __DIR__."/../../autoloader.php";
use app\controller\absensiswacontroller;
$nis = $_POST['nis'];
$tgl = date('Y-m-d');
$ket = $_POST['status'];

$controller = new absensiswacontroller();
$controller->api_proses_absen($nis,$ket);