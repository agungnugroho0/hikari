<?php 
require '../../autoloader.php';


// admin();
$so = tampil("SELECT 
    so.id_so,
    so.so,
    so.foto_so,
    job.job,
    job.id_job,
    job.perusahaan,
    job.tgl_job,
    wawancara.id_w,
    siswa.nama
FROM 
    so
JOIN 
    job ON job.id_so = so.id_so
LEFT JOIN 
    wawancara ON wawancara.id_job = job.id_job
LEFT JOIN 
    siswa ON wawancara.nis = siswa.nis");

$job = [];

// Ubah struktur penambahan peserta jadi array:

foreach ($so as $data_so) {
    $id_so = $data_so['id_so'];
    $id_job = $data_so['id_job'];
        if (!isset($job[$id_so])) {
            $job[$id_so] = [
                'so' => $data_so['so'],
                'foto_so' => $data_so['foto_so'],
                'jobs' => []
            ];
        }
    if (!isset($job[$id_so]['jobs'][$id_job])) {
      $job[$id_so]['jobs'][$id_job] = [
        'job' => $data_so['job'],
        'id_jobs' => $data_so['id_job'],
        'perusahaan' => $data_so['perusahaan'],
        'pertemuan' => 'SEGERA',
        'tgl_job' => $data_so['tgl_job'],
        'peserta' => [],
      ];
    }

    if ($data_so['id_w']) {
      $job[$id_so]['jobs'][$id_job]['peserta'][] = [
        'id_w' => $data_so['id_w'],
        'siswa_nama' => $data_so['nama'],
      ];
    }
}

// var_dump($job);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
  <link rel="icon" type="image/png" href="../../image/asset/logo.png">
  <style>

</style>

</head>
<body>
<?php include 'header.html' ?>

    <div class="flex flex-wrap gap-3 flex-row mt-5 justify-evenly">
        <!-- mulai looping -->
         <?php foreach ($job as $id_so => $data_so): ?>
        <div class="shadow w-full sm:w-[18rem] relative">
            <!-- judul SO -->
            <div class="flex gap-2 logo-container relative overflow-hidden items-center h-16">
                <img src="/hikari/public/image/img_so/<?= $data_so['foto_so']?>" alt="" class="w-16 object-cover logo-img" >
                <p class="nama_so font-semibold text-2xl pl-2 overflow-hidden text-ellipsis whitespace-nowrap"><?= $data_so['so']?></p> 
            </div>
            <!-- judul SO -->
             <!-- job -->
              <?php foreach ($data_so['jobs'] as $job_data):?>
                <div class="grid grid-cols-2 p-2 bg-slate-50 relative min-h-20">
                  <p class="text-sm font-bold"><?= $job_data['perusahaan']?></p>
                  <p class="text-sm text-slate-600 font-bold"><?= $job_data['pertemuan']?></p>
                  <p class="text-sm text-slate-600 font-semibold"><?= $job_data['job']?></p>
                  <p class="font-bold text-sm"><?= $job_data['tgl_job']?></p>
                  
                  
                </div>
                <hr class="mt-1">
                <!-- daftar peserta -->
                <?php if (!empty($job_data['peserta'])): ?>
                  <?php foreach ($job_data['peserta'] as $i => $peserta): ?>
                      <div class="flex flex-row hover:bg-slate-100  py-2">
                        <p class="text-base  px-1 cursor-default"><?= $i + 1 ?></p>
                        <p class="text-base  px-2 grow overflow-hidden text-ellipsis whitespace-nowrap cursor-default"><?= $peserta['siswa_nama'] ?></p>
                        
                      </div>
                  <?php endforeach ?>
                  <?php else : ?>
                    <p class="px-2 py-1 text-sm text-slate-400">Belum ada peserta</p>
                <?php endif ?>
                <?php endforeach ?>

          </div>
          <?php endforeach; ?>
        <!-- akhir looping -->
    </div>
</body>
<script>
  const colorThief = new ColorThief();

  window.addEventListener('load', () => {
    const images = document.querySelectorAll('.logo-img');
    const containers = document.querySelectorAll('.logo-container');

    images.forEach((img, index) => {
      // Pastikan gambar sudah selesai dimuat
      img.addEventListener('load', () => {
        applyColor(img, containers[index]);
      });

      if (img.complete) {
        applyColor(img, containers[index]); // Gambar sudah dimuat, langsung diterapkan
      }
    });

    function getLuminance(rgb) {
      const [r, g, b] = rgb;
      const a = [r, g, b].map(function (v) {
        v /= 255;
        return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
      });
      return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
    }

    function applyColor(img, container) {
      // Ambil warna dominan dari gambar
      const color = colorThief.getColor(img);
      const [r, g, b] = color;
      const luminance = getLuminance([r, g, b]);

      // Tentukan warna teks berdasarkan kecerahan latar belakang
      const textColor = luminance > 0.5 ? 'black' : 'white';
      
      // Sesuaikan warna latar belakang dan teks
      container.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
      const textElement = container.querySelector('.nama_so');
      textElement.style.color = textColor; // Mengubah warna teks
    }
  });
</script>

</html>