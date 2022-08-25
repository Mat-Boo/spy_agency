<?php

namespace App\Model;

class Speciality
{
    private $id_speciality;
    private $name;
    private $missions = [];
    private $agents = [];

    public function __tostring()
    {
        return $this->getName();
    }

    /**
     * Get the value of id_speciality
     */ 
    public function getId_speciality()
    {
        return $this->id_speciality;
    }

    /**
     * Set the value of id_speciality
     *
     * @return  self
     */ 
    public function setId_speciality($id_speciality)
    {
        $this->id_speciality = $id_speciality;

        return $this;
    }
    
    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of missions
     */ 
    public function getMissions()
    {
        return $this->missions;
    }

    /**
     * Set the value of missions
     *
     * @return  self
     */ 
    public function setMissions($missions)
    {
        $this->missions = $missions;

        return $this;
    }

    public function addMissions(Mission $mission): void
    {
        if (!in_array($mission, $this->missions)) {
            $this->missions[] = $mission;
        }
    }

    /**
     * Get the value of agents
     */ 
    public function getAgents()
    {
        return $this->agents;
    }

    /**
     * Set the value of agents
     *
     * @return  self
     */ 
    public function setAgents($agents)
    {
        $this->agents = $agents;

        return $this;
    }

    public function addAgents(Person $agent): void
    {
        if (!in_array($agent, $this->agents)) {
            $this->agents[] = $agent;
        }
    }
}