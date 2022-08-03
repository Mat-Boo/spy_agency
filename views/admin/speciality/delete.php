<?php

use App\Controllers\SpecialitiesController;
use App\Controllers\AgentsSpecialitiesController;
use App\Controllers\MissionsController;

$stashsController = new SpecialitiesController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;
$missionsController = new MissionsController;

/* $agentsSpecialitiesController->deleteAgentSpeciality($params['id']);
$missionsController->deleteMissionSpeciality($params['id']);
$specialitiesController->deleteSpeciality($params['id']); */
header('Location: ' . $router->url('admin_speciality') . '?delete=' . $params['id']);
?>