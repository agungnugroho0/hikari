<?php
require '../../autoloader.php';
admin();
$data = [
    ':id_job' => $_GET['id_job']
];
hapus('wawancara',$data);
hapus('job',$data);
// echo "
//     <script>
//         if (window.innerWidth <= 768) {
//             window.location.href = '/hikari/public/view/wawancara.php?sukses';
//         } else {
//             window.location.href = '/hikari/public/admin/index.php?menu_id=3&sukses';
//         }
//     </script>
// ";
header("Location:../../public/admin/index.php?menu_Id=3&sukses");

