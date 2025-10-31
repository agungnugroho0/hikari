<?php
namespace app\model;
use app\core\Database;

class so{
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function tampilso(){
        $stmt = $this->db->query("SELECT * FROM so");
        $stmt->execute();
        return $stmt->fetchAll(\pdo::FETCH_ASSOC);
    }

    public function simpan($data){
        $stmt = $this->db->prepare("INSERT INTO so (id_so, so, foto_so, lokasi) 
        VALUES (:id_so, :so, :foto_so, :lokasi)");
        $stmt->bindParam(':id_so',$data['id_so']); 
        $stmt->bindParam(':so', $data['so']);
        $stmt->bindParam(':foto_so', $data['foto_so']);
        $stmt->bindParam(':lokasi', $data['lokasi']);
        return $stmt->execute();
    }

    public function findById($id){
    $stmt = $this->db->prepare("SELECT * FROM so WHERE id_so = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}