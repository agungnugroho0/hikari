<?php
namespace app\model;
use app\core\Database;

class finance{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

 public function gettagihan($search = '', $limit = 50){
    try {
        if ($search) {
            $sql = "
                SELECT 
                    s.nis, 
                    s.nama, 
                    s.asal_data,
                    t.jenis_tagihan, 
                    COALESCE(t.sisa_tagihan, 0) AS sisa_tagihan,
                    t.status_tagihan
                FROM (
                    SELECT 'siswa' AS asal_data, nis, nama FROM siswa
                    UNION ALL
                    SELECT 'lolos' AS asal_data, nis, nama FROM lolos
                ) AS s
                LEFT JOIN tagihan AS t ON s.nis = t.nis
                WHERE s.nama LIKE :search
                ORDER BY s.nis ASC
                LIMIT :limit
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', "%$search%", \PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        } else {
            $sql = "
                SELECT 
                    s.nis, 
                    s.nama, 
                    s.asal_data,
                    t.jenis_tagihan, 
                    COALESCE(t.sisa_tagihan, 0) AS sisa_tagihan,
                    t.status_tagihan
                FROM (
                    SELECT 'siswa' AS asal_data, nis, nama FROM siswa
                    UNION ALL
                    SELECT 'lolos' AS asal_data, nis, nama FROM lolos
                ) AS s
                LEFT JOIN tagihan AS t ON s.nis = t.nis
                ORDER BY s.nis ASC
                LIMIT :limit
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Error TagihanModel@gettagihan: " . $e->getMessage());
        return [];
    }
}

}