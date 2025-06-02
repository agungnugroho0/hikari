<?php
require_once '../../autoloader.php';
admin();
$so = $_POST['so'];
$lokasi = $_POST['lokasi'];
$note = $_POST['noted'];

$idbaru = idbaru('SO','id_so','so');
$uploadResult = uploadFotoSo($_FILES['foto_so']);
if (is_array($uploadResult) && $uploadResult['status'] === 'success') {
    $foto = $uploadResult['foto'];
} else {
    exit;
};

$data = [
    ':id_so' => $idbaru,
    ':so' => $so,
    ':foto_so' => $foto,
    ':noted' => $note,
    ':lokasi' => $lokasi
];
masukan('so',$data);

echo "
    <script>
    window.top.location.href= '/public/admin/index.php?menu_Id=8&sukses';;
    </script>
";