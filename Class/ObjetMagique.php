<?php

class ObjetMagique
{
    private $id;
    private $nom;
    private $effet_special;
    private $est_maudit;
    private $types;
    private $valeur;

    public function __construct($id, $nom, $effet_special, $est_maudit, $types, $valeur)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->effet_special = $effet_special;
        $this->est_maudit = $est_maudit;
        $this->types = $types;
        $this->valeur = $valeur;
    }

    //getters  
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getEffetSpecial()
    {
        return $this->effet_special;
    }

    public function getEstMaudit()
    {
        return $this->est_maudit;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getValeur()
    {
        return $this->valeur;
    }

    //setters
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setEffetSpecial($effet_special)
    {
        $this->effet_special = $effet_special;
    }

    public function setEstMaudit($est_maudit)
    {
        $this->est_maudit = $est_maudit;
    }

    public function setTypes($types)
    {
        $this->types = $types;
    }

    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }
}
