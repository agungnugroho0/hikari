<?php
include __DIR__.'../../../autoloader.php';
admin();
$id_w = $_GET['id_w'];
$tampil = tampil("SELECT wawancara.*,job.*,so.id_so,so.so,siswa.nama FROM wawancara JOIN job ON wawancara.id_job = job.id_job JOIN so ON job.id_so = so.id_so JOIN siswa ON wawancara.nis = siswa.nis WHERE id_w = '$id_w'");
foreach ($tampil as $siswa){
    $nis = $siswa['nis'];
    $nama = $siswa['nama'];
    $so = $siswa['so'];
    $job = $siswa['job'];
    $perusahaan = $siswa['perusahaan'];
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LOLOS</title>
</head>
<body class="flex items-center justify-center bg-no-repeat  bg-cover" style="background-image: url(public/image/asset/jepang.png)">
    <div class="bg-slate-50 w-96 p-2 rounded-lg shadow-md">
        <h1 class="text-xl text-center font-semibold mb-4">Kelulusan Siswa </h1>
        <hr class="my-1">
        <form action="/app/database/lolos_job.php" method="post" class="flex flex-col">
            <input type="text" value="<?= $nis ?>" name="nis" hidden>
            <label for="nis" class="text-sm font-semibold text-gray-500 my-2"><?= $nis ?></label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none bg-slate-900 text-white " value="<?= $nama ?>" id="nis" readonly>
            <label for="tgl" class="text-sm font-semibold text-gray-500 my-2">Tanggal Lolos</label>
            <input type="date" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="tgl_lolos" value="<?= date("Y-m-d")?>" id="tgl">
            <label for="lolos_so" class="text-sm font-semibold text-gray-500 my-2">Lolos pada SO</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none bg-slate-900 text-white font-semibold" name="so" value="<?= $so?>" id="lolos_so"readonly>
            <label for="job" class="text-sm font-semibold text-gray-500 my-2">Lolos pada Job</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none bg-slate-900 text-white font-semibold" name="job" value="<?= $job?>" id="job" readonly>
            <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2">Lolos pada Perusahaan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none bg-slate-900 text-white font-semibold" name="perusahaan" value="<?= $perusahaan?>" id="perusahaan" readonly>
            <label for="hikari" class="text-sm font-semibold text-gray-500 my-2">Tagihan Hikari Gakkou</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-semibold" name="hikari" id="hikari" placeholder="0">
            <label for="tagihan_so" class="text-sm font-semibold text-gray-500 my-2">Tagihan SO <?= $so?></label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-semibold" name="tagihan_so" placeholder="0" id="tagihan_so">
            <button type="submit" class="bg-blue-900 rounded-md w-full my-5 h-10 text-white font-semibold">LOLOS</button>
        </form>
    </div>
</body>
<script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            // tambahkan titik setiap 3 angka
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('hikari');
            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
            const input2 = document.getElementById('tagihan_so');
            input2.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        });
    </script>
</html>