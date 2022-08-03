<?php

use App\Controllers\MissionsPersonsController;
use App\Controllers\MissionsStashsController;
use App\Controllers\MissionsController;

$missionsPersonsController = new MissionsPersonsController;
$missionsStashsController = new MissionsStashsController;
$missionsController = new MissionsController;

/* $missionsPersonsController->deleteMissionPerson($params['id']);
$missionsStashsController->deleteMissionStash($params['id']);
$missionsController->deleteMission($params['id']); */
header('Location: ' . $router->url('admin_mission') . '?delete=' . $params['id']);
?>