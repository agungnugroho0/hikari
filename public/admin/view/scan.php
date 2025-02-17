<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
admin();
$destinasi = '/hikari';

?>
<iframe src="<?= $destinasi?>/public/admin/view/viewscan.php" frameborder="0" class="w-full h-screen"></iframe>

