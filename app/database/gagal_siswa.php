<?php
require '../../autoloader.php';
admin();
$data = [
    ':id_w' => $_GET['id_w']
];
hapus('wawancara',$data);
// echo "
//     <script>
//         if (window.innerWidth <= 768) {
//             window.location.href = '/hikari/public/view/wawancara.php?sukses';
//         } else {
//             window.location.href = '/hikari/public/admin/index.php?menu_id=3&sukses';
//         }
//     </script>
// ";
header("Location:../../public/admin/index.php?menu_id=3&sukses");
