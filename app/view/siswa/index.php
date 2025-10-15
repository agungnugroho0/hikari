<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\siswacontroller;
$model = new siswacontroller();
$kelas = $model->daftarkelas();

?>
<head>
<style>

</style>
    </head>
<body>
    <div class="flex gap-2 items-center mb-2">
          <a href="#" class="bg-slate-200 dark:bg-slate-800 text-gray-900 dark:text-gray-200 text-xs p-2 rounded hover:bg-slate-300 dark:hover:bg-black font-medium">Tambah Matching Hikari</a>
          <a href="#" class="bg-slate-200 dark:bg-slate-800 text-gray-900 dark:text-gray-200 text-xs p-2 rounded hover:bg-slate-300 dark:hover:bg-black font-medium">Tambah Matching LPK </a>
    </div>
    <?php foreach ($kelas as $k) : $siswa = $model->daftarsiswa($k['id_kelas'])?>
      <h1 class="text-2xl font-[Lato] font-semibold mt-5 mb-2 dark:text-slate-300">Kelas <?= $k['kelas'] ?></h1>
      <hr>
      <!-- <main class="flex flex-wrap gap-2 justify-evenly mt-5" id="siswa-container"> -->
      <main class="grid gap-2 mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 " id="siswa-container">
        
        <?php $i=1;?>
        <?php $delay=0; foreach ($siswa as $s) : ?>
        <!-- <a href="#"<?php //$s['nis']?> class="border-2 <?php // $s['id_job'] ? 'bg-green-300 dark:bg-red-600 dark:text-white' : 'bg-white dark:bg-slate-700 dark:text-white' ?> rounded p-2 flex flex-col group hover:bg-slate-200 fade-in-up border-slate-600 dark:hover:bg-black" style="--delay: <?php //$delay?>s;" onclick="loadPageFromMenu('router.php?page=siswa&act=detail&nis=<?//= $s['nis']?>','4')"> -->
        <a href="#"<?=$s['nis']?> class="border-2 <?= $s['id_job'] ? 'bg-green-300 dark:bg-red-600 dark:text-white' : 'bg-white dark:bg-slate-700 dark:text-white' ?> rounded p-2 flex flex-col group hover:bg-slate-200 fade-in-up border-slate-600 dark:hover:bg-black"  onclick="loadPageFromMenu('router.php?page=siswa&act=detail&nis=<?= $s['nis']?>','4')">
            <p class="font-normal overflow-hidden w-32 mt-0.5"><span><?= $i ?>. </span><?= $s['nama']?></p>
            <p class="font-normal overflow-hidden text-ellipsis whitespace-nowrap w-32 mt-0.5 text-red-900 dark:text-inherit"><?= umur($s['tgl'])?> 歳</p>
            <?php if (!empty($s['tgl_job'])) : ?>
            <p class="text-xs text-slate-700 dark:text-slate-200">
              Mensetsu : <?= $s['tgl_job'] === '0000-00-00' ? 'Belum ada jadwal ' : date('d-m-Y', strtotime($s['tgl_job'])) ?>
            </p>
            <?php endif; ?>
      </a>
      <?php $delay += 0.1; $i++; endforeach; ?>
    </main>
    <?php endforeach; ?>
</body>
