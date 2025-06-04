<?php
require '../../autoloader.php';
$id_job = idbaru('J','id_job','job');
$data = [
    ':id_job' => $id_job,
    ':id_so' => $_POST['so'],
    ':job' => $_POST['job'],
    ':perusahaan' => $_POST['perusahaan'],
    // ':tgl_job' => $_POST['tgl']
    ':tgl_job' => !empty($_POST['tgl']) ? $_POST['tgl'] : null
];

$tes = masukan('job',$data);
var_dump ($tes);

// echo "
//     <script>
//     window.top.location.href= '/public/admin/index.php?menu_Id=3&sukses';
//     </script>
// ";