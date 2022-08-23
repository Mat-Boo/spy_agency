<?php

use App\Controllers\SpecialitiesController;
use App\Controllers\AgentsSpecialitiesController;
use App\Controllers\MissionsController;

$specialitiesController = new SpecialitiesController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;
$missionsController = new MissionsController;

$nameSpeciality = $specialitiesController->findSpeciality($params['id'])->getName();

$agentsSpecialitiesController->deleteAgentSpecialityFromSpeciality($params['id']);
$specialitiesController->deleteSpeciality($params['id']);
header('Location: ' . $router->url('admin_speciality') . '?deleted=' . htmlspecialchars($nameSpeciality));
?>