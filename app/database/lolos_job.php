<?php
require_once '../../autoloader.php';
admin();

$nis = $_POST['nis'];
$tgl_lolos = $_POST['tgl_lolos'];
$so = $_POST['so'];
$job = $_POST['job'];
$perusahaan = $_POST['perusahaan'];
// $hikari = $_POST['hikari'];
$hikari = str_replace('.', '', $_POST['hikari']);
$tagihan_so = str_replace('.', '', $_POST['tagihan_so']);

$loglolos = idbaru('LLS','id_loglolos','log_lolos');
$tagihan = idbaru('T','id_tagihan','tagihan');
$prefix = substr($tagihan,0,-3);
$angka = (int) substr($tagihan,-3);
$angka_baru = $angka+1;
$idtagihan2 = $prefix . str_pad($angka_baru, 3, '0', STR_PAD_LEFT);

$d_loglolos=[
    ':id_loglolos'=>$loglolos,
    ':nis'=>$nis,
    ':tgl_lolos'=>$tgl_lolos,
    ':so'=>$so,
    ':job'=>$job,
    ':perusahaan'=>$perusahaan
];
$d_tagihan1=[
    ':id_tagihan'=>$tagihan,
    ':jenis_tagihan'=>'Biaya Hikari',
    ':biaya_tagihan' =>$hikari,
    ':nis'=>$nis,
    ':status_tagihan'=>'Belum Lunas',
    ':sisa_tagihan' =>$hikari
];
$d_tagihan2=[
    ':id_tagihan'=>$idtagihan2,
    ':jenis_tagihan'=>'Biaya SO',
    ':biaya_tagihan' =>$tagihan_so,
    ':nis'=>$nis,
    ':status_tagihan'=>'Belum Lunas',
    ':sisa_tagihan' =>$tagihan_so
];
$wawancara = [
    ':nis'=>$nis
];

masukan('log_lolos',$d_loglolos);
masukan('tagihan',$d_tagihan1);
masukan('tagihan',$d_tagihan2);
pindahkanData('lolos','siswa',$nis);
hapus('wawancara',$wawancara);
hapus('siswa',$wawancara);
hapus('absen',$wawancara);
// hapus('keaktifan',$wawancara);
// echo "
//     <script>
//         if (window.innerWidth <= 768) {
//             window.location.href = '/hikari/public/view/wawancara.php?sukses';
//         } else {
//             window.location.href = '/hikari/public/admin/index.php?menu_id=3&sukses';
//         }
//     </script>
// ";
header("Location:../../public/admin/index.php?menu_Id=3&sukses");
