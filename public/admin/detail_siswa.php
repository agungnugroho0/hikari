<?php 
include '../../autoloader.php';
admin();
$nis = $_GET['nis'];
if (isset($_GET['lolos'])== true){
    $lolos = true;
    $ket='lolos=ya';
    $job = tampil("SELECT l.tgl_lolos,l.so,l.job,l.perusahaan,so.so,so.foto_so FROM log_lolos l JOIN so ON l.so = so.so WHERE nis = '".$nis."'");
}else {
    $lolos = false;
    $ket='siswa=ya';
    $ikut_job = tampil("SELECT w.*, s.nis,j.* FROM wawancara w JOIN siswa s ON w.nis = s.nis JOIN job j on w.id_job = j.id_job WHERE s.nis = '".$nis."'");
}

$siswa = tampil("SELECT * FROM $ket WHERE nis = '$nis'");
$kk = tampil("SELECT * FROM kk WHERE nis = '$nis'");
$pendidikan = tampil("SELECT * FROM pendidikan WHERE nis = '$nis'");
$sekarang = new DateTime();
$tx = tampil("SELECT * FROM log_pembayaran WHERE nis = '".$nis."'");
$tagihan = tampil("SELECT id_tagihan,status_tagihan,sisa_tagihan,jenis_tagihan FROM tagihan WHERE nis = '".$nis."'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>SISWA</title>
</head>
<body>
<button
  class="bg-white text-center w-48 rounded-xl h-8 relative text-black text-sm font-semibold group mt-2 sm:hidden"
  type="button"
  onclick="window.location.href='index.php';"
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

<div class="flex">
    <?php include 'menu.php' ?>
    <div class="grow bg-gray-100 pt-4 md:pt-0 md:mt-0">
        <div class="hidden md:block"><?php include 'header.php' ?></div>
            <div class="opacity-100 transition-opacity duration-700 mx-4" id="menu-content">
                <div class="md:flex md:gap-4 ">
                    <div class = "bg-white rounded-lg grow p-2 lg:grid md:grid-cols-3 px-3 max-h-fit md:pt-3">
                        <?php foreach ($siswa as $sis) {
                            $umur = umur($sis['tgl']);
                            $nomor_wa = formatnowa($sis['wa']);
                        ?>
                            <div class="md:col-span-3 flex items-center max-h-fit pb-3">
                                <div class="max-h-14 w-10 rounded-xl overflow-clip"><img src="<?php echo '../image/photos/'.$sis['foto']?>" alt="<?=$sis['foto']?>" class="object-center"/></div>
                                <div class="pl-3 grow">
                                    <p class="text-2xl font-semibold"><?=$sis['nama']?></p>
                                    <div class="flex gap-2">
                                        <a href="https://wa.me/<?= $nomor_wa?>" class="bg-green-900 text-white font-semibold rounded-md px-2 py-0.5 text-sm">WHATSAPP</a>
                                        <a href="<?php echo '../image/photos/'.$sis['foto']?>" download="<?= $sis['nama']?>.jpg" class="bg-red-900 text-white font-semibold rounded-md px-2 py-0.5 text-sm">DOWNLOAD FOTO</a>
                                    </div>
                                </div> 
                                <a href="form/edit_siswa.php?nis=<?= $nis?>&<?=$ket?>"><img src="../image/asset/pen.png" class="w-5"/> </a>
                            </div>
                            <hr class="md:col-span-3 py-1">
                            <?php 
                            $data = [
                                'カタカナ' => $sis['panggilan'],'Tempat Lahir' => $sis['tempat_lhr'],'Tanggal Lahir' => $sis['tgl'],'No Rumah' => $sis['no_rumah'],'Umur' => $umur . ' 歳','Kelamin' => $sis['gender'],'Tempat Tinggal' => "DESA {$sis['kelurahan']}, RT. 0{$sis['rt']} / RW. 0{$sis['rw']}, {$sis['kecamatan']}, {$sis['kabupaten']}, {$sis['provinsi']}",'Agama' => $sis['agama'],'Status' => $sis['status'],'Golongan Darah' => $sis['darah'],'Berat Badan' => $sis['bb'].' Kg','Tinggi Badan' => $sis['tb'].' CM
                                ','Rokok' => $sis['merokok'],'Alkohol' => $sis['alkohol'],'Dominan Tangan' => $sis['tangan'],'Hobi' => $sis['hobi'],'Tujuan Ke Jepang' => $sis['tujuan']
                            ];
                            foreach ($data as $label => $value) { ?>
                                <div class="mb-3 mt-1">
                                    <p class="text-gray-400 font-sm"><?=$label?></p>
                                    <p class="text-xl font-semibold"><?=$value?></p>
                                </div>
                            <?php }
                        }?>
                        <!-- kk -->
                        <div class="md:col-span-3">
                            <hr class="py-1">
                            <div class="text-gray-500 text-xl pb-2 font-medium flex gap-1">Keluarga 
                                <!-- <a href="form/tambah_kk.php?nis=<? //=$nis?>" class="text-red-800">+</a> -->
                            </div>
                            <div class="grid md:grid-cols-2 *:bg-slate-50 *:rounded-lg *:p-2 gap-2 hover:*:shadow-md hover:*:shadow-red-400 *:translate-y-2 hover:*:translate-y-0 *:transition">
                                <!-- kolom per keluarga -->
                                 <?php foreach ($kk as $kel) { ?>
                                    <div class="*:p-0.5">
                                        <p class="text-gray-500 font-sm"><?= $kel['hubungan']?></p>
                                        <p class="text-lg"><?= $kel['nama']?></p>
                                        <div class="flex text-gray-500">
                                            <p class="text-base"><?= umur($kel['thn_kelahiran'])?> 歳</p>
                                            <p class="px-2">-</p>
                                            <p class="text-base"><?= $kel['pekerjaan']?></p>
                                        </div>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                        <!-- end kolom per keluarga -->
                        <!-- pendidikan -->
                        <div class="md:col-span-3 mt-7">
                            <hr class="py-1">
                            <div class="text-gray-500 text-xl pb-2 font-medium flex gap-1">Pendidikan 
                                <!-- <a href="form/tambah_pendidikan.php?nis=<? //=$nis?>" class="text-red-800">+</a> -->
                            </div>
                            <div class="grid md:grid-cols-2 *:bg-slate-50 *:rounded-lg *:p-2 gap-2 hover:*:shadow-md hover:*:shadow-red-400 *:translate-y-2 hover:*:translate-y-0 *:transition">
                                <!-- kolom per pendidikan -->
                                 <?php foreach ($pendidikan as $pdd) { ?>
                                    <div class="*:p-0.5">
                                        <p class="text-lg font-semibold"><?= $pdd['sekolah']?></p>
                                        <div class="flex text-gray-500">
                                            <p class="text-base"><?= $pdd['masuk']?></p>
                                            <p class="px-2"> sampai </p>
                                            <p class="text-base"><?= $pdd['lulus']?></p>
                                        </div>
                                        <p class="text-gray-500 font-sm"><?= $pdd['jurusan']?></p>
                                    </div>
                                <?php }; ?>
                            </div>
                        </div>
                        <!-- end kolom per pendidikan -->
                    </div>
                    <div>
                        <div class="bg-white rounded-lg mt-3 md:mt-0 max-h-fit w-full md:w-60 p-2 flex flex-row">
                            <img src="../../app/api/generate_qr.php?nis=<?= $nis?>" alt="QR Code" class="w-14 h-14 object-center"/>
                            <a class="max-h-fit self-center text-lg font-semibold" href="../../app/api/generateid_card.php?nis=<?= $nis?>" target="_blank">BUAT NAFUDA</a>
                        </div>
                        <!-- tagihan -->
                            <div class="bg-white rounded-lg mt-3 max-h-fit w-full md:w-60 p-2">
                                <div class="flex gap-2"><p class="text-gray-500">Tagihan</p><a href="form/tambah_tagihan.php?nis=<?=$nis?>&<?=$ket?>" class="hover:text-red-700">+</a></div>
                                <hr class="mt-1">
                                <?php 
                                if ($tagihan != null) :
                                foreach ($tagihan as $tg):?>
                                    <a href="form/bayar_tagihan.php?id_tagihan=<?=$tg['id_tagihan']?>&<?=$ket?>" class="">
                                        <div class=" hover:bg-gray-100 p-2">
                                        <?=$tg['jenis_tagihan']?>
                                        <p class="text-lg font-semibold">Rp <?= number_format($tg['sisa_tagihan'],0,".",",")?></p>
                                    </div>
                                    <hr>
                                </a>
                                <?php endforeach; else:?>
                                <div class="text-gray-600 font-semibold">Belum ada Tagihan</div>
                                <?php endif;?>
                            </div>
                            <div class="bg-white rounded-lg mt-3 max-h-fit w-full md:w-60 p-2">
                                    <p class="text-gray-500">Transaksi</p>
                                    <hr class="mt-1">
                                <?php foreach ($tx as $txs){?>
                                    <a class="block hover:bg-gray-100 p-2" href="../../app/api/kwitansi.php?tx=<?=$txs['id_tx']?>&<?=$ket?>" target="_blank">
                                        <p class="text-gray-400 font-sm"><?=$txs['id_tx']?></p>
                                        <p class=""><?=$txs['ket_bayar']?></p>
                                        <p class=""><?=$txs['tgl_bayar']?></p>
                                        <p class="text-lg font-semibold">Rp <?= number_format($txs['jumlah'],0,".",",")?></p>
                                    </a>
                                    <hr class="my-1">
                                <?php } ?>
                            </div>

                        <?php if ($lolos==true){?>
                            <!-- detail job -->
                            <div class="bg-white rounded-lg mt-3 max-h-fit w-full md:w-60 p-2">
                                <p class="text-gray-500">LOLOS JOB</p>
                                <hr class="mt-1">
                                <?php foreach ($job as $j){ ?>
                                    <div class="flex flex-row items-center mt-1">
                                        <div class="max-h-8 w-8 rounded-xl overflow-clip"><img src="<?php echo '../image/img_so/'.$j['foto_so']?>" alt="<?=$j['foto_so']?>" class="object-center"/></div>
                                        <div>
                                            <p class="pl-3 text-lg"><?= $j['so']?></p>
                                            <p class="pl-3 text-sm text-gray-500"><?= $j['tgl_lolos']?></p>
                                        </div>
                                    </div>
                                    <hr class="my-1">
                                        <p class="text-gray-500 font-sm">Jobdesk :</p>
                                        <p><?= $j['job']?></p>
                                        <p class="text-gray-500 font-sm">perusahaan :</p>
                                        <p><?= $j['perusahaan']?></p>
                                <?php }?>
                            </div>
                            
                        <?php }else { ?>
                            <div class="bg-white rounded-lg mt-3 max-h-fit w-full md:w-60 p-2">
                            <div class="flex gap-2"><p class="text-gray-500">Job </p><a href="form/tambah_wawancara.php?nis=<?=$nis?>" class="hover:text-red-700">+</a></div>
                            <hr class="mt-1">
                            <?php if ($ikut_job != null) :
                            foreach ($ikut_job as $ik) : ?>
                            <div class="flex flex-row items-center mt-1">
                                <p><?= $ik['job']?></p>    
                            </div>
                            <?php endforeach; endif;?>
                        <?php };?>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>

<script src="../javascript/menu.js"></script>
<script src="../javascript/pencarian_siswa.js"></script>