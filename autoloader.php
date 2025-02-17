<?php 
$directories = [
    __DIR__ . "/app/function/",
];
foreach ($directories as $directory) {
if (!is_dir($directory)) {
    die("Directory $directory tidak ditemukan!");
}
$files = glob($directory . '*.php');
foreach ($files as $file) {
    require_once $file;
}
}
?>
