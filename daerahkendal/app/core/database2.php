<?php

namespace app\core;
use PDO;
use PDOException;
class database2{
    private $host = 'localhost';
    private $dbname = 'daerahkendal';
    private $username = 'root';
    private $password = 'bapakDjokam354';
    // private $port = 3307;
    public $conn;
    public function connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            die("Koneksi database gagal: " . $e->getMessage());
        }   
        return $this->conn;
    }

}
