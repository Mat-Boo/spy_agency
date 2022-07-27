<?php

namespace App\Model;

class Speciality
{
    private $id_speciality;
    private $name;

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
}