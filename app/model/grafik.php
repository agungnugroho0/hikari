<?php

namespace app\model;
use app\core\Database;

class grafik{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function grafikjmllolosperbulan($bulan){
        $query = "SELECT DATE_FORMAT(tgl_lolos, '%d') as tgl, COUNT(tgl_lolos) AS jumlah_lolos
                  FROM log_lolos 
                  WHERE DATE_FORMAT(tgl_lolos, '%Y-%m') = :bulan
                  GROUP BY DATE_FORMAT(tgl_lolos, '%d')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function grafikjmllolosperkelas($kelas,$bulan){
        $query = "SELECT DATE_FORMAT(log.tgl_lolos, '%d') as 'tgl', COUNT(log.tgl_lolos) AS jumlah_lolos FROM log_lolos log JOIN lolos ON log.nis = lolos.nis JOIN kelas k ON lolos.id_kelas = k.id_kelas WHERE DATE_FORMAT(log.tgl_lolos, '%Y-%m') = :bulan AND k.kelas = :kelas GROUP BY DATE_FORMAT(tgl_lolos, '%d')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->bindParam(':kelas', $kelas);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function grafikjadwalmensetsu(){
    // $query = "SELECT 
    //     job.id_job AS id_job,
    //     UNIX_TIMESTAMP(job.tgl_job) * 1000 AS start_ts,
    //     IF(
    //         job.tgl_job IS NULL 
    //         OR job.tgl_job + 0 = 0, 
    //         NULL, 
    //         UNIX_TIMESTAMP(DATE_ADD(job.tgl_job, INTERVAL 23 HOUR)) * 1000
    //     ) AS end_ts,
    //     so.so AS nama_so,
    //     job.job AS nama_job,
    //     CASE
    //         WHEN job.tgl_job IS NULL 
    //             OR job.tgl_job + 0 = 0
    //         THEN 'Belum Dijadwalkan'
    //         ELSE 'Sudah Dijadwalkan'
    //     END AS status
    //     FROM job
    //     LEFT JOIN so ON job.id_so = so.id_so
    //     ORDER BY status, job.tgl_job";
    $query = "SELECT 
                    job.id_job,
                    job.tgl_job,
                    job.job AS nama_job,
                    so.so AS nama_so
                    job.interview AS interview
                FROM job
                LEFT JOIN so ON job.id_so = so.id_so
                ORDER BY job.tgl_job IS NULL, job.tgl_job ASC";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function grafikabsenperkelas($kelas,$bulan){
        $query ="SELECT 
                            absen.tgl,
                            SUM(ket = 'H') AS hadir,
                            SUM(ket = 'I') AS izin,
                            SUM(ket = 'A') AS alpha,
                            SUM(ket = 'S') AS sakit,
                            SUM(ket = 'M') AS mensetsu
                            FROM absen
                            JOIN siswa ON absen.nis = siswa.nis 
                            WHERE siswa.id_kelas = :kelas 
                            AND DATE_FORMAT(absen.tgl, '%Y-%m') = :bulan
                            GROUP BY absen.tgl
                            ORDER BY absen.tgl";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindparam(':kelas',$kelas);
        $stmt->bindparam(':bulan',$bulan);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function pilihkelas($kelas){
        $query = "SELECT id_kelas FROM kelas WHERE kelas = :kelas";
        $stmt = $this->db->prepare($query);
        $stmt->bindparam(':kelas',$kelas);
        $stmt->execute();
        return $stmt->fetch();
    }
}