<?php

class Monstre
{
    private $id;
    private $nom;
    private $points_vie;
    private $points_attaque;
    private $points_defense;
    private $salle_id;
    private $arme_id;

    //Constructor
    public function __construct($id, $nom, $points_vie, $points_attaque, $points_defense, $salle_id, $arme_id)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->points_vie = $points_vie;
        $this->points_attaque = $points_attaque;
        $this->points_defense = $points_defense;
        $this->salle_id = $salle_id;
        $this->arme_id = $arme_id;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPoints_vie()
    {
        return $this->points_vie;
    }

    public function getPoints_attaque()
    {
        return $this->points_attaque;
    }

    public function getPoints_defense()
    {
        return $this->points_defense;
    }

    public function getSalle_id()
    {
        return $this->salle_id;
    }

    public function getArmeId()
    {
        return $this->arme_id;
    }

    //Setters
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPoints_vie($points_vie)
    {
        $this->points_vie = $points_vie;
    }

    public function setPoints_attaque($points_attaque)
    {
        $this->points_attaque = $points_attaque;
    }

    public function setPoints_defense($points_defense)
    {
        $this->points_defense = $points_defense;
    }

    public function setSalle_Id($salle_id)
    {
        $this->salle_id = $salle_id;
    }

    public function setArmeId($arme_id)
    {
        $this->arme_id = $arme_id;
    }
}
