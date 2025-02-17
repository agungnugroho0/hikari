<?php
function idbaru($awal,$nama_tableid,$tabel){
$hurufawal = $awal;
$kodeawal = $hurufawal.date("Ymd");
$nilaiterbesar = tampil("SELECT max($nama_tableid) as $nama_tableid FROM $tabel WHERE $nama_tableid LIKE '$kodeawal%'");
if(!empty($nilaiterbesar)){
    foreach ($nilaiterbesar as $nilai){
        $nilaii = $nilai[$nama_tableid];
    }
    $angkaTerakhir = intval(substr($nilaii, -3));
    $angkaBaru = str_pad($angkaTerakhir + 1, 3, '0', STR_PAD_LEFT);
} else {
    $angkaBaru = 001;
}
return $kodeawal.$angkaBaru;
}