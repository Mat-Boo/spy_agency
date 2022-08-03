<?php

namespace App\Controllers;

use App\Connection;
use App\model\Specialities;
use App\Model\Speciality;

class SpecialitiesController
{
    public function getSpecialitiesList($sortBy): array
    {
        $specialities = new Specialities((new Connection)->getPdo());
        return $specialities->getSpecialitiesList($sortBy);
    }

    public function filterSpecialities(array $filterOptions, array $agentsFilter, array $missionsFilter): array
    {
        $specialityIds = [];
        foreach($this->getSpecialitiesList('id_speciality') as $speciality) {
            $specialityIds[] = $speciality->getId_speciality();
        }

        $filterConditions = [];
        $filterConditions['idSpecialityFilter'] = isset($filterOptions['idSpecialityFilter']) ? " WHERE id_speciality IN (" . implode(",", $filterOptions['idSpecialityFilter']) . ")" : " WHERE id_speciality IN (" . implode(",", $specialityIds) . ")";
        $filterConditions['agentsFilter'] = isset($filterOptions['agentsFilter']) ? " AND id_speciality IN (" . implode(",", $agentsFilter) . ")" : '';
        $filterConditions['missionsFilter'] = isset($filterOptions['missionsFilter']) ? " AND id_speciality IN (" . implode(",", $missionsFilter) . ")" : '';

        $specialities = new Specialities((new Connection)->getPdo());

        return $specialities->filterSpecialities($filterConditions);
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
            "ATTENTION, la specialité " . $speciality->getId_speciality() . ' - ' . strtoupper($speciality->getName()) . " est encore affectée "
            . (count($speciality->getMissions()) > 1 ? 'aux missions:\\n' : ' à la mission:\\n')
            . implode('\\n', $missionIds) . " \\nVoulez-vous tout de même la supprimer ?";
    }

    public function checkAgentBeforeDelete(Speciality $speciality): array
    {
        if (!empty($speciality->getAgents())) {
            $agentIds = [];
            foreach($speciality->getAgents() as $agent) {
                $agentIds[] = $agent->getId();
            }
        }
        return $agentIds;
    }

    public function deleteSpeciality(int $id_speciality): void
    {
        $specialities = new Specialities((new Connection)->getPdo());
        $specialities->deleteSpeciality($id_speciality);
    }
}