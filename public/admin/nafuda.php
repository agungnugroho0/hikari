<?php
require_once __DIR__ . '/../../autoloader.php';

use app\controller\siswacontroller;
$siswa = new siswacontroller();

$siswa->cetaknafuda($_GET['nis']);