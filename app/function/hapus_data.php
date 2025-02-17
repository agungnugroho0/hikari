<?php
function hapus($namatabel, $where) {
    $konek = koneksi();
    $whereClauses = implode(" AND ", array_map(fn($col) => str_replace(":", "", $col) . " = " . $col, array_keys($where)));
    $sql = "DELETE FROM $namatabel WHERE $whereClauses";
    try {
        $stmt = $konek->prepare($sql);
        $stmt->execute($where);
        return ['status' => 'sukses'];
    } catch (PDOException $e) {
        return [
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ];
    }
}
