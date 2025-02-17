<?php

function hapus_foto_so($id_so){
    $foto_so = tampil("SELECT foto_so FROM so WHERE id_so='$id_so'");
    foreach ($foto_so as $value){
        $foto = $value['foto_so'];
    }
    $targetDir = __DIR__ . "/../../public/image/img_so/";
    $targetFile = $targetDir . $foto;
    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
}