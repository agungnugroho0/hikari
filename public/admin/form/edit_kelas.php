<?php
include '../../../autoloader.php';
admin();
$id_kelas = $_GET['id_kelas'];
$kelas = tampil("SELECT * FROM kelas WHERE id_kelas = '$id_kelas'");
$kls = $kelas[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KELAS</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="">
    <div class="container mx-auto my-auto md:max-w-lg mt-5 shadow-md p-3">
        <p class="text-center font-medium text-xl">KELAS</p>
        <hr class="my-2">
        <form action="../../../app/database/edit_kelas.php" method="post" class="flex flex-col">
            <label for="kelas" class="text-sm font-semibold text-gray-500 my-2">ID Kelas</label>
            <input type="text" class="p-2 border-b-2 text-white w-full bg-blue-800 focus:outline-none" value="<?=$id_kelas?>" name="id_kelas" readonly/>
            <label for="kelas" class="text-sm font-semibold text-gray-500 my-2">Kelas</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="kelas" value="<?= $kls['kelas'] ?>">
            <button type="submit" class="bg-red-800 w-full mt-3 py-2 rounded-md text-white font-semibold">EDIT KELAS</button>
        </form>
    </div>
</body>
</html>