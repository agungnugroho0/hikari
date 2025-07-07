<?php
namespace app\model;
use app\core\Database;
use PDO;

class staff {
    private $db;
    public function __construct(){
         $this->db = (new Database())->connect();
    }

    public function idBaru(){
        $stmt = $this->db->query("SELECT MAX(id_staff) as max_id FROM staff");
        $row= $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['max_id']) {
        // Ambil angka dari format ID terakhir
        $lastNumber = (int) substr($row['max_id'], 5); // contoh: STAFF005 → 5
        $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

    // Format ulang jadi STAFF001, STAFF002, dll
    return "STAFF" . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);
    }

    public function findById($id){
    $stmt = $this->db->prepare("SELECT * FROM staff WHERE id_staff = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tampilstaff(){
        $stmt = $this->db->prepare("SELECT staff.*,kelas.kelas FROM staff LEFT JOIN kelas ON staff.id_kelas = kelas.id_kelas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function simpan($data){
        $stmt = $this->db->prepare("INSERT INTO staff (id_staff, nama, username, password, level, id_kelas, foto, no) 
        VALUES (:id_staff, :nama, :username, :password, :level, :id_kelas, :foto, :no)");
        $stmt->bindParam(':id_staff',$data['id_staff']); 
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':id_kelas', $data['id_kelas']);
        $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':no', $data['no']);
        return $stmt->execute();
    }

    public function update($data){
        $query = "UPDATE staff SET nama = :nama, username = :username, " . (!empty($data['password']) ? "password = :password, " : "") ."level = :level, id_kelas = :id_kelas, " .(!empty($data['foto']) ? "foto = :foto, " : "") ."no = :no WHERE id_staff = :id_staff";

        // bersihkan trailing koma
        $query = preg_replace('/,(\s*WHERE)/', ' $1', $query);

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':username', $data['username']);
        if (!empty($data['password'])) $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':id_kelas', $data['id_kelas']);
        if (!empty($data['foto'])) $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':no', $data['no']);
        $stmt->bindParam(':id_staff', $data['id_staff']);
        return $stmt->execute();
    }

    public function hapus($id_staff) {
    $stmt = $this->db->prepare("DELETE FROM staff WHERE id_staff = :id");
    $stmt->bindParam(':id', $id_staff);
    return $stmt->execute();
    }

}