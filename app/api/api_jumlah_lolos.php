<?php
// require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
header('Content-Type: application/json');
require '../../autoloader.php';

// $tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y'); // Default ke tahun ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m'); // Default ke bulan ini
$kelas = $_GET['kelas'];


// if (!is_numeric($tahun) || $tahun < 2000 || $tahun > 2100) {
//     error_log("Permintaan mencurigakan: tahun=" . $_GET['tahun']);
//     echo json_encode([
//         'status' => 'error',
//         'message' => 'Tahun tidak valid.'
//     ]);
//     exit;
// }

// $jumlah_lolos = tampil("SELECT DATE_FORMAT(tgl_lolos, '%Y-%m') AS bulan, COUNT(*) AS jumlah_lolos 
//           FROM log_lolos 
//           WHERE YEAR(tgl_lolos) = $tahun
//           GROUP BY bulan 
//           ORDER BY bulan");

$jumlah_lolos = tampil("SELECT DATE_FORMAT(log.tgl_lolos, '%d') as 'tgl', COUNT(log.tgl_lolos) AS jumlah_lolos FROM log_lolos log JOIN lolos ON log.nis = lolos.nis JOIN kelas k ON lolos.id_kelas = k.id_kelas WHERE DATE_FORMAT(log.tgl_lolos, '%Y-%m') = '$bulan' AND k.kelas = '$kelas' GROUP BY DATE_FORMAT(tgl_lolos, '%d')");
echo json_encode($jumlah_lolos);