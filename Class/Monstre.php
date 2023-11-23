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

    public function getPointsVie()
    {
        return $this->points_vie;
    }

    public function getPointsAttaque()
    {
        return $this->points_attaque;
    }

    public function getPointsDefense()
    {
        return $this->points_defense;
    }

    public function getSalleId()
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

    public function setPointsVie($points_vie)
    {
        $this->points_vie = $points_vie;
    }

    public function setPointsAttaque($points_attaque)
    {
        $this->points_attaque = $points_attaque;
    }

    public function setPointsDefense($points_defense)
    {
        $this->points_defense = $points_defense;
    }

    public function setSalleId($salle_id)
    {
        $this->salle_id = $salle_id;
    }

    public function setArmeId($arme_id)
    {
        $this->arme_id = $arme_id;
    }
}
