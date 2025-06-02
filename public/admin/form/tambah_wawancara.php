<?php
// require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';

require_once '../../../autoloader.php';

admin();
$nis = $_GET['nis'];
$job = tampil("SELECT j.*, s.* FROM job j JOIN so s ON j.id_so = s.id_so");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wawancara</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex items-center justify-center min-h-screen bg-cover" style="background-image:url('/public/image/asset/jepang.png')">
    <div class="bg-slate-50 w-96 p-2 rounded-lg shadow-md ">
        <h1 class="text-xl text-center font-semibold mb-4">IKUT JOB</h1>
        <hr class="my-1">
        <form action="/app/database/tambah_wawancara.php" method="post" >
            <input type="hidden" name="nis" value="<?= $nis ?>">
            <label for="so" class="text-sm font-semibold text-gray-500">Pilih Job</label>
            <select name="job" id="job" class="w-full p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-300">
                <option value="">Pilih Job</option>
                <?php foreach ($job as $j) : ?>
                    <option value="<?= $j['id_job'] ?>" data-so="<?= $j['so']?>"><?= $j['job'] . " | " . $j['perusahaan'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" id="so" class="w-full p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-300 mt-2" placeholder="Nama SO" disabled>
            <button type="submit" class="w-full bg-red-500 text-white rounded-lg p-2 mt-2">Tambah</button>
        </form>
    </div>
</body>
<script>
    function updateSO(){
        var select = document.getElementById('job');
        var selectedOption = select.options[select.selectedIndex];
        var so = selectedOption.getAttribute("data-so");
        document.getElementById("so").value = so;
    }
    document.getElementById('job').addEventListener('change', updateSO);
</script>
</html>