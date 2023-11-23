<?php


class Arme
{

    private $id;
    private $nom;
    private $niveau_requis;
    private $point_attaque_bonus;

    public function __construct($id, $nom, $niveau_requis, $point_attaque_bonus)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->niveau_requis = $niveau_requis;
        $this->point_attaque_bonus = $point_attaque_bonus;
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

    public function getNiveauRequis()
    {
        return $this->niveau_requis;
    }

    public function getPointAttaqueBonus()
    {
        return $this->point_attaque_bonus;
    }

    // Setters
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setNiveauRequis($niveau_requis)
    {
        $this->niveau_requis = $niveau_requis;
    }

    public function setPointAttaqueBonus($point_attaque_bonus)
    {
        $this->point_attaque_bonus = $point_attaque_bonus;
    }
}
