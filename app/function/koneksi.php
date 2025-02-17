<?php
function koneksi(){
    try{
        $konek = new PDO("mysql:host=localhost;dbname=lpk", "root", "bapakDjokam354");
        $konek->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
    return $konek;
}

 ?>
 