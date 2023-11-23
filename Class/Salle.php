<?php

class Salle
{
    private $id;
    private $type;
    private $description;

    public function __construct($id, $type, $description)
    {
        $this->id = $id;
        $this->type = $type;
        $this->description = $description;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDescription()
    {
        return $this->description;
    }

    // Setters
    public function setType($type)
    {
        $this->type = $type;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}
