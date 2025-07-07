<?php
require_once __DIR__.'/../../autoloader.php';
use app\middleware\AuthMiddleware;

AuthMiddleware::checklogin();
session_unset();
session_destroy();
header("Location: /index.php");
exit;

