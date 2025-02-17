<?php 
function tampil($query){
    $konek = koneksi();
    $stmt = $konek->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>