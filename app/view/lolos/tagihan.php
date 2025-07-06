<?php
require_once __DIR__."/../../../autoloader.php";
$nis =$_GET['nis'];
use app\controller\loloscontroller;
$object = new loloscontroller();
$siswa = $object->detaillolos($nis,'data');
foreach($siswa as $s){
    $nis = $s['nis'];
    $nama = $s['nama'];
}
$detailjob = $object->detaillolos($nis,'lolosjob');
foreach($detailjob as $d){
    $so = $d['so'];
    $job = $d['job'];
    $perusahaan = $d['perusahaan'];
}
// var_dump($kelas);

?>

<body>
    <form id="form-tagihan" method="POST" >
        <div class="grid mb-6 md:grid-cols-3 gap-3">
            <div>
                <label for="nis" class="text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                <input type="text" name="nis" value="<?= $nis?>" id="nis" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-400 mt-1 font-[Lato]" readonly>
            </div>
            <div class="col-span-2">
                <label for="nama_lengkap" class="text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="nama_lengkap" name="nama_lengkap" value="<?= $nama ?>" disabled>
            </div>
            <div>
                <label for="so" class="text-sm font-medium text-gray-900 dark:text-white">Nama SO</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="so" name="so" value="<?= $so ?>" disabled>
            </div>
            <div>
                <label for="job" class="text-sm font-medium text-gray-900 dark:text-white">Nama Job</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="job" name="job" value="<?= $job ?>" disabled>
            </div>
            <div>
                <label for="Perusahaan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Perusahaan</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="Perusahaan" name="Perusahaan" value="<?= $perusahaan ?>" disabled>
            </div>
            <div>
                <label for="jenis_tagihan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Tagihan</label>
                <input type="text" name="jenis_tagihan" id="jenis_tagihan" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-white mt-1 font-[Lato]">
            </div>
            <div>
                <label for="tagihan" class="text-sm font-medium text-gray-900 dark:text-white">Jumlah Tagihan</label>
                <input type="text" name="tagihan" id="tagihan" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-white mt-1 font-[Lato]">
            </div>
            
        <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">Submit</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <a href="#" class=" bg-red-600 block font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center text-white hover:bg-red-900 transition" onclick="loadPageFromMenu('router.php?page=lolos&act=detail&nis=<?= $nis?>','5')">Cancel</a>
                </div>
        </div>

    </form>
    
</body>
<script>
  if (typeof initlolos === "function") {
      initlolos();
  }
</script>