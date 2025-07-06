<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\indexgurucontroller;
use app\controller\kelascontroller;
session_start();
$id_kelas = $_SESSION['id_kelas'];

$kelas = (new kelascontroller())->pilihkelas($id_kelas);
$siswa = (new indexgurucontroller())->previewsiswa($id_kelas);
$nama = $_SESSION['username'] ?? 'guest';
$foto = $_SESSION['foto'] ?? null;
?> 
<body class="mb-11">
    
<p class="text-slate-500">ようこそ</p>
<p class="text-xl dark:text-slate-50 font-semibold"><?= $nama ?></p>


<div class=" my-2">
    <input type="month" class="border-2 p-2 border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white rounded-lg" id="bulan" value="<?= date('Y-m')?>">
    <input id="kelas" class="py-1 px-2 rounded focus:outline-none shadow-sm" value="<?= $kelas[0]['kelas']?>" hidden>
</div>
<header class="flex md:flex-row flex-col gap-3">

    <!-- grafik  -->
    <div class="border-2 p-2 border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white rounded-lg w-full md:w-3/6">
        <h2 class="font-semibold text-base font-[Lato]  ">Jumlah Siswa Lolos</h2>
        <div id="chartLolos"></div>
    </div>
    <div class="border-2 p-2 border-gray-200 bg-white shadow-sm dark:bg-slate-950 dark:text-white rounded-lg w-full md:w-3/6">
            <h2 class="font-semibold text-base font-[Lato]">Rekapan Presensi</h2>
            <div id="chartKelas"></div>
    </div>
</header>
<!-- endgrafik  -->

 <!-- preview tabel siswa -->
<div class="bg-slate-50 dark:bg-gray-700 dark:text-slate-200 p-2 mt-4 rounded">
            <div class="flex flex-row p-2 m-1">
                <p class="grow">Siswa</p>
                <a href="#" class="font-bold text-blue-700 dark:text-slate-400" onclick="loadPage(event,'router.php?page=daftar_siswa')" data-menu-id="2" >Lihat Semua</a>
            </div>
            <!--mulai pengulangan siswa dengan limit 5  -->
            <?php foreach ($siswa as $s):?>
            <div class="flex flex-row hover:bg-slate-100 dark:hover:bg-slate-800 p-2 m-1 align-middle items-center">
                <div class="min-w-8 max-w-8 min-h-8 max-h-8 object-top overflow-hidden rounded-full mr-2">
                    <img src="/public/image/photos/<?= $s['foto']?>" alt="foto_siswa" >
                </div>
                <p class="grow"><?= $s['nama']?></p>
                <p class="bg-red-200 px-2 rounded-full font-semibold text-red-900 text-nowrap opacity-70">Ikut Job</p>

            </div>
            <?php endforeach;?>
            <!--akhir pengulangan siswa dengan limit 5  -->
         </div>
</body>|