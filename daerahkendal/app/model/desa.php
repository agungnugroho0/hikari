<?php
namespace app\model;
use app\core\database2;

class desa {
    private $conn;
    private $table = 'desa';

    public function __construct() {
        $database = new database2();
        $this->conn = $database->connect();
    }

    public function semuadesa() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function desaid($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_desa = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function tambahdesa($id_desa, $nama_desa) {
        $query = "INSERT INTO " . $this->table . " (id_desa, nama_desa) VALUES (:id_desa, :nama_desa)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_desa', $id_desa);
        $stmt->bindParam(':nama_desa', $nama_desa);
        return $stmt->execute();
    }
    public function hapusdesa($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_desa = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function updatedesa($id, $nama_desa) {
        $query = "UPDATE " . $this->table . " SET nama_desa = :nama_desa WHERE id_desa = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_desa', $nama_desa);
        return $stmt->execute();
    }
}