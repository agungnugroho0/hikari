<?php
require_once __DIR__."/../../autoloader.php";
use app\controller\absensiswacontroller;
session_start();
$id_staff = $_SESSION['id_staff'];
$model = new absensiswacontroller();
$model->api_siswa_belumabsen($id_staff);

