<?php
require '../../autoloader.php';
admin();
$data = [
    ':id_w' => $_GET['id_w']
];
hapus('wawancara',$data);

echo "
    <script>
    window.top.location.href= '/public/admin/index.php?menu_Id=3&sukses';
    </script>
";
