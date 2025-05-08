<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();
$kelas = tampil("SELECT kelas.id_kelas, kelas.kelas, GROUP_CONCAT(staff.nama SEPARATOR ', ') AS nama 
FROM kelas 
LEFT JOIN staff ON kelas.id_kelas = staff.id_kelas 
GROUP BY kelas.id_kelas, kelas.kelas
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kelas</title>
    <link rel="icon" type="image/png" href="../../image/asset/logo.png">

</head>
<body>
<button
  class="bg-white text-center w-48 rounded-xl h-8 relative text-black text-sm font-semibold group mt-2 sm:hidden"
  type="button"
  onclick="window.location.href='../index.php';"
>
  <div
    class="bg-red-800 rounded-2xl h-8 w-1/4 flex items-center justify-center absolute left-0 top-[0px] group-hover:w-[184px] z-10 duration-500"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="25px"
      width="25px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="#ffffff"
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="#ffffff"
      ></path>
    </svg>
  </div>
  <p class="translate-x-2">Go Back</p>
</button>
    <a href="<?= BASE_URL ?>form/tambah_kelas.php" class="bg-red-800 text-white font-semibold mb-5 p-2 rounded">TAMBAH</a>
    <div class="flex gap-3 flex-wrap justify-evenly">
        <?php foreach($kelas as $k) : ?>
        <div class="bg-white shadow rounded-md p-2 w-full md:w-1/5 mt-5">
            <div class="flex gap-2 items-center">
                <p class="grow font-semibold">Kelas <?= $k['kelas'];?></p>
                <a href="<?= BASE_URL ?>form/edit_kelas.php?id_kelas=<?=$k['id_kelas']?>"><img src="<?= BASE_URL2?>public/image/asset/pen.png" class="w-4"/></a>
                <a href="<?= BASE_URL2 ?>app/database/hapus_kelas.php?id_kelas=<?=$k['id_kelas']?>"><img src="<?= BASE_URL2?>public/image/asset/sampah.png" class="w-4"/></a>
            </div>
            <hr class="my-2">
            <p class="text-gray-500 italic">Pengampu : <?= $k['nama']?></p>
        </div>
        <?php endforeach;?>
    </div>
</body>
</html>