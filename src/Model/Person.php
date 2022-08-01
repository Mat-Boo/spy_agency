<?php

namespace App\model;

class Person
{
    private $id;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $nationality;
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
        $this->specialities[] = $speciality;
    }
}