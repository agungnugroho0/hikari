<?php
use app\core\Database;
function idBaru($prefix, $kolom, $tabel)
{
    $db = (new Database())->connect();
    $tanggal = date("Ymd");

    $stmt = $db->prepare("
        SELECT MAX($kolom) as max_id 
        FROM $tabel 
        WHERE $kolom LIKE :prefix
    ");

    $likePattern = $prefix . $tanggal . "%";
    $stmt->execute([':prefix' => $likePattern]);
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);

    $lastId = $row['max_id'];

    if ($lastId) {
        // Ambil 3 digit terakhir dan naikkan 1
        $lastNum = (int)substr($lastId, -3);
        $newNum = str_pad($lastNum + 1, 3, "0", STR_PAD_LEFT);
    } else {
        $newNum = "001";
    }

    return $prefix . $tanggal . $newNum;
}

function findById($tabel, $kolom, $nilai) {
    $db = (new Database())->connect();
    $query = "SELECT * FROM {$tabel} WHERE {$kolom} = :nilai LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':nilai', $nilai);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function formatnowa($nomor){
    $nomor_wa = preg_replace('/^0/', '+62', preg_replace('/^62/', '+62', $nomor));
    return !preg_match('/^\+62/', $nomor_wa) ? '+62' . $nomor_wa : $nomor_wa;
};

function umur($tanggallahir) {
    $sekarang = new DateTime();
    $tgllahir = new DateTime($tanggallahir); // Membuat objek DateTime dari tanggal lahir
    $umur = $sekarang->diff($tgllahir)->y; // Menghitung selisih tahun
    return $umur; // Mengembalikan umur
}