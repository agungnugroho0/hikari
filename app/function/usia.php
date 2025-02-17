<?php
function umur($tanggallahir) {
    $sekarang = new DateTime();
    $tgllahir = new DateTime($tanggallahir); // Membuat objek DateTime dari tanggal lahir
    $umur = $sekarang->diff($tgllahir)->y; // Menghitung selisih tahun
    return $umur; // Mengembalikan umur
}
?>