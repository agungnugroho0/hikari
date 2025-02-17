<?php 
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();
$job = tampil("SELECT 
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

$eksekusi = [];

foreach ($job as $data =>$data_so){ 
    $eksekusi[$data_so['id_so']][$data_so['so']][$data_so['foto_so']][$data_so['job']][$data_so['id_job']][$data_so['perusahaan']][$data_so['tgl_job']][$data_so['id_w']]=$data_so['nama'];
  };

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
  
<!-- <div class="mx-auto w-full flex items-center justify-center h-3/6 flex-col">
  <img src="<?= BASE_URL2?>public/image/asset/maintenance.png" alt="" class="w-36 mb-4" />
  <p>MAINTENANCE SAK RAMPUNGE</p>
</div> -->
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

    </div>
    <a href="<?= BASE_URL ?>form/tambah_job.php" class="bg-red-900 rounded-md shadow-md p-2 font-medium text-white max-w-fit mx-3 mt-2 xl:mt-0">TAMBAH JOBS</a>
    <div class="flex mt-4 ml-3 flex-wrap gap-3 justify-between mr-3">
      <?php foreach ($eksekusi as $id_so => $data_so){ 
        foreach ($data_so as $so => $data_fotoso){  ?>
          <div class="bg-white w-full md:w-64 p-2 rounded-md shadow-md">
            <div class="flex flex-row items-center">
              <img src="<?= BASE_URL2 ?>public/image/img_so/<?= key($data_fotoso) ?>" alt="foto_so" class="w-6 h-6 rounded-full">
              <p class="font-semibold ml-2"><?= $so ?></p>
            </div>
            <?php foreach ($data_fotoso as $fotoso => $data_job){
              foreach ($data_job as $job => $data_idjob){ ?>
                <hr class="my-1">
                <?php foreach ($data_idjob as $id_job => $data_perusahaan) { ?>
                <div class="flex items-center gap-2 bg-red-50 px-2 py-2 mt-2">
                    <p class="text-base text-gray-600 grow"><i><?= $job ?></i></p>
                    <a href="<?= BASE_URL ?>form/edit_job.php?id_job=<?= $id_job ?>"><img src="<?= BASE_URL2 ?>public/image/asset/pen.png" class=" w-4"></a>
                    <a href="<?= BASE_URL2 ?>app/database/delete_job.php?id_job=<?= $id_job ?>"><img src="<?= BASE_URL2 ?>public/image/asset/sampah.png" class="w-4"></a>
                </div>
                   <?php foreach ($data_perusahaan as $perusahaan => $datatgljob){?>
                    <div class="flex flex-wrap items-center gap-2 bg-yellow-200 px-2">
                      <p class="font-semibold"><?= $perusahaan ?></p>
                      <p> | </p>
                      <p><?= key($datatgljob); $i = 1; ?></p>
                    </div>
                    <hr class="my-2">
                    <?php foreach ($datatgljob as $tgljob => $data_w){
                        foreach ($data_w as $id_w => $w){ ?>
                        <div class="flex flex-row gap-1 ">
                          <?php if (!empty($w)){?>
                            <p><?= $i++?></p>
                            <p class="text-base px-1 grow"><?= $w ?></p>
                            <a href="<?= BASE_URL ?>form/lolos_job.php?id_w=<?= $id_w ?>"><img src="<?= BASE_URL2 ?>public/image/asset/centang.png" class="w-4"></a>
                            <a href="<?= BASE_URL2 ?>app/database/gagal_siswa.php?id_w=<?= $id_w ?>"><img src="<?= BASE_URL2 ?>public/image/asset/silang.png" class="pt-1 w-4"></a>  
                          <?php } else {
                            ?>
                            <p class="px-2 font-semibold text-gray-700"><i>Belum Ada Peserta</i></p>
                          <?php } ?>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
            <?php } 
          } ?>
          </div>
        <?php
        }
        ?>
      <?php } ?>

    </div>
</body>
</html>