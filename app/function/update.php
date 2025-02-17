<?php
function updateSiswa(array $data,$tabel) {
    $konek = koneksi();
    $query = "UPDATE $tabel SET 
        nama = :nama,
        panggilan = :panggilan,
        tgl = :tgl,
        id_kelas = :id_kelas,
        gender = :gender,
        tempat_lhr = :tempat_lahir,
        provinsi = :provinsi,
        kabupaten = :kabupaten,
        kecamatan = :kecamatan,
        kelurahan = :kelurahan,
        rt = :rt,
        rw = :rw,
        wa = :wa,
        agama = :agama,
        status = :status,
        darah = :darah,
        bb = :bb,
        tb = :tb,
        merokok = :merokok,
        alkohol = :alkohol,
        tangan = :tangan,
        hobi = :hobi,
        tujuan = :tujuan,
        kelebihan = :kelebihan,
        kekurangan = :kekurangan,
        no_rumah = :no_rumah,
        foto = :foto
    WHERE nis = :nis";
    $stmt = $konek->prepare($query);
    return $stmt->execute($data);
}

function perbarui($namatabel, $data, $where) {
    $konek = koneksi();
    
    $setClauses = implode(", ", array_map(fn($col) => str_replace(":", "", $col) . " = " . $col, array_keys($data)));
    $whereClauses = implode(" AND ", array_map(fn($col) => str_replace(":", "", $col) . " = " . $col, array_keys($where)));
    $sql = "UPDATE $namatabel SET $setClauses WHERE $whereClauses";
    try {
        $stmt = $konek->prepare($sql);
        $mergedData = array_merge($data, $where);
        $stmt->execute($mergedData);
        return ['status' => 'sukses'];
    } catch (PDOException $e) {
        return [
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }
}
