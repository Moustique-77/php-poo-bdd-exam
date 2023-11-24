<?php

//Import file
include_once("Config.php");
include_once("DAO.php");
include_once("GlobalVariables.php");

//Import Class
include_once("Class/Arme.php");
include_once("Class/Inventaire.php");
include_once("Class/Marchand.php");
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

    if ($nom === "") {
        echo "Erreur : Nom non valide." . PHP_EOL;
        creationJoueur();
    }

    //Create a new character and save it in the database
    $player = new Personnage("", $nom, 200, 20, 10, 0, 1, 3);
    $personnageDAO->createPersonnage($player);

    //Get the id of the new character
    $playerName = $personnageDAO->getPersonnageByName($nom);

    if ($playerName === null) {
        echo "Erreur : Personnage non trouvé.";
        creationJoueur();
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
        default:
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            jouer($player);
            break;
    }
}

//Display actual play stats
function statistiques($player)
{
    //import GlobalVariables
    $personnageDAO = GlobalVariables::$personnageDAO;

    $arme = $personnageDAO->getPersonnageWeaponById($player->getId());

    //Display stats
    echo "Vos statistiques & informations :" . PHP_EOL . PHP_EOL;
    echo "Nom : " . $player->getNom() . PHP_EOL;
    echo "Points de vie : " . $player->getPoints_vie() . PHP_EOL;
    echo "Attaque : " . $player->getPoints_attaque() . PHP_EOL;
    echo "Defense : " . $player->getPoints_defense() . PHP_EOL;
    echo "Niveau : " . $player->getNiveau() . PHP_EOL;
    echo "Experience : " . $player->getExperience() . PHP_EOL;
    echo "Arme équipée : " . $arme->getNom() . PHP_EOL . PHP_EOL;

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
        // Get objects and weapons directly from $inventaire
        $objetMagiques = $InventaireDAO->getObjetById($inventaire->getId());
        $armesResult = $InventaireDAO->getPersonnageArmeById($inventaire->getPersonnageId());
    } else {
        echo "Erreur : Inventaire non trouvé." . PHP_EOL;
        return;
    }

    // Display inventory
    echo "Votre inventaire:" . PHP_EOL . PHP_EOL;

    // Display objects in the inventory
    echo "Objets : " . PHP_EOL;
    foreach ($objetMagiques as $objet) {
        echo "- " . $objet->getNom() . " " . $objet->getEffetSpecial() . PHP_EOL;
    }

    // Display weapons in the inventory
    echo PHP_EOL . "Armes : " . PHP_EOL;
    foreach ($armesResult as $arme) {
        echo "- " . $arme->getNom() . " " . $arme->getPointAttaqueBonus() . PHP_EOL;
    }

    // Display the possibility to equip an object or a weapon
    echo PHP_EOL . "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
    echo "1. Equiper une arme" . PHP_EOL;
    echo "2. Utiliser un objet" . PHP_EOL;
    echo "3. Jeter un objet" . PHP_EOL;
    echo "4. Jeter une arme" . PHP_EOL;
    echo "5. Retour" . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            equipArme($player);
            break;
        case 2:
            // utiliserObjet($player);
            break;
        case 3:
            removeObjetFromInventaire($inventaire->getPersonnageId());
            inventaire($player);
            break;
        case 4:

            removeArme($inventaire->getPersonnageId());
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
function removeArme($id)
{
    // Import GlobalVariables
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    echo "id : " . $id . "\n";
    $choix = readline("Quel arme voulez-vous jeter ? (id de l'arme) : ");
    $InventaireDAO->removeArmeFromInventaire($choix, $id);
}

// equip a weapon
function equipArme($player)
{
    // Import GlobalVariables
    $personnageDAO = GlobalVariables::$personnageDAO;
    $choix = readline("Quelle arme souhaiter vous équiper (arme id): ");

    // Check if the weapon is in the player's inventory and if the player meets the required level
    if (checkInInventaire($player, $choix)) {

        if (checkNiveauRequis($player, $choix)) {
            $player->setArme_equiper_id($choix);
            echo $player->getArme_equiper_id();
            $personnageDAO->modifyPersonnage($player);
            inventaire($player);
        } else {
            echo "Vous n'avez le niveaux requis pour équiper cette arme" . PHP_EOL;
            inventaire($player);
        }
    } else {
        echo "Vous n'avez pas cette arme dans votre inventaire." . PHP_EOL;
        inventaire($player);
    }
}

// Check if the player's level meets the required level to equip a weapon
function checkNiveauRequis($player, $choix)
{
    $armeDAO = GlobalVariables::$armeDAO;

    $arme = $armeDAO->getArmeById($choix);
    if ($player->getNiveau() >= $arme->getNiveauRequis($player)) {
        return true;
    } else {
        return false;
    }
}

// Check if a weapon is in the player's inventory
function checkInInventaire($player, $choix)
{
    $InventaireDAO = GlobalVariables::$inventaireDAO;
    $inventaire = $InventaireDAO->getInventaireById($player->getId());
    $armes = $inventaire->getArmeId();

    //convert string to array
    $armes = explode(",", $armes);

    var_dump($armes);

    // Check if the player has the weapon in the array of weapon IDs
    if (in_array($choix, $armes)) {
        return true;
    } else {
        return false;
    }
}

// Start the game and display the story of the game
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

//Enter a room
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

        //If the player finished all the rooms, he win the game
        if ($nbSalle == 0) {
            $salleIsEnd = true;
            echo "Félicitation ! Vous avez fini le donjon !" . PHP_EOL . PHP_EOL;
            echo "Merci d'avoir jouer !" . PHP_EOL . PHP_EOL;
            echo "Appuyez sur entrée pour quitter..." . PHP_EOL;
            readline();
            exit();
        }

        //Display the room
        echo "Il vous reste " . $nbSalle . " salle(s) à finir. Vous êtes dans une salle de type " . $salle->getType() . ", " . $salle->getDescription() . PHP_EOL . PHP_EOL;



        echo "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;

        //Display the room options depending on the room type
        if ($salle->getType() === "bonus") {
            echo "1. Trouver le trésors !" . PHP_EOL;
        } else if ($salle->getType() === "marchant") {
            echo "1. Échanger avec le marchant." . PHP_EOL;
        } else {
            echo "1. Combattre le(s) monstre(s)." . PHP_EOL;
        }
        echo "2. Fuire." . PHP_EOL . PHP_EOL;

        $choix = readline("Votre choix: ");

        switch ($choix) {
            case 1:
                system("clear");
                if ($salle->getType() === "bonus") {
                    $salleIsEnd = trouverTresors($salleIsEnd, $player);
                } else if ($salle->getType() === "marchant") {
                    $salleIsEnd = marchand($player, $salleIsEnd);
                } else {
                    $salleIsEnd = combattre($salleIsEnd, $salle, $player);
                }
                break;
            case 2:
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
}

//Fight against the monster in the current room
function combattre($salleIsEnd, $salle, $player)
{
    //Import GlobalVariables
    $salleDAO = GlobalVariables::$salleDAO;
    $monstreDAO = GlobalVariables::$monstreDAO;
    $personnageDAO = GlobalVariables::$personnageDAO;
    $armeDAO = GlobalVariables::$armeDAO;
    $objetDAO = GlobalVariables::$objetDAO;

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
        echo "Vous êtes niveau : " . $player->getNiveau() . " avec " . $player->getExperience() . " / 20 points d'expérience." . PHP_EOL . PHP_EOL;

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
            echo "2. Fuir" . PHP_EOL . PHP_EOL;

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
                    $playerAttack = $player->getPoints_attaque() * ($armeP->getPointAttaqueBonus());

                    //Monster attack calculation
                    $monsterAttack = $monstres[$randomMonster]->getPoints_attaque() * ($armeM->getPointAttaqueBonus());

                    //Player take dmg calculation
                    $playerTakeDmg = $playerAttack * $monstres[$randomMonster]->getPoints_defense() / 100;

                    //Monster take dmg calculation
                    $monsterTakeDmg = $monsterAttack * $player->getPoints_defense();

                    //Fight
                    $player->setPoints_vie($player->getPoints_vie() - $playerTakeDmg);
                    echo "Vous avez infligé " . $playerAttack . " points de dégats à " . $monstres[$randomMonster]->getNom() . " avec, " . $armeP->getNom() . PHP_EOL . PHP_EOL;

                    $monstres[$randomMonster]->setPoints_vie($monstres[$randomMonster]->getPoints_vie() - $monsterTakeDmg);
                    echo $monstres[$randomMonster]->getNom() . " vous a infligé " . $monsterAttack . " points de dégats avec, " . $armeM->getNom() . PHP_EOL . PHP_EOL;

                    //If the monster is dead, remove it from the array
                    if ($monstres[$randomMonster]->getPoints_vie() <= 0) {
                        echo $monstres[$randomMonster]->getNom() . " est mort !" . PHP_EOL . PHP_EOL;
                        array_splice($monstres, $randomMonster, 1);
                        $player->setExperience($player->getExperience() + 20);
                        echo "Vous avez gagné 10 points d'expérience !" . PHP_EOL . PHP_EOL;

                        //If the player get 20 xp, he level up
                        if ($player->getExperience() >= 20) {
                            $player->setExperience(0);
                            $player->setNiveau($player->getNiveau() + 1);
                            echo "Vous avez gagné un niveau !" . PHP_EOL . PHP_EOL;

                            //Player stats up
                            $player->setPoints_vie($player->getPoints_vie() + 50);
                            $player->setPoints_attaque($player->getPoints_attaque() + 10);
                            $player->setPoints_defense($player->getPoints_defense() + 5);
                        }

                        //Random drop of an object or a weapon
                        $luck = rand(1, 3);
                        if ($luck === 1) {
                            $weaponOrObject = rand(1, 2);
                            if ($weaponOrObject === 1) {
                                $itemAleatoire = (rand(1, 5));
                                $inventaire = $personnageDAO->getPersonnageInventaireById($player->getId());
                                if ($personnageDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                                    // Add the item to the player inventory
                                    $personnageDAO->addArmeToInventaire([$itemAleatoire], $player->getId());

                                    echo "Vous avez trouvé : " . $armeDAO->getArmeById($itemAleatoire) . PHP_EOL . PHP_EOL;
                                } else {
                                    echo "Votre inventaire est plein ! Vous ne pouvez pas prendre cet objet !" . PHP_EOL;
                                    readline("Appuyez sur entrée pour revenir au menu...");
                                }
                            } else {
                                $itemAleatoire = (rand(1, 5));
                                $inventaire = $personnageDAO->getPersonnageInventaireById($player->getId());
                                if ($personnageDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                                    // Add the item to the player inventory
                                    $personnageDAO->addObjetToInventaire([$itemAleatoire], $player->getId());

                                    echo "Vous avez trouvé : " . $objetDAO->getObjetById($itemAleatoire) . PHP_EOL . PHP_EOL;
                                } else {
                                    echo "Votre inventaire est plein ! Vous ne pouvez pas prendre cet objet !" . PHP_EOL;
                                    readline("Appuyez sur entrée pour revenir au menu...");
                                }
                            }
                        }
                    }

                    echo "Appuyez sur entrée pour continuer le combat..." . PHP_EOL;
                    readline();
                    system("clear");
                    break;
                case 2:
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

        //If the player is alive, the room is finished
        if ($player->getPoints_vie() > 0) {
            $salleIsEnd = true;
            return $salleIsEnd;
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
function trouverTresors($salleIsEnd, $player)
{
    //Import GlobalVariables
    $inventaireDAO = GlobalVariables::$inventaireDAO;
    $objetDAO = GlobalVariables::$objetDAO;
    $armeDAO = GlobalVariables::$armeDAO;

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

            //Get random weapon
            $itemAleatoire = (rand(1, 5));
            $inventaire = $inventaireDAO->getInventaireById($player->getId());
            if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                // Add the item to the player inventory
                $inventaireDAO->addArmeToInventaire([$itemAleatoire], $player->getId());

                echo "Vous avez trouvé : " . $armeDAO->getArmeById($itemAleatoire) . PHP_EOL . PHP_EOL;
                readline();
                $salleIsEnd = true;
                return $salleIsEnd;
            } else {
                echo "Votre inventaire est plein ! Vous ne pouvez pas prendre cet objet !" . PHP_EOL;
                readline("Appuyez sur entrée pour revenir au menu...");
                system("clear");
                $salleIsEnd = true;
                return $salleIsEnd;
            }
        } else {
            echo "Vous avez trouvé un objet magique !" . PHP_EOL . PHP_EOL;

            //Get random object
            $itemAleatoire = (rand(1, 5));

            $inventaire = $inventaireDAO->getInventaireById($player->getId());
            if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                // Add the item to the player inventory
                $inventaireDAO->addObjetToInventaire([$itemAleatoire], $player->getId());

                echo "Vous avez trouvé : " . $objetDAO->getObjetById($itemAleatoire) . PHP_EOL . PHP_EOL;
                readline();
                $salleIsEnd = true;
                return $salleIsEnd;
            } else {
                echo "Votre inventaire est plein ! Vous ne pouvez pas prendre cet objet !" . PHP_EOL;
                readline("Appuyez sur entrée pour revenir au menu...");
                system("clear");
                $salleIsEnd = true;
                return $salleIsEnd;
            }
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

//Trade room
function marchand($player, $salleIsEnd)
{
    //Import GlobalVariables
    $marchandDAO = GlobalVariables::$marchandDAO;
    $inventaireDAO = GlobalVariables::$inventaireDAO;

    //Select a random merchant & load it
    $randomMarchand = rand(1, $marchandDAO->countMarchand());
    $marchand = $marchandDAO->getMarchandById($randomMarchand);


    print_r($marchand);

    //Load player inventory
    $inventaire = $inventaireDAO->getInventaireById($player->getId());

    print_r($inventaire);

    system("clear");
    echo "Salle bonus ! Dans cette salle aucun monstre n'est présent, mais vous pouvez échanger des items !" . PHP_EOL . PHP_EOL;
    echo "Bonjour " . $player->getNom() . ", je suis un " . $marchand->getNom() . ", " . $marchand->getDescription() . PHP_EOL . PHP_EOL;

    //Display the player options
    echo "Que voulez-vous faire ?" . PHP_EOL . PHP_EOL;
    echo "1. Échanger avec le " . $marchand->getNom() . "." . PHP_EOL;
    echo "2. Passer à la salle suivante." . PHP_EOL . PHP_EOL;

    $choix = readline("Votre choix: ");

    switch ($choix) {
        case 1:
            system("clear");
            echo "Bienvenue dans ma boutique !" . PHP_EOL . PHP_EOL;
            echo "Voici les items disponibles :" . PHP_EOL . PHP_EOL;

            //Check merchant type and display the items
            //If the merchant is a blacksmith
            if ($marchand->getNom() === "forgeron") {
                // Load the items
                $items = $marchandDAO->getArmesMarchandById(1);

                // Display the items
                foreach ($items as $item) {
                    echo "- ID : " . $item->getId() . "| Arme : " . $item->getNom() . " => " . $item->getPointAttaqueBonus() . " points d'attaque bonus" . PHP_EOL . PHP_EOL;
                }

                //Get Random Item of player inventory
                $inventaire = $inventaireDAO->getInventaireById($player->getId());
                $itemAleatoire = null;

                if ($inventaire !== null) {
                    // Get objects and weapons directly from $inventaire
                    $objetMagiques = $inventaireDAO->getObjetById($inventaire->getId());
                    $armesResult = $inventaireDAO->getPersonnageArmeById($inventaire->getPersonnageId());

                    // Combine objects and weapons into a single array
                    $inventaireComplet = array_merge($objetMagiques, $armesResult);

                    if (!empty($inventaireComplet)) {
                        // Get a random item from the combined inventory
                        $itemAleatoire = $inventaireComplet[array_rand($inventaireComplet)];

                        echo "Je te propose d'échanger ton item : " . $itemAleatoire->getNom() . " contre un de mes items." . PHP_EOL . PHP_EOL;

                        // Display the player options
                        $choix = readline("Choisis l'item (ID) que tu veux échanger avec moi : ") . PHP_EOL . PHP_EOL;

                        // Check if the player choice is valid 
                        if ($choix === $itemAleatoire->getId()) {
                            //Check if the player try to trade the same item as the merchant
                            echo "Tu as déjà cet objet. Tu essaies de me voler !" . PHP_EOL;
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        }
                        //Si le joueur demande un item pas proposé par le marchand
                        elseif ($choix > count($items)) {
                            echo "Je ne vends pas cet item. Tu essaies de me voler !" . PHP_EOL;
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        } else {
                            $inventaire = $inventaireDAO->getInventaireById($player->getId());
                            if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                                // Remove the item from the player inventory
                                $inventaireDAO->removeArmeFromInventaire($choix, $player->getId());

                                // Add the item to the player inventory
                                $inventaireDAO->addArmeToInventaire([$itemAleatoire->getId()], $player->getId());
                            } else {
                                echo "Votre inventaire est plein ! Vous ne pouvez pas échanger !" . PHP_EOL;
                                readline("Appuyez sur entrée pour revenir au menu...");
                            }

                            // Display the result
                            echo PHP_EOL . "Tu as échangé ton item : " . $itemAleatoire->getNom() . " contre l'item n°: " . $choix . PHP_EOL;
                            echo "Tu as maintenant l'item : " . $items[$choix - 1]->getNom() . PHP_EOL . PHP_EOL;
                            echo "Appuyez sur entrée pour continuer..." . PHP_EOL;
                            readline();
                            system("clear");
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        }
                    } else {
                        //system("clear");
                        echo "Ton inventaire est vide ! Je ne peux échanger avec toi..." . PHP_EOL;
                        readline();
                        $salleIsEnd = true;
                        return $salleIsEnd;
                    }
                } else {
                    echo "Erreur : Inventaire non trouvé." . PHP_EOL;
                    return;
                }

                // If the merchant is a mage
            } elseif ($marchand->getNom() === "forgemage") {
                $items = $marchandDAO->getObjetsMarchandById($marchand->getId());

                // Display the items
                foreach ($items as $item) {
                    echo "- ID : " . $item->getId() . "| Objet : " . $item->getNom() . " => " . $item->getEffetSpecial() . PHP_EOL . PHP_EOL;
                }

                //Get Random Item of player inventory
                $inventaire = $inventaireDAO->getInventaireById($player->getId());
                $itemAleatoire = null;

                if ($inventaire !== null) {
                    // Get objects and weapons directly from $inventaire
                    $objetMagiques = $inventaireDAO->getObjetById($inventaire->getId());
                    $armesResult = $inventaireDAO->getPersonnageArmeById($inventaire->getPersonnageId());

                    // Combine objects and weapons into a single array
                    $inventaireComplet = array_merge($objetMagiques, $armesResult);

                    if (!empty($inventaireComplet)) {
                        // Get a random item from the combined inventory
                        $itemAleatoire = $inventaireComplet[array_rand($inventaireComplet)];

                        echo "Je te propose d'échanger ton item : " . $itemAleatoire->getNom() . " contre un de mes items." . PHP_EOL . PHP_EOL;

                        // Display the player options
                        $choix = readline("Choisis l'item (ID) que tu veux échanger avec moi : ") . PHP_EOL . PHP_EOL;

                        // Check if the player choice is valid 
                        if ($choix === $itemAleatoire->getId()) {
                            //Check if the player try to trade the same item as the merchant
                            echo "Tu as déjà cet objet. Tu essaies de me voler !" . PHP_EOL;
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        }
                        //Si le joueur demande un item pas proposé par le marchand
                        elseif ($choix > count($items)) {
                            echo "Je ne vends pas cet item. Tu essaies de me voler !" . PHP_EOL;
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        } else {
                            $inventaire = $inventaireDAO->getInventaireById($player->getId());
                            if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {
                                // Remove the item from the player inventory
                                $inventaireDAO->removeObjetFromInventaire($choix, $player->getId());

                                // Add the item to the player inventory
                                $inventaireDAO->addObjetToInventaire([$itemAleatoire->getId()], $player->getId());
                            } else {
                                echo "Votre inventaire est plein ! Vous ne pouvez pas échanger !" . PHP_EOL;
                                readline("Appuyez sur entrée pour revenir au menu...");
                            }

                            // Display the result
                            echo PHP_EOL . "Tu as échangé ton item : " . $itemAleatoire->getNom() . " contre l'item n°: " . $choix . PHP_EOL;
                            echo "Tu as maintenant l'item : " . $items[$choix - 1]->getNom() . PHP_EOL . PHP_EOL;
                            echo "Appuyez sur entrée pour continuer..." . PHP_EOL;
                            readline();
                            system("clear");
                            $salleIsEnd = true;
                            return $salleIsEnd;
                        }
                    } else {
                        //system("clear");
                        echo "Ton inventaire est vide ! Je ne peux échanger avec toi..." . PHP_EOL;
                        readline();
                        $salleIsEnd = true;
                        return $salleIsEnd;
                    }
                } else {
                    echo "Erreur : Inventaire non trouvé." . PHP_EOL;
                    return;
                }
            } else {
                echo "Erreur : Marchand non trouvé." . PHP_EOL;
                return;
            }

            break;
        case 2:
            system("clear");
            echo "Vous avez quitté la salle bonus !" . PHP_EOL . PHP_EOL;
            echo "Appuyez sur entrée pour continuer..." . PHP_EOL;
            readline();
            $salleIsEnd = true;
            return $salleIsEnd;
        default:
            system("clear");
            echo "Erreur de saisie, merci de choisir une option valide." . PHP_EOL . PHP_EOL;
            marchand($player, $salleIsEnd);
            break;
    }
}

function ajouterArme($player)
{
    //Import GlobalVariables
    $inventaireDAO = GlobalVariables::$inventaireDAO;
    $inventaire = $inventaireDAO->getInventaireById($player->getId());
    echo $inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId());
    if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {

        $inventaire = $inventaireDAO->getInventaireById($player->getId());


        // Initialize the $armes array
        $armes = [];

        $idArme = readline("Saisir l'id de l'arme à ajouter : ");
        array_push($armes, $idArme);


        $inventaireDAO->addArmeToInventaire($armes, $player->getId());
    } else {
        echo "Votre inventaire est plein ! Vous ne pouvez pas ajouter d'arme !" . PHP_EOL;
        readline("Appuyez sur entrée pour revenir au menu...");
    }
}

function ajouterObjetMagique($player)
{
    //Import GlobalVariables
    $inventaireDAO = GlobalVariables::$inventaireDAO;
    $inventaire = $inventaireDAO->getInventaireById($player->getId());
    echo $inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId());
    if ($inventaireDAO->getNbItemInventaireById($inventaire->getPersonnageId()) < $inventaire->getTaille()) {

        // Initialize the $objets array
        $objets = [];

        $idObjet = readline("Saisir l'id de l'objet magique à ajouter : ");
        array_push($objets, $idObjet);

        $inventaireDAO->addObjetToInventaire($objets, $player->getId());
    } else {
        echo "Votre inventaire est plein ! Vous ne pouvez pas ajouter d'objet !" . PHP_EOL;
        readline("Appuyez sur entrée pour revenir au menu...");
    }
}

//Start the game
bienvenue();
