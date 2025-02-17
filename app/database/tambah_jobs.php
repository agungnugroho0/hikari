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

masukan('job',$data);
echo "
    <script>
        if (window.innerWidth <= 768) {
            window.location.href = '/hikari/public/view/wawancara.php?sukses';
        } else {
            window.location.href = '/hikari/public/admin/index.php?menu_id=3&sukses';
        }
    </script>
";