<?php
// require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
require '../../autoloader.php';

session_start();
$user = $_SESSION['username'];
$level = $_SESSION['level'];
$guru = tampil("SELECT * FROM staff WHERE nama = '$user'");
foreach ($guru as $g) {
    $id_kelas = $g['id_kelas'];
};
$siswa = tampil("SELECT s.nis, s.nama, s.id_kelas FROM siswa s LEFT JOIN absen a ON s.nis = a.nis AND a.tgl = CURDATE() WHERE s.id_kelas = '$id_kelas' AND a.nis IS NULL");
echo json_encode($siswa);
