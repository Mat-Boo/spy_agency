<?php
session_start();
/* session_destroy(); */
$_SESSION = [];
setcookie('PHPSESSID', '', time() - 3600);
header('Location: ' . $router->url('login'));
exit();