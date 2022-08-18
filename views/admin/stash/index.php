<?php

$title = 'Spy Agency - Planques - Admin';
$styleFolder = '../../../assets/styles/';
$styleSubFolder = 'admin/stash/';

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

//Hydratation des planques avec les missions
$missionsStashsController->hydrateStashs($stashsListFiltered, $missionsList);

?>

<script>
    let emptyGet = <?= json_encode(empty($_GET) || isset($_GET['deleted']) || isset($_GET['updated']) || isset($_GET['created'])) ?>;
</script>

<?php if (isset($_GET['deleted'])): ?>
    <p class="confirmMessage"> <?= 'La planque ' . $_GET['deleted'] . ' a bien été supprimée.' ?></p>
<?php elseif (isset($_GET['updated'])): ?>
    <p class="confirmMessage"> <?= 'La planque ' . $_GET['updated'] . ' a bien été mise à jour.' ?></p>
<?php elseif (isset($_GET['created'])): ?>
    <p class="confirmMessage"> <?= 'La planque ' . $_GET['created'] . ' a bien été créée.' ?></p>
<?php endif ?>
<h1 class="stashTitle">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
    </svg>
    Administration / Planques
    <?php if($isAdmin): ?>
        <button type="button" class="newBtn actionBtn">
            <a href="<?= $router->url('admin_stash_new') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="newSvg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                </svg>
                <span>Nouveau</span>
            </a>
        </button>
    <?php endif ?>
</h1>
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
    <div class="orderBy">
            <div class="orderByFilterBox">
                <label for="orderByFilter" class="orderByLabel">Tri par</label>
                <select name="orderByFilter" id="orderByFilter" class="orderBySelect filter">
                    <option value="" class="headerSelect">Sélectionnez le tri souhaité</option>
                    <?php foreach([
                        'code_name' => 'Code Name',
                        'address' => 'Adresse',
                        'country' => 'Pays',
                        'type' => 'Type'
                        ] as $key => $item) : ?>
                        <option
                            value="<?= $key ?>"
                            <?php if (isset($_GET['orderByFilter'])): ?>
                                <?php if ($key === $_GET['orderByFilter']): ?>
                                    selected
                                <?php endif ?>
                            <?php endif ?>
                        ><?= $item ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="orderByDirectionBox">
                <?php foreach(['ASC' => 'Ascendant ↑', 'DESC' => 'Descendant ↓'] as $key => $value): ?>
                    <div class="orderByRadio">
                        <input
                            type="radio"
                            id=<?= $key ?>
                            name="orderByDirection"
                            value=<?= $key ?>
                            class="filter"
                            <?php if (isset($_GET['orderByDirection'])): ?>
                                <?php if ($key === $_GET['orderByDirection']): ?>
                                    checked
                                <?php endif ?>
                            <?php endif ?>
                        >
                        <label for=<?= $key ?>><?= $value ?></label>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="filters">
            <div class="filtersItemAndTitle planque">
                <span class="filtersBlockTitle">Planque</span>
                <div class="filtersItem">
                    <div class="inputItems">
                        <div class="labelAndFilter">
                            <label for="codenameStashFilter" class="filterTitle">Code Name</label>
                            <input type="text" id="codenameStashFilter" name="codenameStashFilter" class="filter" value="<?= isset($_GET['codenameStashFilter']) ? $_GET['codenameStashFilter'] : '' ?>">
                        </div>
                        <div class="labelAndFilter">
                            <label for="addressStashFilter" class="filterTitle">Adresse</label>
                            <input type="text" id="addressStashFilter" name="addressStashFilter" class="filter" value="<?= isset($_GET['addressStashFilter']) ? $_GET['addressStashFilter'] : '' ?>">
                        </div>
                        <div class='labelAndFilter'>
                            <label for="countryStashFilter" class="filterTitle">Pays</label>
                            <select name="countryStashFilter" id="countryStashFilter" class="filter countryStashSelect">
                                <option value="" class="headerSelect">Sélectionnez un pays</option>
                                <?php foreach($countriesList as $country) : ?>
                                    <option
                                        value="<?= $country['country'] ?>"
                                        <?php if (isset($_GET['countryStashFilter']) && strlen($_GET['countryStashFilter']) > 0): ?>
                                            <?php if ($country['country'] === $_GET['countryStashFilter']): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    ><?= $country['country'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class='labelAndFilter labelAndFilterType'>
                        <label for="typeStashFilter" class="filterTitle">Type</label>
                        <select name="typeStashFilter[]" id="typeStashFilter" multiple class="filter typeStashFilter">
                            <option value="" class="headerSelect">Sélectionnez un ou plusieurs type(s)</option>
                            <?php foreach($stashsController->getTypes() as $stash) : ?>
                                <option
                                    value="<?= $stash  ?>"
                                    <?php if (isset($_GET['typeStashFilter'])): ?>
                                        <?php if (in_array($stash, $_GET['typeStashFilter'])): ?>
                                            selected
                                        <?php endif ?>
                                    <?php endif ?>
                                ><?= $stash  ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="filtersItemAndTitle mission">
                <span class="filtersBlockTitle">Mission</span>
                <div class="filtersItem">
                    <div class="stashsFilterLine">
                        <div class="labelAndFilter">
                            <label for="missionsFilter" class="filterTitle">Code Name</label>
                            <select name="missionsFilter[]" id="missionsFilter" multiple class="filter missionFilter">
                                <option value="headerFilter" disabled class="headerSelect">Sélectionnez une ou plusieurs mission(s)</option>
                                <?php foreach($missionsList as $mission) : ?>
                                    <option
                                        value="<?= $mission->getId_mission() ?>"
                                        <?php if (isset($_GET['missionsFilter'])): ?>
                                            <?php if (in_array($mission->getId_mission(), $_GET['missionsFilter'])): ?>
                                                selected
                                            <?php endif ?>
                                        <?php endif ?>
                                    ><?= $mission->getCode_name() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
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
<ul class="stashsList">
    <?php foreach($stashsListFiltered as $stash): ?>
        <li class="stash">
            <div class="headerStash">
                <p class="stashItem"><?= 'Planque ' . $stash->getCode_name() ?></p>
            </div>
            <div class="infosStash">
                <div class="stashItems">
                    <p class="stashItem"><b>Adresse: </b><?= $stash->getAddress() ?></p>
                    <p class="stashItem"><b>Pays: </b><?= $stash->getCountry() ?></p>
                    <p class="stashItem"><b>Type: </b><?= $stash->getType() ?></p>
                </div>
                <?php if($isAdmin) : ?>
                    <div class="actionBtns">
                        <a href="<?= 'stash/' . $stash->getId_stash() .'/edit'?>" class="editBtn actionBtn">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="editSvg actionSvg" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                                Modifier
                            </span>
                        </a>
                        <form action="<?= $router->url('admin_stash_delete', ['id' => $stash->getId_stash()]) ?>" method="POST" class="deleteBtn actionBtn"
                            onsubmit="
                                <?php if (!empty($stash->getMissions())): ?>
                                    return confirm('***** ATTENTION ***** \n<?= $stashsController->checkMissionBeforeDelete($stash) ?>\n\nVoulez-vous tout de même la supprimer ?')
                                <?php else: ?>
                                    return confirm('Voulez-vous vraiment supprimer la planque <?=$stash->getCode_name() ?> ?')
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
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach ?>
</ul>