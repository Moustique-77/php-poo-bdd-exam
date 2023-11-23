<?php

//Import file
include_once("Config.php");
include_once("DAO.php");

//Import Class
include_once("Class/Arme.php");
include_once("Class/Inventaire.php");
include_once("Class/Monstre.php");
include_once("Class/ObjetMagique.php");
include_once("Class/Personnage.php");
include_once("Class/Salle.php");

//Connect to database
$armeDAO = new ArmeDAO($bdd);
$inventaireDAO = new InventaireDAO($bdd);
$monstreDAO = new MonstreDAO($bdd);
$objetMagiqueDAO = new ObjetMagiqueDAO($bdd);
$personnageDAO = new PersonnageDAO($bdd);
$salleDAO = new SalleDAO($bdd);
