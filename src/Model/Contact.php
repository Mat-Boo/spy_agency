<?php

namespace App\Model;

class Contact
{
    private $id_contact;
    private $firstname;
    private $lastname;
    private $birthdate;
    private $nationality;
    private $id_mission;
    
    /**
     * Get the value of id_contact
     */ 
    public function getId_contact()
    {
        return $this->id_contact;
    }

    /**
     * Set the value of id_contact
     *
     * @return  self
     */ 
    public function setId_contact($id_contact)
    {
        $this->id_contact = $id_contact;

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
}