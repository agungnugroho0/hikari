<?php
require __DIR__.'/../../../autoloader.php';


$kelas = tampil("SELECT * FROM kelas");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @font-face {
        font-family: 'Lato';
        src: url('/public/font/Lato-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
      }

      .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        transition-delay: var(--delay, 0s);
      }

      .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
      }
</style>

</head>
<body class="mt-2">
  <!-- <select name="kelas" id="kelas" class="border-b-2 border-slate-600 p-2 w-full md:w-1/4 md:mb-3"> -->
    <!-- </select> -->
    <a class=" text-red-600 font-[Lato] text-sm hover:bg-red-900 hover:text-white p-2 font-semibold rounded" href="#" target="_top">Tambah Siswa</a>
    
    <?php foreach ($kelas as $k) : ?>
      <?php $siswa = tampil("SELECT siswa.nis, siswa.nama,siswa.foto, siswa.tgl, wawancara.id_job, job.tgl_job 
                        FROM siswa 
                        LEFT JOIN wawancara 
                        ON siswa.nis = wawancara.nis 
                        LEFT JOIN job
                        ON wawancara.id_job = job.id_job 
                        WHERE id_kelas = $k[id_kelas]
                        ORDER BY siswa.gender, siswa.nama ASC"); 
      ?>
      
      <h1 class="text-2xl font-[Lato] font-semibold mt-5 mb-2">Kelas <?= $k['kelas'] ?></h1>
      <hr>
      <main class="flex flex-wrap gap-2 justify-evenly md:justify-start mx-auto mt-5" id="siswa-container">
        <?php $i=1;?>
        <?php $delay=0; foreach ($siswa as $s) : ?>
          <a href="detail_siswa.php?nis=<?=$s['nis']?>" class="border-2 <?= $s['id_job'] ? 'bg-green-300' : 'bg-white' ?> rounded p-2 flex flex-col group hover:bg-slate-200 fade-in-up border-slate-600"
             style="--delay: <?=$delay?>s;">
              
            <p class="font-semibold font-[Lato] overflow-hidden w-32 mt-0.5"><span><?= $i ?>. </span><?= $s['nama']?></p>
            <p class="font-semibold font-[Lato] overflow-hidden text-ellipsis whitespace-nowrap w-32 mt-0.5 text-red-900"><?= umur($s['tgl'])?> 歳</p>
            <?php if (!empty($s['tgl_job'])) : ?>
            <p class="text-xs text-slate-700">
              Job: <?= $s['tgl_job'] === '0000-00-00' ? 'Belum ada jadwal ' : date('d-m-Y', strtotime($s['tgl_job'])) ?>
            </p>
            <?php endif; ?>
      </a>
      <?php $delay += 0.1; $i++; endforeach; ?>
    </main>
    <?php endforeach; ?>
</body>
<script>

  document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target); // animasi hanya sekali
          }
        });
      },
      {
        threshold: 0.1 // elemen muncul 10% di layar
      }
    );

    document.querySelectorAll('.fade-in-up').forEach(el => {
      observer.observe(el);
    });
  });

</script>

</html>