<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();
// if (isset($_GET['absensi'])) {
//     $notification = 'info';
//     $message = "Siswa sudah absensi hari ini";
// } elseif (isset($_GET['status'])) {
//     $notification = 'success';
//     $message = "Absensi siswa sudah masuk";
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
</head>
<body>
    <div class="flex justify-center mt-4">
        <button id="startButton" class="bg-green-800 text-white px-4 py-2 rounded mr-2">Start Scanner</button>
        <button id="stopButton" class="bg-red-500 text-white px-4 py-2 rounded">Stop Scanner</button>
    </div>
    <div class="container mx-auto max-w-md mt-3 ">
        <div id="reader" class="rounded-lg overflow-hidden m-2 md:m-0 "></div>
    </div>

</body>


<script>
const html5QrCode = new Html5Qrcode("reader");

function startScanner() {
        html5QrCode.start(
            { facingMode: "environment" }, 
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText, decodedResult) => {
                // Hentikan scanner untuk sementara
                html5QrCode.stop().then(() => {
                    $.ajax({
                    type: 'POST',
                    url: '<?= BASE_URL2?>app/api/absen_proses.php',
                    data: { "nis": decodedText},
                    success: function(data) {
                        // Tampilkan SweetAlert2 dan restart scanner setelah ditutup
                        Swal.fire({
                            title: 'Scan Berhasil!',
                            text: data,
                            icon: 'success',
                            timer : 1000,
                            showConfirmButton: false
                        }).then(() => {
                            // Mulai ulang scanner setelah menutup notifikasi
                            startScanner();
                        });
                    },
                    error: function() {
                        
                    }
                });
                }).catch((err) => {
                    console.error("Gagal menghentikan scanner:", err);
                });
            },
            // (errorMessage) => {
            //     // Log error untuk debugging
            //     console.warn("QR Code scanning error:", errorMessage);
            // }
        ).catch((err) => {
            console.error("Gagal memulai scanner:", err);
        });
    }

    function stopScanner() {
    html5QrCode.stop().then(() => {
        console.log("Scanner dihentikan.");
    }).catch((err) => {
        console.error("Gagal menghentikan scanner:", err);
    });
}

// Mulai scanner pertama kali
startScanner();
document.getElementById("startButton").addEventListener("click", startScanner);
document.getElementById("stopButton").addEventListener("click", stopScanner);
</script>
</html>