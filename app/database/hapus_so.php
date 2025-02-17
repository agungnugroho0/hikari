<?php
require '../../autoloader.php';
admin();
$data = [
    ':id_so' => $_GET['id_so']
];
hapus_foto_so($_GET['id_so']);
hapus('so',$data);
echo "
    <script>
        if (window.innerWidth <= 768) {
            window.location.href = '/hikari/public/view/so.php?sukses';
        } else {
            window.location.href = '/hikari/public/admin/index.php?menu_id=8&sukses';
        }
    </script>
";

