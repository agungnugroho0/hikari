<?php
function naik($nis){
    $siswa = tampil("SELECT * FROM siswa WHERE nis = '$nis'");
    foreach ($siswa as $s) {
    $id_kelas = $s['id_kelas'];
    }
    $id_kelasbaru = $id_kelas - 1 ;
$where = [':nis' => $nis];
    $data = [':id_kelas' => $id_kelasbaru];
    perbarui('siswa', $data, $where);
}