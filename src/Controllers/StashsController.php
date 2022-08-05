<?php

namespace App\Controllers;

use App\Connection;
use App\model\Stashs;
use App\model\Stash;

class StashsController
{
    public function getStashsList(string $sortBy): array
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->getStashsList($sortBy);
    }

    public function getTypes(): array
    {
        $types = [];
        foreach($this->getStashsList('id_stash') as $stash) {
            if (!in_array($stash->getType(), $types)) {
                $types[] = $stash->getType();
            }
        }

        usort($types, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });

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

    public function filterStashs(array $filterOptions, array $missionsFilter): array
    {
        $stashIds = [];
        foreach($this->getStashsList('id_stash') as $stash) {
            $stashIds[] = $stash->getId_stash();
        }

        $filterConditions = [];
        $filterConditions['addressStashFilter'] = isset($filterOptions['addressStashFilter']) ? " WHERE address LIKE '%" . $filterOptions['addressStashFilter'] . "%'" : " WHERE id_stash IN (" . implode(",", $stashIds) . ")";
        $filterConditions['countryStashFilter'] = isset($filterOptions['countryStashFilter']) && strlen($filterOptions['countryStashFilter']) > 0 ? " AND country = '" . $filterOptions['countryStashFilter'] . "'" : '';
        $filterConditions['typeStashFilter'] = isset($filterOptions['typeStashFilter']) ? " AND type IN (" . $this->convertToStringList($filterOptions['typeStashFilter']) . ")" : '';
        $filterConditions['missionsFilter'] = isset($filterOptions['missionsFilter']) ? " AND id_stash IN (" . implode(",", $missionsFilter) . ")" : '';

        $stashs = new Stashs((new Connection)->getPdo());

        return $stashs->filterStashs($filterConditions);
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
            "La planque " . $stash->getId_stash() . " est encore affectée "
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
}