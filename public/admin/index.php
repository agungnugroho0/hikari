<?php 
require '../../autoloader.php' ;
if(isset($_GET['sukses'])){
    echo '<script>alert("Data Berhasil Disimpan");</script>';
}
admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../image/asset/logo.png">
    <title>ADMIN</title>
</head>
<body>
    <div class="md:hidden container flex mx-auto justify-center mt-2 gap-3 bg-red-900 max-w-sm rounded-md p-3 mb-3 flex-wrap">
        <a href="view/staff.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/staff.png" alt="wawancara" class="w-7 mb-1">
            <p class="text-sm">Staff</p>
        </a>
        <a href="view/wawancara.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/interview.png" alt="wawancara" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">Wawancara</p>
        </a>
        <a href="view/siswa.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/interview.png" alt="siswa" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">Siswa</p>
        </a>
        <a href="view/kelas.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/kelas.png" alt="siswa" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">Kelas</p>
        </a>
        <a href="view/viewlolos.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/lolos.png" alt="siswa" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">Lolos</p>
        </a>
        <a href="view/viewpresensi.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/report.png" alt="siswa" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">Presensi</p>
        </a>
        <a href="view/viewscan.php" class="bg-white flex flex-col justify-center m-1 rounded-sm p-2 items-center h-16 w-16">
            <img src="../image/asset/qr.png" alt="siswa" class="w-7 mb-1">
            <p class="text-[0.7rem] text-center break-words whitespace-normal leading-tight ">SCAN</p>
        </a>
    </div>
    <div class="flex">
        <?php include 'menu.php' ?>
        <div class="grow md:bg-gray-100 ">
            <?php include 'header.php' ?>
            <div class="opacity-0 transition-opacity duration-700 p-2 " id="menu-content"></div>
        </div>
    </div>
</body>
<script>
    
</script>
</html>

<script src="../javascript/menu.js"></script>
<script src="../javascript/pencarian_siswa.js"></script>