<?php

namespace App\Controllers;

use App\Class\Connection;
use App\Model\MissionsPersons;

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

    public function filterMissions(array $filterOptions, $personItem): array
    {
        $personsMissions = new MissionsPersons((new Connection)->getPdo(), $personItem);
        return $personsMissions->filterMissions($filterOptions);
    }
    
    public function hydratePersons(array $persons, array $missions, string $personItem): void
    {
        $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
        $missionsPersons->hydratePersons($persons, $missions);
    }

    public function updateMissionsPersons(array $mission, int $id_mission): void
    {
        foreach(['agent', 'contact', 'target'] as $personItem) {
            $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
            $missionsPersons->updateMissionsPersons($mission, $id_mission);
        }
    }

    public function deleteMissionPersonFromPerson(int $id, string $personItem): void
    {
        $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
        $missionsPersons->deleteMissionPersonFromPerson($id);
    }

    public function deleteMissionPersonFromMission(int $id_mission, string $personItem): void
    {
        $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
        $missionsPersons->deleteMissionPersonFromMission($id_mission);
    }

    public function createMissionPerson(array $newMissionPerson, int $newId_mission): void
    {
        foreach(['agent', 'contact', 'target'] as $personItem) {
            $missionsPersons = new MissionsPersons((new Connection)->getPdo(), $personItem);
            $missionsPersons->createMissionPerson($newMissionPerson, $newId_mission);
        }
    }
}