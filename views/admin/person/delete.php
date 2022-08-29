<?php
session_start();
use App\Controllers\PersonsController;
use App\Controllers\MissionsPersonsController;
use App\Controllers\AgentsSpecialitiesController;

$personsController = new PersonsController;
$missionsPersonsController = new MissionsPersonsController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;

$codenamePerson = $personsController->findPerson($params['id'], substr($match['name'], 6, -7))->getCode_name();

if (isset($_SESSION['token'])) {
    $missionsPersonsController->deleteMissionPersonFromPerson($params['id'], substr($match['name'], 6, -7));
    if (substr($match['name'], 6, -7) === 'agent') {
        $agentsSpecialitiesController->deleteAgentSpecialityFromAgent($params['id']);
    }
    $personsController->deletePerson($params['id'], substr($match['name'], 6, -7));
    header('Location: ' . $router->url('admin_' . substr($match['name'], 6, -7)) . '?deleted=' . htmlspecialchars($codenamePerson));
}
?>
