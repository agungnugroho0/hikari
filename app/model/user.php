<?php

namespace app\model;
use app\core\Database;

class user{
    private $db;
    public function __construct(){
        // $this->db = $db;
        $this->db = (new Database())->connect();
        if (!$this->db) {
        die("Database tidak tersedia di model User");
        }
    }

    public function getbyusername($username){
        $stmt = $this->db->prepare("SELECT * FROM staff WHERE username= :username");
        $stmt->execute([':username'=>$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $newPassword) {
        $stmt = $this->db->prepare("UPDATE staff SET password = :password WHERE id_staff = :id");
        $stmt->execute([':password' => $newPassword, ':id' => $id]);
    }
}