<?php

namespace App\Controllers;

use App\Connection;
use App\model\AgentsSpecialities;
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
            'titleMission' => 'Le <b>TITRE</b> ',
            'codeNameMission' => 'Le <b>CODE NAME</b> ',
            'countryMission' => 'Le <b>PAYS</b> ',
            'typeMission' => 'Le <b>TYPE</b> ',
            'startDateMission' => 'La <b>DATE DE DÉBUT</b> ',
            'endDateMission' => 'La <b>DATE DE FIN</b> ',
            'descriptionMission' => 'La <b>DESCRIPTION</b> '
        ];

        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($missionPost as $keyPost => $itemPost) {
            foreach($missionItems as $key => $item) {
                if ($itemPost === '' && $keyPost === $key) {
                    $errors['blank_' . $key] = '<li class="error">' . $item . ' est obligatoire sur la mission</li>';
                }
            }
        }

        if (!isset($missionPost['status'])) {
            $errors['blank_status'] = '<li class="error">La mission doit avoir un <b>STATUT</b></li>';
        }

        $analyzedAgents = [];
        $analyzedTargets = [];
        $analyzedContacts = [];
        $analyzedStashs = [];
        $nbAgentsWithMissionSpeciality = 0;

        //Récupération des informations des items extérieurs de la mission pour pouvoir créer les règles métier
        if (isset($missionPost['agentMission'])) {
            foreach($missionPost['agentMission'] as $agentIdPost) {
                foreach($personsLists['agentsList'] as $agent) {
                    if($agentIdPost == $agent->getId()) {
                        $analyzedAgents[] = $agent;
                    }
                }
            }
        } else {
            $errors['blank_agentMission'] = '<li class="error">La mission doit comporter au minimum un <b>AGENT</b></li>';
        }

        if(isset($missionPost['targetMission'])) {
            foreach($missionPost['targetMission'] as $targetIdPost) {
                foreach($personsLists['targetsList'] as $target) {
                    if($targetIdPost == $target->getId()) {
                        $analyzedTargets[] = $target;
                    }
                }
            }
        } else {
            $errors['blank_targetMission'] = '<li class="error">La mission doit comporter au minimum une <b>CIBLE</b></li>';
        }

        if (isset($missionPost['contactMission'])) {
            foreach($missionPost['contactMission'] as $contactIdPost) {
                foreach($personsLists['contactsList'] as $contact) {
                    if($contactIdPost == $contact->getId()) {
                        $analyzedContacts[] = $contact;
                    }
                }
            }
        } else {
            $errors['blank_contactMission'] = '<li class="error">La mission doit comporter au minimum un <b>CONTACT</b></li>';
        }
        
        if (isset($missionPost['stashMission'])) {
            foreach($missionPost['stashMission'] as $stashIdPost) {
                foreach($stashsList as $stash) {
                    if($stashIdPost == $stash->getId_stash()) {
                        $analyzedStashs[] = $stash;
                    }
                }
            }
        } else {
            $errors['blank_stashMission'] = '<li class="error">La mission doit comporter au minimum une <b>PLANQUE</b></li>';
        }
        //

        //Vérifie que les agents et cibles n'ont pas la même nationalité
        if (!empty($analyzedAgents) && !empty($analyzedTargets)) {
            foreach($analyzedAgents as $agent) {
                foreach($analyzedTargets as $target) {
                    if ($agent->getNationality() === $target->getNationality()) {
                        if (empty($errors['nationalityAgentTarget'])) {
                            $errors['nationalityAgentTarget'] = '<li class="error">Il ne peut y avoir d\'<b>AGENT</b> et de <b>CIBLE</b> de même nationalité, or :<ul>';
                        }
                        $errors['nationalityAgentTarget'] .= 
                            '<li>L\'Agent <b>' . strtoupper($agent->getLastname()  . ' ' . $agent->getFirstname())  . 
                            '</b> et la Cible <b>' . strtoupper($target->getLastname() . ' ' . $target->getFirstname()) .
                            '</b> sont originaires du Pays <b>' . strtoupper($agent->getNationality()) . '</b></li>';
                    }      
                }
            }
            if (isset($errors['nationalityAgentTarget'])) {
                $errors['nationalityAgentTarget'] .= '</ul></li>';
            }
        }

        //Vérifie si les contacts ont la même nationalité que le pays de la mission
        if (!empty($analyzedContacts) && strlen($missionPost['countryMission']) > 0) {
            foreach($analyzedContacts as $contact) {
                if ($contact->getNationality() !== $missionPost['countryMission']) {
                    if (empty($errors['countryMissionContact'])) {
                        $errors['countryMissionContact'] = '<li class="error">Les <b>CONTACTS</b> doivent avoir la même nationalité que le Pays de la mission, soit <b>' . strtoupper($missionPost['countryMission']) . '</b> or :<ul>';
                    }
                    $errors['countryMissionContact'] .=
                    '<li>Le Contact <b>' . strtoupper($contact->getLastname() . ' ' . $contact->getFirstname()) . '</b> a la Nationalité <b>' . $contact->getNationality() . '</b></li>';
                }
            }
            if (isset($errors['countryMissionContact'])) {
                $errors['countryMissionContact'] .= '</ul></li>';
            }
        }
        
        // Vérifie si au moins un agent dispose de la spécialité requise par la mission
        $agentsSpecialitiesController = new AgentsSpecialitiesController;
        $agentsSpecialitiesController->hydrateAgents($analyzedAgents, $specialitiesList);
        if ($missionPost['specialityMission'] !== 'headerFilter') {
            foreach($analyzedAgents as $agent) {
                if (in_array($missionPost['specialityMission'], $agent->getSpecialities())) {
                    $nbAgentsWithMissionSpeciality += 1;
                }
            }
            if ($nbAgentsWithMissionSpeciality === 0) {
                $errors['agentsWithMissionSpeciality'] = '<li class="error">Il doit y avoir au moins un <b>AGENT</b> disposant de la <b>SPÉCIALITÉ</b> requise par la mission</li>';
            }
        } else {
            $errors['blank_specialityMission'] = '<li class="error">La mission doit comporter une <b>SPÉCIALITÉ</b></li>';
        }
        
        //Vérifie si les planques sont bien dans le même pays que le pays de la mission
        if (!empty($analyzedStashs) && strlen($missionPost['countryMission']) > 0) {
            foreach($analyzedStashs as $stash) {
                if ($stash->getCountry() !== $missionPost['countryMission']) {
                    if (empty($errors['countryMissionStash'])) {
                        $errors['countryMissionStash'] = '<li class="error">Les <b>PLANQUES</b> doivent être situées dans le même Pays que celui de la mission, soit <b>' . strtoupper($missionPost['countryMission']) . '</b> or :<ul>';
                    }
                    $errors['countryMissionStash'] .=
                    '<li>La <b>PLANQUE ' . strtoupper($stash->getCode_name()) . '</b> est située dans le Pays <b>' . strtoupper($stash->getCountry()) . '</b></li>';
                }
            }
            if (isset($errors['countryMissionStash'])) {
                $errors['countryMissionStash'] .= '</ul></li>';
            }
        }

        return $errors;
    }
}