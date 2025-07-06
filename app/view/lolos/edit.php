<?php
require_once __DIR__."/../../../autoloader.php";
$nis =$_GET['nis'];
use app\controller\siswacontroller;
use app\controller\loloscontroller;
$object = new loloscontroller();
$object2 = new siswacontroller();
$siswa = $object->detaillolos($nis,'data');
$kelas = $object2->daftarkelas();
foreach($siswa as $s){
    $nis = $s['nis'];
    $nama = $s['nama'];
    $panggilan = $s['panggilan'];
    $id_kelas = $s['id_kelas'];
    $tgl = $s['tgl'];
    $gender = $s['gender'];
    $tempat_lhr = $s['tempat_lhr'];
    $provinsi = $s['provinsi'];
    $kab = $s['kabupaten'];
    $kec = $s['kecamatan'];
    $kel = $s['kelurahan'];
    $rt = $s['rt'];
    $rw = $s['rw'];
    $wa = $s['wa'];
    $agama = $s['agama'];
    $status = $s['status'];
    $darah = $s['darah'];
    $bb = $s['bb'];
    $tb = $s['tb'];
    $merokok = $s['merokok'];
    $alkohol = $s['alkohol'];
    $tangan = $s['tangan'];
    $hobi = $s['hobi'];
    $tujuan = $s['tujuan'];
    $kelebihan = $s['kelebihan'];
    $kekurangan = $s['kekurangan'];
    $foto = $s['foto'];
    $no_rumah = $s['no_rumah'];
}
// var_dump($kelas);

?>

<body>
    <form id="form-update-lolos" method="POST" enctype="multipart/form-data">
        <div class="grid mb-6 md:grid-cols-3 gap-3">
            <div>
                <label for="nis" class="text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                <input type="text" name="nis" value="<?= $nis?>" id="nis" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-400 mt-1 font-[Lato]" readonly>
            </div>
            <div class="col-span-2">
                <label for="nama_lengkap" class="text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="nama_lengkap" name="nama_lengkap" value="<?= $nama ?>" required>
            </div>
            <div>
                <label for="panggilan" class="text-sm font-medium text-gray-900 dark:text-white">カタカナ</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="panggilan" name="panggilan" value="<?= $panggilan ?>" required>
            </div>
            <div class="w-full mx-auto">
                <label for="kelas" class="text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelas" name="id_kelas" required>
                    <?php foreach($kelas as $k):?>
                        <option value="<?= $k['id_kelas']?>" <?= $id_kelas === $k['id_kelas'] ? 'selected' : '' ?>><?= $k['kelas']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            <div>
                <label for="tempat_lahir" class="text-sm font-medium text-gray-900 dark:text-white">Tempat Lahir</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tempat_lahir" name="tempat_lahir" value="<?= $tempat_lhr ?>" required>
            </div>
            <div>
                <label for="gender" class="text-sm font-medium text-gray-900 dark:text-white">Kelamin</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelas" name="gender" required>
                <option value="L" <?= $gender === 'L' ? 'selected' : ''?>>Pria</option>
                <option value="P" <?= $gender === 'P' ? 'selected' : ''?>>Perempuan</option>
                </select>
            </div>
            <div>
                <label for="tgl" class="text-sm font-medium text-gray-900 dark:text-white">Tempat Lahir</label>
                <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tgl" name="tgl" value="<?= $tgl ?>" required>
            </div>
            <div>
                <label for="provinsi" class="text-sm font-medium text-gray-900 dark:text-white">Provinsi</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="provinsi" name="provinsi" value="<?= $provinsi ?>" required>
            </div>
            <div>
                <label for="kab" class="text-sm font-medium text-gray-900 dark:text-white">Kabupaten</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kab" name="kab" value="<?= $kab ?>" required>
            </div>
            <div>
                <label for="kec" class="text-sm font-medium text-gray-900 dark:text-white">Kecamatan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kec" name="kec" value="<?= $kec ?>" required>
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label for="rt" class="text-sm font-medium text-gray-900 dark:text-white">RT</label>
                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="rt" name="rt" value="<?= $rt ?>" required>
                </div>
                <div>
                    <label for="rw" class="text-sm font-medium text-gray-900 dark:text-white">RW</label>
                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="rw" name="rw" value="<?= $rw ?>" required>
                </div>
            </div>  
            <div>
                <label for="wa" class="text-sm font-medium text-gray-900 dark:text-white">wa</label>
                <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="wa" name="wa" value="<?= $wa ?>" required>
            </div>
            <div>
                <label for="agama" class="text-sm font-medium text-gray-900 dark:text-white">Agama</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelas" name="agama" required>
                <option value="Islam" <?= $agama === 'Islam' ? 'selected' : ''?>>Islam</option>
                <option value="Kristen" <?= $agama === 'Kristen' ? 'selected' : ''?>>Kristen</option>
                <option value="Katholik" <?= $agama === 'Katholik' ? 'selected' : ''?>>Katholik</option>
                <option value="Budha" <?= $agama === 'Budha' ? 'selected' : ''?>>Budha</option>
                <option value="Hindu" <?= $agama === 'Hindu' ? 'selected' : ''?>>Hindu</option>
                <option value="Konghucu" <?= $agama === 'Konghucu' ? 'selected' : ''?>>Konghucu</option>
                </select>
            </div>
            <div>
                <label for="status" class="text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="status" name="status" required>
                <option value="Belum Menikah" <?= $status === 'Belum Menikah' ? 'selected' : ''?>>Belum Menikah</option>
                <option value="Menikah" <?= $status === 'Menikah' ? 'selected' : ''?>>Menikah</option>
                <option value="Cerai" <?= $status === 'Cerai' ? 'selected' : ''?>>Cerai</option>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-4 gap-3">
            <div>
                <label for="darah" class="text-sm font-medium text-gray-900 dark:text-white">Golongan Darah</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="darah" name="darah" required>
                <option value="A" <?= $darah === 'A' ? 'selected' : ''?>>A</option>
                <option value="B" <?= $darah === 'B' ? 'selected' : ''?>>B</option>
                <option value="AB" <?= $darah === 'AB' ? 'selected' : ''?>>AB</option>
                <option value="O" <?= $darah === 'O' ? 'selected' : ''?>>O</option>
                <option value="Belum Tahu" <?= $darah === 'Belum Tahu' ? 'selected' : ''?>>Belum Tahu</option>
                </select>
            </div>
            <div>
                <label for="bb" class="text-sm font-medium text-gray-900 dark:text-white">Berat Badan</label>
                <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="bb" name="bb" value="<?= $bb ?>" required>
            </div>
            <div>
                <label for="tb" class="text-sm font-medium text-gray-900 dark:text-white">Tinggi Badan</label>
                <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tb" name="tb" value="<?= $tb ?>" required>
            </div>
            <div>
                <label for="merokok" class="text-sm font-medium text-gray-900 dark:text-white">Merokok</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="merokok" name="merokok" required>
                <option value="YA" <?= $merokok === 'YA' ? 'selected' : ''?>>YA</option>
                <option value="TIDAK" <?= $merokok === 'TIDAK' ? 'selected' : ''?>>TIDAK</option>
                </select>

            </div>
            <div>
                <label for="alkohol" class="text-sm font-medium text-gray-900 dark:text-white">Alkohol</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="alkohol" name="alkohol" required>
                <option value="YA" <?= $alkohol === 'YA' ? 'selected' : ''?>>YA</option>
                <option value="TIDAK" <?= $alkohol === 'TIDAK' ? 'selected' : ''?>>TIDAK</option>
                </select>

            </div>
            <div>
                <label for="tangan" class="text-sm font-medium text-gray-900 dark:text-white">Tangan Dominan</label>
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tangan" name="tangan" required>
                <option value="KANAN" <?= $tangan === 'KANAN' ? 'selected' : ''?>>KANAN</option>
                <option value="KIRI" <?= $tangan === 'KIRI' ? 'selected' : ''?>>KIRI</option>
                </select>

            </div>
            <div>
                <label for="hobi" class="text-sm font-medium text-gray-900 dark:text-white">Hobi</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="hobi" name="hobi" value="<?= $hobi ?>" >
            </div>
            <div>
                <label for="tujuan" class="text-sm font-medium text-gray-900 dark:text-white">Tujuan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="tujuan" name="tujuan" value="<?= $tujuan ?>" >
            </div>
            <div>
                <label for="kelebihan" class="text-sm font-medium text-gray-900 dark:text-white">Kelebihan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kelebihan" name="kelebihan" value="<?= $kelebihan ?>" >
            </div>
            <div>
                <label for="kekurangan" class="text-sm font-medium text-gray-900 dark:text-white">Kekurangan</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="kekurangan" name="kekurangan" value="<?= $kekurangan ?>" >
            </div>
            <div>
                <label for="no_rumah" class="text-sm font-medium text-gray-900 dark:text-white">No Wali</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 mt-1 font-[Lato]" id="no_rumah" name="no_rumah" value="<?= $no_rumah ?>" >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">Ganti foto</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2 mt-1.5" id="file_input" type="file" name="foto" >
            </div>
        </div>
        <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=siswa&act=detail&nis=<?= $nis?>','4')">Cancel</a>
                </div>
        </div>

    </form>
    
</body>
<script>
  if (typeof initsiswa === "function") {
      initlolos();
  }
</script>