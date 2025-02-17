<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
$nis = $_POST['nis'];
$tgl = date('Y-m-d');

// validasi apakah siswa sudah absen hari ini
$result = tampil("SELECT COUNT(*) AS count FROM absen WHERE nis = '$nis' AND tgl = '$tgl'");
foreach ($result as $row) {
    $result = $row['count'];
};
if ($result > 0) {
    echo "Siswa sudah melakukan Presensi hari ini";
    exit;
};

// ambil data siswa
$siswa = tampil("SELECT nama FROM siswa WHERE nis = $nis");
foreach ($siswa as $data) {
    $nama = $data['nama'];
};

// //buat id_absen
$id_absen = idbaru('ABS', 'id_absen', 'absen');


// // masukkan data ke absen
$data = [
    ':id_absen' => $id_absen,
    ':nis' => $nis,
    ':nama' => $nama,
    ':tgl' => $tgl,
    ':ket' => 'H'
];
masukan('absen',$data);
echo 'Presensi sudah masuk';
