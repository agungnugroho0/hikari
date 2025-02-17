<?php 
ob_start();
include '../../autoloader.php';
$nis = $_GET['nis'];
id_card($nis);
ob_end_clean(); 
?>