<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\staffcontroller;

$data = (new staffcontroller())->tampilstaffcontroller();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>staff</title> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <style>
        @font-face{
            font-family:'Lato';
            src: url('../font/Lato-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .toast {
        opacity: 1 !important; /* bikin toast jadi full solid */
        background-color:#3ec922 !important; 
        color: #fff !important; /* warna teks */
        }
    </style> -->
</head>
<body>
    <a href="#" onclick="loadPageFromMenu('router.php?page=staff&act=tambah', '2')" class="p-2 bg-red-900 rounded hover:bg-red-800 transition-colors duration-700 ease-out text-white font-semibold font-[Lato] dark:bg-gray-700 dark:hover:bg-black my-4">Tambah Staff</a>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="w-[60px]">
                        &nbsp;
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th class="px-6 py-3">
                        Username
                    </th>
                    <th class="px-6 py-3">
                        Akses
                    </th>
                    <th class="px-6 py-3">
                        Kelas
                    </th>
                    <th class="px-6 py-3">
                        Aksi
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($data as $d):?>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-4 w-[60px] py-2">
                        <div class="w-10 h-10 overflow-hidden object-top rounded-full">
                            <img src="/public/image/photos/<?= $d['foto']?>" alt="<?= $d['foto']?>" class=""> 
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                       <?= $d['nama']?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $d['username']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['level']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['kelas'];?>
                    </td>
                    
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="loadPageFromMenu('router.php?page=staff&act=edit&id_staff=<?= $d['id_staff'] ?>', '2')">Edit</a>
                        <span> | </span>
                        <a href="#" class="font-medium text-red-600 dark:text-red-400 hover:underline" onclick="loadPageFromMenu('router.php?page=staff&act=hapus&id_staff=<?= $d['id_staff'] ?>', '2')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

