<?php 
include __DIR__.'/../../../autoloader.php';

// Dapetin base folder URL dari __DIR__
// $rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
// $currentPath = realpath(__DIR__);

// Hitung path relatif dari DOCUMENT_ROOT ke folder ini
// $relativePath = str_replace('\\', '/', str_replace($rootPath, '', $currentPath));

// Buat URL dasarnya
// $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $relativePath . '/';

// define('BASE_URL', $baseUrl);            // otomatis ke /hikari/public/admin/
// define('BASE_URL2', dirname($baseUrl, 3) . '/');  // naik tiga folder jadi ke /hikari/


$nis= $_GET['nis'] ?? null;
$lolos = isset($_GET['lolos']);
$ket = $lolos ? 'lolos' : 'siswa';
if ($lolos) {
    $job = tampil("
        SELECT l.tgl_lolos, l.so, l.job, l.perusahaan, so.so, so.foto_so
        FROM log_lolos l
        JOIN so ON l.so = so.so
        WHERE nis = '$nis'
    ");
} else {
    $job = tampil("
        SELECT w.*, s.nis, j.*
        FROM wawancara w
        JOIN siswa s ON w.nis = s.nis
        JOIN job j ON w.id_job = j.id_job
        WHERE s.nis = '$nis'
    ");
    $ikut_job = tampil("SELECT w.*, s.nis,j.*,so.so, so.foto_so FROM wawancara w JOIN siswa s ON w.nis = s.nis JOIN job j on w.id_job = j.id_job JOIN so ON j.id_so = so.id_so WHERE s.nis = '".$nis."'");
}

$siswa      = tampil("SELECT a.*,kls.kelas FROM $ket a JOIN kelas kls ON a.id_kelas = kls.id_kelas WHERE nis = '$nis'");
$kk         = tampil("SELECT * FROM kk WHERE nis = '$nis' ORDER BY urutan");
$pendidikan = tampil("SELECT * FROM pendidikan WHERE nis = '$nis'");
$tx         = tampil("SELECT * FROM log_pembayaran WHERE nis = '$nis'");
$tagihan    = tampil("SELECT id_tagihan, status_tagihan, sisa_tagihan, jenis_tagihan FROM tagihan WHERE nis = '$nis'");
$sekarang   = new DateTime();
$datasiswa= [];
$garis = "outline outline-2 rounded px-2 py-1 outline-gray-300";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         @font-face {
        font-family: 'Lato';
        src: url('../../font/Lato-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
      }
    </style>
</head>
<body class="font-[Lato]">
    <header class="flex flex-col sm:flex-row gap-2 p-1">
        <div class="flex flex-row grow <?= $garis ?> gap-2">
            <!-- data diri -->
            <?php foreach ($siswa as $s) :
                $umur = umur($s['tgl']);
                $nomor_wa = formatnowa($s['wa']);

                ?>
            <div class="max-h-14 max-w-14 rounded-full overflow-clip">
                <img src="<?= '../../image/photos/'.$s['foto']?>" alt="<?=$s['foto']?>" class="object-top"/></div>
            <div class="grow flex flex-col gap-1">
                <p class="text-gray-500 text-xs font-normal"><?= $s['nis']?></p>
                <p class="text-black text-lg font-semibold "><?= $s['nama']?></p>
                <hr>
                
                    <?php 
                    $datasiswa = [
                        'Kelas' => $s['kelas'],
                        'カタカナ' => $s['panggilan'],
                        'Tempat Lahir' => $s['tempat_lhr'],
                        'Tanggal Lahir' => $s['tgl'],
                        'No Whatsapp' => '0'.$s['wa'],
                        'No Rumah' => '0'.$s['no_rumah'],
                        'Umur' => $umur . ' 歳',
                        'Kelamin' => $s['gender'],
                        'Agama' => $s['agama'],
                        'Status' => $s['status'],
                        'Golongan Darah' => $s['darah'],
                        'Berat Badan' => $s['bb'].' Kg',
                        'Tinggi Badan' => $s['tb'].' CM',
                        'Rokok' => $s['merokok'],
                        'Alkohol' => $s['alkohol'],
                        'Dominan Tangan' => $s['tangan'],
                        'Hobi' => $s['hobi'],
                        'Tujuan Ke Jepang' => $s['tujuan'],
                    ];
                    $labelt ='Tempat Tinggal';
                    $valuet = "DESA {$s['kelurahan']}, RT. 00{$s['rt']} / RW. 00{$s['rw']}, {$s['kecamatan']}, {$s['kabupaten']}, {$s['provinsi']}";
                    ?>
                <p class="text-gray-500 text-xs font-normal"><?= $labelt ?></p>
                <p class="text-black text-lg font-semibold"><?=$valuet?></p>
                <div class="grid md:grid-cols-3 gap-2">
                    <?php foreach ($datasiswa as $label => $value) : ?>
                    <div>
                        <p class="text-gray-500 text-xs font-normal"><?= $label ?></p>
                        <p class="text-black text-lg font-semibold"><?=$value?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <table class="w-full border border-gray-300 text-sm text-left text-gray-700 cursor-default mt-2">
                    <thead class="bg-gray-100 text-gray-800 font-[Lato]">
                        <tr>
                            <th class="border px-4 py-2 w-[5%]">No</th>
                            <th class="border px-4 py-2 w-[15%]">Hubungan</th>
                            <th class="border px-4 py-2 w-[40%]">Nama</th>
                            <th class="border px-4 py-2 w-[10%]">Umur</th>
                            <th class="border px-4 py-2">Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($kk as $k): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="border px-4 py-2"><?= $i ?></td>
                            <td class="border px-4 py-2"><?= $k['hubungan'] ?></td>
                            <td class="border px-4 py-2"><?= $k['nama'] ?></td>
                            <td class="border px-4 py-2"><?=  umur($k['thn_kelahiran']) ?></td>
                            <td class="border px-4 py-2"><?= $k['pekerjaan'] ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>
                <table class="w-full border border-gray-300 text-sm text-left text-gray-700 cursor-default mt-2">
                    <thead class="bg-gray-100 text-gray-800 font-[Lato]">
                        <tr>
                            <th class="border px-4 py-2 w-[5%]">No</th>
                            <th class="border px-4 py-2 w-[40%]">Sekolah</th>
                            <th class="border px-4 py-2 w-[5%]">Thn Masuk</th>
                            <th class="border px-4 py-2 w-[5%]">Thn Lulus</th>
                            <th class="border px-4 py-2 2-[10%]">Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($pendidikan as $p): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="border px-4 py-2"><?= $i ?></td>
                            <td class="border px-4 py-2"><?= $p['sekolah'] ?></td>
                            <td class="border px-4 py-2"><?= $p['masuk'] ?></td>
                            <td class="border px-4 py-2"><?= $p['lulus'] ?></td>
                            <td class="border px-4 py-2"><?= $p['jurusan'] ?></td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; ?>
            <div class="">
                <a href="../form/edit_siswa.php?nis=<?= $nis?>&<?=$ket?>"><img src="../../image/asset/pen.png" class="max-w-6 md:w-6 translate-y-3"/> </a>
            </div>
            <div>
                <a href="#<?= $nis?>"><img src="../../image/asset/sampah.png" class="max-w-6 md:w-6 translate-y-3"/> </a>
            </div>
            <!-- end data diri -->
        </div>

        <!-- bilik kanan -->
        <div class="<?= $garis ?> sm:min-w-64">
            <div class=" my-1 bg-green-600 text-white font-semibold rounded-md px-2 py-1 text-sm text-center h-7 hover:bg-green-700 cursor-pointer"><a href="https://wa.me/<?= $nomor_wa?>" target="_top">WHATSAPP</a></div>
            <div class=" my-1 bg-red-700 text-white font-semibold rounded-md px-2 py-1 text-sm text-center ">
            <a href="<?='../../image/photos/'.$s['foto']?>" download="<?= $s['nama']?>.jpg">DOWNLOAD FOTO</a></div>
            <hr class="my-2">
            <!-- jika lolos -->
            <?php if ($lolos) : ?>
                <a href="#" download="#" >
                    <div class=" my-1 bg-red-700 text-white font-semibold rounded-md px-2 py-1 text-sm text-center">TWIBBON LOLOS</div>
                </a>

                <!-- SO lolos JOB -->
                <div class="font-semibold font-[Lato] bg-slate-100 p-1"><span class="text-sm font-normal">DATA LOLOS JOB</span>
                    <!-- <div class="grid grid-cols-2 gap-2 p-2"> -->
                        <?php foreach ($job as $j) : ?>
                            <div class="flex flex-row items-center mt-1">
                                            <div class="max-h-8 w-8 overflow-clip"><img src="<?php echo '../../image/img_so/'.$j['foto_so']?>" alt="<?=$j['foto_so']?>" class="object-center"/></div>
                                            <div>
                                                <p class="pl-3 text-lg"><?= $j['so']?></p>
                                                <p class="pl-3 text-sm text-gray-500"><?= $j['tgl_lolos']?></p>
                                            </div>
                                        </div>
                                        <!-- <hr class="my-1"> -->
                                            <p class="text-gray-500 text-sm ">Jobdesk :</p>
                                            <p class=" font-[Lato] font-semibold text-wrap"><?= $j['job']?></p>
                                            <p class="text-gray-500 text-sm">perusahaan :</p>
                                            <p class=" font-[Lato] font-semibold"><?= $j['perusahaan']?></p>
                        <?php endforeach; ?>
                </div>
                <!-- end SO lolos JOB -->

                <!-- start tagihan lolos -->
                <hr class="my-2">
                <div class="font-[Lato] bg-gray-50 p-1">
                    <div class="flex flex-cols">
                        <p class="text-sm grow">TAGIHAN </p>
                        <a href="../form/tambah_tagihan.php?nis=<?=$nis?>&<?=$ket?>" class="hover:text-red-700 pr-1">+</a>
                    </div>
                    <?php if ($tagihan) : ?>
                        <!-- <div class="grid grid-cols-2 gap-2 p-2"> -->
                            <?php foreach ($tagihan as $t) : ?>
                                <a href="../form/bayar_tagihan.php?id_tagihan=<?=$t['id_tagihan']?>&<?=$ket?>" class="bg-white">
                                        <div class=" hover:bg-gray-100 p-2">
                                            <?=$t['jenis_tagihan']?>
                                            <p class="text-lg font-semibold">Rp <?= number_format($t['sisa_tagihan'],0,".",",")?></p>
                                        </div>
                                        <hr>
                                    </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </div>
                  <!-- end tagihan -->

                <!-- start log pembayaran -->
                <hr class="my-2">
                <div class="font-[Lato] bg-gray-50 p-1">
                    <p class="text-sm grow">Transaksi </p>
                    <?php foreach ($tx as $txs):?>
                                    <a class="block hover:bg-gray-100 p-2" href="../../../app/api/kwitansi.php?tx=<?=$txs['id_tx']?>&<?=$ket?>" target="_blank">
                                        <p class="text-gray-400 font-sm"><?=$txs['id_tx']?></p>
                                        <p class=""><?=$txs['ket_bayar']?></p>
                                        <p class=""><?=$txs['tgl_bayar']?></p>
                                        <p class="text-lg font-semibold">Rp <?= number_format($txs['jumlah'],0,".",",")?></p>
                                    </a>
                                    <hr class="my-1">
                    <?php endforeach; ?>
                </div>
                <!-- end log pembayaran -->  

            <?php else : ?>
                <!-- buat nafuda -->
                <div class=" rounded-lg md:mt-0 max-h-fit w-full p-1 flex flex-row outline outline-2 outline-gray-300 gap-2">
                            <img src="../../../app/api/generate_qr.php?nis=<?= $nis?>" alt="QR Code" class="w-14 h-14 object-center"/>
                            <a class="max-h-fit self-center text-lg font-semibold" href="../../../app/api/generateid_card.php?nis=<?= $nis?>" target="_blank">BUAT NAFUDA</a>
                </div>
                <!-- end nafuda -->
    
                <!-- input job -->
                <div class="rounded mt-2 p-1 outline outline-2 outline-gray-300 gap-2 font-[Lato] px-2">
                    <div class="flex flex-row ">
                        <p class="grow font-semibold text-gray-500 ">Ikut Job</p>
                        <a href="../form/tambah_wawancara.php?nis=<?=$nis?>" class="hover:text-red-700 font-semibold text-red-500 ">+</a>
                    </div>
                    <?php if ($ikut_job) : ?>
                        <?php foreach ($ikut_job as $j) : ?>
                            <div class="flex flex-row items-center mt-1">
                                <div class="max-h-8 w-8 overflow-clip"><img src="<?php echo '../../image/img_so/'.$j['foto_so']?>" alt="<?=$j['foto_so']?>" class="object-center"/></div>
                                <p class="pl-3 text-lg"><?= $j['so']?></p>
                            </div>
                            <hr class="my-1">
                            <p class="text-gray-500 text-sm ">Jobdesk :</p>
                            <p class=" font-[Lato] font-semibold text-wrap"><?= $j['job']?></p>
                        <?php endforeach; ?>
                    <?php else : ?> 
                        <p class="text-gray-500 text-sm">Belum ikut job</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>