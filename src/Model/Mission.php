<?php

namespace App\Model;

class Mission
{
    private $id_mission;
    private $code_name;
    private $title;
    private $description;
    private $country;
    private $type;
    private $status;
    private $start_date;
    private $end_date;
    private $speciality;
    private $agents = [];
    private $contacts = [];
    private $targets = [];
    private $stashs = [];

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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Get the value of status
     */ 
    public function getStatus()
    {
        $statusAndColor = [];
        switch ($this->status) {
            case 'En cours':
                $background = '#7ED3B2';
                break;
            case 'Terminé':
                $background = '#4797B1';
                break;
            case 'En préparation':
                $background = '#F3D179';
                break;
            case 'Echec':
                $background = '#F46060';
                break;
        }
        $statusAndColor['status'] = $this->status;
        $statusAndColor['background'] = $background;
        return $statusAndColor;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of start_date
     */ 
    public function getStart_date()
    {
        $convertedDate = date("m/d/Y", strtotime($this->start_date));
        return $convertedDate;
    }

    /**
     * Set the value of start_date
     *
     * @return  self
     */ 
    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * Get the value of end_date
     */ 
    public function getEnd_date()
    {
        $convertedDate = date("m/d/Y", strtotime($this->end_date));
        return $convertedDate;
    }

    /**
     * Set the value of end_date
     *
     * @return  self
     */ 
    public function setEnd_date($end_date)
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * Get the value of speciality
     */ 
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set the value of speciality
     *
     * @return  self
     */ 
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get the value of agents
     */ 
    public function getAgents()
    {
        return $this->agents;
    }

    /**
     * Set the value of agents
     *
     * @return  self
     */ 
    public function setAgents(array $agents)
    {
        $this->agents= $agents;

        return $this;
    }

    public function addAgents(Agent $agent): void
    {
        $this->agents[] = $agent;
    }

    /**
     * Get the value of contacts
     */ 
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set the value of contacts
     *
     * @return  self
     */ 
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function addContacts(Contact $contact): void
    {
        $this->contacts[] = $contact;
    }

    /**
     * Get the value of targets
     */ 
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Set the value of targets
     *
     * @return  self
     */ 
    public function setTargets($targets)
    {
        $this->targets = $targets;

        return $this;
    }

    public function addTargets(target$target): void
    {
        $this->targets[] = $target;
    }

    /**
     * Get the value of stashs
     */ 
    public function getStashs()
    {
        return $this->stashs;
    }

    /**
     * Set the value of stashs
     *
     * @return  self
     */ 
    public function setStashs($stashs)
    {
        $this->stashs = $stashs;

        return $this;
    }

    public function addStashs(Stash $stash): void
    {
        $this->stashs[] = $stash;
    }
}