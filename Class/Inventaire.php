<?php

class Inventaire
{

    private $id;
    private $personnage_id;
    private $objet_id;
    private $arme_id;
    private $taille;

    public function __construct($id, $personnage_id, $objet_id, $arme_id, $taille)
    {
        $this->id = $id;
        $this->personnage_id = $personnage_id;
        $this->objet_id = $objet_id;
        $this->arme_id = $arme_id;
        $this->taille = $taille;
    }

    //getters
    public function getId()
    {
        return $this->id;
    }

    public function getPersonnageId()
    {
        return $this->personnage_id;
    }

    public function getObjetId()
    {
        return $this->objet_id;
    }

    public function getArmeId()
    {
        return $this->arme_id;
    }

    public function getTaille()
    {
        return $this->taille;
    }

    //setters
    public function setPersonnageId($personnage_id)
    {
        $this->personnage_id = $personnage_id;
    }

    public function setObjetId($objet_id)
    {
        $this->objet_id = $objet_id;
    }

    public function setArmeId($arme_id)
    {
        $this->arme_id = $arme_id;
    }

    public function setTaille($taille)
    {
        $this->taille = $taille;
    }
}
