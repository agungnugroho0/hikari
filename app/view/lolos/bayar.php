<?php
require_once __DIR__."/../../../autoloader.php";
$tagihan =$_GET['tagihan'];
use app\controller\loloscontroller;
$object = new loloscontroller();
$detailtagihan = $object->tampiltagihan($tagihan);
foreach($detailtagihan as $d){
    $jenis_tagihan = $d['jenis_tagihan'];
    $biaya_tagihan = $d['biaya_tagihan'];
    $sisa_tagihan = $d['sisa_tagihan'];
    $nis = $d['nis'];
    $status_tagihan = $d['status_tagihan'];
}
// var_dump($kelas);

?>

<body>
    <form id="form-bayar" method="POST" >
        <div class="grid mb-6 md:grid-cols-3 gap-3">
            <input type="hidden" value="<?= $nis ?>" name="nis" id="nis"> 
            <input type="hidden" value="<?= $status_tagihan ?>" name="status_tagihan"> 
            <div>
                <label for="id_tagihan" class="text-sm font-medium text-gray-900 dark:text-white"> ID Tagihan</label>
                <input type="text" name="id_tagihan" value="<?= $tagihan?>" id="id_tagihan" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-400 mt-1 font-[Lato]" readonly>
            </div>
            <div>
                <label for="jenis_tagihan" class="text-sm font-medium text-gray-900 dark:text-white">Nama Tagihan</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="jenis_tagihan" name="jenis_tagihan" value="<?= $jenis_tagihan ?>" readonly>
            </div>
            <div>
                <label for="biaya_tagihan" class="text-sm font-medium text-gray-900 dark:text-white">Nilai Tunggakan</label>
                <input type="text" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="biaya_tagihan" name="biaya_tagihan" value="<?= $biaya_tagihan ?>" readonly>
            </div>
            <div>
                <label for="sisa_tagihan" class="text-sm font-medium text-gray-900 dark:text-white">Sisa Angsuran</label>
                <input type="sisa_tagihan" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 mt-1 font-[Lato]" id="sisa_tagihan" name="sisa_tagihan" value="<?= $sisa_tagihan ?>" readonly>
            </div>
            <div>
                <label for="pembayaran" class="text-sm font-medium text-gray-900 dark:text-white">Jumlah Pembayaran</label>
                <input type="text" name="pembayaran" id="pembayaran" class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg  w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:text-white mt-1 font-[Lato]">
            </div>
            
        <div class="flex gap-2 mt-2">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white" for="file_input">&nbsp;</label>
                    <button class=" bg-green-700 dark:bg-blue-600 dark:hover:bg-blue-950 hover:bg-green-950 text-white font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition">TRANSAKSI</button>
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