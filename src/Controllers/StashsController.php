<?php

namespace App\Controllers;

use App\Class\Connection;
use App\Model\Stashs;
use App\Model\Stash;

class StashsController
{
    public function getStashsList(string $sortBy): array
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->getStashsList($sortBy);
    }

    public function getTypes(): array
    {
        $stashsListByType = $this->getStashsList('type');

        $types = [];
        foreach($stashsListByType as $stash) {
            if (!in_array($stash->getType(), $types)) {
                $types[] = $stash->getType();
            }
        }       

        return $types;
    }

    /**
     * Permet de créer une chaîne de caractères lisible dans les requêtes SQL, utilisé ici pour filtrer
     *
     * @param array $arrayToConvert
     * @return string
     */
    public function convertToStringList(array $arrayToConvert): string
    {
        $newString = '';
            foreach($arrayToConvert as $item) {
                $newString .= "'" . $item . "'" . ",";
        }
        return $newString = substr($newString, 0, -1);
    }

    public function filterStashs(array $filterOptions, array $missionsFilter, int $page): array
    {
        $filterConditions = [];
        $filterSort = '';

        if (isset($filterOptions['codenameStashFilter'])) {
            $filterConditions[] = "LOWER(code_name) LIKE '%" . strtolower($filterOptions['codenameStashFilter']) . "%'";
        }

        if (isset($filterOptions['addressStashFilter'])) {
            $filterConditions[] = "LOWER(address) LIKE '%" . strtolower($filterOptions['addressStashFilter']) . "%'";
        }

        if (isset($filterOptions['countryStashFilter']) && strlen($filterOptions['countryStashFilter']) > 0) {
            $filterConditions[] = "country = '" . $filterOptions['countryStashFilter'] . "'";
        }

        if (isset($filterOptions['typeStashFilter'])) {
            $filterConditions[] = "type IN (" . $this->convertToStringList($filterOptions['typeStashFilter']) . ")";
        }

        if (isset($filterOptions['missionsFilter'])) {
            $filterConditions[] = "id_stash IN (" . implode(",", $missionsFilter) . ")";
        }

        if (isset($filterOptions['orderByFilter']) && isset($filterOptions['orderByDirection'])  && strlen($filterOptions['orderByFilter']) > 0) {
            $filterSort = $filterOptions['orderByFilter'] . ' ' . $filterOptions['orderByDirection'];
        }

        $stashs = new Stashs((new Connection)->getPdo());

        return $stashs->filterStashs($filterConditions, $filterSort, $page);
    }

    public function findStash(int $idStash): Stash
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->findStash($idStash);
    }

    public function updateStash(array $stash, int $id_stash): void
    {
        $stashs = new Stashs((new Connection)->getPdo());
        $stashs->updateStash($stash, $id_stash);
    }

    public function checkMissionBeforeDelete(Stash $stash): string
    {
        if (!empty($stash->getMissions())) {
            $missionIds = [];
            foreach($stash->getMissions() as $mission) {
                $missionIds[] = $mission->getId_mission() . ' - ' . strtoupper($mission->getCode_name());
            }
        }
        return 
            "La planque " . $stash->getCode_name() . " est encore affectée "
            . (count($stash->getMissions()) > 1 ? 'aux missions:\\n' : ' à la mission:\\n')
            . implode('\\n', $missionIds);
    }

    public function deleteStash(int $id_stash): void
    {
        $stashs = new Stashs((new Connection)->getPdo());
        $stashs->deleteStash($id_stash);
    }

    public function createStash(array $newStash): int
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->createStash($newStash);
    }

    public function getCountriesStashs(): array
    {
        $stashsListByCountry = $this->getStashsList('country');

        $countriesStashs = [];
        foreach($stashsListByCountry as $stash) {
            if (!in_array($stash->getCountry(), $countriesStashs)) {
                $countriesStashs[] = $stash->getCountry();
            }
        }

        return $countriesStashs;
    }

    public function controlsRules(array $stashPost, Stash $editedStash = null): array
    {
        $errors = [];

        $stashItems = 
        [
            'codenameStash' => 'Le <b>CODE NAME</b> ',
            'addressStash' => 'L\' <b>ADRESSE</b> ',
            'countryStash' => 'Le <b>PAYS</b> ',
            'typeStash' => 'Le <b>TYPE</b> '
        ];

        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($stashPost as $keyPost => $itemPost) {
            foreach($stashItems as $key => $item) {
                if ($itemPost === '' && $keyPost === $key) {
                    $errors['blank_' . $key] = '<li class="error">' . $item . ' est obligatoire sur la planque</li>';
                }
            }
        }

        // Vérifie l'unicité du champs CodeName
        $stashsList = $this->getStashsList('id_stash');
        if ($editedStash === null || $editedStash->getCode_name() !== $stashPost['codenameStash']) {
            foreach($stashsList as $stash) {
                if (strtolower($stash->getCode_name()) == strtolower($stashPost['codenameStash'])) {
                    $errors['uniqueCodeName'] = '<li class="error">Le <b>CODE NAME</b> saisi existe déjà</li>';
                }
            }
        }

        // Vérifie que si on change le pays de la planque, celle ci n'est pas affecté à une mission, sinon message d'erreur
        if ($editedStash !== null) {
            if ($stashPost['countryStash'] !== $editedStash->getCountry()) {
                if (!empty($editedStash->getMissions())) {
                    foreach ($editedStash->getMissions() as $mission) {
                        if ($stashPost['countryStash'] !== $mission->getCountry()) {
                            $errors['countryChange_' . $editedStash->getId_stash() . '-' . $mission->getId_mission()] = 
                            "<li class='error'>Cette planque est affectée à la mission <b>" . strtoupper($mission->getCode_name()) ."</b> dont la pays est <b>" . strtoupper($mission->getCountry()) . 
                            "</b> or la mission doit avoir sa ou ses planque(s) dans le même pays. Si vous souhaitez vraiment changer le pays, veuillez d'abord la désaffecter de la mission concernée.</li>";
                        }
                    }
                }
            }
        }

        return $errors;
    }
}