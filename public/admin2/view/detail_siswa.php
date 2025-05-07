<?php 
include '../../../autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');

$nis= $_GET['nis'] ?? null;
$lolos = isset($_GET['lolos']);
$ket = $lolos ? 'lolos' : 'siswa';
echo $nis;
if ($lolos) {
    $job = tampil("
        SELECT l.tgl_lolos, l.so, l.job, l.perusahaan, so.so, so.foto_so
        FROM log_lolos l
        JOIN so ON l.so = so.so
        WHERE nis = '$nis'
    ");
} else {
    $job = tampil("
        SELECT w.*, s.nis, j.*
        FROM wawancara w
        JOIN siswa s ON w.nis = s.nis
        JOIN job j ON w.id_job = j.id_job
        WHERE s.nis = '$nis'
    ");
}

$siswa      = tampil("SELECT a.*,kls.kelas FROM $ket a JOIN kelas kls ON a.id_kelas = kls.id_kelas WHERE nis = '$nis'");
$kk         = tampil("SELECT * FROM kk WHERE nis = '$nis'");
$pendidikan = tampil("SELECT * FROM pendidikan WHERE nis = '$nis'");
$tx         = tampil("SELECT * FROM log_pembayaran WHERE nis = '$nis'");
$tagihan    = tampil("SELECT id_tagihan, status_tagihan, sisa_tagihan, jenis_tagihan FROM tagihan WHERE nis = '$nis'");
$sekarang   = new DateTime();


// if (isset($_GET['lolos'])== true){
//     $lolos = true;
//     $ket='lolos=ya';
//     $job = tampil("SELECT l.tgl_lolos,l.so,l.job,l.perusahaan,so.so,so.foto_so FROM log_lolos l JOIN so ON l.so = so.so WHERE nis = '".$nis."'");
// }else {
//     $lolos = false;
//     $ket='siswa=ya';
//     $ikut_job = tampil("SELECT w.*, s.nis,j.* FROM wawancara w JOIN siswa s ON w.nis = s.nis JOIN job j on w.id_job = j.id_job WHERE s.nis = '".$nis."'");
// }

// $siswa = tampil("SELECT * FROM $ket WHERE nis = '$nis'");
// $kk = tampil("SELECT * FROM kk WHERE nis = '$nis'");
// $pendidikan = tampil("SELECT * FROM pendidikan WHERE nis = '$nis'");
// $sekarang = new DateTime();
// $tx = tampil("SELECT * FROM log_pembayaran WHERE nis = '".$nis."'");
// $tagihan = tampil("SELECT id_tagihan,status_tagihan,sisa_tagihan,jenis_tagihan FROM tagihan WHERE nis = '".$nis."'");

?>
