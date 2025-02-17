<?php 
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
admin();
$nis = $_POST['nis'];
$ket2 = $_POST['ket'];
$_POST = toUpperCase($_POST);
if ($ket2 == 'lolos') {
    $foto_siswa = tampil("SELECT foto FROM lolos WHERE nis='$nis'");
    foreach ($foto_siswa as $value){
        $foto = $value['foto'];
    };
    $dir = "&lolos";
    $tabel = 'lolos';
} elseif ($ket2 == 'siswa') {
    $foto_siswa = tampil("SELECT foto FROM siswa WHERE nis='$nis'");
    foreach ($foto_siswa as $value){
        $foto = $value['foto'];
    };
    $dir = "";
    $tabel = 'siswa';
};


// Periksa apakah ada file baru yang diunggah
if ($_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
    $fotos = uploadFotoSiswa($_FILES['foto'], $nis);
    if (is_array($fotos) && $fotos['status'] === 'success') {
        $foto = $fotos['foto'];
    } else {
        $foto_siswa;
        foreach ($foto_siswa as $value){
            $foto = $value['foto'];
        }
    }
}

// Ambil data dari POST

 $data = [
    ':nis' => $nis,
    ':nama' => $_POST['nama_lengkap'],
    ':panggilan' => $_POST['カタカナ'],
    ':tgl' => $_POST['tgl'],
    ':id_kelas' => $_POST['id_kelas'],
    ':gender' => $_POST['gender'],
    ':tempat_lahir' => $_POST['tempat_lahir'],
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
    ':merokok' => $_POST['merokok'],
    ':alkohol' => $_POST['alkohol'],
    ':tangan' => $_POST['tangan'],
    ':hobi' => $_POST['hobi'],
    ':tujuan' => $_POST['tujuan_ke_jepang'],
    ':kelebihan' => $_POST['kelebihan'],
    ':kekurangan' => $_POST['kekurangan'],
    ':no_rumah' => $_POST['no_rumah'],
    ':foto' => $foto,
];

error_reporting(E_ALL);
$result = updateSiswa($data,$tabel);
if ($result) {
    header ("Location: ../../public/admin/detail_siswa.php?nis=$nis$dir&sukses");
} else {
    header ("Location: ../../detail_siswa.php?nis=$nis&pesan=fail");
}
?>
