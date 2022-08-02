<?php

namespace App\Controllers;

use App\Connection;
use App\model\AgentsSpecialities;
use App\model\MissionsStashs;

class MissionsStashsController
{
    
    public function getStashsFilters(array $filterOptions): array
    {
        $stashsFilters = [];
        $stashsFilters['missionsStashs'] = new MissionsStashs((new Connection)->getPdo());
        $stashsFilters['stashsListFiltered'] = $stashsFilters['missionsStashs']->filterStashs($filterOptions); //Besoin pour filtrer selon les planques
        return $stashsFilters;
    }

    public function hydrateMissions(array $missionsListFiltered, array $stashsLists, array $stashsFilters)
    {
        $stashsFilters['missionsStashs']->hydrateMissions($missionsListFiltered, $stashsLists);
    }

    public function updateMissionsStashs(array $mission, int $id_mission): void
    {
        $missionsStashs = new MissionsStashs((new Connection)->getPdo());
        $missionsStashs->updateMissionsStashs($mission, $id_mission);
    }
}