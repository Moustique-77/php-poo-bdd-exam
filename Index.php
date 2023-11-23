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

//Connect to the database
GlobalVariables::init($bdd);


function bienvenue()
{
    system("clear");
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
    $inventaireDAO = GlobalVariables::$inventaireDAO;

    //Chose a character name
    echo "Veuillez choisir un nom pour votre personnage : ";
    $nom = readline();

    //Create a new character and save it in the database
    $player = new Personnage("", $nom, 20, 2, 2, 0, 1, "");
    $personnageDAO->createPersonnage($player);

    //Get the id of the new character
    $playerName = $personnageDAO->getPersonnageByName($nom);

    if ($playerName === null) {
        echo "Erreur : Personnage non trouvé.";
        exit(); // ou gérer d'une autre manière selon vos besoins
    }

    $inventory = new Inventaire("", $playerName->getId(), "", "", 10);
    $inventaireDAO->createInventaire($inventory);

    $player = $playerName;

    //Start the game
    jouer($player);
}


function jouer($player)
{
    system("clear");
    echo "Bienvenue " . $player->getNom() . " que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
    echo "1. Entrer dans le donjon"  . PHP_EOL;
    echo "2. Voir vos statistiques" . PHP_EOL;
    echo "3. Ouvrir votre inventaire" . PHP_EOL;
    echo "4. Quitter" . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            system("clear");
            entrerDonjon($player);
            break;
        case 2:
            system("clear");
            statistiques($player);
            break;
        case 3:
            system("clear");
            inventaire($player);
            break;
        case 4:
            echo "A bientot !";
            exit();
        default:
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            jouer($player);
            break;
    }
}

//Display actual play stats
function statistiques($player)
{
    echo "Vos statistiques & informations :" . PHP_EOL . PHP_EOL;
    echo "Nom : " . $player->getNom() . PHP_EOL;
    echo "Points de vie : " . $player->getPoints_vie() . PHP_EOL;
    echo "Attaque : " . $player->getPoints_attaque() . PHP_EOL;
    echo "Defense : " . $player->getPoints_defense() . PHP_EOL;
    echo "Niveau : " . $player->getNiveau() . PHP_EOL;
    echo "Experience : " . $player->getExperience() . PHP_EOL . PHP_EOL;

    echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
    readline();
    jouer($player);
}

function inventaire($player)
{
    print_r($player);
    //Import GlobalVariables
    $InventaireDAO = GlobalVariables::$inventaireDAO;

    $inventaire = $InventaireDAO->getInventaireById($player->getId());
    print_r($inventaire);
    if ($inventaire !== null) {
        $objetMagique = $InventaireDAO->getObjetById($inventaire->getId());
        $arme = $InventaireDAO->getArmeById($inventaire->getId());
    } else {
        echo "Erreur : Inventaire non trouvé.";
    }
    // Display inventory

    // Check if the inventory is empty
    if (empty($objetMagique) && empty($arme)) {
        echo "Votre inventaire est vide!" . PHP_EOL . PHP_EOL;
        echo "Appuyer sur entre pour revenir au menu..." . PHP_EOL;
        readline();
        jouer($player);
    } else {
        echo "Your inventory:" . PHP_EOL . PHP_EOL;

        // Display objects in the inventory
        echo "Objects: " . PHP_EOL;
        foreach ($objetMagique as $objet) {
            echo $objet->getNom() . PHP_EOL;
        }

        // Display weapons in the inventory
        echo "Weapons: " . PHP_EOL;
        foreach ($arme as $arme) {
            echo $arme->getNom() . PHP_EOL;
        }
    }
}


function entrerDonjon($player)
{
    //Import GlobalVariables
    $salleDAO = GlobalVariables::$salleDAO;

    //Get the number of rooms in the dungeon
    $nbSalle = $salleDAO->getNbSalle();

    //Story of the game
    system("clear");
    echo "Vous entrez dans un donjon..." . PHP_EOL . PHP_EOL;
    readline();
    system("clear");
    echo "Vous allez devoir affronter des monstres pour progresser dans le donjon de salle en salle..." . PHP_EOL . PHP_EOL;
    readline();
    system("clear");
    echo "Vous pouvez vous équiper d'armes et d'objets magiques pour vous aider dans votre quête..." . PHP_EOL . PHP_EOL;
    readline();
    system("clear");
    echo "Vous allez devoir survire à " . $nbSalle . " salles dans ce donjon" . PHP_EOL . PHP_EOL;
    readline();
    system("clear");
    echo "Bonne chance !" . PHP_EOL . PHP_EOL;
    readline();
    system("clear");

    //Player game options
    echo "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
    echo "1. Entrer dans la salle." . PHP_EOL;
    echo "2. Ouvrir votre inventaire." . PHP_EOL;
    echo "3. Fuire." . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            system("clear");
            entrerSalle($player);
            break;
        case 2:
            system("clear");
            inventaire($player);
            break;
        case 3:
            system("clear");
            echo "Vous avez fuit le donjon !" . PHP_EOL . PHP_EOL;
            echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
            readline();
            jouer($player);
            break;
        default:
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            entrerDonjon($player);
            break;
    }
}

function entrerSalle($player)
{
    //Import GlobalVariables
    $salleDAO = GlobalVariables::$salleDAO;

    //Load all the rooms
    $salles = $salleDAO->getAllSalle();
}








//Start the game
bienvenue();
