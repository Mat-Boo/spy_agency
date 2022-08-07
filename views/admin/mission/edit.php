<?php

$title = 'Spy Agency - Missions - Admin';
$styleFolder = '../../../styles/';
$styleSubFolder = 'admin/mission/editMission_';

use App\Controllers\AgentsSpecialitiesController;
use App\Controllers\MissionsController;
use App\Controllers\PersonsController;
use App\Controllers\StashsController;
use App\Controllers\MissionsPersonsController;
use App\Controllers\MissionsStashsController;
use App\Controllers\SpecialitiesController;
use App\Controllers\CountriesController;

$missionsController = new MissionsController;
$personsController = new PersonsController;
$stashsController = new StashsController;
$missionsPersonsController = new MissionsPersonsController;
$missionsStashsController = new MissionsStashsController;
$specialitiesController = new SpecialitiesController;
$countriesController = new CountriesController;
$agentsSpecialities = new AgentsSpecialitiesController;

//Récupération des listes
$personsLists = $personsController->getPersonsLists('nationality, lastname, firstname');
$stashsList = $stashsController->getStashsList('country, type');
$specialitiesList = $specialitiesController->getSpecialitiesList('name');
$countriesList = $countriesController->getCountriesList();
$nationalitiesPersonsLists = $personsController->getNationalitiesPersons();
$countriesStashs = $stashsController->getCountriesStashs();

//Application des filtre de recherche sur les missions
$personsFilters = $missionsPersonsController->filterPersons($_GET);
$stashsFilters = $missionsStashsController->getStashsFilters($_GET);

if (!empty($params)) {
    //Récupération de la mission à éditer
    $mission = $missionsController->findMission($params['id']);
    $missionArray[] = $mission;
    
    //Hydratation de la mission éditée avec les personnes (agents, contacts, cibles) et les planques
    $missionsPersonsController->hydrateMissions($missionArray, $personsLists, $personsFilters);
    $missionsStashsController->hydrateMissions($missionArray, $stashsList, $stashsFilters);
    
    //Hydratation des agents listés avec leurs spécialités
    $agentsSpecialities->hydrateAgents($personsLists['agentsList'], $specialitiesList);
    
    //Validation des modifications et retour à la liste des missions
    if (!empty($_POST)) {
        $errors = $missionsController->controlsRules($_POST, $personsLists, $stashsList, $specialitiesList);
        if (empty($errors)) {
            $missionsController->updateMission($_POST, $mission->getId_mission());
            $missionsPersonsController->updateMissionsPersons($_POST, $mission->getId_mission());
            $missionsStashsController->updateMissionsStashs($_POST, $mission->getId_mission());
            header('Location: ' . $router->url('admin_mission') . '?updated=' . $_POST['codeNameMission']);
        } else {
            $displayErrors = implode('', $errors);
        }
    }
} else {
    //Création de la nouvelle mission et retour à la liste des missions
    if (!empty($_POST)) {
        $errors = $missionsController->controlsRules($_POST, $personsLists, $stashsList, $specialitiesList);
        if (empty($errors)) {
            $newIdMission = $missionsController->createMission($_POST);
            $missionsPersonsController->createMissionPerson($_POST, $newIdMission);
            $missionsStashsController->createMissionStash($_POST, $newIdMission);
            header('Location: ' . $router->url('admin_mission') . '?created=' . $_POST['codeNameMission']);
        } else {
            $displayErrors = implode('', $errors);
        }
    }
}
?>

<div class="missionEdit">
    <?php if (isset($displayErrors)): ?>
        <ul class="alertMessage">
            <?= $displayErrors ?>
        </ul>
    <?php endif ?>
    <h1 class="missionEditTitle">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
        </svg> 
        <?= !empty($params) ? 'Administration / Édition de la mission ' . $mission->getId_mission() : 'Administration / Nouvelle mission'?>
    </h1>
    <form action="" method="POST" class="mission">
        <div class="headerMission">
            <div class="titleItem">
                <label for="titleMission"><b>Titre:</b></label>
                <input type="text" id="titleMission" name="titleMission" value="<?= isset($_POST['titleMission']) ? $_POST['titleMission'] : (!empty($params) ? $mission->getTitle() :'') ?>">
            </div>
            <div class="filter statusMission">
                <?php foreach($missionsController->getStatus() as $status) : ?>
                    <div style="background:<?= $status['background'] ?>">
                        <input
                            type="radio"
                            id="<?= $status['status'] ?>"
                            name="status"
                            value="<?= $status['status'] ?>"
                            <?php if (isset($_POST['status'])): ?>
                                <?php if ($status['status'] === $_POST['status']): ?>
                                    checked
                                <?php endif ?>
                            <?php elseif (!empty($params)): ?>
                                <?php if ($status['status'] === $mission->getStatus()['status']): ?>
                                    checked
                                <?php endif ?>
                            <?php endif ?>
                        >
                        <label for="<?= $status['status'] ?>"><?= $status['status'] ?></label>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="infosMission">
            <div class="missionItem">
                <label for="codeNameMission"><b>Code Name:</b></label>
                <input type="text" id="codeNameMission" name="codeNameMission" value="<?= isset($_POST['codeNameMission']) ? $_POST['codeNameMission'] : (!empty($params) ? $mission->getCode_name() : '') ?>">
            </div>
            <div class="missionItem">
                <label for="countryMission"><b>Pays: </b></label>
                <select name="countryMission" id="countryMission" class="filter countryMissionSelect">
                    <option value="" class="headerSelect">Sélectionnez un pays</option>
                    <?php foreach($countriesList as $country) : ?>
                        <option
                            value="<?= $country['country'] ?>"
                            <?php if (isset($_POST['countryMission'])): ?>
                                <?php if ($country['country'] === $_POST['countryMission']): ?>
                                    selected
                                <?php endif ?>
                            <?php elseif (!empty($params)): ?>
                                <?php if ($country['country'] === $mission->getCountry()): ?>
                                    selected
                                <?php endif ?>
                            <?php endif ?>
                        ><?= $country['country'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="missionItem">
                <label for="typeMission"><b>Type: </b></label>
                <input type="text" id="typeMission" name="typeMission" value="<?= isset($_POST['typeMission']) ? $_POST['typeMission'] : (!empty($params) ? $mission->getType() : '') ?>">
            </div>
            <div class="missionItem">
                <label for="startDateMission"><b>Date de début: </b></label>
                <input type="date" id="startDateMission" name="startDateMission" value="<?= isset($_POST['startDateMission']) ? $_POST['startDateMission'] : (!empty($params) ? $mission->getStart_date() : '') ?>">
            </div>
            <div class="missionItem">
                <label for="endDateMission"><b>Date de fin: </b></label>
                <input type="date" id="endDateMission" name="endDateMission" value="<?= isset($_POST['endDateMission']) ? $_POST['endDateMission'] : (!empty($params) ? $mission->getEnd_date() : '') ?>">
            </div>
        </div>
        <div class="details">
            <div class="detailsBtn">
                <span>Détails</span>
            </div>
            <div class="detailsInfos">
                <div class="descriptionItem">
                    <label for="descriptionMission">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                            <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <b>Description: </b>
                    </label>
                    <textarea id="descriptionMission" name="descriptionMission" rows="5"><?= isset($_POST['descriptionMission']) ? $_POST['descriptionMission'] : (!empty($params) ? $mission->getDescription() : '') ?></textarea>
                </div>
                <div class="InfosItems">
                    <?php foreach(['agent', 'contact', 'target'] as $person): ?>
                        <div class="infosItem <?= $person . 's' ?>">
                            <label for="<?= $person ?>mission">
                                <?php if($person === 'agent'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512">
                                        <path d="M377.7 338.8l37.15-92.87C419 235.4 411.3 224 399.1 224h-57.48C348.5 209.2 352 193 352 176c0-4.117-.8359-8.057-1.217-12.08C390.7 155.1 416 142.3 416 128c0-16.08-31.75-30.28-80.31-38.99C323.8 45.15 304.9 0 277.4 0c-10.38 0-19.62 4.5-27.38 10.5c-15.25 11.88-36.75 11.88-52 0C190.3 4.5 181.1 0 170.7 0C143.2 0 124.4 45.16 112.5 88.98C63.83 97.68 32 111.9 32 128c0 14.34 25.31 27.13 65.22 35.92C96.84 167.9 96 171.9 96 176C96 193 99.47 209.2 105.5 224H48.02C36.7 224 28.96 235.4 33.16 245.9l37.15 92.87C27.87 370.4 0 420.4 0 477.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 420.4 420.1 370.4 377.7 338.8zM176 479.1L128 288l64 32l16 32L176 479.1zM271.1 479.1L240 352l16-32l64-32L271.1 479.1zM320 186C320 207 302.8 224 281.6 224h-12.33c-16.46 0-30.29-10.39-35.63-24.99C232.1 194.9 228.4 192 224 192S215.9 194.9 214.4 199C209 213.6 195.2 224 178.8 224h-12.33C145.2 224 128 207 128 186V169.5C156.3 173.6 188.1 176 224 176s67.74-2.383 96-6.473V186z"/>
                                    </svg>
                                <?php elseif($person === 'contact'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                        <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                                    </svg>
                                <?php elseif($person === 'target'): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10zm0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                                        <path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg> 
                                <?php endif ?>
                                <b><?=$person === 'target' ? 'Cible' : ucfirst($person) ?>(s) :</b>
                            </label>
                            <span class="descrSelect">Nom Prénom</span>
                            <select name="<?= $person ?>Mission[]" id="<?= $person ?>Mission" multiple class="<?= $person ?>Mission">
                                <option value="headerFilter" disabled class="headerSelect">Sélectionnez <?= $person === 'target' ? 'une' : 'un' ?> ou plusieurs <?= $person ?>(s)</option>
                                <?php foreach($nationalitiesPersonsLists as $key => $nationalitiesPersonsList): ?>
                                    <?php foreach($nationalitiesPersonsList as $nationality): ?>
                                        <?php if ($person === substr($key, 0, -14)): ?>
                                            <optgroup label=<?= $nationality ?>>
                                                <?php foreach($personsLists[$person . 'sList'] as ${$person}) : ?>
                                                    <?php if(${$person}->getNationality() === $nationality): ?>
                                                        <option
                                                            <?php if($person === 'agent'): ?>
                                                                id=<?= 'option_' . $agent->getId() ?>
                                                                class="optionAgent"
                                                            <?php endif ?>
                                                            value="<?= ${$person}->getId() ?>"
                                                            <?php if (isset($_POST[$person . 'Mission'])): ?>
                                                                <?php foreach($_POST[$person . 'Mission'] as ${$person . 'Mission'}): ?>
                                                                    <?php if (${$person}->getId() == ${$person . 'Mission'}): ?>
                                                                        selected
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php elseif (!empty($params)): ?>
                                                                <?php foreach($mission->{'get' . ucfirst($person) . 's'}() as ${$person . 'Mission'}): ?>
                                                                    <?php if (${$person}->getId() === ${$person . 'Mission'}->getId()): ?>
                                                                        selected
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            <?php endif ?>
                                                        >
                                                            <?= ${$person}->getLastname() . ' ' . ${$person}->getfirstname() ?>
                                                        </option>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </optgroup>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            </select>
                            <?php foreach($personsLists['agentsList'] as $agent): ?>
                                <?php if($person === 'agent'): ?>
                                    <div id=<?= 'specialitiesHover_' . $agent->getId() ?> class="specialitiesHover">
                                        <span>Spécialités :</span>
                                        <ul>
                                            <?php foreach($agent->getSpecialities() as $speciality): ?>
                                                <li>
                                                    <?= $speciality->getName() ?>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                    <div class="infosItem stashs">
                        <label for="missionStash">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                            </svg>
                            <b>Planque(s) :</b>
                        </label>
                        <span class="descrSelect">Code Name | Type | Adresse</span>
                        <select name="stashMission[]" id="stashMission" multiple class="stashMission">
                            <option value="headerFilter" disabled class="headerSelect">Sélectionnez une ou plusieurs planque(s)</option>
                            <?php foreach($countriesStashs as $country): ?>
                                <optgroup label=<?= $country ?>>
                                    <?php foreach($stashsList as $stash) : ?>
                                        <?php if($stash->getCountry() === $country): ?>
                                            <option
                                                value="<?= $stash->getId_stash() ?>"
                                                <?php if(isset($_POST['stashMission'])): ?>
                                                    <?php foreach($_POST['stashMission'] as $stashMission): ?>
                                                        <?php if ($stash->getId_stash() == $stashMission): ?>
                                                            selected
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php elseif (!empty($params)): ?>
                                                    <?php foreach($mission->getStashs() as $stashMission): ?>
                                                        <?php if ($stash->getId_stash() === $stashMission->getId_stash()): ?>
                                                            selected
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            >
                                                <div>
                                                    <p><?= $stash->getCode_name() . ' | ' ?></p>
                                                    <p><?= $stash->getType() . ' | ' ?></p>
                                                    <p><?= $stash->getAddress() ?></p>
                                                </div>
                                            </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </optgroup>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="specialityItem">
                    <label for="missionSpeciality">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M423.51 61.53c-5.02,-5.03 -10.92,-7.51 -17.75,-7.51 -6.82,0 -12.8,2.48 -17.75,7.51l-27.05 26.97c-7.25,-4.7 -14.93,-8.8 -22.95,-12.47 -8.02,-3.67 -16.22,-6.82 -24.5,-9.55l0 -41.48c0,-7 -2.38,-12.89 -7.25,-17.75 -4.86,-4.86 -10.75,-7.25 -17.75,-7.25l-52.05 0c-6.66,0 -12.45,2.39 -17.49,7.25 -4.95,4.86 -7.43,10.75 -7.43,17.75l0 37.98c-8.7,2.04 -17.15,4.6 -25.26,7.76 -8.19,3.16 -15.95,6.74 -23.29,10.75l-29.96 -29.53c-4.69,-4.94 -10.4,-7.5 -17.32,-7.5 -6.83,0 -12.71,2.56 -17.75,7.5l-36.43 36.54c-5.03,5.03 -7.51,10.92 -7.51,17.73 0,6.83 2.48,12.81 7.51,17.75l26.97 27.06c-4.7,7.26 -8.79,14.93 -12.46,22.95 -3.68,8.02 -6.83,16.22 -9.56,24.49l-41.47 0c-7.01,0 -12.9,2.39 -17.76,7.26 -4.86,4.86 -7.25,10.75 -7.25,17.75l0 52.05c0,6.65 2.39,12.46 7.25,17.5 4.86,4.94 10.75,7.42 17.76,7.42l37.97 0c2.04,8.7 4.6,17.15 7.76,25.25 3.17,8.2 6.75,16.13 10.75,23.81l-29.52 29.44c-4.95,4.7 -7.51,10.41 -7.51,17.33 0,6.82 2.56,12.71 7.51,17.75l36.53 36.95c5.03,4.69 10.92,7 17.75,7 6.82,0 12.79,-2.31 17.75,-7l27.04 -27.48c7.26,4.69 14.94,8.78 22.96,12.46 8.02,3.66 16.21,6.83 24.49,9.55l0 41.48c0,7 2.39,12.88 7.25,17.74 4.86,4.87 10.76,7.26 17.75,7.26l52.05 0c6.66,0 12.46,-2.39 17.5,-7.26 4.94,-4.86 7.42,-10.74 7.42,-17.74l0 -37.98c8.7,-2.04 17.15,-4.6 25.25,-7.76 8.2,-3.16 16.14,-6.74 23.81,-10.75l29.44 29.53c4.7,4.95 10.49,7.5 17.51,7.5 7.07,0 12.87,-2.55 17.57,-7.5l36.95 -36.53c4.69,-5.04 7,-10.92 7,-17.75 0,-6.82 -2.31,-12.8 -7,-17.75l-27.48 -27.05c4.7,-7.26 8.79,-14.93 12.46,-22.96 3.66,-8.01 6.83,-16.21 9.56,-24.49l41.47 0c7,0 12.88,-2.4 17.74,-7.25 4.87,-4.87 7.26,-10.75 7.26,-17.75l0 -52.05c0,-6.66 -2.39,-12.45 -7.26,-17.5 -4.86,-4.95 -10.74,-7.42 -17.74,-7.42l-37.98 0c-2.04,-8.36 -4.6,-16.73 -7.76,-25 -3.16,-8.37 -6.74,-16.21 -10.75,-23.56l29.53 -29.95c4.95,-4.69 7.5,-10.41 7.5,-17.32 0,-6.83 -2.55,-12.71 -7.5,-17.75l-36.53 -36.43zm-48.41 257.98c-22.72,42.52 -67.54,71.44 -119.1,71.44 -51.58,0 -96.37,-28.92 -119.09,-71.42 2.66,-11.61 7.05,-21.74 19.9,-28.84 17.76,-9.89 48.34,-9.15 62.89,-22.24l20.1 52.78 10.1 -28.77 -4.95 -5.42c-3.72,-5.44 -2.44,-11.62 4.46,-12.74 2.33,-0.37 4.95,-0.14 7.47,-0.14 2.69,0 5.68,-0.25 8.22,0.32 6.41,1.41 7.07,7.62 3.88,12.56l-4.95 5.42 10.11 28.77 18.18 -52.78c13.12,11.8 48.43,14.18 62.88,22.24 12.89,7.22 17.26,17.24 19.9,28.82zm-159.11 -86.45c-1.82,0.03 -3.31,-0.2 -4.93,-1.1 -2.15,-1.19 -3.67,-3.24 -4.7,-5.55 -2.17,-4.86 -3.89,-17.63 1.57,-21.29l-1.02 -0.66 -0.11 -1.41c-0.21,-2.57 -0.26,-5.68 -0.32,-8.95 -0.2,-12 -0.45,-26.56 -10.37,-29.47l-4.25 -1.26 2.81 -3.38c8.01,-9.64 16.38,-18.07 24.82,-24.54 9.55,-7.33 19.26,-12.2 28.75,-13.61 9.77,-1.44 19.23,0.75 27.97,7.62 2.57,2.03 5.08,4.48 7.5,7.33 9.31,0.88 16.94,5.77 22.38,12.75 3.24,4.16 5.71,9.09 7.29,14.33 1.56,5.22 2.24,10.77 1.95,16.23 -0.53,9.8 -4.2,19.35 -11.61,26.33 1.3,0.04 2.53,0.33 3.61,0.91 4.14,2.15 4.27,6.82 3.19,10.75 -1.08,3.28 -2.44,7.08 -3.73,10.28 -1.56,4.31 -3.85,5.12 -8.27,4.65 -9.93,43.45 -69.98,44.93 -82.53,0.04zm40.01 -135.69c87.64,0 158.63,71.04 158.63,158.63 0,87.64 -71.04,158.63 -158.63,158.63 -87.63,0 -158.63,-71.04 -158.63,-158.63 0,-87.64 71.04,-158.63 158.63,-158.63z"/>
                        </svg>
                        <b>Spécialité :</b>
                    </label>
                    <select name="specialityMission" id="specialityMission">
                        <option value="headerFilter" class="headerSelect">Sélectionnez une spécialité</option>
                        <?php foreach($specialitiesList as $speciality) : ?>
                            <option
                                value="<?= $speciality->getId_speciality() ?>"
                                <?php if(isset($_POST['specialityMission'])): ?>
                                    <?php if ($speciality->getId_speciality() == $_POST['specialityMission']): ?>
                                        selected
                                    <?php endif ?>
                                <?php elseif (!empty($params)): ?>
                                    <?php if ($speciality->getName() === $mission->getSpeciality()): ?>
                                        selected
                                    <?php endif ?>
                                <?php endif ?>
                            ><?= $speciality->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="actionBtns">
            <div class="CancelAndConfirmBtns">
                <button type="button" class="cancelBtn actionBtn">
                    <a href="<?= $router->url('admin_mission') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="cancelSvg actionSvg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        Annuler
                    </a>
                </button>
                <button type="submit" class="confirmBtn actionBtn">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="confirmSvg actionSvg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                        </svg>
                        Valider
                    </span>
                </button>
            </div>
        </div>
    </form>
    <?php if (!empty($params)): ?>
        <form action="<?= $router->url('admin_mission_delete', ['id' => $mission->getId_mission()]) ?>" method="POST" class="deleteBtn actionBtn"
            onsubmit="return confirm('Voulez-vous vraiment supprimer la mission <?=$mission->getId_mission() ?> ?')">
            <button type="submit" >
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="deleteSvg actionSvg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                    Supprimer
                </span>
            </button>
        </form>
    <?php endif ?>
</div>