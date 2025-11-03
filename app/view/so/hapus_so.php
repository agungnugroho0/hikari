<?php
require_once __DIR__."/../../../autoloader.php";
use app\model\so;
$so = new so();
$cari_so = $so->findById($id_so);

?>
<form method="POST" id="form-hapus-so">
    <input type="hidden" name="id_so" value="<?= $cari_so['id_so'] ?>" class="dark:text-white">
    <div class="p-4">
        <p class="text-lg">Yakin ingin menghapus SO: <strong><?= $cari_so['so'] ?></strong>?</p>
        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800">Ya, Hapus</button>
            <a href="#" onclick="loadPageFromMenu('router.php?page=so', '8')" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
        </div>
    </div>
</form>

<script>
  if (typeof initso === "function") {
      initso();
  }
</script>