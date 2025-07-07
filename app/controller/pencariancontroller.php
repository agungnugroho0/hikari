<?php
namespace app\controller;
use app\model\pencarian;

class pencariancontroller{
    public function pencariansiswacontroller() {
        $cari = $_GET['cari'];
        $model = new pencarian;
        $data = $model->pencarian_siswa($cari);
        header ('Content-Type: application/json');
        echo json_encode($data);
    }
}