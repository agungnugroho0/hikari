<?php
require '../../autoloader.php';
admin();
$data = [
    ':id_kelas' => $_GET['id_kelas']
];
hapus('kelas',$data);
echo "
    <script>
        if (window.innerWidth <= 768) {
            window.location.href = '/hikari/public/view/kelas.php?sukses';
        } else {
            window.location.href = '/hikari/public/admin/index.php?menu_id=6&sukses';
        }
    </script>
";