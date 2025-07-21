<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\siswacontroller;

$model = new siswacontroller();
$daftar = $model->daftar_wawancara();
$nis = $_GET['nis'];
$siswa = $model->detailsiswa($nis,'data');
foreach($siswa as $s){
    $nama = $s['nama'];
};


?>

<body>
    <form id="form-tambah-peserta_job" method="POST">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <input type="hidden" name="nis" value="<?= $nis ?>" id="nis">
            <div>
                <label for="nis" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">NIP <?= $nis ?></label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="siswa" name="siswa" value="<?= $nama ?>" readonly>
            </div>
            <div>
                <label for="job"  class="text-sm font-medium text-gray-900 dark:text-white">Pilih Job</label>
                <select class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="job" name="id_job" required>
                    <option>Pilih Job</option>
                    <?php 
                    foreach($daftar as $d){
                        $id_job = $d['id_job'];
                        $job = $d['job'];
                        $perusahaan = $d['perusahaan'];
                        $interview = $d['interview'];
                        $penempatan = $d['penempatan'];
                        $tgl_job = $d['tgl_job'];
                        $so = $d['so'];
                        echo "<option value='$id_job' 
                                data-so='$so' 
                                data-perusahaan='$perusahaan' 
                                data-interview='$interview' 
                                data-penempatan='$penempatan' 
                                data-tgl-job='$tgl_job'>
                                $job
                            </option>";
                    };
                    ?>
                </select>
            </div>
            <div>
                <label for="so" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">Nama SO</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="so" name="so" readonly>
            </div>
            <div>
                <label for="perusahaan" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">Nama Perusahaan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="perusahaan" name="perusahaan" readonly>
            </div>
            <div>
                <label for="interview" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">Model interview</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="interview" name="interview" readonly>
            </div>
            <div>
                <label for="penempatan" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">Penempatan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="penempatan" name="penempatan" readonly>
            </div>
            <div>
                <label for="tgl_job" class="text-sm font-semibold text-gray-500 my-2 dark:text-gray-200">Tanggal Interview</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tgl_job" name="tgl_job" readonly>
            </div>
        </div>
        <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=siswa&act=detail&nis<?= $nis?>', '2')">Cancel</a>
                </div>
            </div>
    </form> 

</body>
