<?php

use App\Controllers\PersonsController;
use App\Controllers\MissionsPersonsController;
use App\Controllers\AgentsSpecialitiesController;

$personsController = new PersonsController;
$missionsPersonsController = new MissionsPersonsController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;

$missionsPersonsController->deleteMissionPersonFromPerson($params['id'], substr($match['name'], 6, -7));
if (substr($match['name'], 6, -7) === 'agent') {
    $agentsSpecialitiesController->deleteAgentSpecialityFromAgent($params['id']);
}
$personsController->deletePerson($params['id'], substr($match['name'], 6, -7));
header('Location: ' . $router->url('admin_' . substr($match['name'], 6, -7)) . '?delete=' . $params['id']);
?>
