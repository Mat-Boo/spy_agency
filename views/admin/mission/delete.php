<?php

use App\Controllers\MissionsPersonsController;
use App\Controllers\MissionsStashsController;
use App\Controllers\MissionsController;

$missionsPersonsController = new MissionsPersonsController;
$missionsStashsController = new MissionsStashsController;
$missionsController = new MissionsController;

$codenameMission = $missionsController->findMission($params['id'])->getCode_name();

foreach(['agent', 'contact', 'target'] as $personItem) {
    $missionsPersonsController->deleteMissionPersonFromMission($params['id'], $personItem);
}
$missionsStashsController->deleteMissionStashFromMission($params['id']);
$missionsController->deleteMission($params['id']);

header('Location: ' . $router->url('admin_mission') . '?deleted=' . htmlspecialchars($codenameMission));
?>