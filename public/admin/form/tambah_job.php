<?php
require '../../../autoloader.php';
admin();
$so = tampil("SELECT * FROM so");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOBDESK</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <div class="container mx-auto md:max-w-lg mt-5 shadow-md p-3">
        <p class="text-center font-medium text-xl">JOBDESK</p>
        <hr class="my-2">
        <form action="/app/database/tambah_jobs.php" method="post" class="flex flex-col">
            <label for="so" class="text-sm font-semibold text-gray-500">Pilih SO</label>
            <select name="so" id="so" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none">
                <?php
                foreach($so as $key => $value){?>
                <option value="<?= $value['id_so']?>"><?= $value['so']?></option>
                <?php } ?>
            </select>
            <label for="job" class="text-sm font-semibold text-gray-500 my-2">Nama Job</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="job">
            <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2">Nama Perusahaan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="perusahaan">
            <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2">Tanggal</label>
            <input type="date" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="tgl">
            <button type="submit" class="bg-red-800 w-full mt-3 py-2 rounded-md text-white font-semibold">TAMBAH JOB</button>
        </form>
    </div>
</body>
</html>