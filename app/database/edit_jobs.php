<?php
require_once '../../autoloader.php';
admin();

$data = [
    ':id_job' => $_POST['id_job'],
    ':job' => $_POST['job'],
    ':perusahaan' => $_POST['perusahaan'],
    ':id_so' => $_POST['so'],
    ':tgl_job' => $_POST['tgl']
];
$where = [':id_job' => $_POST['id_job']];
perbarui('job',$data, $where);
// echo "
//     <script>
//         if (window.innerWidth <= 768) {
//             window.location.href = '/hikari/public/view/wawancara.php?sukses';
//         } else {
//             window.location.href = '/hikari/public/admin/index.php?menu_id=3&sukses';
//         }
//     </script>
// ";
// header("Location:../../public/admin/index.php?menu_Id=3&sukses");

echo "
    <script>
    window.top.location.href= '/hikari/public/admin/index.php?menu_Id=3&sukses';;
    </script>
";