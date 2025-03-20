<?php
require '../../autoloader.php';
$nis = idbaru('','nis','siswa');
$_POST = toUpperCase($_POST);
$id_kelas = $_POST['id_kelas'] ?? '4';
$nama_lengkap = $_POST['nama_lengkap'];
$namaExist = cek_nama($nama_lengkap);
if ($namaExist > 0) {
    header('Location:../../siswa.php?sk&nama');
    exit;
}
$uploadResult = uploadFotoSiswa($_FILES['foto'], $nis);
if (is_array($uploadResult) && $uploadResult['status'] === 'success') {
    $foto = $uploadResult['foto'];
} else {
    header('Location:../../siswa.php?sk&foto');
    exit;
}

$data = [
    ':nis' => $nis,
    ':nama' => $_POST['nama_lengkap'],
    ':panggilan' =>$_POST['nama_panggilan'],
    ':tgl' =>$_POST['tgl_lahir'],
    ':id_kelas' => $id_kelas,
    ':gender' => $_POST['gender'],
    ':tempat_lhr' => $_POST['tempat_lahir'],
    ':provinsi' => $_POST['provinsi'],
    ':kabupaten' => $_POST['kabupaten'],
    ':kecamatan' => $_POST['kecamatan'],
    ':kelurahan' => $_POST['kelurahan'],
    ':rt' => $_POST['rt'],
    ':rw' => $_POST['rw'],
    ':wa' => $_POST['wa'],
    ':agama' => $_POST['agama'],
    ':status' => $_POST['status'],
    ':darah' => $_POST['darah'],
    ':bb' => $_POST['bb'],
    ':tb' => $_POST['tb'],
    ':merokok' => $_POST['rokok'],
    ':alkohol' => $_POST['alkohol'],
    ':tangan' => "TIDAK",
    ':hobi' => "",
    ':tujuan' => "",
    ':kelebihan' => "",
    ':kekurangan' => "",
    ':foto' => $foto,
    ':no_rumah' => $_POST['no_rumah']
];
masukan('siswa',$data);
header('Location:../../siswa.php?sk&sukses');