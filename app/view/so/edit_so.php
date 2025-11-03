<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\socontroller;
use app\model\so;
$so_id = $_GET['id_so'];
$so = new so();
$cari_so = $so->findById($so_id);
// $kelas = (new staffcontroller())->kelas();
var_dump($cari_so);
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <form id="form-update-so" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_so" value="<?= $cari_so['id_so'] ?>">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <div>
                <label for="so" class="text-sm font-medium text-gray-900 dark:text-white">Nama Sending Organization</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="so" name="so" value="<?= $cari_so['so'] ?>" required>
            </div>
            <div>
                <label for="lokasi" class="text-sm font-medium text-gray-900 dark:text-white">Lokasi</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="lokasi" name="lokasi" placeholder="-" value="<?= $cari_so['lokasi'] ?>" required>
            </div>
            <div>
                <label for="noted" class="text-sm font-medium text-gray-900 dark:text-white">Notulen</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="noted" name="noted" value="<?= $cari_so['noted'] ?>">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">Ganti Logo</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" id="file_input" type="file" name="foto_so" >
            </div>
            <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=so', '8')">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
  if (typeof initso === "function") {
      initso();
  }
</script>
</html>