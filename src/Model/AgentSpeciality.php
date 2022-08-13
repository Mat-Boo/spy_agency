<?php

namespace App\Model;

class AgentSpeciality
{
    private $id;
    private $id_speciality;
    private $missions = [];
    private $agents = [];
   
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
}