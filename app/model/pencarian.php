<?php
namespace app\model;
use app\core\Database;

class pencarian {
    private $db;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

    function pencarian_siswa($search){
        $query = "(SELECT 'siswa' AS sumber, nis, nama, foto
        FROM siswa
        WHERE nama LIKE CONCAT('%', :search, '%'))

        UNION ALL

        (SELECT 'lolos' AS sumber, nis, nama, foto
        FROM lolos
        WHERE nama LIKE CONCAT('%', :search, '%'))
        LIMIT 5";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}