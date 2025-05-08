<?php
require __DIR__.'/../../autoloader.php';
admin();
$nis = $_GET['nis'] ?? null;
$lolos = $_GET['lolos'] ?? null;
$siswa = $_GET['siswa'] ?? null;

$params = [];
if ($nis) $params[] = "nis=$nis";
if ($lolos) $params[] = "lolos=ya";
if ($siswa) $params[] = "siswa=ya";

$url = "view/viewsiswa.php";
if (!empty($params)) {
    $url = "view/detail_siswa.php?" . implode("&", $params);
};
?>


<iframe src="<?= $url ?>" frameborder="0" class="w-full h-[87vh]"></iframe>

