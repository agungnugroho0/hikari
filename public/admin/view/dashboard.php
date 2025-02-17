<?php
    include '../../autoloader.php';
    admin();
    $kelas = tampil("SELECT kelas.id_kelas, kelas.kelas, COUNT(siswa.nis) AS jumlah_siswa FROM kelas JOIN siswa ON kelas.id_kelas = siswa.id_kelas GROUP BY kelas.id_kelas");
    $job = tampil("SELECT job.*, so.id_so,so.so,so.foto_so FROM job JOIN so ON job.id_so = so.id_so ORDER BY job.id_so");
    $so = tampil("SELECT * FROM so ORDER BY so");
?>
<div class="container mx-auto md:grid md:grid-cols-4 p-1 md:mx-1 gap-3 cursor-default">
    <div class="bg-white rounded-lg px-4 py-1 shadow-md md:h-[80vh] overflow-y-auto mt-2 md:mt-0">
            <p class="text-slate-500 text-sm font-normal mt-1 mb-2 pt-1">DAFTAR KELAS</p>
            <?php foreach ($kelas as $row) { ?>
                <p>Kelas <?= $row['kelas']?></p>
                <p class="text-red-900 text-xl font-semibold"><?= $row['jumlah_siswa']?> SISWA</p>
                <hr class="my-1">
                
            <?php } ?>
    </div>
    <div class="bg-white rounded-lg px-4 py-1 shadow-md md:h-[80vh] overflow-y-auto mt-2 md:mt-0">
        <p class="text-slate-500 text-sm font-normal mt-1 mb-2 pt-1">DAFTAR JOBS</p>
        <hr>
        <?php foreach ($job as $row) { ?>
            <div class="flex my-2">
                <img src="../image/img_so/<?= $row['foto_so']?>" alt="<?= $row['foto_so']?>" class="w-6 h-6 rounded-full overflow-clip">
                <p class="content-center pl-2 text-sm font-normal text-wrap"><?= $row['job']?></p>
            </div>
        <?php } ?>
    </div>
    <div class="bg-white rounded-lg px-4 py-1 shadow-md md:h-[80vh] overflow-y-auto mt-2 md:mt-0">
        <p class="text-slate-500 text-sm font-normal mt-1 mb-2 pt-1">DAFTAR SO</p>
        <hr>
        <?php foreach ($so as $row) { ?>
            <div class="flex my-2">
                <img src="../image/img_so/<?= $row['foto_so']?>" alt="<?= $row['foto_so']?>" class="w-6 h-6 rounded-full overflow-clip">
                <p class="content-center pl-2 text-sm font-normal text-wrap"><?= $row['so']?></p>
            </div>
        <?php } ?>
    </div>
    <div class="bg-white rounded-lg px-4 py-1 shadow-md md:h-[80vh] overflow-y-auto mt-2 md:mt-0 flex justify-center items-center">
        <img src="../image/asset/comingsoon.png" alt="" class="w-1/2">
    </div>
</div>

