<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\loloscontroller;

$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$controller = new loloscontroller();
$result = $controller->daftarlolos($page);
$data = $result['data'];
$total = $result['total'];
$limit = $result['limit'];
$totalPages = ceil($total / $limit);
$i = ($page - 1) * $limit + 1;
?>
<body>
    <div class="relative shadow-md sm:rounded-lg mt-4 overflow-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="w-[60px] px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        Nama Siswa
                    </th>
                    <th class="px-6 py-3">
                        Tgl Lolos
                    </th>
                    <th class="px-6 py-3">
                        Job
                    </th>
                    <th class="px-6 py-3">
                        Perusahaan
                    </th>
                    <th class="px-6 py-3">
                        SO
                    </th>
                    <th class="px-6 py-3">
                        More
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach($data as $d):?>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                       <?= $i++?>
                    </td>
                    <td class="px-4 w-[60px] py-2">
                        <div class="w-10 h-10 overflow-hidden object-top rounded-full">
                            <img src="/public/image/nas_photos/<?= $d['foto']?>" alt="<?= $d['foto']?>" class=""> 
                        </div>
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-wrap text-gray-900 whitespace-nowrap dark:text-white">
                       <?= $d['nama']?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $d['tgl_lolos']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['job']?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['perusahaan'];?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $d['so'];?>
                    </td>
                    
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="loadPageFromMenu('router.php?page=lolos&act=detail&nis=<?= $d['nis'] ?>', '5')">...</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="flex flex-wrap justify-center mt-4 space-x-2" id="pagination-lolos">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button 
                    class="px-3 py-1 my-2 border rounded <?= $i == $page ? 'bg-blue-800 text-white' : 'bg-gray-100 hover:bg-gray-200' ?>"
                    onclick="loadPageFromMenu('router.php?page=lolos&halaman=<?= $i ?>', '5')">
                    <?= $i ?>
                </button>
            <?php endfor; ?>
        </div>
    </div>
</body>