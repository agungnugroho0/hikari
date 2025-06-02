<?php

header('Content-Type: application/json');
require '../../autoloader.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m'); // Default ke bulan ini
$kelas = $_GET['kelas'];


$jumlah_lolos = tampil("SELECT DATE_FORMAT(log.tgl_lolos, '%d') as 'tgl', COUNT(log.tgl_lolos) AS jumlah_lolos FROM log_lolos log JOIN lolos ON log.nis = lolos.nis JOIN kelas k ON lolos.id_kelas = k.id_kelas WHERE DATE_FORMAT(log.tgl_lolos, '%Y-%m') = '$bulan' AND k.kelas = '$kelas' GROUP BY DATE_FORMAT(tgl_lolos, '%d')");
echo json_encode($jumlah_lolos);