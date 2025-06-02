<?php
require_once '../../autoloader.php';
admin();
$data = [
 ':id_kelas' => $_POST['id_kelas'],
 ':kelas' => $_POST['kelas']
];
$where = [':id_kelas' => $_POST['id_kelas']];
perbarui('kelas',$data, $where);
// echo "
//     <script>
//         if (window.innerWidth <= 768) {
//             window.location.href = '/hikari/public/view/kelas.php?sukses';
//         } else {
//             window.location.href = '/hikari/public/admin/index.php?menu_id=6&sukses';
//         }
//     </script>
// ";
header("Location:/public/admin/index.php?menu_Id=6&sukses");
