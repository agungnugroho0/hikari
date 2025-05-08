<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
admin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SO</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-slate-50 w-96 p-2 rounded-lg shadow-md">
        <h1 class="text-xl text-center font-semibold mb-4">Tambah SO</h1>
        <hr class="my-1">
        <form action="../../../app/database/tambah_so.php" method="post" enctype="multipart/form-data">
            <label for="so" class="text-sm font-semibold text-gray-500 my-2">Nama SO</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal my-2" name="so" placeholder="" id="so">
            <label for="lokasi" class="text-sm font-semibold text-gray-500 my-2">Lokasi</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal my-2" name="lokasi" placeholder="" id="lokasi">
            <label for="note" class="text-sm font-semibold text-gray-500 my-2">Catatan</label>
            <input type="text" class="p-2 border-b-2 border-blue-400 w-full focus:border-blue-800 focus:outline-none font-normal my-2" name="noted" placeholder="" id="note">
            <label for="foto_so" class="text-sm font-semibold text-gray-500 my-2">LOGO SO</label>
            <div class="flex gap-2">
                <input type="file" class="w-full rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900  hover:bg-gray-800 hover:text-white" name="foto_so" id="fileInput"/>
            </div>
            <button type="submit" class="bg-blue-900 rounded-md w-full my-5 h-10 text-white font-semibold">TAMBAH</button>

        </form>
    </div>
</body>
</html>