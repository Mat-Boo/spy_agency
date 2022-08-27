<?php
session_start();
$_SESSION = [];
setcookie('PHPSESSID', '', time() - 3600);
header('Location: ' . $router->url('login'));
exit();