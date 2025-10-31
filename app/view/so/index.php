<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\socontroller;

$data = (new socontroller())->tampilsocontroller();

?>

<body>
    <a href="#" onclick="loadPageFromMenu('router.php?page=so&act=tambah', '8')" class="p-2 bg-red-900 rounded hover:bg-red-800 transition-colors duration-700 ease-out text-white font-semibold font-[Lato] dark:bg-gray-700 dark:hover:bg-black my-4">+ Tambah Sending Organizer</a>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="w-[60px]">
                        &nbsp;
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sending Organizer
                    </th>
                    <th class="px-6 py-3">
                        Lokasi
                    </th>
                    <th class="px-6 py-3">
                        Penanggung Jawab
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
                        <div class="w-10 h-10 overflow-hidden rounded bg-white p-1">
                            <img src="/public/image/img_so/<?= $d['foto_so']?>" alt="<?= $d['foto_so']?>" class=""> 
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                       <?= $d['so']?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $d['lokasi']?>
                    </td>                    
                    <td class="px-6 py-4">
                        &nbsp;
                    </td>                    
                    <td class="px-6 py-4">
                        
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="loadPageFromMenu('router.php?page=so&act=edit&id_so=<?= $d['id_so'] ?>', '8')">Edit</a>
                        <span> | </span>
                        <a href="#" class="font-medium text-red-600 dark:text-red-400 hover:underline" onclick="loadPageFromMenu('router.php?page=so&act=hapus&id_so=<?= $d['id_so'] ?>', '8')">Delete</a>
                        <!-- <p>Coming Soon</p> -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

