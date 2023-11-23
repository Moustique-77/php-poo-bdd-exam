<?php

//Import file
include_once("Config.php");
include_once("DAO.php");
include_once("GlobalVariables.php");

//Import Class
include_once("Class/Arme.php");
include_once("Class/Inventaire.php");
include_once("Class/Monstre.php");
include_once("Class/ObjetMagique.php");
include_once("Class/Personnage.php");
include_once("Class/Salle.php");

GlobalVariables::init($bdd);

//Connect to database
// $armeDAO = new ArmeDAO($bdd);
// $inventaireDAO = new InventaireDAO($bdd);
// $monstreDAO = new MonstreDAO($bdd);
// $objetMagiqueDAO = new ObjetMagiqueDAO($bdd);
// $personnageDAO = new PersonnageDAO($bdd);
// $salleDAO = new SalleDAO($bdd);

function bienvenue()
{
    echo "Bienvenue sur le jeu" . PHP_EOL . PHP_EOL;
    echo "1. Nouvelle partie" . PHP_EOL;
    echo "2. Charger une partie" . PHP_EOL;
    echo "3. Quitter" . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            system("clear");
            creationJoueur();
            break;
        case 2:
            system("clear");
            //TODO
            //chargerPartie();
        case 3:
            echo "A bientot !";
            exit();
        default:
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            bienvenue();
            break;
    }
}

function creationJoueur()
{
    //Import GlobalVariables
    $personnageDAO = GlobalVariables::$personnageDAO;

    //Chose a character name
    echo "Veuillez choisir un nom pour votre personnage: " . PHP_EOL;
    $nom = readline("Votre nom: ");

    //Create a new character and save it in database
    $player = new Personnage("", $nom, 20, 2, 2, 0, 1, "");
    $personnageDAO->createPersonnage($player);

    jouer($player);
}


function jouer($player)
{
    echo "Bienvenue " . $player->getNom() . "que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
    echo "1. Entrer dans le donjon"  . PHP_EOL;
    echo "2. Voir vos statistiques" . PHP_EOL;
    echo "3. Ouvrir votre inventaire" . PHP_EOL;
    echo "4. Quitter" . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            system("clear");
            //entrerDonjon();
            break;
        case 2:
            system("clear");
            //TODO
            //statistiques();
            break;
        case 3:
            system("clear");
            //TODO
            //inventaire();
            break;
        case 4:
            echo "A bientot\n";
            exit();
        default:
            echo "Erreur de saisie\n";
            jouer($player);
            break;
    }
}

//Display actual play stats
function statistiques()
{
    //echo "Vos statistiques:" . PHP_EOL . PHP_EOL;
    //echo "Nom: " . $personnage->getNom() . PHP_EOL;
}
















function inventaire()
{
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    $Personnage = GlobalVariables::$personnageDAO;
    $inventaire = $InventaireDAO->getInventaire($Personnage->getId());
    echo "Votre inventaire:" . PHP_EOL . PHP_EOL;
}





//Start the game
bienvenue();
