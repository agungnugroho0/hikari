<?php
namespace app\model;
use app\core\Database;
class Kelas{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function semuakelas(){
        $stmt = $this->db->query("SELECT * FROM kelas");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function pilihkelas($id){
        $stmt = $this->db->prepare("SELECT * FROM kelas WHERE id_kelas = :id OR tingkat = :id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function tampil(){
         $stmt = $this->db->query("SELECT kelas.*,staff.nama as pengampu FROM kelas LEFT JOIN staff ON kelas.id_kelas = staff.id_kelas ORDER BY kelas.tingkat DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function simpan($data){
        $stmt = $this->db->prepare("INSERT INTO kelas (id_kelas, kelas, tingkat) VALUES (:id_kelas,:kelas,:tingkat)");
        $stmt->bindParam(':id_kelas',$data['id_kelas']);
        $stmt->bindParam(':kelas',$data['kelas']);
        $stmt->bindParam(':tingkat',$data['tingkat']);
        return $stmt->execute();

    }

    public function update($data){
        $stmt = $this->db->prepare("UPDATE kelas SET id_kelas = :id_kelas, kelas = :kelas, tingkat = :tingkat WHERE id_kelas = :id_kelas");
        return $stmt->execute([
            ':id_kelas' => $data['id_kelas'],
            ':kelas' => $data['kelas'],
            ':tingkat' => $data['tingkat']
        ]);

    }

    public function hapuskelas($id_kelas){
        $stmt = $this->db->prepare("DELETE FROM kelas WHERE id_kelas = :id_kelas");
        return $stmt->execute([':id_kelas' => $id_kelas]);
    }
    

}