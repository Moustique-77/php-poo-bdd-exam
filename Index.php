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
    $player = new Personnage("", $nom, 200, 20, 10, 0, 1, 3);
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
    print_r($inventaire);
    if ($inventaire !== null) {
        // Get objects and weapons directly from $inventaire
        $objetMagiques = $InventaireDAO->getObjetById($inventaire->getId());
        $armesResult = $InventaireDAO->getArmeById($inventaire->getPersonnageId());
    } else {
        echo "Erreur : Inventaire non trouvé." . PHP_EOL;
        return;
    }

    // Display inventory
    echo "Votre inventaire:" . PHP_EOL . PHP_EOL;

    // Display objects in the inventory
    echo "Objects: " . PHP_EOL;
    foreach ($objetMagiques as $objet) {
        echo $objet->getNom() . PHP_EOL;
        echo $objet->getEffetSpecial() . PHP_EOL;
    }

    // Display weapons in the inventory
    echo "Weapons: " . PHP_EOL;
    foreach ($armesResult as $arme) {
        echo $arme->getNom() . PHP_EOL;
        echo $arme->getPointAttaqueBonus() . PHP_EOL;
    }

    // Display the possibility to equip an object or a weapon
    echo "1. Equiper une arme" . PHP_EOL;
    echo "2. Utiliser un objet" . PHP_EOL;
    echo "3. Jeter un objet" . PHP_EOL;
    echo "4. Jeter une arme" . PHP_EOL;
    echo "5. Retour" . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            // equiperArme($player);
            break;
        case 2:
            // utiliserObjet($player);
            break;
        case 3:
            removeObjetFromInventaire($inventaire->getId());
            inventaire($player);
            break;
        case 4:
            removeArmeFromInventaire($inventaire->getId());
            inventaire($player);
            break;
        case 5:
            jouer($player);
            break;
        default:
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            inventaire($player);
            break;
    }
}


// Remove an object from the inventory
function removeObjetFromInventaire($id)
{
    // Import GlobalVariables
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    $choix = readline("Quel objet voulez-vous jeter ? (id de l'objet) : ");
    $InventaireDAO->removeObjetFromInventaire($choix, $id);
}

// Remove a weapon from the inventory
function removeArmeFromInventaire($id)
{
    // Import GlobalVariables
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    echo "id : " . $id . "\n";
    $choix = readline("Quel arme voulez-vous jeter ? (id de l'arme) : ");
    $InventaireDAO->removeArmeFromInventaire($choix, $id);
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
            entrerSalle($player, $nbSalle);
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

function entrerSalle($player, $nbSalle)
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
                if ($salle->getType() === "bonus") {
                    trouverTresors($salleIsEnd);
                } else if ($salle->getType() === "marchant") {
                    //TODO : MARCHAND
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
                entrerSalle($player, $nbSalle);
                break;
        }
    }

    //If the room is finished, go to the next room
    if ($salleIsEnd === true) {
        echo "Vous avez fini la salle : " . $salle->getType() . " !" . PHP_EOL . PHP_EOL;
        $nbSalle--;
        echo "Appuyez sur entrée pour continuer..." . PHP_EOL;
        readline();
        entrerSalle($player, $nbSalle);
    }

    //If the player finished all the rooms, he win the game
    if ($nbSalle === 0) {
        echo "Félicitation ! Vous avez fini le donjon !" . PHP_EOL . PHP_EOL;
        echo "Merci d'avoir jouer !" . PHP_EOL . PHP_EOL;
        echo "Appuyez sur entrée pour quitter..." . PHP_EOL;
        readline();
        exit();
    }
}

//Fight against the monster in the current room
function combattre($salleIsEnd, $salle, $player)
{
    //Import GlobalVariables
    $salleDAO = GlobalVariables::$salleDAO;
    $monstreDAO = GlobalVariables::$monstreDAO;
    $personnageDAO = GlobalVariables::$personnageDAO;

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

        echo "Appuyez sur entrée pour commencer le combat..." . PHP_EOL;
        readline();
        system("clear");

        //While the player is alive and there is still monsters in the room
        while ($player->getPoints_vie() > 0 && count($monstres) > 0) {
            //Display the player life
            echo "Vous avez " . $player->getPoints_vie() . " points de vie." . PHP_EOL . PHP_EOL;

            //Display the monsters life
            echo "Il reste " . count($monstres) . " monstre(s) en vie." . PHP_EOL . PHP_EOL;
            foreach ($monstres as $monstre) {
                echo "- " . $monstre->getNom() . " avec " . $monstre->getPoints_vie() . " points de vie." . PHP_EOL . PHP_EOL;
            }

            //Display the player options
            echo "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
            echo "1. Attaquer" . PHP_EOL;
            echo "2. Ouvrir votre inventaire" . PHP_EOL;
            echo "3. Fuir" . PHP_EOL . PHP_EOL;

            $choix = readline("Votre choix: ");

            switch ($choix) {
                case 1:
                    system("clear");

                    //Random monster attack
                    $randomMonster = rand(0, count($monstres) - 1);

                    //Get weapon
                    $armeP = $personnageDAO->getPersonnageWeaponById($player->getId());
                    $armeM = $monstreDAO->getMonstreWeaponById($monstres[$randomMonster]->getId());

                    //Player attack calculation
                    $playerAttack = $player->getPoints_attaque() * ($armeP->getPointAttaqueBonus() / 100);

                    //Monster attack calculation
                    $monsterAttack = $monstres[$randomMonster]->getPoints_attaque() * ($armeM->getPointAttaqueBonus() / 100);

                    //Player take dmg calculation
                    $playerTakeDmg = $playerAttack * $monstres[$randomMonster]->getPoints_defense() / 100;

                    //Monster take dmg calculation
                    $monsterTakeDmg = $monsterAttack * $player->getPoints_defense() / 100;

                    //Fight
                    $player->setPoints_vie($player->getPoints_vie() - $playerTakeDmg);
                    echo "Vous avez infligé " . $playerAttack . " points de dégats à " . $monstres[$randomMonster]->getNom() . " avec, " . $armeP->getNom() . PHP_EOL . PHP_EOL;

                    $monstres[$randomMonster]->setPoints_vie($monstres[$randomMonster]->getPoints_vie() - $monsterTakeDmg);
                    echo $monstres[$randomMonster]->getNom() . " vous a infligé " . $monsterAttack . " points de dégats avec, " . $armeM->getNom() . PHP_EOL . PHP_EOL;

                    //If the monster is dead, remove it from the array
                    if ($monstres[$randomMonster]->getPoints_vie() <= 0) {
                        echo $monstres[$randomMonster]->getNom() . " est mort !" . PHP_EOL . PHP_EOL;
                        array_splice($monstres, $randomMonster, 1);
                    }

                    echo "Appuyez sur entrée pour continuer le combat..." . PHP_EOL;
                    readline();

                    break;
                case 2:
                    system("clear");
                    inventaire($player);
                    break;
                case 3:
                    system("clear");
                    echo "Vous avez fuit le combat !" . PHP_EOL . PHP_EOL;
                    echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
                    readline();
                    jouer($player);
                    break;
                default:
                    system("clear");
                    echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
                    combattre($salleIsEnd, $salle, $player);
                    break;
            }
        }
    } else {
        echo "Vous êtes mort !" . PHP_EOL . PHP_EOL;
        echo "Appuyez sur entrée pour revenir au menu principal..." . PHP_EOL;
        readline();
        $salleIsEnd = true;
        return $salleIsEnd;
    }
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
