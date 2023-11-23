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

//Lunch the game with the main menu
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

//Create a new character and save it in the database
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

//Load a character from the database and start the game with it
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
        case 5:
            system("clear");

            ajouterArme($player);
            ajouterObjetMagique($player);
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

// Display the player inventory and the possibility to equip an object or a weapon
function inventaire($player)
{
    // Import GlobalVariables
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    $inventaire = $InventaireDAO->getInventaireById($player->getId());

    if ($inventaire !== null) {
        $objetMagiques = $InventaireDAO->getObjetById($inventaire->getId());
        $armesResult = $InventaireDAO->getArmeById($inventaire->getPersonnageId());
    } else {
        echo "Erreur : Inventaire non trouvé." . PHP_EOL;
        return;
    }

    // Display inventory
    echo "Your inventory:" . PHP_EOL . PHP_EOL;

    // Display objects in the inventory
    echo "Objects: " . PHP_EOL;
    foreach ($objetMagiques as $objet) {
        echo $objet->getNom() . PHP_EOL;
        echo $objet->getEffetSpecial() . PHP_EOL;
        echo $objet->getEstMaudit() . PHP_EOL;
    }

    // Display weapons in the inventory
    echo "Weapons: " . PHP_EOL;
    foreach ($armesResult as $arme) {
        echo $arme->getNom();
        echo $arme->getPointAttaqueBonus() . PHP_EOL;
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

    //Select a random rooms
    $salleRandom = rand(1, $salleDAO->getNbSalle());

    //Load the room
    $salle = $salleDAO->getSalleById($salleRandom);

    //boolean for end of the room
    $salleIsEnd = false;

    //While the room is not finished
    while ($salleIsEnd === false) {
        //Display the room
        echo "Vous êtes dans la salle n°" . $salle->getId() . " c'est une salle de type " . $salle->getType() . ", " . $salle->getDescription() . PHP_EOL . PHP_EOL;
        echo "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;

        //Display the room options depending on the room type
        if ($salle->getType() === "bonus") {
            echo "1. Trouver le trésors !" . PHP_EOL;
        } else if ($salle->getType() === "marchant") {
            echo "1. Échanger avec le marchant." . PHP_EOL;
        } else {
            echo "1. Combattre le(s) monstre(s)." . PHP_EOL;
        }

        echo "2. Ouvrir votre inventaire." . PHP_EOL;
        echo "3. Fuire." . PHP_EOL . PHP_EOL;

        $choix = readline("Votre choix: ");

        switch ($choix) {
            case 1:
                system("clear");
                if ($salle->getType() === "Bonus") {
                    trouverTresors($salleIsEnd);
                } else {
                    combattre($salleIsEnd, $salle, $player);
                }
                break;
            case 2:
                system("clear");
                inventaire($player);
                break;
            case 3:
                system("clear");
                echo "Vous avez fuit la salle !" . PHP_EOL . PHP_EOL;
                echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
                readline();
                jouer($player);
                break;
            default:
                system("clear");
                echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
                entrerSalle($player);
                break;
        }
    }

    //TODO : END OF THE ROOM

}

//Fight against the monster in the current room
function combattre($salleIsEnd, $salle, $player)
{
    //Import GlobalVariables
    $salleDAO = GlobalVariables::$salleDAO;
    $monstreDAO = GlobalVariables::$monstreDAO;

    //Load the monster(s) for the room
    $monstresIds = $salleDAO->getSalleMonstreById($salle->getId());

    //Load the monster(s) data, create objects of the monster(s) and put them in an array
    foreach ($monstresIds as $monstreId) {
        $monstre = $monstreDAO->getMonstreById($monstreId);
        $monstre = new Monstre($monstre->getId(), $monstre->getNom(), $monstre->getPoints_vie(), $monstre->getPoints_attaque(), $monstre->getPoints_defense(), $monstre->getSalle_id(), $monstre->getArmeId());
        $monstres[] = $monstre;
    }

    echo "Vous allez devoir combattre le(s) monstre(s) d'une salle " . $salle->getType() . ", " . $salle->getDescription() . PHP_EOL . PHP_EOL;

    if ($player->getPoints_vie() > 0) {

        echo "Vous avez " . $player->getPoints_vie() . " points de vie." . PHP_EOL . PHP_EOL;

        //Display all the monsters in the room
        echo "Vous allez devoir combattre " . count($monstres) . " monstre(s)." . PHP_EOL . PHP_EOL;
        foreach ($monstres as $monstre) {
            echo "- " . $monstre->getNom() . " avec " . $monstre->getPoints_vie() . " points de vie." . PHP_EOL . PHP_EOL;
        }
    } else {
        echo "Vous êtes mort !" . PHP_EOL . PHP_EOL;
        echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
        readline();
        jouer($player);
    }



    //LOGIQUE DE JEU

    //If the player kill the monster, he can go to the next room
    //If the player is alive, he can go to the next room
    //If the player is dead, display the game over screen
}

//If the player is lucky, he get an object, else, the room is finished
function trouverTresors($salleIsEnd)
{
    system("clear");
    echo "Vous cherchez un trésor...";
    readline();
    system("clear");
    echo "Hmmm...";
    readline();
    system("clear");

    //Random numbre to get a object or not
    $luck = rand(1, 3);

    //If the player is lucky, he get an object
    if ($luck === 1) {
        echo "Il a y quelque chose ici !" . PHP_EOL . PHP_EOL;
        readline();
        system("clear");
        $weaponOrObject = rand(1, 2);

        //If the player get a weapon
        if ($weaponOrObject === 1) {
            echo "Vous avez trouvé une arme !" . PHP_EOL . PHP_EOL;
            //TODO : Ajouter l'arme random à l'inventaire
        } else {
            echo "Vous avez trouvé un objet magique !" . PHP_EOL . PHP_EOL;
            //TODO : Ajouter l'objet magique random à l'inventaire
        }
    } else {
        echo "Il n'y a rien par ici.. Que de la poussière et des toiles d'araignée..." . PHP_EOL . PHP_EOL;
        readline();
        system("clear");
        //End of the room
        $salleIsEnd = true;
        return $salleIsEnd;
    }
}

function ajouterArme($player)
{
    //Import GlobalVariables
    $inventaireDAO = GlobalVariables::$inventaireDAO;

    echo "Sélectionner le nombre d'arme à ajouter à votre inventaire : " . PHP_EOL;

    // Initialize the $armes array
    $armes = [];

    $idArme = readline("Saisir l'id de l'arme à ajouter : ");
    array_push($armes, $idArme);


    $inventaireDAO->addArmeToInventaire($armes, $player->getId());
}

function ajouterObjetMagique($player)
{
    //Import GlobalVariables
    $inventaireDAO = GlobalVariables::$inventaireDAO;

    echo "Sélectionner le nombre d'objet magique à ajouter à votre inventaire : " . PHP_EOL;

    // Initialize the $objets array
    $objets = [];

    $idObjet = readline("Saisir l'id de l'objet magique à ajouter : ");
    array_push($objets, $idObjet);

    $inventaireDAO->addObjetToInventaire($objets, $player->getId());
}



//Start the game
bienvenue();
