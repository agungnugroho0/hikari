<?php
require '../../autoloader.php';
$id_job = idbaru('J','id_job','job');
$data = [
    ':id_job' => $id_job,
    ':id_so' => $_POST['so'],
    ':job' => $_POST['job'],
    ':perusahaan' => $_POST['perusahaan'],
    ':tgl_job' => $_POST['tgl']
];

$tes = masukan('job',$data);
var_dump ($tes);

// echo "
//     <script>
//     window.top.location.href= '/public/admin/index.php?menu_Id=3&sukses';
//     </script>
// ";