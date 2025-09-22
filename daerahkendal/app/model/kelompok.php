<?php
namespace app\model;
use app\core\database2;

class kelompok{
    private $conn;
    private $table = 'kelompok';

    public function __construct() {
        $database = new database2();
        $this->conn = $database->connect();
    }

    public function semuakelompok(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}