<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\wawancaracontroller;
$id = $_GET['id_jobs'];
$model = new wawancaracontroller();
$job = $model->cariwawancara($id);
$so = $model->formwawancara();
$siswa = $model->daftarsiswa();
// $wawancara['id_so'] == $so['id_so'] ? 'selected' : '';
?>
<body>
    <form id="form-tambah-peserta" method="POST">
        <input type="hidden" name="id_job" value="<?= $job['id_job'] ?>">
        <div class="grid mb-6 md:grid-cols-2 gap-3">
            <?php foreach($so as $s):?>
                <?php if ($s['id_so'] == $job['id_so']):?>
                    <input type="text" name="so" value="<?= $s['so'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" disabled>
                <?php endif;?>
            <?php endforeach;?>

            <input type="text" name="job" value="Job <?= $job['job'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" disabled>
            <input type="text" name="perusahaan" value="Perusahaan <?= $job['perusahaan'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" disabled>
            <input type="date" name="tgl" value="<?= $job['tgl_job'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" disabled>

            <?php if (is_array($siswa)): ?>
            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white flex-wrap col-span-2 ">
                <?php foreach ($siswa as $s): ?>
                <li class="w-full sm:w-1/2 border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                    <div class="flex items-center ps-3">
                        <input 
                            id="siswa_<?= $s['nis'] ?>" 
                            name="siswa[]" 
                            type="checkbox" 
                            value="<?= $s['nis'] ?>" 
                            <?= !empty($s['id_w']) ? 'disabled' : '' ?> 
                            class="w-4 h-4 text-black bg-gray-100 border-gray-300 rounded-sm focus:ring-red-500 dark:focus:ring-slate-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 "
                        >
                        <label for="siswa_<?= $s['nis'] ?>" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            <?php if (!empty($s['id_w'])): ?>
                                <p class="text-slate-400"><?= $s['nama'] ?></p>
                                <span class="text-xs text-red-400">sudah terdaftar</span>
                            <?php else: ?>
                                <p><?= $s['nama'] ?> </p>
                                <p>Kelas : <?= $s['kelas']?></p>
                            <?php endif; ?>
                        </label>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <p class="text-red-500">⚠️ Data siswa gagal dimuat.</p>
            <?php endif; ?>
            <div class="flex gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                    <button type="submit" class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">SUBMIT</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=wawancara', '3')">Cancel</a>
                </div>
            </div>
        </div>    
    </form>
    
</body>
