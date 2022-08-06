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
        $stashsFilters['stashsListFiltered'] = $stashsFilters['missionsStashs']->filterStashs($filterOptions);
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

    public function filterMissions(array $filterOptions): array
    {
        $stashsMissions = new MissionsStashs((new Connection)->getPdo());
        return $stashsMissions->filterMissions($filterOptions);
    }

    public function hydrateStashs(array $stashs, array $missions): void
    {
        $missionsStashs = new MissionsStashs((new Connection)->getPdo());
        $missionsStashs->hydrateStashs($stashs, $missions);
    }

    public function deleteMissionStashFromStash(int $id_stash): void
    {
        $missionsStashs = new MissionsStashs((new Connection)->getPdo());
        $missionsStashs->deleteMissionStashFromStash($id_stash);
    }

    public function deleteMissionStashFromMission(int $id_stash): void
    {
        $missionsStashs = new MissionsStashs((new Connection)->getPdo());
        $missionsStashs->deleteMissionStashFromMission($id_stash);
    }

    public function createMissionStash(array $newMissionStash, int $newId_mission): void
    {
        $missionsStashs = new MissionsStashs((new Connection)->getPdo());
        $missionsStashs->createMissionStash($newMissionStash, $newId_mission);
    }
    
}