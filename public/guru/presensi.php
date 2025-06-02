<?php
require '../../autoloader.php';
guru();
// define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
$user = $_SESSION['username'];
$level = $_SESSION['level'];
$guru = tampil("SELECT * FROM staff WHERE nama = '$user'");
foreach ($guru as $g) {
    $id_kelas = $g['id_kelas'];
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESENSI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link rel="icon" type="image/png" href="/public/image/asset/logo.png">
    
</head>
<body class="dark:bg-slate-800">
    <?php include 'header.html'?>
    <main class="flex mx-auto sm:p-5 p-3 flex-wrap">
    <!-- scanner -->
        <div class="w-full md:max-w-screen-sm">
            <div class="flex justify-center mt-4">
                <button id="startButton" class="bg-green-800 text-white px-4 py-2 rounded mr-2">Start Scanner</button>
                <button id="stopButton" class="bg-red-500 text-white px-4 py-2 rounded">Stop Scanner</button>
            </div>
            <div class="container mx-auto max-w-md mt-3 ">
            <div id="reader" class="rounded-lg overflow-hidden m-2 md:m-0 "></div>
            </div>
        </div>
    <!-- endscanner -->
     <!-- siswa -->
        <div class="w-full md:max-w-screen-sm">
            <p class="text-base font-semibold dark:text-slate-400">Siswa Yang Belum Presensi</p>
            <hr class="border-t-2 border-gray-200 mt-1 mb-2 dark:border-slate-600">
            <div id="siswa_list" class="w-full"></div>
        </div>
     <!-- endsiswa -->
    </main>
</body>
<script src="/public/javascript/presensi_guru.js"></script>

</html>