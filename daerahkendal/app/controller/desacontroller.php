<?php
namespace app\controller;
use app\model\desa;

class desacontroller {
    private $desaModel;

    public function __construct() {
        $this->desaModel = new desa();
    }

    public function getAllDesa() {
        return $this->desaModel->semuadesa();
    }

    public function getDesaById($id) {
        return $this->desaModel->desaid($id);
    }
    public function createDesa($id_desa, $nama_desa) {
        return $this->desaModel->tambahdesa($id_desa, $nama_desa);
    }
    public function updateDesa($id, $nama_desa) {
        return $this->desaModel->tambahdesa($id, $nama_desa);
    }
    public function deleteDesa($id) {
        return $this->desaModel->hapusdesa($id);
    }
}