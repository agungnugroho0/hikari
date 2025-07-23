<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\siswacontroller;
$nis = $_GET['nis'];
$objek = new siswacontroller();
$siswa = $objek->detailsiswa($nis,'data');
$job = $objek->detailsiswa($nis,'job');
$kk = $objek->detailsiswa($nis,'keluarga');
$pendidikan = $objek->detailsiswa($nis,'pendidikan');
$dokumen = $objek->lihatdokumen($nis);


// var_dump($siswa);
?>
<body>
    

<div class="md:flex md:flex-row gap-2 dark:bg-black rounded p-2 justify-around ">
        <!-- konten utama -->
        <div class=" gap-2 text-wrap mr-2 ">
            <?php foreach ($siswa as $s) :
                $umur = umur($s['tgl']);
                $nomor_wa = formatnowa($s['wa']);

                ?>
            <div class="sm:grow flex flex-col gap-1 ">
                <header class="flex flex-row gap-2">
                    <div class="min-h-5 max-h-14 max-w-14 rounded overflow-clip sm:block hidden">
                        <img src="<?= '/public/image/photos/'.$s['foto']?>" alt="<?=$s['foto']?>" class="object-top  "/>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex">
                            <p class="text-gray-500 dark:text-gray-300 text-xs font-normal mr-2"><?= $s['nis']?></p>
                            <a href="#" class="text-gray-900 dark:text-white text-xs font-normal " onclick="loadPageFromMenu('router.php?page=siswa&act=edit&nis=<?=$s['nis']?>','4')">EDIT</a>
                            <p class="text-gray-500 dark:text-gray-300 text-xs font-normal">&nbsp;&nbsp; | &nbsp;&nbsp;</p>
                            <a href="#" class="text-red-500 dark:text-red-600 text-xs font-normal btn-hapus" data-url="router.php?page=siswa&act=hapus&nis=<?= $s['nis'] ?>">DELETE</a>
                            <!-- <a href="#" class="px-2 btn-gagal" data-url="router.php?page=wawancara&act=gagal&id_w=<? //= $peserta['id_w']?>"> -->

                        </div>
                        <p class="text-black text-xl font-semibold dark:text-white "><?= $s['nama']?></p>
                    </div>
                </header>
                <!-- <div>
                </div> -->
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
                <p class="text-gray-500 text-xs font-normal dark:text-slate-300 text-wrap"><?= $labelt ?></p>
                <p class="text-black text-lg font-semibold dark:text-white text-wrap"><?=$valuet?></p>
                <div class="grid md:grid-cols-3 gap-2">
                    <?php foreach ($datasiswa as $label => $value) : ?>
                    <div>
                        <p class="text-gray-500 text-xs font-normal dark:text-gray-300"><?= $label ?></p>
                        <p class="text-black text-lg font-semibold dark:text-white"><?=$value?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <table class="w-full border border-gray-300 dark:border-gray-900 text-sm text-left text-gray-700 cursor-default mt-2 ">
                    <thead class="bg-gray-100 text-gray-800 font-[Lato] dark:bg-slate-900 dark:text-white">
                        <tr >
                            <th class="border px-4 py-2 w-[5%]">No</th>
                            <th class="border px-4 py-2 w-[15%]">Hubungan</th>
                            <th class="border px-4 py-2 w-[40%]">Nama</th>
                            <th class="border px-4 py-2 w-[10%]">Umur</th>
                            <th class="border px-4 py-2">Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody class="text-white ">
                        <?php $i = 1; foreach ($kk as $k): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-900 dark:odd:bg-gray-800 dark:even:bg-gray-700">
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
                    <thead class="bg-gray-100 text-gray-800 font-[Lato] dark:bg-slate-900 dark:text-white">
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
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-900 dark:odd:bg-gray-800 dark:even:bg-gray-700">
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
            <!-- end data diri -->
        </div>
        

        <!-- bilik kanan -->
        <div class=" sm:min-w-64">
            <div class=" my-1 bg-green-600 dark:bg-green-400 text-white font-semibold rounded-md px-2 py-1 text-sm text-center h-7 hover:bg-green-700 cursor-pointer transition duration-400 ease-out"><a href="https://wa.me/<?= $nomor_wa?>" >WHATSAPP</a></div>
            <div class=" my-1 bg-slate-700 text-white font-semibold rounded-md px-2 py-1 text-sm text-center hover:bg-slate-800 cursor-pointer transition duration-400 ease-out">
            <a href="<?='/public/image/photos/'.$s['foto']?>" download="<?= $s['nama']?>.jpg">DOWNLOAD FOTO</a>
            </div>
            <hr class="my-2">
                <!-- buat nafuda -->
                <div class="bg-white rounded-lg md:mt-0 max-h-fit w-full p-1 flex flex-row outline outline-2 outline-gray-300 gap-2">
                        <img src="/public/image/qr_images/<?= $nis ?>.png" alt="QR Code" class="w-14 h-14 object-center"/>
                       <a href="router.php?page=siswa&act=nafuda&nis=<?= $s['nis'] ?>" 
                        target="_blank"
                        class="max-h-fit self-center text-lg font-semibold hover:scale-125 hover:translate-x-3 transition ease-out duration-300">
                        BUAT NAFUDA
                        </a>
                </div>
                <!-- end nafuda -->
    
                <!-- input job -->
                <div class="rounded mt-5 p-1 outline outline-2 outline-gray-300 dark:outline-white gap-2 font-[Lato] px-2">
                    <div class="flex flex-row ">
                        <p class="grow font-semibold text-gray-500 dark:text-gray-300">Ikut Job</p>
                        <a href="#" onclick="loadPageFromMenu('router.php?page=siswa&act=add_job&nis=<?=$s['nis']?>','4')" class="hover:text-red-700 font-semibold text-red-500 ">+</a>
                    </div>
                    <?php if ($job) : ?>
                        <?php foreach ($job as $j) : ?>
                            <div class="flex flex-row items-center mt-1">
                                <div class="max-h-8 w-8 overflow-clip"><img src="<?php echo '/public/image/img_so/'.$j['foto_so']?>" alt="<?=$j['foto_so']?>" class="object-center"/></div>
                                <p class="pl-3 text-lg dark:text-white"><?= $j['so']?></p>
                            </div>
                            <hr class="my-1">
                            <p class="text-gray-500 text-sm dark:text-gray-300">Jobdesk :</p>
                            <p class=" font-[Lato] font-semibold text-wrap dark:text-white"><?= $j['job']?></p>
                        <?php endforeach; ?>
                    <?php else : ?> 
                        <p class="text-gray-500 text-sm dark:text-gray-400">Belum ikut job</p>
                    <?php endif; ?>
                </div>
                <div class="rounded mt-5 p-1 outline outline-2 outline-gray-300 dark:outline-white gap-2 font-[Lato] px-2">
                    <div class="flex flex-row items-center"> 
                        <p class="grow font-semibold text-gray-500 dark:text-gray-300">Dokumen</p>
                        <a href="#" onclick="loadPageFromMenu('router.php?page=siswa&act=uploaddoc&nis=<?=$s['nis']?>','4')" class="hover:text-red-700 font-semibold text-red-500 ">+</a>
                    </div>
                    <?php 
                    if ($dokumen):?>
                        <?php foreach ($dokumen as $d): 
                            $icon = $objek->getFileIcon($d['dokumen']);    
                        ?>
                            <hr class="my-1">
                            <div class="flex gap-2">
                                <?= $icon ?>
                                <div>
                                    <p class="dark:text-white dark:font-semibold dark:text-sm"><?= $d['tipe']?></p>
                                    <p class="dark:text-slate-400 dark:font-medium dark:text-sm"><?= $d['keterangan']?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm dark:text-gray-400">Belum ada dokumen yang diupload</p>
                    <?php endif; ?>
                    
                    <hr>
                </div>
        </div>
    </div>
</body>

<div id="toast-konfirmasi-hapus" class="fixed top-5 bg-white border p-4 rounded shadow hidden z-50 w-80">
  <p class="text-sm text-gray-800 mb-3">Yakin ingin menghapus siswa ini?</p>
  <div class="flex justify-end gap-2">
    <button id="btn-batal-hapus" class="px-3 py-1 text-gray-600 hover:text-black">Batal</button>
    <button id="btn-ya-hapus" class="px-3 py-1 bg-red-600 text-white rounded">Ya, hapus!</button>
  </div>
</div>
<script>
  if (typeof initsiswa === "function") {
      initsiswa();
  }
</script>