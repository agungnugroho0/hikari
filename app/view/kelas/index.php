<?php
use app\controller\kelascontroller;
$model = new kelascontroller();
$data = $model->tampil();
?>

<body>
    <a href="#" onclick="loadPageFromMenu('router.php?page=kelas&act=tambah', '6')" class="p-2 bg-red-900 rounded hover:bg-red-800 transition-colors duration-700 ease-out text-white font-semibold font-[Lato] dark:bg-gray-700 dark:hover:bg-black my-4">+ Tambah Kelas</a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-3">
                        No
                    </th>
                    <th class="px-6 py-3">
                        Id Kelas
                    </th>
                    <th class="px-6 py-3">
                        Kelas
                    </th>
                    <th class="px-6 py-3">
                        Tingkat
                    </th>
                    <th class="px-6 py-3">
                        Pengampu
                    </th>
                    <th class="px-6 py-3">
                        Aksi
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach($data as $d):?>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-4 py-4">
                        <?= $i ;?>
                    </td>
                    <th scope="row" class="px-6 py-4 text-gray-600 dark:text-gray-600">
                       <?= $d['id_kelas']?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $d['kelas']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['tingkat']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['pengampu'];?>
                    </td>
                    
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="loadPageFromMenu('router.php?page=kelas&act=edit&id_kelas=<?= $d['id_kelas'] ?>', '6')">Edit</a>
                        <span> | </span>
                        <a href="#" class="font-medium text-red-600 dark:text-red-400 hover:underline btn-hapus" data-url="router.php?page=kelas&act=hapus&id_kelas=<?= $d['id_kelas'] ?>">Delete</a>
                    </td>
                </tr>
                <?php $i++; endforeach?>
</body>