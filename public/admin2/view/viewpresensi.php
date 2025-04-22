<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
admin();
$kelas = tampil("SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link rel="icon" type="image/png" href="../../image/asset/logo.png">

</head>
<body>
<button
  class="bg-white text-center w-48 rounded-xl h-8 relative text-black text-sm font-semibold group mt-2 sm:hidden"
  type="button"
  onclick="window.location.href='../index.php';"
>
  <div
    class="bg-red-800 rounded-2xl h-8 w-1/4 flex items-center justify-center absolute left-0 top-[0px] group-hover:w-[184px] z-10 duration-500"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="25px"
      width="25px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="#ffffff"
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="#ffffff"
      ></path>
    </svg>
  </div>
  <p class="translate-x-2">Go Back</p>
</button>

<div class="mx-2 flex flex-col sm:flex-row gap-3 mt-3 sm:mt-0">
        <input type="month" class="py-1 px-2 rounded focus:outline-none shadow-sm" id="bulan" >
        <select id="kelas" class="py-1 px-2 rounded focus:outline-none shadow-sm">
            <?php foreach ($kelas as $key => $value) :?>
                <option value="<?=$value['kelas']?>"><?= $value['kelas']?>
            <?php endforeach;?>
        </select>
        <!-- <button id="exportBtn" class="py-1 px-3 bg-green-800 text-white rounded">EXPORT EXCEL</button> -->
        
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
<script src="../../javascript/presensi.js"></script>
</html>