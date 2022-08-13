<?php

namespace App\Model;

class Person
{
    private $id;
    private $code_name;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $nationality;
    private $missions = [];
    private $specialities = [];

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
     * Get the value of code_name
     */ 
    public function getCode_name()
    {
        return $this->code_name;
    }

    /**
     * Set the value of code_name
     *
     * @return  self
     */ 
    public function setCode_name($code_name)
    {
        $this->code_name = $code_name;

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

    public function getConvertedBirthdate()
    {
        $convertedDate = date("d/m/Y", strtotime($this->birthdate));
        return $convertedDate;
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
     * Get the value of specialities
     */ 
    public function getSpecialities()
    {
        return $this->specialities;
    }
    
    /**
     * Set the value of specialities
     *
     * @return  self
     */ 
    public function setSpecialities($specialities)
    {
        $this->specialities = $specialities;
        
        return $this;
    }

    public function addSpecialities(Speciality $speciality): void
    {
        if (!in_array($speciality, $this->specialities)) {
            $this->specialities[] = $speciality;
        }
    }
}