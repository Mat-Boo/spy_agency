<?php

use App\Controllers\MissionsPersonsController;
use App\Controllers\MissionsStashsController;
use App\Controllers\MissionsController;

$missionsPersonsController = new MissionsPersonsController;
$missionsStashsController = new MissionsStashsController;
$missionsController = new MissionsController;

foreach(['agent', 'contact', 'target'] as $personItem) {
    $missionsPersonsController->deleteMissionPersonFromMission($params['id'], $personItem);
}
$missionsStashsController->deleteMissionStashFromMission($params['id']);
$missionsController->deleteMission($params['id']);
header('Location: ' . $router->url('admin_mission') . '?delete=' . $params['id']);
?>