<?php
require_once '../../autoloader.php';
admin();
$nis = $_POST['nis'];
$ket = $_POST['ket'];
if($ket == 'lolos'){
    $ket2 = '&lolos=ya';
} else {
    $ket2 = '';
}
$tagihan = str_replace('.', '', $_POST['tagihan']);
$idtagihan = idbaru('T','id_tagihan','tagihan');

$d_tagihan=[
    ':id_tagihan'=>$idtagihan,
    ':jenis_tagihan'=>$_POST['jenis_tagihan'],
    ':biaya_tagihan' =>$tagihan,
    ':nis'=>$nis,
    ':status_tagihan'=>'Belum Lunas',
    ':sisa_tagihan' =>$tagihan
];
masukan('tagihan',$d_tagihan);
header("Location:../../public/admin/view/detail_siswa.php?nis=$nis$ket2");
