<?php 
namespace app\controller;
use app\model\kelompok;

class kelompokcontroller {
    private $kelompokModel;

    public function __construct() {
        $this->kelompokModel = new kelompok();
    }

    public function getAllKelompok() {
        return $this->kelompokModel->semuakelompok();
    }

    public function getKelompokById($id) {
        return $this->kelompokModel->kelompokid($id);
    }

    public function createKelompok($id_kelompok, $nama_kelompok) {
        return $this->kelompokModel->tambahkelompok($id_kelompok, $nama_kelompok);
    }

    public function updateKelompok($id, $nama_kelompok) {
        return $this->kelompokModel->updatekelompok($id, $nama_kelompok);
    }

    public function deleteKelompok($id) {
        return $this->kelompokModel->hapuskelompok($id);
    }
}