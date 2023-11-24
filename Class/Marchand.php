<?php

class Marchand
{
    private $id;
    private $nom;
    private $objet_id;
    private $arme_id;
    private $description;

    public function __construct($id, $nom, $objet_id, $arme_id, $description)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->objet_id = $objet_id;
        $this->arme_id = $arme_id;
        $this->description = $description;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getObjetId()
    {
        return $this->objet_id;
    }

    public function getArmeId()
    {
        return $this->arme_id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNom($nom)
    {
        if (strlen($nom) > 0 && strlen($nom) <= 50) {
            $this->nom = $nom;
        }
    }

    public function setObjetId($objet_id)
    {
        $this->objet_id = $objet_id;
    }

    public function setArmeId($arme_id)
    {
        $this->arme_id = $arme_id;
    }

    public function setDescription($description)
    {
        if (strlen($description) > 0 && strlen($description) <= 255) {
            $this->description = $description;
        }
    }
}
