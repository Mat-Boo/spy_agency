<?php

namespace App\Model;

class Administrator
{
    private $id_admin;
    private $firstanme;
    private $lastname;
    private $email;
    private $password;
    private $created_at;

    /**
     * Get the value of id_admin
     */ 
    public function getId_admin()
    {
        return $this->id_admin;
    }

    /**
     * Set the value of id_admin
     *
     * @return  self
     */ 
    public function setId_admin($id_admin)
    {
        $this->id_admin = $id_admin;

        return $this;
    }

    /**
     * Get the value of firstanme
     */ 
    public function getFirstanme()
    {
        return $this->firstanme;
    }

    /**
     * Set the value of firstanme
     *
     * @return  self
     */ 
    public function setFirstanme($firstanme)
    {
        $this->firstanme = $firstanme;

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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
}