<?php
namespace app\model;
use app\core\Database;

class finance{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

 public function gettagihan($search = '', $filter) {
    $limit = 50;
    try {
        $baseQuery = "
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
        ";

        $conditions = [];
        if ($search) {
            $conditions[] = "s.nama LIKE :search";
        }

        if ($filter === 'siswa') {
            $conditions[] = "s.asal_data = 'siswa'";
        } elseif ($filter === 'lolos') {
            $conditions[] = "s.asal_data = 'lolos'";
        }

        $whereSql = count($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "$baseQuery $whereSql ORDER BY s.nis ASC LIMIT :limit";

        $stmt = $this->db->prepare($sql);

        if ($search) {
            $stmt->bindValue(':search', "%$search%", \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        error_log("Error TagihanModel@gettagihan: " . $e->getMessage());
        return [];
    }
}


}