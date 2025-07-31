<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\wawancaracontroller;
$id = $_GET['id_w'];

$model = new wawancaracontroller();
$job = $model->lolossiswa($id);
$so = $model->formwawancara();
foreach ($job as $j){
    $nis=$j['nis'];
    $siswa=$j['nama'];
    $nama_job=$j['job'];
    $nama_perusahaan=$j['perusahaan'];
    $nama_so=$j['so'];
}
?>
<body>
    <h1 class="text-xl text-center font-semibold mb-4 dark:text-white">Kelolosan Siswa </h1>
    <form id="form-lolos-peserta" method="POST">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <input type="hidden" name="nis" value="<?= $nis ?>">
            <input type="hidden" name="tagihan_hikari" value="Tagihan Hikari">
            <input type="hidden" name="tagihan_so2" value="Tagihan SO <?= $nama_so ?>">
            <div>
                <label for="siswa" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">NIP <?= $nis ?></label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="siswa" name="siswa" value="<?= $siswa ?>" readonly>
            </div>
            <div>
                <label for="nama_job" class="text-sm font-medium text-gray-900 dark:text-white">Nama Job</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_job" name="nama_job" value="<?= $nama_job ?>" readonly>
            </div>
            <div>
                <label for="nama_perusahaan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Perusahaan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_perusahaan" name="nama_perusahaan" value="<?= $nama_perusahaan ?>" readonly>
            </div>
            <div>
                <label for="nama_so" class="text-sm font-medium text-gray-900 dark:text-white">Sending Organizer</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_so" name="nama_so" value="<?= $nama_so ?>" readonly>
            </div>
            <div>
                <label for="tgl_lolos" class="text-sm font-medium text-gray-900 dark:text-white">Tanggal Lolos</label>
                <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tgl_lolos" name="tgl_lolos" value="<?= date('Y-m-d') ?>" readonly>
            </div>
            <div>
                <label for="biaya_hikari" class="text-sm font-medium text-gray-900 dark:text-white">Biaya Pendidikan</label>
                <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-950 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="hikari" name="biaya_hikari" >
                
            </div>
            <div>
                <label for="biaya_so" class="text-sm font-medium text-gray-900 dark:text-white">Biaya SO <?= $nama_so ?></label>
                <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-950 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="biaya_so" name="tagihan_so" value="0">
            </div>
            <div class="flex gap-2">
                <label class="text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                    <button class="md:mt-2 bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-500 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">LOLOS</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class="md:mt-2 bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=wawancara', '3')">Cancel</a>
                </div>
            </div>
    </div>

<script>
  if (typeof initstaff === "function") {
      initwawancara();
  }
</script>
</body>



