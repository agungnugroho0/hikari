<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
header('Content-Type: application/json');
$bulan = $_GET['bulan'];
$kelas = $_GET['kelas'] ;
    $absen = tampil("SELECT 
                            absen.tgl,
                            SUM(ket = 'H') AS hadir,
                            SUM(ket = 'I') AS izin,
                            SUM(ket = 'A') AS alpha,
                            SUM(ket = 'S') AS sakit,
                            SUM(ket = 'M') AS mensetsu
                            FROM absen
                            JOIN siswa ON absen.nis = siswa.nis
                            WHERE siswa.id_kelas = '$kelas' 
                            AND DATE_FORMAT(absen.tgl, '%Y-%m') = '$bulan'
                            GROUP BY absen.tgl
                            ORDER BY absen.tgl");


echo json_encode($absen);