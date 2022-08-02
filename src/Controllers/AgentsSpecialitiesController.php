<?php

namespace App\Controllers;

use App\Connection;
use App\model\AgentsSpecialities;

class AgentsSpecialitiesController
{
    public function getAgentsSpecialitiesList(): array
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        return $agentsSpecialities->getAgentsSpecialitiesList();
    }

    public function hydrateAgents(array $agents, array $specialities): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->hydrateAgents($agents, $specialities);
    }

    public function filterSpecialities(array $filterOptions): array
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        return $agentsSpecialities->filterSpecialities($filterOptions);
    }
}