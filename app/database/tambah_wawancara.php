<?php
require_once '../../autoloader.php';

admin();
$nis = $_POST['nis'];
$id_job = $_POST['job'];
$id_baru = idbaru('W', 'id_w', 'wawancara');
$data = [
    ':id_w' => $id_baru,
    ':id_job' => $id_job,
    ':nis' => $nis
];
masukan('wawancara', $data);
header("Location:/public/admin/view/detail_siswa.php?nis=$nis");