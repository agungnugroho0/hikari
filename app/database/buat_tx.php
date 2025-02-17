<?php
include '../../autoloader.php';
admin();
$id_tagihan = $_POST['id_tagihan'];
$ket = $_POST['ket'];
if($ket == 'lolos'){
    $ket2 = '&lolos=ya';
} else {
    $ket2 = '';
};

$nominal = str_replace('.', '', $_POST['tx']);
$tagihan = tampil("SELECT * FROM tagihan WHERE id_tagihan = '$id_tagihan'");
foreach($tagihan as $view){
    $jenis_tagihan = $view['jenis_tagihan'];
    $biaya_tagihan = $view['biaya_tagihan'];
    $nis = $view['nis'];
    $sisa_tagihan = $view['sisa_tagihan'];
}
if($nominal<$sisa_tagihan){
    $status_tagihan = 'belum lunas';
} else {
    $status_tagihan = 'lunas';
};
$sisa_tagihan2 = $sisa_tagihan - $nominal;
$d_tagihan=[
    ':id_tagihan'=>$id_tagihan,
    ':jenis_tagihan'=>$jenis_tagihan,
    ':biaya_tagihan' =>$biaya_tagihan,
    ':nis'=>$nis,
    ':status_tagihan'=>$status_tagihan,
    ':sisa_tagihan' =>$sisa_tagihan2
];
$where=[
    ':id_tagihan'=>$id_tagihan
];
$idtx = idbaru('TX','id_tx','log_pembayaran');
$d_bayar =[
    ':id_tx'=>$idtx,
    ':nis'=>$nis,
    ':ket_bayar' => $jenis_tagihan,
    ':jumlah'=>$nominal,
    ':kekurangan'=>$sisa_tagihan2,
    ':tgl_bayar'=> date('Y-m-d')
];
perbarui('tagihan',$d_tagihan, $where);
masukan('log_pembayaran',$d_bayar);
header("Location:../../public/admin/detail_siswa.php?nis=$nis$ket2");

