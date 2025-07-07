<?php
namespace app\model;
use app\core\Database;

class guru{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }
    public function previewssiswa($id){
        $stmt = $this->db->prepare("SELECT siswa.nis,siswa.nama,siswa.foto,siswa.wa,wawancara.id_job FROM siswa JOIN wawancara ON wawancara.nis = siswa.nis WHERE id_kelas = :id_kelas LIMIT 5");
        $stmt->bindParam(':id_kelas',$id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

        public function kenaikankelas(){
        $stmt = $this->db->query("SELECT tgl_event FROM event WHERE nama_event ='UKK'");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
        public function naik($data){
            $stmt = $this->db->prepare("UPDATE siswa SET
            id_kelas = :id_kelas
            WHERE nis = :nis");
            $stmt->bindParam(':nis',$data['nis']);
            $stmt->bindParam(':id_kelas',$data['id_kelas']);
            return $stmt->execute();
        }
}