<?php

namespace App\Model;

class Target
{
    private $code_name_target;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $nationality;
    private $id_code_mission;
    
    /**
     * Get the value of code_name_target
     */ 
    public function getCode_name_target()
    {
        return $this->code_name_target;
    }
    
    /**
     * Set the value of code_name_target
     *
     * @return  self
     */ 
    public function setCode_name_target($code_name_target)
    {
        $this->code_name_target = $code_name_target;
    
        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of birthdate
     */ 
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     *
     * @return  self
     */ 
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get the value of nationality
     */ 
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set the value of nationality
     *
     * @return  self
     */ 
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get the value of id_code_mission
     */ 
    public function getId_code_mission()
    {
        return $this->id_code_mission;
    }

    /**
     * Set the value of id_code_mission
     *
     * @return  self
     */ 
    public function setId_code_mission($id_code_mission)
    {
        $this->id_code_mission = $id_code_mission;

        return $this;
    }

}