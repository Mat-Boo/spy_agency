<?php

namespace App\model;
use PDO;

class AgentsSpecialities
{
    private $pdo;

    public function __construct(PDO $pdo)
    {   
        $this->pdo = $pdo;
    }

    public function getAgentsSpecialities(): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id, id_speciality
                FROM AgentSpeciality"
            );
        }
        $agentsSpecialities = [];
        while ($agentSpeciality = $stmt->fetchObject(AgentSpeciality::class)) {
            $agentsSpecialities[] = $agentSpeciality;
        }
        return $agentsSpecialities;
    }

    public function hydrateAgents(array $agents, array $specialities): void
    {
        foreach($agents as $agent) {
            foreach($specialities as $speciality) {
                    foreach($this->getAgentsSpecialities() as $agentSpeciality) {
                    if ($agent->getId() === $agentSpeciality->getId()) {
                        if ($speciality->getId_speciality() === $agentSpeciality->getId_speciality()) {
                            $agent->addSpecialities($speciality);
                        }
                    }
                }
            }
        }
    }

    public function filterSpecialities(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $specialityFilter = isset($filterOptions['specialityFilter']) ? " WHERE id_speciality IN (" . implode(",", $filterOptions['specialityFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id
                FROM agentSpeciality"
                . $specialityFilter
            );
            $agentIdsFromSpecialities = [];
            while ($agentIdsFromspeciality = $stmt->fetchColumn()) {
                $agentIdsFromSpecialities[] = $agentIdsFromspeciality;
            }
        }
        return $agentIdsFromSpecialities;
    }
}