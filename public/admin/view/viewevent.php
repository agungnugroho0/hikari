<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <main class="grid grid-cols-2">
        <div>
            <input type="month" id="month" class="h-8 p-2 focus:outline-red-900 border border-gray-300 rounded-md font-semibold ml-3" value="<?= date('Y-m') ?>">
            <div class="max-w-lg mt-4 mx-3 grid grid-cols-7 gap-2 *:p-1 *:border-b *:border-b-gray-300" id="hari">
            <p>Minggu</p>
            <p>Senin</p>
            <p>Selasa</p>
            <p>Rabu</p>
            <p>Kamis</p>
            <p>Jumat</p>
            <p>Sabtu</p>
            </div>
            <div class="max-w-lg mt-4 mx-3 grid grid-cols-7 gap-2 *:p-2 *:h-20 *:rounded-md *:border *:border-gray-300 " id="tanggal">
            </div>
        </div>
        <div class="border border-slate-200 m-2 rounded p-2">
            <p class="text-lg font-semibold">Acara</p>
            <hr class="my-1">
            <div id="isi_event" class=" flex flex-col">
                <!-- <div class="border rounded p-2"></div> -->
                <hr class="my-1">
            </div>
        </div>
    </main>
</body>
<script>
        const inputMonth = document.getElementById('month');
        const tanggalElement = document.getElementById('tanggal');
        const isievent = document.getElementById('isi_event');
        
        function isi_event(tahun, bulan) {
        fetch(`<?= BASE_URL2 ?>app/api/api_event.php?y=${tahun}&m=${bulan+1}`)
        .then(response => {
            // Log response untuk memeriksa isi response
            console.log(response);
            return response.json(); // Parse JSON response
        })
        .then(data => {
            isievent.innerHTML = '';
            data.forEach(event => {
                isievent.innerHTML += `<div class="border rounded p-2">
                <p class="font-semibold">${event.nama_event}</p>
                <p>${event.tgl_event}</p>
                </div>`;
            });
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
    }
        

        function renderTanggal() {
        const tanggal = new Date(inputMonth.value);
        const tahun = tanggal.getFullYear();
        const bulan = tanggal.getMonth();
        const tanggalAwal = new Date(tahun, bulan, 1);
        const tanggalAkhir = new Date(tahun, bulan + 1, 0);
        tanggalElement.innerHTML = '';
        // Tambahkan tanggal kosong untuk hari pertama
        for (let i = 0; i < tanggalAwal.getDay(); i++) {
            tanggalElement.innerHTML += '<div class="h-20"></div>';
        }

        // Tambahkan tanggal
        for (let i = 1; i <= tanggalAkhir.getDate(); i++) {
            tanggalElement.innerHTML += `<a class="hover:bg-red-900 hover:text-white transition duration-150" href="y=${tahun}&m=${bulan}&d=${i}">${i}</a>`;
        }
        isi_event(tahun, bulan);
    }

    inputMonth.addEventListener('change', renderTanggal);
    renderTanggal();
</script>
</html>