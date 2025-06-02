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


echo "
    <script>
    window.top.location.href= '/public/admin/index.php?menu_Id=3&sukses';;
    </script>
";