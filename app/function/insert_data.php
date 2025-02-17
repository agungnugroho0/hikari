<?php

function masukan($namatabel,$data){
    $konek = koneksi();
    $columns = implode(", ", array_map(fn($col) => str_replace(":", "", $col), array_keys($data)));
    $placeholders = implode(",", array_keys($data));
    $sql = "INSERT INTO $namatabel ($columns) VALUES ($placeholders)";
    try{
        $stmt = $konek->prepare($sql);
        $stmt->execute($data);
        return ['status'=>'sukses'];
    } catch (PDOException $e) {
        return [
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }
}

function cek_nama ($nama){
    $konek = koneksi();
    $query = "SELECT COUNT(*) FROM siswa WHERE nama = :nama";
    $stmt = $konek->prepare($query);
    $stmt->execute([':nama' => $nama]);
    return $stmt->fetchColumn();
}

function pindahkanData($namatabelTujuan, $namatabelSumber, $nis) {
    $konek = koneksi();
    $sql = "INSERT INTO $namatabelTujuan SELECT * FROM $namatabelSumber WHERE nis = :nis";
    try {
        $stmt = $konek->prepare($sql);
        $stmt->execute([':nis' => $nis]);
        return ['status' => 'sukses', 'message' => 'Data berhasil dipindahkan'];
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
    }
}

