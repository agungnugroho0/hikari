<?php
include '../../../autoloader.php';
admin();
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
        <form action="/app/database/tambah_kelas.php" method="post" class="flex flex-col">
            <label for="kelas" class="text-sm font-semibold text-gray-500 my-2">Kelas</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none" name="kelas" >
            <button type="submit" class="bg-red-800 w-full mt-3 py-2 rounded-md text-white font-semibold">TAMBAH</button>
        </form>
    </div>
</body>
</html>