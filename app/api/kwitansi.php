<?php
include '../../autoloader.php';
admin();
ob_start();
$id_tx = $_GET['tx'];
if(isset($_GET['lolos'])== true){
   $tabel = 'lolos';
}elseif(isset($_GET['siswa'])== true){
    $tabel = 'siswa';
}
ob_end_clean(); 
kuitansi($id_tx,$tabel);