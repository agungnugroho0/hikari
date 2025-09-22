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

    public function kelompokid($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id_klp = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function tambahkelompok($id_kelompok, $nama_kelompok){
        $query = "INSERT INTO " . $this->table . " (id_klp, nama_klp) VALUES (:id_klp, :nama_klp)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_klp', $id_kelompok);
        $stmt->bindParam(':nama_klp', $nama_kelompok);
        return $stmt->execute();
    }

    public function updatekelompok($id, $nama_kelompok){
        $query = "UPDATE " . $this->table . " SET nama_klp = :nama_klp WHERE id_klp = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_klp', $nama_kelompok);
        return $stmt->execute();
    }

    public function hapuskelompok($id){
        $query = "DELETE FROM " . $this->table . " WHERE id_klp = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}