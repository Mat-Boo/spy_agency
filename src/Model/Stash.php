<?php

namespace App\Model;

class Stash
{
    private $id_stash;
    private $address;
    private $country;
    private $type;
    private $missions = [];

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
}