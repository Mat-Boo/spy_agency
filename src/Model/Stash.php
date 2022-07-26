<?php

namespace App\Model;

class Stash
{
    private $id_code_stash;
    private $address;
    private $country;
    private $type;
    private $id_code_mission;

    /**
     * Get the value of id_code_stash
     */ 
    public function getId_code_stash()
    {
        return $this->id_code_stash;
    }

    /**
     * Set the value of id_code_stash
     *
     * @return  self
     */ 
    public function setId_code_stash($id_code_stash)
    {
        $this->id_code_stash = $id_code_stash;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

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