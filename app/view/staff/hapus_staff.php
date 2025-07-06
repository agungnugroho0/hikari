<?php
require_once __DIR__."/../../../autoloader.php";
use app\model\staff;
$staff = new staff();
$cari_staff = $staff->findById($id_staff);

?>
<form method="POST" id="form-hapus-staff">
    <input type="hidden" name="id_staff" value="<?= $cari_staff['id_staff'] ?>" class="dark:text-white">
    <div class="p-4">
        <p class="text-lg">Yakin ingin menghapus staff: <strong><?= $cari_staff['nama'] ?></strong>?</p>
        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800">Ya, Hapus</button>
            <a href="#" onclick="loadPageFromMenu('router.php?page=staff', '2')" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
        </div>
    </div>
</form>

<script>
  if (typeof initstaff === "function") {
      initstaff();
  }
</script>