<?php
include '../../../autoloader.php';
admin();
$id_tagihan = $_GET['id_tagihan'];
if (isset($_GET['siswa'])){
    $ket = 'siswa';
} elseif (isset($_GET['lolos'])){
    $ket = 'lolos';
};
$tagihan = tampil("SELECT * FROM tagihan WHERE id_tagihan = '$id_tagihan'");
foreach($tagihan as $view){
    $id_tagihan = $view['id_tagihan'];
    $jenis_tagihan = $view['jenis_tagihan'];
    $biaya_tagihan = round($view['biaya_tagihan']);
    $nis = $view['nis'];
    $sisa_tagihan = $view['sisa_tagihan'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LOLOS</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-no-repeat bg-cover" style="background-image: url(../../image/asset/jepang.png)">
    <div class="bg-slate-50 w-96 p-2 rounded-lg shadow-md">
        <h1 class="text-xl text-center font-semibold mb-4">Buat Transaksi</h1>
        <hr class="my-1">
        <form action="/app/database/buat_tx.php" method="post" class="flex flex-col">
            <input type="text" value="<?= $id_tagihan ?>" name="id_tagihan" hidden>
            <input type="text" value="<?= $ket ?>" name="ket" hidden>
            <label for="jenis_tagihan" class="text-sm font-semibold text-gray-500 my-2">Jenis Tagihan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal bg-blue-900 text-white" name="jenis_tagihan" value="<?= $jenis_tagihan?>" id="jenis_tagihan" readonly>
            <label for="tx" class="text-sm font-semibold text-gray-500 my-2">Tagihan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal bg-blue-900 text-white" name="tagihan" value="<?= $biaya_tagihan?>" id="tx"readonly>
            <label for="sisa" class="text-sm font-semibold text-gray-500 my-2">Sisa Tagihan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal bg-blue-900 text-white" name="tagihan" value="<?= $biaya_tagihan?>" id="sisa"readonly>
            <label for="tagihan" class="text-sm font-semibold text-gray-500 my-2">Bayar</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal" name="tx" placeholder="<?= $biaya_tagihan?>" id="tagihan">
            <button type="submit" class="bg-blue-900 rounded-md w-full my-5 h-10 text-white font-semibold">TRANSAKSI</button>
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
            const input = document.getElementById('tagihan');

            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
            
        });
    </script>
</html>