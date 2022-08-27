<?php

namespace App\Controllers;

use App\Class\Connection;
use App\Model\Specialities;
use App\Model\Speciality;

class SpecialitiesController
{
    public function getSpecialitiesList($sortBy): array
    {
        $specialities = new Specialities((new Connection)->getPdo());
        return $specialities->getSpecialitiesList($sortBy);
    }

    public function filterSpecialities(array $filterOptions, array $agentsFilter, array $missionsFilter, int $page): array
    {
        $filterConditions = [];
        $filterSort = '';

        if (isset($filterOptions['idSpecialityFilter'])) {
            $filterConditions[] = "id_speciality IN (" . implode(",", $filterOptions['idSpecialityFilter']) . ")";
        }

        if (isset($filterOptions['agentsFilter'])) {
            $filterConditions[] = "id_speciality IN (" . implode(",", $agentsFilter) . ")";
        }

        if (isset($filterOptions['missionsFilter'])) {
            $filterConditions[] = "id_speciality IN (" . implode(",", $missionsFilter) . ")";
        }

        if (isset($filterOptions['orderByFilter']) && isset($filterOptions['orderByDirection'])  && strlen($filterOptions['orderByFilter']) > 0) {
            $filterSort = $filterOptions['orderByFilter'] . ' ' . $filterOptions['orderByDirection'];
        }


        $specialities = new Specialities((new Connection)->getPdo());

        return $specialities->filterSpecialities($filterConditions, $filterSort, $page);
    }

    public function findSpeciality(int $idSpeciality): Speciality
    {
        $specialities = new Specialities((new Connection)->getPdo());
        return $specialities->findSpeciality($idSpeciality);
    }

    public function updateSpeciality(array $speciality, int $id_speciality): void
    {
        $specialities = new Specialities((new Connection)->getPdo());
        $specialities->updateSpeciality($speciality, $id_speciality);
    }

    public function checkMissionBeforeDelete(Speciality $speciality): string
    {
        if (!empty($speciality->getMissions())) {
            $missionIds = [];
            foreach($speciality->getMissions() as $mission) {
                $missionIds[] = $mission->getId_mission() . ' - ' . strtoupper($mission->getCode_name());
            }
        }
        return 
            "La specialité " . $speciality->getId_speciality() . " - " . strtoupper($speciality->getName()) . " est encore affectée "
            . (count($speciality->getMissions()) > 1 ? "aux missions:\\n" : " à la mission:\\n")
            . implode('\\n', $missionIds) . "\\n\\nLa spécialité étant requise sur une mission, si vous souhaitez vraiment la supprimer, veuillez d\'abord "
            . ((count($speciality->getMissions())) > 1 ? "la désaffecter des missions concernées" : "la désaffecter de la mission concernée" . " et en affecter une autre.");
    }

    public function checkAgentBeforeDelete(Speciality $speciality): string
    {
        
        if (!empty($speciality->getAgents())) {
            $agentIds = [];
            foreach($speciality->getAgents() as $agent) {
                $agentIds[] = $agent->getId() . ' - ' . strtoupper($agent->getFirstname() . ' ' . strtoupper($agent->getLastname()));
            }
        }
        
        return 
            "La specialité " . $speciality->getId_speciality() . " - " . strtoupper($speciality->getName()) . " est encore affectée "
            . (count($speciality->getAgents()) > 1 ? "aux agents:" : "à l\'agent:") . "\\n"
            . implode("\\n", $agentIds);
    }

    public function deleteSpeciality(int $id_speciality): void
    {
        $specialities = new Specialities((new Connection)->getPdo());
        $specialities->deleteSpeciality($id_speciality);
    }

    public function createSpeciality(array $newSpeciality): int
    {
        $specialities = new Specialities((new Connection)->getPdo());
        return $specialities->createSpeciality($newSpeciality);
    }

    public function controlsRules(array $specialityPost): array
    {
        $errors = [];

        $specialityItems = 
        [
            'idSpeciality' => 'Le <b>CODE</b> ',
            'nameSpeciality' => 'Le <b>TITRE</b> ',
        ];

        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($specialityPost as $keyPost => $itemPost) {
            foreach($specialityItems as $key => $item) {
                if ($itemPost === '' && $keyPost === $key) {
                    $errors['blank_' . $key] = '<li class="error">' . $item . ' est obligatoire sur la spécialité</li>';
                }
            }
        }

        return $errors;
    }
}