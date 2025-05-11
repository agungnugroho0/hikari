<?php
require '../../autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
guru();
$user = $_SESSION['username'];
$level = $_SESSION['level'];

$guru = tampil("SELECT * FROM staff WHERE nama = '$user'");
foreach ($guru as $g) {
    $id_kelas = $g['id_kelas'];
    $nama = $g['nama'];
    $foto = $g['foto'];
};

$kelasku = tampil("SELECT kelas FROM kelas WHERE id_kelas = '$id_kelas'");
foreach ($kelasku as $kl){
    $kelas = $kl['kelas'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../image/asset/logo.png">
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        @font-face{
            font-family:'Lato';
            src: url('../font/Lato-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body class="dark:bg-black bg-white">
    <header class="w-full px-6 py-2 flex ">
        <div>
            <?php
            if ($foto == null ){
                echo '<div class="py-2 "><img class="max-w-10 rounded-full mr-2" src="../image/asset/app.png" /></div>';
            } else {
                echo '<div class="py-2 "><img class="max-w-10 rounded-full mr-2" src="../image/photos/'.$foto.'" /></div>';
            }
            ?>
        </div>
        <a href="../../app/config/logout.php" class="cursor-pointer font-semibold overflow-hidden relative z-100 border border-black dark:border-white group px-5 py-1.5 h-10 ml-auto mt-2">
            <span class="relative z-10 text-black dark:text-white group-hover:text-white dark:group-hover:text-black text-base duration-500 font-semibold font-[Lato]">KELUAR</span>
            <span class="absolute w-full h-full bg-black dark:bg-gray-100 -left-32 top-0 -rotate-45 group-hover:rotate-0 group-hover:left-0 duration-500"></span>
            <span class="absolute w-full h-full bg-black dark:bg-gray-100 -right-32 top-0 -rotate-45 group-hover:rotate-0 group-hover:right-0 duration-500"></span>
        </a>
    </header>
    <main class="container w-full grid grid-cols-2 gap-3 mx-auto px-6 dark:bg-black">
        <div class="col-span-2 border-4 border-black dark:border-white w-full">
            <div class="p-2 flex items-center justify-between font-[Lato] font-semibold dark:text-white text-black">
                <p>Jumlah Siswa Lolos <span id="bln"></span> 
                <span id="kls" class="hidden sm:inline"></span>
                </p>
                <!-- <select name="tahun" id="tahun" class="dark:text-white dark:bg-black">
                    <script>
                        let tahunSekarang = new Date().getFullYear();
                        for (let i = tahunSekarang; i >= tahunSekarang - 5; i--) {
                            document.write(`<option value="${i}">${i}</option>`);
                        }
                    </script>
                </select>  -->
            <input type="month" class="py-1 px-2 rounded focus:outline-none shadow-sm dark:border dark:text-black" id="bulan" value="<?= date('Y-m')?>">
            <input type="hidden" value="<?= $kelas?>" id="kelas">
            </div>
            <div id="chartLolos" class="dark:bg-white pt-3"></div>
        </div>
        <a href="siswa.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/staff.png" alt="siswa" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:scale-150 sm:group-hover:scale-100 group-hover:translate-x-6 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">SISWA</p> 
        <a href="presensi.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/qr.png" alt="qr" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">PRESENSI</p> 
        </a>
        <a href="laporan.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/report.png" alt="laporan" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">LAPORAN</p> 
        </a>
        <a href="#" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/gear.png" alt="setting" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">SETTINGS</p> 
        </a>
        
    </main>
</body>
<!-- <script src="../javascript/grafik_lolos.js"></script> -->
<script src="/hikari/public/javascript/jumlah_lolos.js"></script>
<!-- <script src="../javascript/jumlah_lolos.js"></script> -->
<script>
     
</script>
</html>
