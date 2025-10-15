<?php
namespace app\controller;
use app\model\finance;

class financecontroller{
    private $model;
    public function __construct(){
        $this->model = new finance();
    }

    public function index($search = ''){
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $data = $this->model->gettagihan($search);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}