<?php

namespace App\Controllers;

use App\Connection;
use App\Model\Missions;
use PDO;

class MissionsController
{
    public function getMissionsLists(): array
    {
        $missions = new Missions((new Connection)->getPdo());
        return $missions->getMissionsList();
    }

    public function hydrateMissionsFromTables(array $missionsListFiltered, array $personsLists, array $personsFilters, array $stashsLists, array $stashsFilters)
    {
        // Hydratation des missions avec les personnes (Agents, contacts, et cibles)
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')]->hydrateMissions($missionsListFiltered, $personsLists[$person . 'sList']); //Besoin pour hydrater les missions filtrées    
        }
        //

        // Hydratation des missions avec les planques
        $stashsFilters['missionsStashs']->hydrateMissions($missionsListFiltered, $stashsLists);
        //
    }
}