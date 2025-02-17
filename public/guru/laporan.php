<?php
require '../../autoloader.php';
guru();
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
$user = $_SESSION['username'];
$level = $_SESSION['level'];
$guru = tampil("SELECT * FROM staff WHERE nama = '$user'");
foreach ($guru as $g) {
    $id_kelas = $g['id_kelas'];
};
$laporan = tampil("SELECT a.*, s.nis, s.nama FROM absen a JOIN siswa s ON a.nis = s.nis WHERE s.id_kelas = '$id_kelas'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <title>LAPORAN</title>
</head>
<body>
<?php include 'header.html' ?>
<div class="mx-2 flex flex-col sm:flex-row gap-3 mt-3">
        <input type="month" class="py-1 px-2 rounded focus:outline-none shadow-sm" id="bulan" >
        <input type="text" value="<?= $id_kelas?>" id="kelas" hidden>
        <button type="submit" class="flex justify-center gap-2 items-center shadow-md text-sm bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-green-800 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group" id="exportBtn"
            >EXPORT EXCEL
            <svg
                class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                viewBox="0 0 16 19"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                class="fill-gray-800 group-hover:fill-gray-800"
                ></path>
            </svg>
            </button>
    </div>
<div class="mx-auto w-full mt-3" id="hasil"></div>
    
</body>
<script>
    const kelas = document.getElementById('kelas');
    const bulan = document.getElementById('bulan');
    const hasil = document.getElementById('hasil');
    const exportBtn = document.getElementById('exportBtn');

        async function loadData() {
        const response = await fetch(`../../app/api/api_presensi.php?kelas=${kelas.value}&bulan=${bulan.value}`);
        if (!response.ok) {
            throw new Error("Gagal mengambil data");
        }
        const data = await response.text();
        hasil.innerHTML = data;
    }
        function exportexcel(){
        // Ambil tabel dari div hasil
        const table = hasil.querySelector('table');
        if (!table) {
            alert("Tidak ada data yang dapat diekspor");
            return;
        }
        // Konversi tabel ke excel
        const wb = XLSX.utils.table_to_book(table, {sheet: "Presensi"},{cellStyles: true}, {cellDates: true});
        // Simpan ke file
        XLSX.writeFile(wb, `Presensi ${kelas.value} ${bulan.value}.xlsx`);
    }
    
    bulan.addEventListener('change', loadData);
    exportBtn.addEventListener('click', exportexcel);
</script>
</html>