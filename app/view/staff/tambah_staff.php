<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\staffcontroller;

$kelas = (new staffcontroller())->kelas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <form id="form-tambah-staff" method="POST" enctype="multipart/form-data">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <div>
                <label for="nama_lengkap" class="text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div>
                <label for="username" class="text-sm font-medium text-gray-900 dark:text-white">Username</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="username" name="username" required>
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="password" name="password" placeholder="-" required>
            </div>
            <div>
                <label for="no" class="text-sm font-medium text-gray-900 dark:text-white">No Whatsapp</label>
                <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="no" name="no">
            </div>
            <div>
                <label for="akses" class="text-sm font-medium text-gray-900 dark:text-white">Akses</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="akses" name="akses" placeholder="-" required>
                    <option value="admin">Admin</option>    
                    <option value="guru">Guru</option>    
                </select>   
            </div>
            <div class="w-full mx-auto">
                <label for="kelas" class="text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelas" name="id_kelas" required>
                    <option value="0">Tidak mengampu KBM</option>
                    <?php foreach($kelas as $k):?>
                    <option value="<?= $k['id_kelas']?>"><?= $k['kelas']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload foto</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" id="file_input" type="file" name="foto">
            </div>
            <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=staff', '2')">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
  if (typeof initstaff === "function") {
      initstaff();
  }
</script>
</html>