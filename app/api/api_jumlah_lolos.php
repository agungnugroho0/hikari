<?php

require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y'); // Default ke tahun ini


$jumlah_lolos = tampil("SELECT DATE_FORMAT(tgl_lolos, '%Y-%m') AS bulan, COUNT(*) AS jumlah_lolos 
          FROM log_lolos 
          WHERE YEAR(tgl_lolos) = $tahun
          GROUP BY bulan 
          ORDER BY bulan");

// header('Content-Type: application/json');
echo json_encode($jumlah_lolos);