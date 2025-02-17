<?php
require '../../autoloader.php';
guru();
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
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
    
</head>
<body>
    <?php include 'header.html' ?>
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
            <p class="text-base font-semibold">Siswa Belum Presensi</p>
            <hr class="border-t-2 border-gray-200 mt-1 mb-2">
            <div id="siswa_list" class="w-full"></div>
        </div>
     <!-- endsiswa -->
    </main>
</body>
<script src="../javascript/presensi_guru.js"></script>
<script>
// const siswaList = document.getElementById("siswa_list");
// const html5QrCode = new Html5Qrcode("reader");

// function startScanner() {
//     html5QrCode.start(
//         { facingMode: "environment" }, 
//         {
//             fps: 10,
//             qrbox: { width: 250, height: 250 }
//         },
//         (decodedText, decodedResult) => {
//             // Hentikan scanner untuk sementara
//             html5QrCode.stop().then(() => {
//                 $.ajax({
//                 type: 'POST',
//                 url: '<?= BASE_URL2?>app/api/absen_proses.php',
//                 data: { "nis": decodedText},
//                 success: function(data) {
//                     // Tampilkan SweetAlert2 dan restart scanner setelah ditutup
//                     Swal.fire({
//                         title: 'Scan Berhasil!',
//                         text: data,
//                         icon: 'success',
//                         timer : 1000,
//                         showConfirmButton: false
//                     }).then(() => {
//                         // Mulai ulang scanner setelah menutup notifikasi
//                         loadSiswa();
//                         startScanner();
//                     });
//                 },
//                 error: function() {
                    
//                 }
//             });
//             }).catch((err) => {
//                 console.error("Gagal menghentikan scanner:", err);
//             });
//         }
//     ).catch((err) => {
//         console.error("Gagal memulai scanner:", err);
//     });
// }

// function stopScanner() {
// html5QrCode.stop().then(() => {
//     console.log("Scanner dihentikan.");
// }).catch((err) => {
//     console.error("Gagal menghentikan scanner:", err);
// });
// }

// async function updateStatus(nis, status) {
// try {
//     const response = await fetch('<?= BASE_URL2?>app/api/absen_izin.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: new URLSearchParams({ nis, status }),
//     });

//     if (!response.ok) {
//         throw new Error('Gagal mengupdate status.');
//     }

//     const result = await response.text();
//     Swal.fire({
//         title: 'Berhasil!',
//         text: result,
//         icon: 'success',
//         showConfirmButton: false,
//         timer: 1000
//     });

//     // Perbarui daftar siswa
//     loadSiswa();
// } catch (error) {
//     console.error(error.message);
//     Swal.fire({
//         title: 'Error!',
//         text: 'Gagal mengupdate status.',
//         icon: 'error',
//         showConfirmButton: false,
//         timer: 1000
//     });
// }
// }

// async function loadSiswa() {
// try {
//     const response = await fetch('<?= BASE_URL2?>app/api/api_belum_absen.php');
//     if (!response.ok) {
//         throw new Error('Gagal memuat data siswa.');
//     }
//     const siswaData = await response.json();
//     let siswaHtml = '';
//     if (siswaData.length > 0) {
//         siswaData.forEach((siswa) => {
//             siswaHtml += `
//                 <div class="border p-2 mb-2 rounded shadow">
//                     <p class="font-semibold pb-2">${siswa.nama}</p>
//                     <button onclick="updateStatus('${siswa.nis}', 'I')" class="rounded px-2 bg-blue-700 text-white font-semibold">IZIN</button>
//                     <button onclick="updateStatus('${siswa.nis}', 'A')" class="rounded px-2 bg-red-700 text-white font-semibold">ALPHA</button>
//                     <button onclick="updateStatus('${siswa.nis}', 'M')" class="rounded px-2 bg-green-700 text-white font-semibold">MENSETSU</button>
//                     <button onclick="updateStatus('${siswa.nis}', 'S')" class="rounded px-2 bg-orange-700 text-white font-semibold">SAKIT</button>
//                 </div>`;
//         });
//     } else {
//         siswaHtml = '<p class="text-gray-500">Semua siswa sudah melakukan absensi.</p>';
//     }
//     siswaList.innerHTML = siswaHtml;
// } catch (error) {
//     console.error(error.message);
// }
// }


// loadSiswa();
// startScanner();
// document.getElementById("startButton").addEventListener("click", startScanner);
// document.getElementById("stopButton").addEventListener("click", stopScanner);
</script>
</html>