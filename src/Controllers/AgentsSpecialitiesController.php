<?php

namespace App\Controllers;

use App\Class\Connection;
use App\Model\AgentsSpecialities;

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

    public function updateAgentsSpecialities(array $agent, int $id_agent): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->updateAgentsSpecialities($agent, $id_agent);
    }

    public function filterAgents(array $filterOptions): array
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        return $agentsSpecialities->filterAgents($filterOptions);
    }

    public function hydrateSpecialities(array $specialities, array $agents): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->hydrateSpecialities($specialities, $agents);
    }

    public function deleteAgentSpecialityFromSpeciality(int $id_speciality): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->deleteAgentSpecialityFromSpeciality($id_speciality);
    }

    public function deleteAgentSpecialityFromAgent(int $id_agent): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->deleteAgentSpecialityFromAgent($id_agent);
    }

    public function createAgentSpeciality(array $newAgent, int $id): void
    {
        $agentsSpecialities = new AgentsSpecialities((new Connection)->getPdo());
        $agentsSpecialities->createAgentSpeciality($newAgent, $id);
    }
}