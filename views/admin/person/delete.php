<?php

use App\Controllers\PersonsController;
use App\Controllers\MissionsPersonsController;
use App\Controllers\AgentsSpecialitiesController;

$personsController = new PersonsController;
$missionsPersonsController = new MissionsPersonsController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;

/* $missionsPersonsController->deleteMissionPerson($params['id'], $personItem);
if ($personItem === 'agent') {
    $agentsSpecialitiesController->deleteAgentSpeciality($params['id']);
}
$personsController->deletePerson($params['id'], $personItem); */
header('Location: ' . $router->url('admin_' . $personItem) . '?delete=' . $params['id']);
?>
