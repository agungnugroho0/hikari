<?php
namespace app\controller;
use app\model\guru;

class indexgurucontroller{
    private $db;

    public function  __construct() {
        $this->db = new guru();
    }

    public function previewsiswa($id_kelas){
        return $this->db->previewssiswa($id_kelas);
    }

}