<?php
require_once __DIR__."/../../../autoloader.php";
session_start();
?>

<body>
    
<div class="relative overflow-x-auto">
    <input id="searchInput" type="search" placeholder="Cek Tagihan" class="focus:border-2 border-gray-300 px-5 py-3 rounded-lg w-36 sm:w-56 h-9 transition-all focus:w-56 sm:focus:w-80 outline-none font-[Lato] duration-700 ease-in-out placeholder:font-medium mb-2">
    <select id="filterSelect" class="rounded border p-1">
        <option value="semua">Semua</option>
        <option value="siswa">Siswa</option>
        <option value="lolos">Lolos</option>
    </select>
    <table class="shadow-md dark:text-white text-wrap w-full">
        <thead class="bg-gray-300 dark:bg-gray-700">
            <tr class="*:p-2 ">
                <th rowspan="2" >No</th>
                <th rowspan="2" class="">Siswa</th>
                <th colspan="5">Tagihan</th>
                <th rowspan="2">Sisa Tagihan</th>
                <th rowspan="2"></th>
            </tr>
            <tr class="*:py-2 *:pr-3 *:pl-2">
                <td class="w-20">Pra-MCU</td>
                <td>Pendidikan 1</td>
                <td>Pendidikan 2</td>
                <td>Sending Organizer</td>
                <td>Lain - lain</td>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800" id="bodyTagihan">
            <!-- Data akan dimuat di sini oleh JavaScript -->
            <tr>
                <td colspan="9" class="text-center p-4">Memuat data...</td>
            </tr>
    </tbody>
    </table>
</div>
</body>