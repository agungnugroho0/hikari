<?php
namespace app\model;
use app\core\Database;

class absensiswa{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function cekkehadiransiswa($nis,$tgl){
        
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM absen WHERE nis = :nis AND tgl = :tgl");
        $stmt->bindParam(':nis',$nis);
        $stmt->bindParam(':tgl',$tgl);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function masukanabsensiswa($data){
        $stmt = $this->db->prepare("INSERT INTO absen (id_absen,nis,nama,tgl,ket) 
                                        VALUES (:id_absen,:nis,:nama,:tgl,:ket)");
        $stmt->bindParam(':id_absen',$data['id_absen']);
        $stmt->bindParam(':nis',$data['nis']);
        $stmt->bindParam(':nama',$data['nama']);
        $stmt->bindParam(':tgl',$data['tgl']);
        $stmt->bindParam(':ket',$data['ket']);
        return $stmt->execute();
    }

    public function siswabelumabsen($id_kelas){
        $tgl = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT s.nis, s.nama, s.id_kelas FROM siswa s LEFT JOIN absen a ON s.nis = a.nis AND a.tgl = :tgl WHERE s.id_kelas = :id_kelas AND a.nis IS NULL ORDER BY s.nama ASC");
        $stmt->bindParam(':id_kelas',$id_kelas);
        $stmt->bindParam(':tgl',$tgl);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}