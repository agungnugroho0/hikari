<?php
namespace app\controller;
use app\model\finance;

class financecontroller{
    private $model;
    public function __construct(){
        $this->model = new finance();
    }

    public function index($search = '',$filter){
        // $search = isset($_GET['search']) ? $_GET['search'] : '';
        // $filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
        $data = $this->model->gettagihan($search,$filter);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}