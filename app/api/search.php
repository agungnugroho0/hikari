<?php
include __DIR__.'/../../autoloader.php';
$konek = koneksi();
header('Content-type: application/json');

if (isset($_GET['query'])) {
    $search = trim($_GET['query']);

    if ($search === '') {
        echo json_encode([]);
        exit;
    }

    $stmt = $konek->prepare(
        "(SELECT 'siswa' AS sumber, nis, nama, foto
        FROM siswa
        WHERE nama LIKE CONCAT('%', :search, '%'))

        UNION ALL

        (SELECT 'lolos' AS sumber, nis, nama, foto
        FROM lolos
        WHERE nama LIKE CONCAT('%', :search, '%'))
        LIMIT 6;
    ");

    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);

} else {
    echo json_encode([]);
}
?>
