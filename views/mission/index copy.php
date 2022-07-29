<?php

$title = $isAdmin ? 'Spy Agency - Missions - Admin' : 'Spy Agency - Missions';
$styleFolder = $isAdmin ? '../styles/mission/': 'styles/mission/';

use App\Connection;
use App\Model\Missions;
use App\model\Specialities;
use App\model\Agents;
use App\model\Contacts;
use App\model\Targets;
use App\model\Stashs;

$pdo = (new Connection)->getPdo();

$missions = new Missions($pdo);
$missionsList = $missions->getMissionsList();

$specialities = new Specialities($pdo);

$agents = new Agents($pdo);
$agentsListFiltered = $agents->filterAgents($_GET);
$contacts = new Contacts($pdo);
$contactsListFiltered = $contacts->filterContacts($_GET);
$targets = new Targets($pdo);
$targetsListFiltered = $targets->filterTargets($_GET);
$stashs = new Stashs($pdo);
$stashsListFiltered = $stashs->filterStashs($_GET);
$missionsListFiltered = $missions->filterMissions($_GET, $agentsListFiltered, $contactsListFiltered, $targetsListFiltered, $stashsListFiltered);

$agentsList = $agents->getAgentsList();
$agents->hydrateMissions($missionsListFiltered, $agentsList);

/* var_dump($missionsListFiltered); */

$contactsList = $contacts->getContactsList();
$contacts->hydrateMissions($missionsListFiltered, $contactsList);

$targetsList = $targets->getTargetsList();
$targets->hydrateMissions($missionsListFiltered, $targetsList);

$stashsList = $stashs->getStashsList();
$stashs->hydrateMissions($missionsListFiltered, $stashsList);

/* var_dump($_GET); */

?>

<script>
    let emptyGet = <?= json_encode(empty($_GET)) ?>;
</script>

<h1 class="missionTitle"><?= $isAdmin ? 'Administration / Missions' : 'Missions' ?></h1>

<form action="" method="GET" class="filtersBox">
    <div class="headerFilters">
        <div class="filtersTitle">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="sliders" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"/>
            </svg>
            <span>Filtres</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="chevronDownFilters" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>
        <button type="reset" class="cancelFiltersBtn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="cancelSvg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
            <span>Annuler les filtres</span>
        </button>
    </div>
    <div class="filtersAndApplyBtn">
        <div class="filters">
            <div class="filtersItemAndTitle">
                <span class="filtersBlockTitle">Mission</span>
                <div class="filtersItem">
                    <div class="missionsFiltersLine">
                        <div class="labelAndFilter">
                            <span class="filterTitle">CodeName</span>
                            <select name="idMissionFilter[]" id="idMissionFilter" multiple class="filter">
                                <option value="headerFilter" disabled class="headerSelect">Sélectionnez un ou plusieurs CodeName(s)</option>
                                <?php foreach($missionsList as $mission) : ?>
                                    <option
                                        value="<?= $mission->getId_mission() ?>"
                                        <?php if (isset($_GET['idMissionFilter'])): ?>
                                            <?php if (in_array($mission->getId_mission(), $_GET['idMissionFilter'])): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    ><?= $mission->getCode_name() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class='labelAndFilter'>
                            <span class="filterTitle">Type</span>
                            <select name="typeMissionFilter[]" id="typeMissionFilter" multiple class="filter">
                                <option value="headerFilter" disabled class="headerSelect">Sélectionnez un ou plusieurs type(s)</option>
                                <?php foreach($missions->getTypes() as $type) : ?>
                                    <option
                                        value="<?= $type ?>"
                                        <?php if (isset($_GET['typeMissionFilter'])): ?>
                                            <?php if (in_array($type, $_GET['typeMissionFilter'])): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    ><?= $type ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class='labelAndFilter'>
                            <span class="filterTitle">Spécialité</span>
                            <select name="specialityMissionFilter[]" id="specialityMissionFilter" multiple class="filter">
                                <option value="headerFilter" disabled class="headerSelect">Sélectionnez une ou plusieurs spécialité(s)</option>
                                <?php foreach($specialities->getSpecialitiesList() as $speciality) : ?>
                                    <option
                                        value="<?= $speciality->getId_speciality() ?>"
                                        <?php if (isset($_GET['specialityMissionFilter'])): ?>
                                            <?php if (in_array($speciality->getId_speciality(), $_GET['specialityMissionFilter'])): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    ><?= $speciality->getName() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="missionsFiltersLine">
                        <div class='labelAndFilter'>
                            <span class="filterTitle">Statut</span>
                            <div class="filter statusMissionFilter">
                                <?php foreach($missions->getStatus() as $status) : ?>
                                    <div style="background:<?= $status['background'] ?>">
                                        <input
                                            type="checkbox"
                                            id="<?= $status['status'] ?>"
                                            name=<?= "statusMissionFilter[" . str_replace(' ', '_', $status['status']) . "]" ?> class="filter"
                                            <?php if (isset($_GET['statusMissionFilter'])): ?>
                                                <?php if (array_key_exists(str_replace(' ', '_', $status['status']), $_GET['statusMissionFilter'])): ?>
                                                    checked
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                        <label for="<?= $status['status'] ?>"><?= $status['status'] ?></label>
                                    </div>
                                    <?php endforeach ?>
                            </div>
                        </div>
                        <div class='labelAndFilter'>
                            <label for="countryMissionFilter" class="filterTitle">Pays</label>
                            <input
                                type="text"
                                id="countryMissionFilter"
                                name="countryMissionFilter"
                                class="filter"
                                <?php if (isset($_GET['countryMissionFilter'])): ?>              
                                    value=<?= $_GET['countryMissionFilter'] ?>
                                <?php endif ?>
                            >
                        </div>
                        <div class='labelAndFilter'>
                            <label for="startDateMissionFilter" class="filterTitle">Date de début</label>
                            <input
                                type="date"
                                id="startDateMissionFilter"
                                name="startDateMissionFilter"
                                class="filter"
                                <?php if (isset($_GET['startDateMissionFilter'])): ?>              
                                    value=<?= $_GET['startDateMissionFilter'] ?>
                                <?php endif ?>
                            >
                        </div>
                        <div class='labelAndFilter'>
                            <label for="endDateMissionFilter" class="filterTitle">Date de fin</label>
                            <input
                                type="date"
                                id="endDateMissionFilter"
                                name="endDateMissionFilter"
                                class="filter"
                                <?php if (isset($_GET['endDateMissionFilter'])): ?>              
                                    value=<?= $_GET['endDateMissionFilter'] ?>
                                <?php endif ?>
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="filtersItemAndTitle">
                <span class="filtersBlockTitle">Agent</span>
                <div class="filtersItem">
                    <select name="agentFilter[]" id="agentFilter" multiple class="filter agentFilter">
                        <option value="headerFilter" disabled class="headerSelect">Sélectionnez un ou plusieurs agent(s)</option>
                        <?php foreach($agents->getAgents() as $agent) : ?>
                            <option 
                                value="<?= $agent->getId_agent() ?>"
                                <?php if (isset($_GET['agentFilter'])): ?>
                                    <?php if (in_array($agent->getId_agent(), $_GET['agentFilter'])): ?>
                                        selected
                                    <?php endif ?>
                                <?php endif ?>
                            ><?= $agent->getLastname() . ' ' . $agent->getfirstname() ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="filtersItemAndTitle">
                <span class="filtersBlockTitle">Contact</span>
                <div class="filtersItem">
                    <select name="contactFilter[]" id="contactFilter" multiple class="filter contactFilter">
                        <option value="headerFilter" disabled class="headerSelect">Sélectionnez un ou plusieurs contact(s)</option>
                        <?php foreach($contacts->getContacts() as $contact) : ?>
                            <option
                                value="<?= $contact->getId_contact() ?>"
                                <?php if (isset($_GET['contactFilter'])): ?>
                                    <?php if (in_array($contact->getId_contact(), $_GET['contactFilter'])): ?>
                                        selected
                                    <?php endif ?>
                                <?php endif ?>
                            ><?= $contact->getLastname() . ' ' . $contact->getFirstname() ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="filtersItemAndTitle">
                <span class="filtersBlockTitle">Cibles</span>
                <div class="filtersItem">
                    <select name="targetFilter[]" id="targetFilter" multiple class="filter targetFilter">
                        <option value="headerFilter" disabled class="headerSelect">Sélectionnez une ou plusieurs cible(s)</option>
                        <?php foreach($targets->getTargets() as $target) : ?>
                            <option
                                value="<?= $target->getId_target() ?>"
                                <?php if (isset($_GET['targetFilter'])): ?>
                                    <?php if (in_array($target->getId_target(), $_GET['targetFilter'])): ?>
                                        selected
                                    <?php endif ?>
                                <?php endif ?>
                            ><?= $target->getLastname() . ' ' . $target->getFirstname() ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="filtersItemAndTitle">
                <span class="filtersBlockTitle">Planques</span>
                <div class="filtersItem">
                    <select name="stashFilter[]" id="stashFilter" multiple class="filter stashFilter">
                        <option value="headerFilter" disabled class="headerSelect">Sélectionnez une ou plusieurs planque(s)</option>
                        <?php foreach($stashs->getTypes() as $stash) : ?>
                            <option
                                value="<?= $stash ?>"
                                <?php if (isset($_GET['stashFilter'])): ?>
                                    <?php if (in_array($stash, $_GET['stashFilter'])): ?>
                                        selected
                                    <?php endif ?>
                                <?php endif ?>
                            ><?= $stash ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="applyFiltersBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="confirmSvg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            <span>Appliquer</span>
        </button>
    </div>
</form>


    <ul class="missionsList">
        <?php foreach($missionsListFiltered as $mission): ?>
            <li
                class="mission"
                style="background:<?= $mission->getStatus()['background'] ?>">
                    <div class="headerMission">
                        <p class="missionItem"><?= $mission->getTitle() ?></p>
                        <p class="missionItem"><?= $mission->getStatus()['status'] ?></p>
                    </div>
                    <div class="infosMission">
                        <div class="missionItems">
                            <p class="missionItem"><b>Code Name: </b><?= $mission->getCode_name() ?></p>
                            <p class="missionItem"><b>Pays: </b><?= $mission->getCountry() ?></p>
                            <p class="missionItem"><b>Type: </b><?= $mission->getType() ?></p>
                            <p class="missionItem"><b>Du </b><?= $mission->getStart_date() ?></p>
                            <p class="missionItem"><b>Au </b><?= $mission->getEnd_date() ?></p>
                        </div>
                        <?php if($isAdmin) : ?>
                            <div class="actionBtns">
                                <button id="<?= $mission->getCode_name() . 'EditBtn' ?>" type="submit" class="editBtn actionBtn">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="editSvg actionSvg" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                        Modifier
                                    </span>
                                </button>
                                <button id="<?= $mission->getCode_name() . 'DeleteBtn' ?>" type="submit" class="deleteBtn actionBtn">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="deleteSvg actionSvg" viewBox="0 0 16 16">
                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                        </svg>
                                        Supprimer
                                    </span>
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="details">
                        <div class="detailsBtn">
                            <span>Détails</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="chevronDownDetails" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div class="detailsInfos">
                            <div class="infosItem description">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                    <b>Description :</b>
                                </span>
                                <p><?= $mission->getDescription() ?></p>
                            </div>
                            <div class="infosItem speciality">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 512 512">
                                        <path d="M423.51 61.53c-5.02,-5.03 -10.92,-7.51 -17.75,-7.51 -6.82,0 -12.8,2.48 -17.75,7.51l-27.05 26.97c-7.25,-4.7 -14.93,-8.8 -22.95,-12.47 -8.02,-3.67 -16.22,-6.82 -24.5,-9.55l0 -41.48c0,-7 -2.38,-12.89 -7.25,-17.75 -4.86,-4.86 -10.75,-7.25 -17.75,-7.25l-52.05 0c-6.66,0 -12.45,2.39 -17.49,7.25 -4.95,4.86 -7.43,10.75 -7.43,17.75l0 37.98c-8.7,2.04 -17.15,4.6 -25.26,7.76 -8.19,3.16 -15.95,6.74 -23.29,10.75l-29.96 -29.53c-4.69,-4.94 -10.4,-7.5 -17.32,-7.5 -6.83,0 -12.71,2.56 -17.75,7.5l-36.43 36.54c-5.03,5.03 -7.51,10.92 -7.51,17.73 0,6.83 2.48,12.81 7.51,17.75l26.97 27.06c-4.7,7.26 -8.79,14.93 -12.46,22.95 -3.68,8.02 -6.83,16.22 -9.56,24.49l-41.47 0c-7.01,0 -12.9,2.39 -17.76,7.26 -4.86,4.86 -7.25,10.75 -7.25,17.75l0 52.05c0,6.65 2.39,12.46 7.25,17.5 4.86,4.94 10.75,7.42 17.76,7.42l37.97 0c2.04,8.7 4.6,17.15 7.76,25.25 3.17,8.2 6.75,16.13 10.75,23.81l-29.52 29.44c-4.95,4.7 -7.51,10.41 -7.51,17.33 0,6.82 2.56,12.71 7.51,17.75l36.53 36.95c5.03,4.69 10.92,7 17.75,7 6.82,0 12.79,-2.31 17.75,-7l27.04 -27.48c7.26,4.69 14.94,8.78 22.96,12.46 8.02,3.66 16.21,6.83 24.49,9.55l0 41.48c0,7 2.39,12.88 7.25,17.74 4.86,4.87 10.76,7.26 17.75,7.26l52.05 0c6.66,0 12.46,-2.39 17.5,-7.26 4.94,-4.86 7.42,-10.74 7.42,-17.74l0 -37.98c8.7,-2.04 17.15,-4.6 25.25,-7.76 8.2,-3.16 16.14,-6.74 23.81,-10.75l29.44 29.53c4.7,4.95 10.49,7.5 17.51,7.5 7.07,0 12.87,-2.55 17.57,-7.5l36.95 -36.53c4.69,-5.04 7,-10.92 7,-17.75 0,-6.82 -2.31,-12.8 -7,-17.75l-27.48 -27.05c4.7,-7.26 8.79,-14.93 12.46,-22.96 3.66,-8.01 6.83,-16.21 9.56,-24.49l41.47 0c7,0 12.88,-2.4 17.74,-7.25 4.87,-4.87 7.26,-10.75 7.26,-17.75l0 -52.05c0,-6.66 -2.39,-12.45 -7.26,-17.5 -4.86,-4.95 -10.74,-7.42 -17.74,-7.42l-37.98 0c-2.04,-8.36 -4.6,-16.73 -7.76,-25 -3.16,-8.37 -6.74,-16.21 -10.75,-23.56l29.53 -29.95c4.95,-4.69 7.5,-10.41 7.5,-17.32 0,-6.83 -2.55,-12.71 -7.5,-17.75l-36.53 -36.43zm-48.41 257.98c-22.72,42.52 -67.54,71.44 -119.1,71.44 -51.58,0 -96.37,-28.92 -119.09,-71.42 2.66,-11.61 7.05,-21.74 19.9,-28.84 17.76,-9.89 48.34,-9.15 62.89,-22.24l20.1 52.78 10.1 -28.77 -4.95 -5.42c-3.72,-5.44 -2.44,-11.62 4.46,-12.74 2.33,-0.37 4.95,-0.14 7.47,-0.14 2.69,0 5.68,-0.25 8.22,0.32 6.41,1.41 7.07,7.62 3.88,12.56l-4.95 5.42 10.11 28.77 18.18 -52.78c13.12,11.8 48.43,14.18 62.88,22.24 12.89,7.22 17.26,17.24 19.9,28.82zm-159.11 -86.45c-1.82,0.03 -3.31,-0.2 -4.93,-1.1 -2.15,-1.19 -3.67,-3.24 -4.7,-5.55 -2.17,-4.86 -3.89,-17.63 1.57,-21.29l-1.02 -0.66 -0.11 -1.41c-0.21,-2.57 -0.26,-5.68 -0.32,-8.95 -0.2,-12 -0.45,-26.56 -10.37,-29.47l-4.25 -1.26 2.81 -3.38c8.01,-9.64 16.38,-18.07 24.82,-24.54 9.55,-7.33 19.26,-12.2 28.75,-13.61 9.77,-1.44 19.23,0.75 27.97,7.62 2.57,2.03 5.08,4.48 7.5,7.33 9.31,0.88 16.94,5.77 22.38,12.75 3.24,4.16 5.71,9.09 7.29,14.33 1.56,5.22 2.24,10.77 1.95,16.23 -0.53,9.8 -4.2,19.35 -11.61,26.33 1.3,0.04 2.53,0.33 3.61,0.91 4.14,2.15 4.27,6.82 3.19,10.75 -1.08,3.28 -2.44,7.08 -3.73,10.28 -1.56,4.31 -3.85,5.12 -8.27,4.65 -9.93,43.45 -69.98,44.93 -82.53,0.04zm40.01 -135.69c87.64,0 158.63,71.04 158.63,158.63 0,87.64 -71.04,158.63 -158.63,158.63 -87.63,0 -158.63,-71.04 -158.63,-158.63 0,-87.64 71.04,-158.63 158.63,-158.63z"/>
                                    </svg>
                                    <b>Spécialité :</b>
                                </span>
                                <p><?= $mission->getSpeciality() ?></p>
                            </div>
                            <div class="infosItem agents">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512">
                                        <path d="M377.7 338.8l37.15-92.87C419 235.4 411.3 224 399.1 224h-57.48C348.5 209.2 352 193 352 176c0-4.117-.8359-8.057-1.217-12.08C390.7 155.1 416 142.3 416 128c0-16.08-31.75-30.28-80.31-38.99C323.8 45.15 304.9 0 277.4 0c-10.38 0-19.62 4.5-27.38 10.5c-15.25 11.88-36.75 11.88-52 0C190.3 4.5 181.1 0 170.7 0C143.2 0 124.4 45.16 112.5 88.98C63.83 97.68 32 111.9 32 128c0 14.34 25.31 27.13 65.22 35.92C96.84 167.9 96 171.9 96 176C96 193 99.47 209.2 105.5 224H48.02C36.7 224 28.96 235.4 33.16 245.9l37.15 92.87C27.87 370.4 0 420.4 0 477.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 420.4 420.1 370.4 377.7 338.8zM176 479.1L128 288l64 32l16 32L176 479.1zM271.1 479.1L240 352l16-32l64-32L271.1 479.1zM320 186C320 207 302.8 224 281.6 224h-12.33c-16.46 0-30.29-10.39-35.63-24.99C232.1 194.9 228.4 192 224 192S215.9 194.9 214.4 199C209 213.6 195.2 224 178.8 224h-12.33C145.2 224 128 207 128 186V169.5C156.3 173.6 188.1 176 224 176s67.74-2.383 96-6.473V186z"/>
                                    </svg>
                                    <b>Agent(s) :</b>
                                </span>
                                <ul>
                                <?php foreach($mission->getAgents() as $agent): ?>
                                    <li>
                                        <?= $agent->getFirstname() . ' ' . $agent->getLastname() ?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="infosItem contacts">
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                    <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                                </svg  >
                                    <b>Contact(s) :</b>
                                </span>
                                <ul>
                                <?php foreach($mission->getContacts() as $contact): ?>
                                    <li>
                                        <?= $contact->getFirstname() . ' ' . $contact->getLastname() ?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="infosItem targets">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10zm0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                                        <path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>    
                                    <b>Cible(s) :</b>
                                </span>
                                <ul>
                                <?php foreach($mission->getTargets() as $target): ?>
                                    <li>
                                    <?= $target->getFirstname() . ' ' . $target->getLastname() ?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="infosItem stashs">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                                    </svg>
                                    <b>Planque(s) :</b>
                                </span>
                                <ul>
                                <?php foreach($mission->getStashs() as $stash): ?>
                                    <li>
                                        <?= $stash->getType() ?><br/>
                                        <?= $stash->getAddress() ?>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
            </li>
        <?php endforeach ?>
    </ul>
