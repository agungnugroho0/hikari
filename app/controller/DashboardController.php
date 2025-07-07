<?php
namespace app\controller;
use app\model\Kelas;

class DashboardController{

    private $kelasmodel;
    public function __construct(){
        // $this->db = (new Database())->connect();
    }
    
    public function index(){
        $kelasmodel = new Kelas;
        $data = $kelasmodel->semuakelas();
        return $data;
        // include __DIR__."/../view/dashboard/index.php";
    }
    
}
