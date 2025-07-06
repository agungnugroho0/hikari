<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\DashboardController;
$kelas = (new DashboardController())->index();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>
<body>
   <h2 class="font-semibold text-2xl mb-2 font-[Lato] dark:text-white">DASHBOARD</h2>
    <input type="month" class="border-2 border-gray-200 rounded p-1 outline-none " id="month" name="month" value="<?php echo date('Y-m'); ?>">
    <div class="sm:grid sm:grid-cols-2 gap-2 mt-2">
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white">
            <h2 class="font-semibold text-base font-[Lato] ">Jumlah Siswa Lolos Bulan <span id="bln"></span></h2>
            <div id="chartLolos"></div>
        </div>
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white">
            <h2 class="font-semibold text-base font-[Lato]">Jadwal Mensetsu </h2>
            <div id="chartMensetsu"></div>

        </div>
        
    </div>

    <div class="grid md:grid-cols-3 gap-2 grid-cols-1 mt-2">
      <?php foreach ($kelas as $kls) : ?>
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white">
          <h2 class="font-semibold text-base font-[Lato]">Presensi Kelas <?php echo $kls['kelas']; ?></h2>
          <div id="chartKelas<?php echo $kls['id_kelas']; ?>"></div>
        </div>
      <?php endforeach; ?>
      
    </div>
</body>

<div id="kelasData" data-kelas='<?php echo json_encode(array_column($kelas, 'id_kelas')); ?>'></div>

<script>
  // if (typeof initdashboard === "function") {
  //   initdashboard();
  // } else {
  //   console.warn("initdashboard belum siap!");
  // }
</script>
</html>