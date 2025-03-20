<?php
require '../../autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
guru();
$user = $_SESSION['username'];
$level = $_SESSION['level'];

$guru = tampil("SELECT * FROM staff WHERE nama = '$user'");
foreach ($guru as $g) {
    $id_kelas = $g['id_kelas'];
    $nama = $g['nama'];
    $foto = $g['foto'];
};

$siswa = tampil("SELECT wawancara.id_job, siswa.nis,siswa.nama,siswa.id_kelas,siswa.tgl FROM wawancara RIGHT JOIN siswa ON wawancara.nis = siswa.nis WHERE siswa.id_kelas = '$id_kelas' ORDER BY gender,nama");

$event = tampil("SELECT tgl_event FROM event WHERE nama_event ='UKK'");
foreach ($event as $e) {
    $tgl_event = $e['tgl_event'];
};
$hari_ini = date('Y-m-d');
if(isset($_GET['sukses'])){
    echo '<script>alert("OK");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="dark:bg-slate-800">
<?php include 'header.html' ?>
<main class="container mx-auto sm:p-5 p-3">
        <p class="text-md text-slate-400 dark:text-slate-300">ようこそ</p>
        <div id="judul" class="flex">
            <?php
            if ($foto == null ){
                echo '<div class="py-2 "><img class="max-w-12 rounded-full mr-2" src="../image/asset/app.png" /></div>';
            } else {
                echo '<div class="py-2 "><img class="max-w-12 rounded-full mr-2" src="../image/photos/'.$foto.'" /></div>';
            }
            ?>
            <h2 class="font-bold text-xl self-center dark:text-slate-200"><?= $nama?> 先生</h2>    
        </div>
        <hr>
        <div class="container mx-auto flex p-1 flex-col max-w-md">
            <?php $i=1;
            foreach ($siswa as $s) : ?>
                <div class="flex p-1 hover:bg-gray-100 justify-between">
                    <?php if($s['id_job'] !== null):?>
                        <div class="bg-green-900 w-1 dark:bg-yellow-600"></div>
                    <?php else:?>
                        <div class="w-1"></div>
                    <?php endif; ?>
                    <p class="py-1 px-1 dark:text-slate-200"><?= $i++ ?></p>
                    <p class="py-1 w-72 dark:text-slate-200"><?= $s['nama'] ?></p>
                    <p class="py-1 ml-auto dark:text-slate-400"><?= umur($s['tgl']) ?> 歳</p>
                    <?php if ($hari_ini == $tgl_event && $s['id_kelas']!== '1') { ?>
                            <a class="ml-auto bg-green-900 rounded py-1 px-1.5 font-medium text-white" href="<?=BASE_URL?>app/database/event.php?nis=<?= $s['nis']?>">NAIK KELAS</a>
                        <?php } else { ?>
                            <!-- <a class="ml-auto bg-blue-900 rounded py-1 px-1.5 font-medium text-white" href="">Detail</a> -->
                        <?php } ?>
                </div>
                <hr>
            <?php
            endforeach;
            ?>
        </div>
</main>
</body>
</html>
