<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\wawancaracontroller;
$wawancara = (new wawancaracontroller())->formwawancara();
?>
<body>
    <form id="form-tambah-wawancara" method="POST">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <div class="w-full mx-auto">
                <label for="nama_so" class="text-sm font-medium text-gray-900 dark:text-white">Pilih SO</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_so" name="nama_so" required>
                    <option value="0">Pilih SO</option>
                    <?php foreach($wawancara as $so):?>
                    <option value="<?= $so['id_so']?>"><?= $so['so']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="nama_job" class="text-sm font-medium text-gray-900 dark:text-white">Nama Job</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_job" name="nama_job" placeholder="Katawaku etc" required>
            </div>
            <div>
                <label for="nama_perusahaan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Perusahaan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_perusahaan" name="nama_perusahaan" placeholder="Yamaha etc">
            </div>
            <div class="w-full mx-auto">
                <label for="interview" class="text-sm font-medium text-gray-900 dark:text-white">Metode Interview</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="interview" name="interview" required>
                    <option value="ONLINE">ONLINE</option>
                    <option value="OFFLINE">OFFLINE</option>
                </select>
            </div>
            <div>
                <label for="nama_penempatan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Penempatan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_penempatan" name="nama_penempatan" placeholder="Yohomaha etc">
            </div>
            <div>
                <label for="tgl_interview" class="text-sm font-medium text-gray-900 dark:text-white">Tanggal Mensetsu</label>
                <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tgl_interview" name="tgl_interview" >
            </div>
            <div class="flex gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=wawancara', '3')">Cancel</a>
                </div>
            </div>
        </div>
</body>

<script>
  if (typeof initstaff === "function") {
      initwawancara();
  }
</script>