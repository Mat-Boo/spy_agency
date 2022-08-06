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

    public function controlsRules(array $missionPost, array $personsLists, array $stashsList, array $specialitiesList): array
    {
        $errors = [];

        $missionItems = 
        [
            'titleMission' => 'Le Titre ',
            'codeNameMission' => 'Le Code Name ',
            'countryMission' => 'Le Pays ',
            'typeMission' => 'Le Type ',
            'startDateMission' => 'La Date de début ',
            'endDateMission' => 'La Date de fin ',
            'descriptionMission' => 'La Description '
        ];

        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($missionPost as $keyPost => $itemPost) {
            foreach($missionItems as $key => $item) {
                if ($itemPost === '' && $keyPost === $key) {
                    $errors['blank_' . $key] = $item . ' est obligatoire sur la mission';
                }
            }
        }

        if (!isset($missionPost['status'])) {
            $errors['blank_status'] = 'La mission doit avoir un Statut';
        }

        $analyzedAgent = [];
        $analyzedTarget = [];
        $analyzedContact = [];
        $analyzedStash = [];
        $nbAgentsWithMissionSpeciality = 0;

        //Récupération des informations des items extérieurs de la mission pour pouvoir créer les règles métier
        if (isset($missionPost['agentMission'])) {
            foreach($missionPost['agentMission'] as $agentIdPost) {
                foreach($personsLists['agentsList'] as $agent) {
                    if($agentIdPost == $agent->getId()) {
                        $analyzedAgent[$agentIdPost]['nationality'] = $agent->getNationality();
                        $analyzedAgent[$agentIdPost]['firstname'] = $agent->getFirstname();
                        $analyzedAgent[$agentIdPost]['lastname'] = $agent->getLastname();
                        $analyzedAgent[$agentIdPost]['speciality'] = $agent->getSpecialities();
                    }
                }
            }
        } else {
            $errors['blank_agentMission'] = 'La mission doit comporter au minimum un Agent';
        }

        if(isset($missionPost['targetMission'])) {
            foreach($missionPost['targetMission'] as $targetIdPost) {
                foreach($personsLists['targetsList'] as $target) {
                    if($targetIdPost == $target->getId()) {
                        $analyzedTarget[$targetIdPost]['nationality'] = $target->getNationality();
                        $analyzedTarget[$targetIdPost]['firstname'] = $target->getFirstname();
                        $analyzedTarget[$targetIdPost]['lastname'] = $target->getLastname();
                    }
                }
            }
        } else {
            $errors['blank_targetMission'] = 'La mission doit comporter au minimum une Cible';
        }

        if (isset($missionPost['contactMission'])) {
            foreach($missionPost['contactMission'] as $contactIdPost) {
                foreach($personsLists['contactsList'] as $contact) {
                    if($contactIdPost == $contact->getId()) {
                        $analyzedContact[$contactIdPost]['nationality'] = $contact->getNationality();
                        $analyzedContact[$contactIdPost]['firstname'] = $contact->getFirstname();
                        $analyzedContact[$contactIdPost]['lastname'] = $contact->getLastname();
                    }
                }
            }
        } else {
            $errors['blank_contactMission'] = 'La mission doit comporter au minimum un Contact';
        }
        
        if (isset($missionPost['stashMission'])) {
            foreach($missionPost['stashMission'] as $stashIdPost) {
                foreach($stashsList as $stash) {
                    if($stashIdPost == $stash->getId_stash()) {
                        $analyzedStash[$stashIdPost]['code_name'] = $stash->getCode_name();
                        $analyzedStash[$stashIdPost]['country'] = $stash->getCountry();
                    }
                }
            }
        } else {
            $errors['blank_stashMission'] = 'La mission doit comporter au minimum une Planque';
        }
        //

        //Vérifie que les agents et cibles n'ont pas la même nationalité
        if (!empty($analyzedAgent) && !empty($analyzedTarget)) {
            foreach($analyzedAgent as $keyAgent => $agent) {
                foreach($analyzedTarget as $keyTarget => $target) {
                    if ($agent['nationality'] === $target['nationality']) {
                        if (empty($errors['nationalityAgentTarget'])) {
                            $errors['nationalityAgentTarget'] = 'Il ne peut y avoir d\'Agent et de Cible de même nationalité, or:';
                        }
                        $errors['nationalityAgentTarget_' . $keyAgent . '_' . $keyTarget] = 
                            'L\'Agent ' . $agent['lastname']  . ' ' . $agent['firstname']  . 
                            ' et la Cible ' . $target['lastname'] . ' ' . $target['firstname'] .
                            ' sont originaires du Pays ' . strtoupper($agent['nationality']);
                    }      
                }
            }
        }

        //Vérifie si les contacts ont la même nationalité que le pays de la mission
        if (!empty($analyzedContact) && strlen($missionPost['countryMission']) > 0) {
            foreach($analyzedContact as $keyContact => $contact) {
                if ($contact['nationality'] !== $missionPost['countryMission']) {
                    if (empty($errors['countryMissionContact'])) {
                        $errors['countryMissionContact'] = 'Les Contacts doivent avoir la même nationalité que le Pays de la mission, soit ' . strtoupper($missionPost['countryMission']) . ' or:';
                    }
                    $errors['countryMissionContact_' . $missionPost['countryMission'] . '_' . $keyContact] =
                    'Le Contact ' . $contact['lastname'] . ' ' . $contact['firstname'] . ' a la Nationalité ' . $contact['nationality'];
                }
            }
        }
        
        // Vérifie si au moins un agent dispose de la spécialité requise par la mission
        /* if ($missionPost['specialityMission'] !== 'headerFilter') {
            foreach($analyzedAgent as $keyAgent => $agent) {
                if (in_array($missionPost['specialityMission'], $agent['specialities'])) {
                    $nbAgentsWithMissionSpeciality += 1;
                }
            }
            if ($nbAgentsWithMissionSpeciality === 0) {
                $errors['agentsWithMissionSpeciality'] = 'Il doit y avoir au moins un Agent disposant de la Spécialité requise par la mission';
            }
        } else {
            $errors['blank_specialityMission'] = 'La mission doit comporter une Spécialité';
        }  */   
        
        //Vérifie si les planques sont bien dans le même pays que le pays de la mission
        if (!empty($analyzedStash) && strlen($missionPost['countryMission']) > 0) {
            foreach($analyzedStash as $keyStash => $stash) {
                if ($stash['country'] !== $missionPost['countryMission']) {
                    if (empty($errors['countryMissionStash'])) {
                        $errors['countryMissionStash'] = 'Les Planques doivent être situées dans le même Pays que celui de la mission, soit ' . strtoupper($missionPost['countryMission']) . ' or:';
                    }
                    $errors['countryMissionStash_' . $missionPost['countryMission'] . '_' . $keyStash] =
                    'La Planque ' . $stash['code_name'] . ' est située dans le Pays ' . $stash['country'];
                }
            }
        }

        return $errors;
    }
}