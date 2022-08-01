<?php

namespace App\Controllers;

use App\Connection;
use App\model\MissionsPersons;

class MissionsPersonsController
{
    public function getPersonsFilters(array $filterOptions): array
    {
        $personsFilters = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')] = new MissionsPersons((new Connection)->getPdo(), $person);
            $personsFilters[$person . 'sListFiltered'] = $personsFilters['missions' . ucfirst($person . 's')]->filterPersons($filterOptions); //Besoin pour filtrer selon les personnes (Agents, contacts et cibles)
        }
        return $personsFilters;
    }
}