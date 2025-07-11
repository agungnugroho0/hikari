<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\wawancaracontroller;
$so = (new wawancaracontroller())->tampilwawancara();
$job = [];
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
        'interview' => $data_so['interview'],
        'tgl_job' => $data_so['tgl_job'],
        'penempatan' => $data_so['penempatan'],
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
?>

<body>
<a href="#" class="text-white bg-gradient-to-br from-orange-600 to-red-700 hover:to-yellow-700 focus:ring-1 focus:outline-none text-sm px-5 py-2 text-center dark:from-black dark:to-black dark:hover:to-gray-900 font-[Lato] font-bold rounded" onclick="loadPageFromMenu('router.php?page=wawancara&act=tambah', '3')">+ Training Order</a>

    <div class="grid gap-2 mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
        <!-- mulai looping -->
         <?php foreach ($job as $id_so => $data_so): ?>
        <div class="shadow w-full bg-white dark:bg-gray-700">
            <!-- judul SO -->
            <div class="flex gap-2 logo-container relative overflow-hidden items-center h-16">
                <img src="/public/image/img_so/<?= $data_so['foto_so']?>" alt="" class="w-16 object-cover logo-img" >
                <p class="nama_so font-semibold text-2xl pl-2 overflow-hidden text-ellipsis whitespace-nowrap"><?= $data_so['so']?></p> 
            </div>
            <!-- judul SO -->
             <!-- job -->
              <?php foreach ($data_so['jobs'] as $job_data):?>
                <div class="grid grid-cols-2 p-2 bg-slate-50 dark:bg-slate-800 relative min-h-20 dark:text-white pr-10">
                  <p class="text-sm font-bold"><?= $job_data['perusahaan']?></p>
                  <p class="text-sm text-slate-600 dark:text-slate-300 font-bold"><?= $job_data['interview']?></p>
                  <p class="text-sm text-slate-600 dark:text-slate-300 font-semibold"><?= $job_data['job']?></p>
                  <p class="text-sm text-slate-600 dark:text-slate-300 font-semibold"><?= $job_data['penempatan']?></p>
                  <p class="font-bold text-sm"><?= $job_data['tgl_job']?></p>
                  <div class="absolute right-0 top-0 ">
                    <a href="#" class="block mb-4 mt-2" onclick="loadPageFromMenu('router.php?page=wawancara&act=edit&id_jobs=<?= $job_data['id_jobs']?>','3')">
                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50" class="-translate-x-1.5 translate-y-1  fill-current text-black dark:text-white">
                          <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875 44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375 6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z"></path>
                      </svg>
                    </a>
                      <a href="#" class="block" onclick="loadPageFromMenu('router.php?page=wawancara&act=hapus&id_jobs=<?= $job_data['id_jobs']?>','3')">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" class="-translate-x-2 translate-y-1  fill-current text-black dark:text-white">
                        <path d="M 20.5 4 A 1.50015 1.50015 0 0 0 19.066406 6 L 14.640625 6 C 12.796625 6 11.086453 6.9162188 10.064453 8.4492188 L 7.6972656 12 L 7.5 12 A 1.50015 1.50015 0 1 0 7.5 15 L 40.5 15 A 1.50015 1.50015 0 1 0 40.5 12 L 40.302734 12 L 37.935547 8.4492188 C 36.913547 6.9162187 35.202375 6 33.359375 6 L 28.933594 6 A 1.50015 1.50015 0 0 0 27.5 4 L 20.5 4 z M 8.9726562 18 L 11.125 38.085938 C 11.425 40.887937 13.77575 43 16.59375 43 L 31.40625 43 C 34.22325 43 36.574 40.887938 36.875 38.085938 L 39.027344 18 L 8.9726562 18 z"></path>
                        </svg>
                      </a>
                  </div>
                </div>
                <a href="#" class="w-full dark:bg-stone-900 block text-center dark:text-white font-bold font-[Lato] hover:dark:bg-slate-950 py-1" onclick="loadPageFromMenu('router.php?page=wawancara&act=tambahpeserta&id_jobs=<?= $job_data['id_jobs']?>','3')">Tambah Peserta</a>
                <hr class="mt-1">
                <!-- daftar peserta -->
                <?php if (!empty($job_data['peserta'])): ?>
                  <?php foreach ($job_data['peserta'] as $i => $peserta): ?>
                      <div class="flex flex-row hover:bg-slate-100 dark:hover:bg-gray-950 py-2 dark:bg-gray-700 dark:text-gray-100">
                        <p class="text-base  px-1 cursor-default"><?= $i + 1 ?></p>
                        <p class="text-base  px-2 grow overflow-hidden text-ellipsis whitespace-nowrap cursor-default"><?= $peserta['siswa_nama'] ?></p>
                        <a href="#" class="px-2 "  onclick="loadPageFromMenu('router.php?page=wawancara&act=lolos&id_w=<?= $peserta['id_w']?>','3')">
                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                          <linearGradient id="HoiJCu43QtshzIrYCxOfCa_VFaz7MkjAiu0_gr1" x1="21.241" x2="3.541" y1="39.241" y2="21.541" gradientUnits="userSpaceOnUse"><stop offset=".108" stop-color="#0d7044"></stop><stop offset=".433" stop-color="#11945a"></stop></linearGradient><path fill="url(#HoiJCu43QtshzIrYCxOfCa_VFaz7MkjAiu0_gr1)" d="M16.599,41.42L1.58,26.401c-0.774-0.774-0.774-2.028,0-2.802l4.019-4.019	c0.774-0.774,2.028-0.774,2.802,0L23.42,34.599c0.774,0.774,0.774,2.028,0,2.802l-4.019,4.019	C18.627,42.193,17.373,42.193,16.599,41.42z"></path><linearGradient id="HoiJCu43QtshzIrYCxOfCb_VFaz7MkjAiu0_gr2" x1="-15.77" x2="26.403" y1="43.228" y2="43.228" gradientTransform="rotate(134.999 21.287 38.873)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2ac782"></stop><stop offset="1" stop-color="#21b876"></stop></linearGradient><path fill="url(#HoiJCu43QtshzIrYCxOfCb_VFaz7MkjAiu0_gr2)" d="M12.58,34.599L39.599,7.58c0.774-0.774,2.028-0.774,2.802,0l4.019,4.019	c0.774,0.774,0.774,2.028,0,2.802L19.401,41.42c-0.774,0.774-2.028,0.774-2.802,0l-4.019-4.019	C11.807,36.627,11.807,35.373,12.58,34.599z"></path>
                          </svg>
                        </a>
                        <a href="#" class="px-2 btn-gagal" data-url="router.php?page=wawancara&act=gagal&id_w=<?= $peserta['id_w']?>">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                            <linearGradient id="hbE9Evnj3wAjjA2RX0We2a_OZuepOQd0omj_gr1" x1="7.534" x2="27.557" y1="7.534" y2="27.557" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f44f5a"></stop><stop offset=".443" stop-color="#ee3d4a"></stop><stop offset="1" stop-color="#e52030"></stop></linearGradient><path fill="url(#hbE9Evnj3wAjjA2RX0We2a_OZuepOQd0omj_gr1)" d="M42.42,12.401c0.774-0.774,0.774-2.028,0-2.802L38.401,5.58c-0.774-0.774-2.028-0.774-2.802,0	L24,17.179L12.401,5.58c-0.774-0.774-2.028-0.774-2.802,0L5.58,9.599c-0.774,0.774-0.774,2.028,0,2.802L17.179,24L5.58,35.599	c-0.774,0.774-0.774,2.028,0,2.802l4.019,4.019c0.774,0.774,2.028,0.774,2.802,0L42.42,12.401z"></path><linearGradient id="hbE9Evnj3wAjjA2RX0We2b_OZuepOQd0omj_gr2" x1="27.373" x2="40.507" y1="27.373" y2="40.507" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a8142e"></stop><stop offset=".179" stop-color="#ba1632"></stop><stop offset=".243" stop-color="#c21734"></stop></linearGradient><path fill="url(#hbE9Evnj3wAjjA2RX0We2b_OZuepOQd0omj_gr2)" d="M24,30.821L35.599,42.42c0.774,0.774,2.028,0.774,2.802,0l4.019-4.019	c0.774-0.774,0.774-2.028,0-2.802L30.821,24L24,30.821z"></path>
                            </svg>
                        </a>
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
