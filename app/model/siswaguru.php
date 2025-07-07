<?php
namespace app\model;
use app\core\Database;
class siswaguru{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

}