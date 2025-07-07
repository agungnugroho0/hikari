<?php

namespace app\model;
use app\core\Database;

class table{
    private $db;
    
    public function __construct(){
        $this->db = (new Database())->connect();

    }

    public function siswa($kelas){
        $stmt = $this->db->prepare("SELECT nis, nama FROM siswa 
    INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
    WHERE kelas.kelas = :kelas
    ORDER BY siswa.nama");
        $stmt->bindParam(':kelas',$kelas);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function presensi($bulan,$kelas){
        $stmt = $this->db->prepare("SELECT siswa.nis, siswa.nama, absen.tgl, absen.ket 
    FROM absen 
    INNER JOIN siswa ON absen.nis = siswa.nis 
    INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
    WHERE DATE_FORMAT(absen.tgl, '%Y-%m') = :bulan AND kelas.kelas = :kelas
    ORDER BY siswa.nama");
        $stmt->bindParam(':kelas',$kelas);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);


    }
}