<?php
if (isset($_GET['menu_id'])) {
    $menuId = intval($_GET['menu_id']); // Amankan input
    ob_start(); 
    switch ($menuId) {
        case 1:
            include 'view/dashboard.php';
            break;
        case 2:
            include 'view/staff.php';
            break;
        case 3:
            include 'view/wawancara.php';
            break;
        case 4:
            include 'view/siswa.php';
            break;
        case 5:
            include 'view/lolos.php';
            break;
        case 6:
            include 'view/kelas.php';
            break;
        case 7:
            include 'view/presensi.php';
            break;
        case 8:
            include 'view/so.php';
            break;
        case 9:
            include 'view/scan.php';
            break;
        default:
            echo "<div>Menu tidak ditemukan</div>";
            break;
    }
    echo ob_get_clean();
}