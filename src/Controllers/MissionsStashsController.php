<?php

namespace App\Controllers;

use App\Connection;
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
}