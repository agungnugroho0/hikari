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
    <div class="flex flex-wrap flex-row gap-2 w-full justify-around ">
        <?php foreach ($kelas as $kelass) :?>
        <div class="bg-white rounded-md p-2 w-full md:w-64"> 
            <div class="flex gap-2 p-1">
                <p class="text-base font-semibold">Kelas <?= $kelass['kelas']?></p>
                <a href="../../siswa.php?sk&id_kelas=<?= $kelass['id_kelas']?>" class="bg-red-800 mx-2 px-2 text-white hover:bg-red-600 transition rounded-md">Tambah</a>
            </div>
            
            <?php 
            $wali = tampil("SELECT * FROM staff WHERE id_kelas=$kelass[id_kelas]");
            foreach($wali as $walikelas):  echo "<p class='text-sm text-gray-400'>".$walikelas['nama']."</p>"; endforeach; ?>
            <hr class="my-1">
            <?php
            $siswa = tampil("SELECT siswa.nis,siswa.nama,wawancara.id_job,siswa.tgl FROM siswa LEFT JOIN wawancara ON siswa.nis = wawancara.nis WHERE id_kelas=$kelass[id_kelas] order by siswa.gender, siswa.nama asc");
            $i=1;
            foreach($siswa as $siswas):?>
                <a href="<?= BASE_URL ?>detail_siswa.php?nis=<?= $siswas['nis']?>"><div class="flex gap-1 mb-1 hover:bg-gray-100">
                    <?php if($siswas['id_job'] !== null):?>
                        <div class="bg-green-900 w-1"></div>
                    <?php else:?>
                        <div class="w-1"></div>
                    <?php endif; ?>
                    <p><?= $i++ ?></p>
                    <p><?= $siswas['nama']?></p>
                    <p class="ml-auto text-red-800"><?= umur($siswas['tgl'])?> 歳</p>
                </div></a>
            <?php
            endforeach;
            ?>
        </div>
        <?php endforeach ;?>
    </div>
</body>
</html>