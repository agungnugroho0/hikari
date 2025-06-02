<?php
include '../../autoloader.php';
$nis = $_GET['nis'];
naik($nis);
echo "
    <script>
            window.location.href = '/public/guru/siswa.php?sukses';
    </script>
";