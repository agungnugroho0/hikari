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

$kelasku = tampil("SELECT kelas FROM kelas WHERE id_kelas = '$id_kelas'");
foreach ($kelasku as $kl){
    $kelas = $kl['kelas'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../image/asset/logo.png">
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        @font-face{
            font-family:'Lato';
            src: url('../font/Lato-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body class="dark:bg-black bg-white">
    <header class="w-full px-6 py-2 flex ">
        <div>
            <?php
            if ($foto == null ){
                echo '<div class="py-2 "><img class="max-w-10 rounded-full mr-2" src="../image/asset/app.png" /></div>';
            } else {
                echo '<div class="py-2 "><img class="max-w-10 rounded-full mr-2" src="../image/photos/'.$foto.'" /></div>';
            }
            ?>
        </div>
        <a href="../../app/config/logout.php" class="cursor-pointer font-semibold overflow-hidden relative z-100 border border-black dark:border-white group px-5 py-1.5 h-10 ml-auto mt-2">
            <span class="relative z-10 text-black dark:text-white group-hover:text-white dark:group-hover:text-black text-base duration-500 font-semibold font-[Lato]">KELUAR</span>
            <span class="absolute w-full h-full bg-black dark:bg-gray-100 -left-32 top-0 -rotate-45 group-hover:rotate-0 group-hover:left-0 duration-500"></span>
            <span class="absolute w-full h-full bg-black dark:bg-gray-100 -right-32 top-0 -rotate-45 group-hover:rotate-0 group-hover:right-0 duration-500"></span>
        </a>
    </header>
    <main class="container w-full grid grid-cols-2 gap-3 mx-auto px-6 dark:bg-black mb-2">
        <div class="col-span-2 border-4 border-black dark:border-white w-full">
            <div class="p-2 flex items-center justify-between font-[Lato] font-semibold dark:text-white text-black">
                <p>Jumlah Siswa Lolos <span id="bln"></span> 
                <span id="kls" class="hidden sm:inline"></span>
                </p>

            <input type="month" class="py-1 px-2 rounded focus:outline-none shadow-sm dark:border dark:text-black" id="bulan" value="<?= date('Y-m')?>">
            <input type="hidden" value="<?= $kelas?>" id="kelas">
            </div>
            <div id="chartLolos" class="dark:bg-white pt-3"></div>
        </div>
        <a href="siswa.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/staff.png" alt="siswa" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:scale-150 sm:group-hover:scale-100 group-hover:translate-x-6 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">SISWA</p>
        </a> 
        <a href="wawancara.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
                <!-- <img src="../image/asset/gear.png" alt="setting" class="h-14 group-hover:scale-0 transition duration-200">
                  -->
                <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" class="h-14 group-hover:scale-0 transition duration-200 group"
                            >

                            <g transform="translate(0,512) scale(0.1,-0.1)"
                            fill="#000000" stroke="none">
                            <path d="M1780 4797 c-170 -58 -294 -194 -335 -369 -10 -41 -15 -116 -15 -215
                            l0 -152 -502 -3 -503 -3 -72 -26 c-179 -66 -308 -214 -343 -395 -8 -42 -10
                            -403 -8 -1289 l3 -1230 23 -60 c70 -184 238 -321 422 -345 109 -14 1139 -13
                            1179 1 53 19 66 67 31 112 l-21 26 -597 3 -597 3 -58 23 c-81 33 -166 114
                            -203 194 l-29 63 -2 800 -3 800 22 -30 c134 -181 343 -308 573 -346 l75 -13 0
                            -171 c0 -164 1 -173 26 -223 85 -171 315 -210 450 -75 71 71 79 98 82 296 l4
                            177 623 0 624 0 5 -57 c27 -263 82 -441 188 -606 l31 -48 -79 -80 c-67 -68
                            -83 -79 -105 -75 -71 14 -87 1 -442 -352 -388 -387 -392 -393 -392 -527 0 -94
                            24 -154 86 -216 67 -67 111 -84 219 -84 80 0 102 4 140 24 29 15 165 142 374
                            350 343 340 371 375 364 447 -2 31 5 42 76 113 l79 79 47 -29 c229 -141 511
                            -207 768 -181 191 19 365 74 514 162 36 22 70 40 74 40 15 0 -4 -166 -26 -222
                            -43 -115 -159 -207 -286 -228 -33 -6 -320 -10 -667 -10 -594 0 -607 0 -627
                            -20 -40 -40 -16 -111 43 -125 12 -3 306 -5 652 -3 577 4 635 5 685 22 190 63
                            326 210 365 393 8 38 15 124 15 193 l0 125 67 75 c198 223 304 478 319 775 18
                            330 -102 659 -326 898 l-60 65 0 163 c0 104 -6 189 -15 232 -43 203 -221 374
                            -425 407 -38 6 -259 10 -526 10 l-461 0 -5 173 c-5 138 -10 185 -27 238 -39
                            122 -130 233 -242 293 -98 54 -121 56 -674 56 -501 -1 -511 -1 -575 -23z
                            m1161 -158 c75 -36 134 -96 172 -177 31 -65 32 -72 35 -234 l4 -168 -81 0 -81
                            0 0 133 c0 72 -5 150 -11 172 -15 54 -52 101 -100 125 -38 20 -55 20 -528 18
                            l-489 -3 -39 -31 c-71 -58 -78 -79 -81 -256 l-4 -158 -79 0 -79 0 0 149 c0
                            121 4 161 20 214 34 110 115 192 228 233 29 11 145 13 547 11 l510 -2 56 -26z
                            m-111 -298 c5 -11 10 -78 10 -150 l0 -131 -475 0 -475 0 0 138 c0 94 4 142 12
                            150 9 9 126 12 465 12 437 0 453 -1 463 -19z m1515 -460 c42 -17 78 -42 121
                            -85 85 -85 106 -142 112 -304 l4 -124 -39 25 c-395 249 -905 256 -1304 17
                            -300 -181 -509 -475 -577 -812 l-19 -93 -632 -3 -631 -2 0 53 c0 82 -26 144
                            -84 203 -112 112 -287 113 -398 2 -48 -49 -71 -102 -77 -183 l-6 -70 -40 3
                            c-106 8 -257 74 -356 156 -85 71 -152 157 -199 258 -61 131 -72 207 -68 474 3
                            228 3 229 32 291 30 65 105 147 164 177 90 46 17 45 2037 43 l1900 -2 60 -24z
                            m-232 -471 c242 -52 478 -203 630 -402 247 -324 295 -760 124 -1122 -60 -125
                            -115 -205 -210 -303 -332 -342 -848 -429 -1272 -215 -218 110 -418 322 -512
                            545 -193 458 -57 988 332 1289 154 120 356 204 546 227 98 12 253 4 362 -19z
                            m-2952 -735 c59 -31 69 -64 69 -222 l0 -143 -130 0 -130 0 0 149 c0 147 0 150
                            27 181 43 51 106 65 164 35z m69 -572 c0 -96 -52 -156 -134 -156 -82 0 -126
                            53 -126 153 l0 60 130 0 130 0 0 -57z m1760 -758 l-65 -65 -55 55 -55 55 65
                            65 65 65 55 -55 55 -55 -65 -65z m-229 -112 c60 -59 109 -110 109 -115 0 -13
                            -71 -88 -84 -88 -6 0 -61 49 -121 110 l-109 110 44 45 c24 25 46 45 49 45 2 0
                            53 -48 112 -107z m-199 -200 c60 -59 108 -113 108 -118 0 -6 -100 -111 -223
                            -232 -240 -238 -246 -242 -337 -230 -50 6 -85 33 -110 83 -22 45 -25 88 -9
                            131 9 24 444 473 459 473 2 0 53 -48 112 -107z"/>
                            <path d="M3690 3224 c-278 -59 -509 -246 -630 -508 -54 -116 -72 -193 -77
                            -337 -11 -261 73 -481 250 -663 271 -276 680 -350 1026 -185 146 69 273 176
                            361 303 46 67 107 201 127 278 17 66 17 68 -3 95 -15 19 -32 29 -55 31 -45 4
                            -72 -25 -88 -93 -31 -129 -144 -299 -259 -391 -71 -56 -195 -116 -287 -140
                            -82 -21 -264 -23 -340 -5 -228 55 -420 209 -516 414 -53 113 -72 214 -67 351
                            8 206 70 348 218 496 149 149 287 210 495 217 147 6 231 -10 347 -65 198 -93
                            329 -242 398 -453 18 -51 39 -100 48 -107 28 -21 82 -11 105 20 19 26 19 28 3
                            94 -80 318 -357 580 -687 649 -88 19 -281 18 -369 -1z"/>
                            </g>
                        </svg>
                <p class="text-xl sm:text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] -translate-y-2">JADWAL MENSETSU</p> 
        </a>
        <a href="presensi.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/qr.png" alt="qr" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">PRESENSI</p> 
        </a>
        <a href="laporan.php" class="border-4 border-black dark:hover:border-white dark:bg-white h-40 p-5 group hover:bg-red-900 active:bg-black active:border-red-600 transition">
            <img src="../image/asset/report.png" alt="laporan" class="h-14 group-hover:scale-0 transition duration-200">
            <p class="text-3xl font-bold group-hover:-translate-x-1 sm:group-hover:translate-x-0 group-hover:-translate-y-7 duration-500 pt-6 group-hover:pt-0 group-hover:text-slate-50 font-[Lato] ">LAPORAN</p> 
        </a>
        
    </main>
</body>
<!-- <script src="../javascript/grafik_lolos.js"></script> -->
<script src="/hikari/public/javascript/jumlah_lolos.js"></script>
<!-- <script src="../javascript/jumlah_lolos.js"></script> -->
<script>
     
</script>
</html>
