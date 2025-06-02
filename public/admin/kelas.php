<?php

require __DIR__.'/../../autoloader.php';

admin();
$kelas = tampil("SELECT kelas.id_kelas, kelas.kelas, GROUP_CONCAT(staff.nama SEPARATOR ', ') AS nama 
FROM kelas 
LEFT JOIN staff ON kelas.id_kelas = staff.id_kelas 
GROUP BY kelas.id_kelas, kelas.kelas
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelas</title>
    <link rel="icon" type="image/png" href="/public/image/asset/logo.png">

</head>
<body>
    <a href="form/tambah_kelas.php" class="bg-red-800 text-white font-semibold mb-5 p-2 rounded">TAMBAH</a>
    <div class="flex gap-3 flex-wrap justify-evenly">
        <?php foreach($kelas as $k) : ?>
        <div class="bg-white shadow rounded-md p-2 w-full md:w-1/5 mt-5">
            <div class="flex gap-2 items-center">
                <p class="grow font-semibold">Kelas <?= $k['kelas'];?></p>
                <a href="form/edit_kelas.php?id_kelas=<?=$k['id_kelas']?>"><img src="/public/image/asset/pen.png" class="w-4"/></a>
                <a href="/app/database/hapus_kelas.php?id_kelas=<?=$k['id_kelas']?>"><img src="/public/image/asset/sampah.png" class="w-4"/></a>
            </div>
            <hr class="my-2">
            <p class="text-gray-500 italic">Pengampu : <?= $k['nama']?></p>
        </div>
        <?php endforeach;?>
    </div>
</body>
</html>