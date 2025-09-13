<?php

// PSR-4 Autoloader manual
spl_autoload_register(function ($class) {
    // Hilangkan base namespace "App\"
    $prefix = 'app\\';
    $base_dir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
// require_once __DIR__ . '/app/helpers/helper.php';
// require_once __DIR__ . '/vendor/autoload.php';

