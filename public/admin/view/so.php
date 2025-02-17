<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');

admin();
$so = tampil("SELECT * FROM so order by so asc");
if(isset($_GET['sukses'])){
    echo '<script>alert("Data Berhasil Disimpan");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<button type="button" class="mt-3 ml-2 text-white bg-gradient-to-r from-red-600 via-red-700 to-red-900 hover:bg-gradient-to-br focus:ring-1 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xl px-3 py-1 text-center me-2 mb-2 transition-all" onclick="window.location.href='<?= BASE_URL?>admin/form/tambah_so.php';"><p class="-translate-y-0.5">+</p></button>
<div class="relative overflow-x-auto shadow-md rounded-lg hidden md:block">
    <table class="w-full text-sm text-left text-gray-700 shadow-lg text-nowrap">
        <tr class="bg-gray-50 text-gray-900 uppercase text-sm leading-normal text-left">
            <th class="px-2 w-1">NO</th>
            <th class="px-2" colspan="2">NAMA SO</th>
            <th class="px-2">LOKASI</th>
            <th class="px-2">NOTE</th>
            <th class="px-2" colspan="2"></th>
        </tr>
        <?php
        $no = 1;
        foreach ($so as $s) :?>
        <tr class="bg-white border-b text-sm">
            <td class="p-2"><?= $no++; ?></td>
            <td class="p-2 w-11">
                <img src="<?= BASE_URL ?>image/img_so/<?= $s['foto_so']?>" alt="<?= $s['foto_so']?>" class="h-8 rounded-md me-2 object-cover object-center" />
            </td>
            <td class="p-2 text-base">
                <?= $s['so']; ?>
            </td>
            <td class="p-2"><?= $s['lokasi']?></td>
            <td class="p-2"><?= $s['noted']?></td>
            <td class="p-2">
            <a href="<?= BASE_URL ?>admin/form/edit_so.php?id_so=<?=$s['id_so']?>"><img src="<?= BASE_URL?>image/asset/pen.png" class="w-4"/></a>
            </td>
            <td class="p-2">
            <a href="<?= BASE_URL2 ?>app/database/hapus_so.php?id_so=<?=$s['id_so']?>"><img src="<?= BASE_URL?>image/asset/sampah.png" class="w-4"/></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>