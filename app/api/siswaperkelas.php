<?php
header('Content-Type: application/json');
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');

$id_kelas = $_GET['id_kelas'] ?? 1;
$siswa = tampil("SELECT siswa.nis, siswa.nama,siswa.foto, siswa.tgl, wawancara.id_job, job.tgl_job 
                        FROM siswa 
                        LEFT JOIN wawancara 
                        ON siswa.nis = wawancara.nis 
                        LEFT JOIN job
                        ON wawancara.id_job = job.id_job 
                        WHERE id_kelas = $id_kelas 
                        ORDER BY siswa.gender, siswa.nama ASC");

$data = [];

foreach ($siswa as $s) {
    $data[] = [
        'nis' => $s['nis'],
        'nama' => $s['nama'],
        'foto' => $s['foto'] ? BASE_URL2 . 'public/image/photos/' . $s['foto'] : BASE_URL2 . 'public/image/asset/app.png',
        'umur' => umur($s['tgl']),
        'id_job' => $s['id_job'],
        'tgl_job' => !empty($s['id_job'])
    ? ($s['tgl_job'] === '0000-00-00' ? 'Belum ada jadwal' : date('d-m-Y', strtotime($s['tgl_job'])))
    : null,
    ];
}

echo json_encode([
    'status' => 'success',
    'data' => $data,
]);
?>