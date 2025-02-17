<?php
require '../../autoloader.php';

// Validasi input page dan limit
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

// Pastikan header JSON dikirim sebelum echo
if (!headers_sent()) {
    header('Content-Type: application/json');
}

// Query data siswa
try {
    $query = "SELECT log_lolos.*,lolos.* FROM log_lolos JOIN lolos ON log_lolos.nis = lolos.nis ORDER BY log_lolos.tgl_lolos DESC LIMIT $limit OFFSET $offset ";
    $data = tampil($query);
    if ($data === false) {
        echo json_encode(['error' => 'SQL Query failed', 'query' => $query]);
        exit;
    }

    // Hitung total data
    $totalQuery = "SELECT COUNT(*) AS total FROM log_lolos";
    $totalData = tampil($totalQuery);
    if ($totalData === false) {
        echo json_encode(['error' => 'SQL Total Query failed']);
        exit;
    }

    $total = $totalData[0]['total'];
    $response = [
        'data' => $data,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => ceil($total / $limit)
    ];

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(['error' => 'Internal server error', 'message' => $e->getMessage()]);
}
