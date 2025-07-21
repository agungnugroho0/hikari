<?php
require_once __DIR__."/../../../autoloader.php";
$nis = $_GET['nis'];

use app\controller\siswacontroller;
$model = new siswacontroller();
$siswa = $model->detailsiswa($nis,'data');
foreach($siswa as $s){
    $nama = $s['nama'];
};
?>

<body>
    <form method="post" enctype="multipart/form-data" id="form-upload-doc" class="grid mb-6 md:grid-cols-3 gap-3">
        <input type="hidden" name="nis" value="<?php echo $nis; ?>" id="nis">
        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
        <div>
            <label for="dokumen" class="text-sm font-medium text-gray-900 dark:text-slate-300">Upload Dokumen</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-100 focus:outline-none dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" type="file" name="dokumen" id="dokumen" required>
        </div>  
        <div>
            <label for="tipe" class="text-sm font-medium text-gray-900 dark:text-slate-300">Jenis Dokumen</label>
            <select name="tipe" id="tipe" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-100 focus:outline-none dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" required>
                <option value="SISWA">Data Diri</option>
                <option value="PRAMCU">Pra-MCU</option>
                <option value="PASSPORT">Passport</option>
                <option value="MCU_FINAL">MCU-Final</option>
                <option value="LAINNYA">Lainnya</option>
            </select>
        </div>
        <div>
            <label for="keterangan" class="text-sm font-medium text-gray-900 dark:text-slate-300">Keterangan</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-gray-100 focus:outline-none dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" type="text" name="keterangan" id="keterangan">
        </div>
        <div class="flex gap-2 mt-2 sm:mt-0">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Upload</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=siswa&act=detail&nis=<?= $nis?>','4')">Cancel</a>
                </div>
        </div>
    </form>
</body>