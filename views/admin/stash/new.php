<?php

$title = 'Spy Agency - Planques - Admin';
$styleFolder = '../../../styles/';
$styleSubFolder = 'admin/stash/editStash_';

use App\Controllers\MissionsController;
use App\Controllers\StashsController;
use App\Controllers\MissionsStashsController;
use App\Controllers\CountriesController;

$missionsController = new MissionsController;
$stashsController = new StashsController;
$missionsStashsController = new MissionsStashsController;
$countriesController = new CountriesController;

//Récupération des listes
$missionsList = $missionsController->getMissionsList();
$stashsList = $stashsController->getStashsList('id_stash');
$countriesList = $countriesController->getCountriesList();

//Application des filtre de recherche sur les planques
$missionsFilters = $missionsStashsController->filterMissions($_GET);
$stashsListFiltered = $stashsController->filterStashs($_GET, $missionsFilters);

$stash = $stashsController->findStash($params['id']);
$stashArray[] = $stash;

//Hydratation des planques avec les missions
$missionsStashsController->hydrateStashs($stashArray, $missionsList);

//Validation des modifications et retour à la liste des planques
if (!empty($_POST)) {
    $stashsController->updateStash($_POST, $stash->getId_stash());
    header('location: /admin/stash');
}

?>

<script>
    let emptyGet = <?= json_encode(empty($_GET)) ?>;
</script>

<div class="stashEdit">
    <h1 class="stashEditTitle">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
        </svg>
        Administration / Édition de la planque 
        <?= $stash->getId_stash() ?>
    </h1>
    <form action="" method="POST" class="stash">
        <div class="headerStash">
            <div class="titleItem">
                <label for="idStash"><b>Code:</b></label>
                <input type="text" id="idStash" name="idStash" value="<?= $stash->getId_stash() ?>">
            </div>
        </div>
        <div class="infosStash">
            <div class="stashItem">
                <label for="addressStash"><b>Adresse:</b></label>
                <input type="text" id="addressStash" name="addressStash" value="<?= $stash->getAddress() ?>">
            </div>
            <div class="stashItem">
                <label for="countryStash"><b>Nationalité: </b></label>
                <select name="countryStash" id="countryStash" class="filter countryStashSelect">
                    <option value="" class="headerSelect">Sélectionnez un pays</option>
                    <?php foreach($countriesList as $country) : ?>
                        <option
                            value="<?= $country['country'] ?>"
                                <?php if ($country['country'] === $stash->getCountry()): ?>
                                    selected
                                <?php endif ?>
                        ><?= $country['country'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="stashItem">
                <div class="stashItem">
                    <label for="typeStash"><b>Type:</b></label>
                    <input type="text" id="typeStash" name="typeStash" value="<?= $stash->getType() ?>">
                </div>
            </div>
        </div>
        <div class="details">
            <div class="detailsBtn">
                <span>Détails</span>
            </div>
            <div class="detailsInfos">
                <div class="infosItem missions">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                        </svg>
                        <b>Mission(s) :</b>
                    </span>
                    <ul class="missionsList">
                        <?php if (count($stash->getMissions()) === 0): ?>
                            <p>Cette planque n'est affectée à aucune mission.</p>
                        <?php else: ?>
                            <?php foreach($stash->getMissions() as $mission): ?>
                                <li><?= $mission->getCode_name() ?></li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                    <div class="textMissions">
                        <p>Les missions ne sont pas modifiables.</p>
                        <p>Pour affecter une planque à une mission, veuillez vous rendre sur l'édition de la mission concernée.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="actionBtns">
            <button type="button" class="deleteBtn actionBtn">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="deleteSvg actionSvg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                    Supprimer
                </span>
            </button>
            <div class="CancelAndConfirmBtns">
                <button type="button" class="cancelBtn actionBtn">
                    <a href="<?= $router->url('admin_stash') ?>">
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
</div>