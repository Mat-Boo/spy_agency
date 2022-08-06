<?php

namespace App\Controllers;

use App\Connection;
use App\Model\Mission;
use App\Model\Missions;

class MissionsController
{
    public function getMissionsList(): array
    {
        $missions = new Missions((new Connection)->getPdo());
        return $missions->getMissionsList();
    }

    public function getStatus(): array
    {
        $status = [];
        foreach($this->getMissionsList() as $mission) {
            if (!in_array($mission->getStatus(), $status)) {
                $status[] = $mission->getStatus();
            }
        }

        usort($status, function ($a, $b)
        {
            if ($a['status'] == $b['status']) {
                return 0;
            } else {
                return ($a['status'] < $b['status']) ? -1 : 1;
            }
        });

        return $status;
    }

    public function getTypes(): array
    {
        $types = [];
        foreach($this->getMissionsList() as $mission) {
            if (!in_array($mission->getType(), $types)) {
                $types[] = $mission->getType();
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


    public function filterMissions(array $filterOptions, array $personsFilters, array $stashsFilters): array
    {
        $missionIds = [];
        foreach($this->getMissionsList() as $mission) {
            $missionIds[] = $mission->getId_mission();
        }

        $filterConditions = [];
        $filterConditions['missionFilter'] = isset($filterOptions['idMissionFilter']) ? " WHERE Mission.id_mission IN (" . implode(",", $filterOptions['idMissionFilter']) . ")" : " WHERE Mission.id_mission IN (" . implode(",", $missionIds) . ")";
        $filterConditions['countryMissionFilter'] = isset($filterOptions['countryMissionFilter']) && strlen($filterOptions['countryMissionFilter']) > 0 ? " AND country = '" . $filterOptions['countryMissionFilter'] . "'" : '';
        $filterConditions['typeMissionFilter'] = isset($filterOptions['typeMissionFilter']) ? " AND type IN (" . $this->convertToStringList($filterOptions['typeMissionFilter']) . ")" : '';
        $filterConditions['specialityMissionFilter'] = isset($filterOptions['specialityMissionFilter']) ? " AND Mission.id_speciality IN (" . implode(",", $filterOptions['specialityMissionFilter']) . ")" : '';
        $filterConditions['statusMissionFilter'] = isset($filterOptions['statusMissionFilter']) ? " AND status IN (" . $this->convertToStringList($filterOptions['statusMissionFilter']) . ")" : '';
        $filterConditions['startDateMissionFilter'] = isset($filterOptions['startDateMissionFilter']) && strlen($filterOptions['startDateMissionFilter']) > 0 ? " AND start_date >= '" . $filterOptions['startDateMissionFilter'] . "'" : '';
        $filterConditions['endDateMissionFilter'] = isset($filterOptions['endDateMissionFilter']) && strlen($filterOptions['endDateMissionFilter']) > 0 ? " AND end_date <= '" . $filterOptions['endDateMissionFilter'] . "'" : '';
        $filterConditions['agentFilter'] = isset($filterOptions['agentFilter']) ? " AND Mission.id_mission IN (" . implode(",", $personsFilters['agentsListFiltered']) . ")" :'';
        $filterConditions['contactFilter'] = isset($filterOptions['contactFilter']) ? " AND Mission.id_mission IN (" . implode(",", $personsFilters['contactsListFiltered']) . ")" :'';
        $filterConditions['targetFilter'] = isset($filterOptions['targetFilter']) ? " AND Mission.id_mission IN (" . implode(",", $personsFilters['targetsListFiltered']) . ")" :'';
        $filterConditions['stashFilter'] = isset($filterOptions['stashFilter']) ? " AND Mission.id_mission IN (" . implode(",", $stashsFilters['stashsListFiltered']) . ")" :'';

        $missions = new Missions((new Connection)->getPdo());

        return $missions->filterMissions($filterConditions);
    }

    public function findMission(int $idMission): Mission
    {
        $missions = new Missions((new Connection)->getPdo());
        return $missions->findMission($idMission);
        
    }

    public function updateMission(array $mission, int $id_mission): void
    {
        $missions = new Missions((new Connection)->getPdo());
        $missions->updateMission($mission, $id_mission);
    }

    public function filterMissionsForSpeciality(array $filterOptions): array
    {
        $missions = new Missions((new Connection)->getPdo());
        return $missions->filterMissionsForSpeciality($filterOptions);
    }

    public function hydrateSpecialities(array $specialities): void
    {
        $missions = new Missions((new Connection)->getPdo());
        $missions->hydrateSpecialities($specialities);
    }

    public function deleteMission(int $id): void
    {
        $missions = new Missions((new Connection)->getPdo());
        $missions->deleteMission($id);
    }

    public function createMission(array $newMission): int
    {
        $missions = new Missions((new Connection)->getPdo());
        return $missions->createMission($newMission);
    }
}