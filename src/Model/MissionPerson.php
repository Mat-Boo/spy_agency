<?php

namespace App\model;

class MissionPerson
{
    private $id_mission;
    private $id;
    
    /**
     * Get the value of id_mission
     */ 
    public function getId_mission()
    {
        return $this->id_mission;
    }
    
    /**
     * Set the value of id_mission
     *
     * @return  self
     */ 
    public function setId_mission($id_mission)
    {
        $this->id_mission = $id_mission;
    
        return $this;
    }

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
}