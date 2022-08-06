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

    public function controlsRules(array $missionPost): array
    {
        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($missionPost as $key => $item) {
            if ($item === '') {
                $errors['blank_' . $key] = $key . ' est obligatoire';
            }
        }
        $nbAgentsWithMissionSpeciality = 0;
        foreach($missionPost['agentMission'] as $agentPost) {
            //Vérifie que les agents et cibles n'ont pas la même nationalité
            foreach($missionPost['targetMission'] as $targetPost) {
                if ($agentPost->getNationality() === $targetPost->getNationality()) {
                    if (empty($errors['nationalityAgentTarget'])) {
                        $errors['nationalityAgentTarget'] = 'Il ne peut y avoir d\'agent et de cible de même nationalité';
                    }
                    $errors['nationalityAgentTarget_' . $agentPost->getId() . '_' . $targetPost->getId()] = 
                        'L\'agent ' . $agentPost->getLastname() . ' ' . $agentPost->getFirstname() . 
                        ' et la cible ' . $targetPost->getLastname() . ' ' . $targetPost->getFirstname() .
                        ' sont originaires du pays ' . strtoupper($agentPost->getNationality());
                }
            }
            // Vérifie si au mlins un agent dispose de la spécialité requise par la mission
            if (in_array($missionPost['specialityMission'], $agentPost->getNationality())) {
                $nbAgentsWithMissionSpeciality += 1; 
            }
        }
        if ($nbAgentsWithMissionSpeciality === 0) {
            $errors['agentsWithMissionSpeciality'] = 'Il doit y avoir au moins un agent disposant de la spécialité requise par la mission';
        }
        //Vérifie si les contacts ont la même nationalité que le pays de la mission
        foreach($missionPost['contactMission'] as $contactPost) {
            if ($contactPost->getNationality() !== $missionPost['countryMission']) {
                if (empty($errors['countryMissionContact'])) {
                    $errors['countryMissionContact'] = 'Les contacts doivent avoir la même nationalité que le pays de la mission, soit ' . strtoupper($missionPost['countryMission']) . ' or:';
                }
                $errors['countryMissionContact_' . $missionPost['countryMission'] . '_' . $contactPost->getId()] =
                'Le contact ' . $contactPost->getLastname() . ' ' . $contactPost->getFirstname() . ' a la nationalité ' . $contactPost->getNationality();
            }
        }
        //Vérifie si les planques sont bien dans le même pays que le pays de la mission
        foreach($missionPost['stashMission'] as $stashPost) {
            if ($stashPost->getCountry() !== $missionPost['countryMission']) {
                if (empty($errors['countryMissionStash'])) {
                    $errors['countryMissionStash'] = 'Les planques doivent doivent situées dans le même pays que celui de la mission, soit ' . strtoupper($missionPost['countryMission']) . ' or:';
                }
                $errors['countryMissionStash_' . $missionPost['countryMission'] . '_' . $stashPost->getId()] =
                'La planque ' . $stashPost->getCode_name() . ' est située dans le pays ' . $stashPost->getCountry();
            }
        }


        return $errors;
    }
}