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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../image/asset/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <p>Jumlah Siswa Lolos </p>
                <select name="tahun" id="tahun" class="dark:text-white dark:bg-black">
                    <script>
                        let tahunSekarang = new Date().getFullYear();
                        for (let i = tahunSekarang; i >= tahunSekarang - 5; i--) {
                            document.write(`<option value="${i}">${i}</option>`);
                        }
                    </script>
                </select> 
            </div>
            <canvas id="chartLolos" class="dark:bg-white pt-3"></canvas>
        </div>
        <a href="#" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-black active:bg-black active:border-red-600 transition">
            <img src="../image/asset/staff.png" alt="siswa" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:scale-150 sm:group-hover:scale-100 group-hover:translate-x-6 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">SISWA</p> 
        <a href="presensi.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-black active:bg-black active:border-red-600 transition">
            <img src="../image/asset/qr.png" alt="qr" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">PRESENSI</p> 
        </a>
        <a href="laporan.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-black active:bg-black active:border-red-600 transition">
            <img src="../image/asset/report.png" alt="laporan" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">LAPORAN</p> 
        </a>
        <a href="#" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-black active:bg-black active:border-red-600 transition">
            <img src="../image/asset/gear.png" alt="setting" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">SETTINGS</p> 
        </a>
        
    </main>
</body>
<script>
     const ctx = document.getElementById('chartLolos').getContext('2d');
     let chart; // Simpan referensi ke grafik
     function loadChart(tahun) {
        fetch(`../../app/api/api_jumlah_lolos.php?tahun=${tahun}`)
        .then(response => response.json())  // Mengambil data dari server dan mengubahnya ke format JSON
            .then(data =>{
                const bulan = data.map(item => item.bulan); // Mengambil bulan dari data
                const jumlah = data.map(item => item.jumlah_lolos); // Mengambil jumlah siswa lolos dari data
                if (chart) {
                        chart.destroy(); // Hapus grafik lama sebelum membuat yang baru
                    }
                    chart = new Chart(ctx, {
                    type: 'line',  // Grafik jenis batang
                    data: {
                        labels: bulan,  // Label sumbu X (bulan)
                        datasets: [{
                            label: `Jumlah Lolos ${tahun}`,
                            data: jumlah,  // Data jumlah siswa lolos
                            backgroundColor: '#69140e',
                            borderColor: '#69140e',
                            borderWidth: 3,
                            tension: 0.5, // Mengatur kelengkungan garis
                        }]
                    },
                    options: {
                        animation: {
                            duration: 2000, // Durasi animasi dalam milidetik
                            easing: 'easeInOutQuart' // Efek animasi yang halus
                        },
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legend
                            }
                        },
                        scales: {
                            y: { beginAtZero: true } // Pastikan sumbu Y dimulai dari 0
                        }
                    }
                });

            })
     }
     document.getElementById('tahun').addEventListener('change', function() {
        const tahun = this.value; // Ambil tahun dari dropdown
        loadChart(tahun); // Panggil fungsi untuk memuat grafik dengan tahun yang dipilih
     });
        // Panggil fungsi untuk memuat grafik pertama kali dengan tahun default
        loadChart(new Date().getFullYear()); // Load data tahun ini saat pertama kali dibuka
</script>
</html>
