<?php

$title = 'Spy Agency - Spécialités - Admin';
$styleFolder = '../../../styles/';
$styleSubFolder = 'admin/speciality/editSpeciality_';

use App\Controllers\MissionsController;
use App\Controllers\SpecialitiesController;
use App\Controllers\PersonsController;
use App\Controllers\AgentsSpecialitiesController;

$missionsController = new MissionsController;
$specialitiesController = new SpecialitiesController;
$personsController = new PersonsController;
$agentsSpecialitiesController = new AgentsSpecialitiesController;

//Récupération des listes
$missionsList = $missionsController->getMissionsList();
$specialitiesList = $specialitiesController->getSpecialitiesList('id_speciality');
$agentsList = $personsController->getPersonsLists('id')['agentsList'];

if (!empty($params)) {
    //Récupération de la spécialité à éditer
    $speciality = $specialitiesController->findSpeciality($params['id']);
    $specialityArray[] = $speciality;
    
    //Hydratation des spécialités avec les agents et les missions
    $agentsSpecialitiesController->hydrateSpecialities($specialityArray, $agentsList);
    $missionsController->hydrateSpecialities($specialityArray);
    
    //Validation des modifications et retour à la liste des spécialités
    if (!empty($_POST)) {
        $specialitiesController->updateSpeciality($_POST, $speciality->getId_speciality());
        header('location: ' . $router->url('admin_speciality') . '?updated=' . $_POST['nameSpeciality']);
    }
} else {
    //Création de la nouvelle spécialité et retour à la liste des spécialités
    if (!empty($_POST)) {
        $newIdSpeciality = $specialitiesController->createSpeciality($_POST);
        header('location: ' . $router->url('admin_speciality') . '?created=' . $_POST['nameSpeciality']);
    }
}


?>

<script>
    let emptyGet = <?= json_encode(empty($_GET)) ?>;
</script>

<div class="specialityEdit">
    <h1 class="specialityEditTitle">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
        </svg>
        <?= !empty($params) ? 'Administration / Édition de la spécialité ' . $speciality->getId_speciality() : 'Administration / Nouvelle spécialité'?>
    </h1>
    <form action="" method="POST" class="speciality">
        <div class="headerSpeciality">
            <div class="titleItem">
                <label for="idSpeciality"><b>Code:</b></label>
                <input type="text" id="idSpeciality" name="idSpeciality" value="<?= !empty($params) ? $speciality->getId_speciality() : '' ?>">
            </div>
        </div>
        <div class="infosSpeciality">
            <div class="specialityItems">
                <label for="nameSpeciality"><b>Titre:</b></label>
                <input type="text" id="nameSpeciality" name="nameSpeciality" value="<?= !empty($params) ? $speciality->getName() : '' ?>">
            </div>
        </div>
        <?php if(!empty($params)): ?>
        <div class="details">
            <div class="detailsBtn">
                <span>Détails</span>
            </div>
            <div class="detailsInfos">
                <div class="infosItem agents">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512">
                            <path d="M377.7 338.8l37.15-92.87C419 235.4 411.3 224 399.1 224h-57.48C348.5 209.2 352 193 352 176c0-4.117-.8359-8.057-1.217-12.08C390.7 155.1 416 142.3 416 128c0-16.08-31.75-30.28-80.31-38.99C323.8 45.15 304.9 0 277.4 0c-10.38 0-19.62 4.5-27.38 10.5c-15.25 11.88-36.75 11.88-52 0C190.3 4.5 181.1 0 170.7 0C143.2 0 124.4 45.16 112.5 88.98C63.83 97.68 32 111.9 32 128c0 14.34 25.31 27.13 65.22 35.92C96.84 167.9 96 171.9 96 176C96 193 99.47 209.2 105.5 224H48.02C36.7 224 28.96 235.4 33.16 245.9l37.15 92.87C27.87 370.4 0 420.4 0 477.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 420.4 420.1 370.4 377.7 338.8zM176 479.1L128 288l64 32l16 32L176 479.1zM271.1 479.1L240 352l16-32l64-32L271.1 479.1zM320 186C320 207 302.8 224 281.6 224h-12.33c-16.46 0-30.29-10.39-35.63-24.99C232.1 194.9 228.4 192 224 192S215.9 194.9 214.4 199C209 213.6 195.2 224 178.8 224h-12.33C145.2 224 128 207 128 186V169.5C156.3 173.6 188.1 176 224 176s67.74-2.383 96-6.473V186z"/>
                        </svg>
                        <b>Agent(s) :</b>
                    </span>
                    <ul class="agentsList">
                        <?php if (count($speciality->getAgents()) === 0): ?>
                            <p>Cette spécialité ne concerne aucune agent.</p>
                        <?php else: ?>
                            <?php foreach($speciality->getAgents() as $agent): ?>
                                <li><?= $agent->getFirstname() . ' ' . $agent->getLastname() ?></li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                    <div class="textMissions">
                        <p>Les agents ne sont pas modifiables.</p>
                        <p>Pour affecter une spécialité à un agent, veuillez vous rendre sur l'édition de l'agent concerné.</p>
                    </div>
                </div>
                <div class="infosItem missions">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                        </svg>
                        <b>Mission(s) :</b>
                    </span>
                    <ul class="missionsList">
                        <?php if (count($speciality->getMissions()) === 0): ?>
                            <p>Cette spécialité ne concerne aucune mission.</p>
                        <?php else: ?>
                            <?php foreach($speciality->getMissions() as $mission): ?>
                                <li><?= $mission->getCode_name() ?></li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                    <div class="textMissions">
                        <p>Les missions ne sont pas modifiables.</p>
                        <p>Pour affecter une spécialité à une mission, veuillez vous rendre sur l'édition de la mission concernée.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
        <div class="actionBtns">
            <div class="CancelAndConfirmBtns">
                <button type="button" class="cancelBtn actionBtn">
                    <a href="<?= $router->url('admin_speciality') ?>">
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
    <?php if(!empty($params)): ?>
        <form action="<?= !empty($speciality->getMissions()) ? $router->url('admin_speciality_edit', $params) : $router->url('admin_speciality_delete', ['id' => $speciality->getId_speciality()]) ?>" method="POST" class="deleteBtn actionBtn"
            onsubmit="
                <?php if (!empty($speciality->getMissions())): ?>
                    return alert('***** ATTENTION ***** \n<?= $specialitiesController->checkMissionBeforeDelete($speciality)?>')
                <?php elseif(!empty($speciality->getAgents())): ?>
                    return confirm('***** ATTENTION ***** \n<?= $specialitiesController->checkAgentBeforeDelete($speciality)?>\n\nVoulez-vous tout de même la supprimer ?')
                <?php else: ?>
                    return confirm('Voulez-vous vraiment supprimer la spécialité <?=$speciality->getId_speciality() . ' - ' . strtoupper($speciality->getName()) ?> ?')
                <?php endif ?>
            ">
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