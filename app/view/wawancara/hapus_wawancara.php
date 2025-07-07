<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\wawancaracontroller;
$model = new wawancaracontroller();
$wawancara = $model->cariwawancara($id_jobs);

?>
<form method="POST" id="form-hapus-wawancara" class="dark:text-white">
    <input type="hidden" name="id_job" value="<?= $wawancara['id_job'] ?>">
    <div class="p-4">
        <p class="text-lg">Yakin ingin menghapus Job <strong><?= $wawancara['job'] ?></strong>?</p>
        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800">Ya, Hapus</button>
            <a href="#" onclick="loadPageFromMenu('router.php?page=wawancara', '3')" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
        </div>
    </div>
</form>

<script>
  if (typeof initstaff === "function") {
    initwawancara();
  }
</script>