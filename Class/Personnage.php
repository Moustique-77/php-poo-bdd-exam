<?php

// implémentez une classe Personnage avec des
// attributs tels que le nom, les points de vie (PV), les points d'attaque (PA), les points de défense (PD), une gestion de l'expérience, et une évolution des compétences avec le niveau.

class Personnage
{
    private $id;
    private $nom;
    private $points_vie;
    private $points_attaque;
    private $points_defense;
    private $experience;
    private $niveau;
    private $arme_equiper_id;

    public function __construct($id, $nom, $pv, $pa, $pd, $exp, $niveau, $arme_equiper_id)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->points_vie = $pv;
        $this->points_attaque = $pa;
        $this->points_defense = $pd;
        $this->experience = $exp;
        $this->niveau = $niveau;
        $this->arme_equiper_id = $arme_equiper_id;
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

    public function getExperience()
    {
        return $this->experience;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function getArme_equiper_id()
    {
        return $this->arme_equiper_id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    // Setters
    public function setPoints_vie($pv)
    {
        $this->points_vie = $pv;
    }

    public function setPoints_attaque($pa)
    {
        $this->points_attaque = $pa;
    }

    public function setPoints_defense($pd)
    {
        $this->points_defense = $pd;
    }

    public function setExperience($exp)
    {
        $this->experience = $exp;
    }

    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }

    public function setArme_equiper_id($arme_equiper_id)
    {
        $this->arme_equiper_id = $arme_equiper_id;
    }
}
