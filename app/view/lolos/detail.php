<?php
require_once __DIR__."/../../../autoloader.php";
use app\controller\loloscontroller;
$nis = $_GET['nis'];
$objek = new loloscontroller();
$siswa = $objek->detaillolos($nis,'data');
$job = $objek->detaillolos($nis,'lolosjob');
$tagihan = $objek->detaillolos($nis,'tagihan');
$transaksi = $objek->detaillolos($nis,'transaksi');

// var_dump($siswa);
?>
<body>
    

<div class="flex sm:flex-row gap-2 dark:bg-black rounded p-2 justify-around ">
        <!-- konten utama -->
        <div class=" gap-2 text-wrap mr-2 ">
            <?php foreach ($siswa as $s) :
                $umur = umur($s['tgl']);
                $nomor_wa = formatnowa($s['wa']);

                ?>
            <div class="sm:grow flex flex-col gap-1 ">
                <header class="flex flex-row gap-2">
                    <div class="min-h-5 max-h-14 max-w-14 rounded overflow-clip sm:block hidden">
                        <img src="<?= '/public/image/nas_photos/'.$s['foto']?>" alt="<?=$s['foto']?>" class="object-top  "/>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex">
                            <p class="text-gray-500 dark:text-gray-300 text-xs font-normal mr-2"><?= $s['nis']?></p>
                            <a href="#" class="text-gray-900 dark:text-white text-xs font-normal " onclick="loadPageFromMenu('router.php?page=lolos&act=edit&nis=<?=$s['nis']?>','5')">EDIT</a>
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
                        'No Whatsapp' => $s['wa'],
                        'No Rumah' => $s['no_rumah'],
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
                
            </div>
            <?php endforeach; ?>
            <div class="rounded mt-5 p-1 outline outline-2 outline-gray-300 dark:outline-white gap-2 font-[Lato] px-2">
                    <p class="font-semibold text-gray-800 dark:text-gray-300">Daftar Transaksi Siswa</p>
                    <table class="w-full border border-gray-300 text-sm text-left text-gray-700 cursor-default mt-2">
                    <thead class="bg-gray-100 text-gray-800 font-[Lato] dark:bg-slate-900 dark:text-white">
                        <tr>
                            <th class="border px-4 py-2 w-[5%]">No Tx</th>
                            <th class="border px-4 py-2 w-[40%]">Keterangan Pembayaran</th>
                            <th class="border px-4 py-2 w-[5%]">Tanggal Pembayaran</th>
                            <th class="border px-4 py-2 2-[10%]">Jumlah</th>
                            <th class="border px-4 py-2 ">Kuitansi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $txs) : ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-900 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                            <td class="border px-4 py-2 text-gray-600 font-sm"><?= $txs['id_tx']?></td>
                            <td class="border px-4 py-2 dark:text-white"><?=$txs['ket_bayar']?></td>
                            <td class="border px-4 py-2 dark:text-white"><?=$txs['tgl_bayar']?></td>
                            <td class="border px-4 py-2 dark:text-white">Rp <?= number_format($txs['jumlah'],0,".",",")?></td>
                            <td class="border px-4 py-2 dark:text-red-400 text-red-800"><a href="#" onclick="window.open('router.php?page=lolos&act=kuitansi&id_tx=<?=$txs['id_tx']?>','5')" target="_blank" >CETAK</a></td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                    </table>
                        
                </div>
            <!-- end data diri -->
        </div>
        

        <!-- bilik kanan -->
        <div class=" sm:min-w-64">
            <div class=" my-1 bg-green-600 dark:bg-green-400 text-white font-semibold rounded-md px-2 py-1 text-sm text-center h-7 hover:bg-green-700 cursor-pointer transition duration-400 ease-out"><a href="https://wa.me/<?= $nomor_wa?>" >WHATSAPP</a></div>
            <div class=" my-1 bg-red-700 text-white font-semibold rounded-md px-2 py-1 text-sm text-center hover:bg-green-700 cursor-pointer transition duration-400 ease-out">
            <a href="<?='/public/image/nas_photos/'.$s['foto']?>" download="<?= $s['nama']?>.jpg">DOWNLOAD FOTO</a>
            </div>
            <hr class="my-2">
                <!-- data lolos -->
                <div class="rounded mt-5 p-1 outline outline-2 outline-gray-300 dark:outline-white gap-2 font-[Lato] px-2">
                    <p class="font-semibold text-gray-800 dark:text-gray-300">Data Lolos Interview</p>
                        <?php foreach ($job as $j) : ?>
                            <div class="flex flex-row items-center mt-1">
                                <div class="max-h-8 w-8 overflow-clip"><img src="<?php echo '/public/image/img_so/'.$j['foto_so']?>" alt="<?=$j['foto_so']?>" class="object-center"/></div>
                                <p class="pl-3 text-lg dark:text-white"><?= $j['so']?></p>
                            </div>
                            <hr class="my-1">
                            <p class="text-gray-500 text-sm dark:text-gray-300">Tanggal Lolos :</p>
                            <p class=" font-[Lato] font-semibold text-wrap dark:text-white"><?= $j['tgl_lolos']?></p>
                            <p class="text-gray-500 text-sm dark:text-gray-300">Jobdesk :</p>
                            <p class=" font-[Lato] font-semibold text-wrap dark:text-white"><?= $j['job']?></p>
                            <p class="text-gray-500 text-sm dark:text-gray-300">Perusahaan :</p>
                            <p class=" font-[Lato] font-semibold text-wrap dark:text-white"><?= $j['perusahaan']?></p>
                        <?php endforeach; ?>
                </div>
                
                <div class="rounded mt-5 p-1 outline outline-2 outline-gray-300 dark:outline-white gap-2 font-[Lato] px-2">
                    <div class="flex flex-row mb-2">
                        <p class="grow font-semibold text-gray-800 dark:text-gray-300">Daftar Tagihan Siswa</p>
                        <a href="#" onclick="loadPageFromMenu('router.php?page=lolos&act=addtagihan&nis=<?=$s['nis']?>','5')" class="hover:text-red-700 font-semibold text-red-500 ">+</a>
                    </div>
                        <?php foreach ($tagihan as $t) : ?>
                            <a href="#" onclick="loadPageFromMenu('router.php?page=lolos&act=bayartagihan&tagihan=<?=$t['id_tagihan']?>','5')" >
                                <div class=" hover:bg-gray-100 p-2 dark:text-white dark:hover:bg-slate-700">
                                            <?=$t['jenis_tagihan']?>
                                            <?php 
                                            if ($t['sisa_tagihan'] <= '0'){?>
                                                <p class="text-lg font-bold">LUNAS</p>
                                            <?php }else{ ?>
                                                <p class="text-lg font-semibold">Rp <?= number_format($t['sisa_tagihan'],0,".",",")?></p>
                                            <?php
                                            }
                                            ?>
                                </div>
                            </a>
                            <hr>
                        <?php endforeach; ?>
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
                            <div class="flex gap-2 group">
                                <?= $icon ?>
                                <div class="grow  dark:group-hover:text-white">
                                    <p class="dark:text-slate-400 dark:text-sm"><?= $d['tipe']?></p>
                                    <p class="dark:text-slate-400 dark:font-medium dark:text-sm"><?= $d['keterangan']?></p>
                                </div>
                                <a href="router.php?page=siswa&act=downloadfile&tipe=<?= urlencode($d['tipe']) ?>&file=<?= urlencode($d['dokumen']) ?>" class="text-blue-500 dark:text-blue-400 hover:underline" target="_blank"><i class="fa fa-download"></i></a>
                                <a href="#"  onclick="loadPageFromMenu('router.php?page=siswa&act=hapusdoc&tipe=<?=$d['tipe']?>&file=<?=$d['dokumen']?>&id_doc=<?=$d['id_doc']?>&nis=<?=$nis?>','4')"  class="text-blue-500 dark:text-blue-400 hover:underline"><i class="fas fa-trash-alt"></i></a>
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

<script>
  if (typeof initsiswa === "function") {
      initsiswa();
  }
</script>