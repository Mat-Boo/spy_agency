<?php

namespace App\Model;

class MissionStash
{
    private $id_mission;
    private $id_stash;
   
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
     * Get the value of id_stash
     */ 
    public function getId_stash()
    {
        return $this->id_stash;
    }

    /**
     * Set the value of id_stash
     *
     * @return  self
     */ 
    public function setId_stash($id_stash)
    {
        $this->id_stash = $id_stash;

        return $this;
    }
}
