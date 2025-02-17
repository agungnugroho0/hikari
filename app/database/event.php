<?php
include '../../autoloader.php';
$nis = $_GET['nis'];
naik($nis);
echo "
    <script>
            window.location.href = '/hikari/public/guru/index.php?sukses';
    </script>
";