<?php
session_start();
$_SESSION = [];
setcookie('PHPSESSID', '', 1);
header('Location: ' . $router->url('login'));
exit();