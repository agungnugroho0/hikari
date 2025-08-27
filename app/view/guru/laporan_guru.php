<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\kelascontroller;
$model1 = new kelascontroller();
$kelas = $model1->semuakelas();
session_start();
$id_kelas = $_SESSION['id_kelas'] ?? null;
foreach ($kelas as $k) {
    // Do something with $k
    if ($k['id_kelas'] === $id_kelas) {
        // This is the selected class
        $kelas = $k['kelas'];
    }
}

?>

<body>
    <div class="mx-2 flex flex-col sm:flex-row gap-3 mt-3 sm:mt-0">
        <input type="month" class="py-1 px-2 rounded focus:outline-none shadow-sm" id="bulan" value="<?= date('Y-m')?>">
        <input type="hidden" id="kelas" value="<?= $kelas ?>">
    </div>

    <div class="sm:grid sm:grid-cols-2 gap-2 mt-2">
      <div class="border-2 p-2 rounded border-gray-200 bg-white ">
            <h2 class="font-semibold text-base font-[Lato]">Rekapan Presensi Siswa Bulan <span id="bln2"></span> Kelas <span id="kls2"></span></h2>
            <div id="chartKelas"></div>
      </div>
    </div>  
    <div class="mx-auto w-full mt-3" id="hasil"></div>
</body>

