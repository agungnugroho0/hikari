<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
$destinasi = '/hikari';
admin();

?>
<iframe src="<?= $destinasi?>/public/admin/view/viewevent.php" frameborder="0" class="w-full h-[82vh]"></iframe>