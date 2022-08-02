<?php

namespace App\Controllers;

use App\Connection;
use App\model\MissionsPersons;

class MissionsPersonsController
{
    public function getMissionsPersonsLists(string $personItem): array
    {
        $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
        return $missionsPersons->getMissionsPersonsLists();
    }

    public function hydrateMissions(array $missionsListFiltered, array $personsLists, array $personsFilters)
    {
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')]->hydrateMissions($missionsListFiltered, $personsLists[$person . 'sList']);
        }
    }

    public function filterPersons(array $filterOptions): array
    {
        $personsFilters = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')] = new MissionsPersons((new Connection)->getPdo(), $person);
            $personsFilters[$person . 'sListFiltered'] = $personsFilters['missions' . ucfirst($person . 's')]->filterPersons($filterOptions); //Besoin pour filtrer selon les personnes (Agents, contacts et cibles)
        }
        return $personsFilters;
    }

    public function hydratePersons(array $persons, array $missions, string $personItem): void
    {
        $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
        $missionsPersons->hydratePersons($persons, $missions);
    }

    public function filterMissions(array $filterOptions, $personItem): array
    {
        $personsMissions = new MissionsPersons((new Connection)->getPdo(), $personItem);
        return $personsMissions->filterMissions($filterOptions);
    }
}