<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();
$kelas = tampil("SELECT * FROM kelas");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Siswa</title>
    <link rel="icon" type="image/png" href="../../image/asset/logo.png">
</head>
<body>
 <div class="flex flex-col">
   <?php foreach ($kelas as $k) : ?>
  <ul class="hidden sm:block p-2">
    <li role="button" class="hover:bg-slate-200 "><input type="radio" name="kelas"id="<?= $k['kelas']?>">
      <label for="<?= $k['kelas']?>" class="translate-x-10"><?= $k['kelas']?></label>
    </li>
  </ul>
  <?php endforeach; ?>
 </div>
</body>
<script src="../javascript/cek.js"></script>

</html>