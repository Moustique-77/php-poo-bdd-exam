<?php

class ArmeDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Get arme by id
    public function getArmeById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM arme WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Arme($donnees['id'], $donnees['nom'], $donnees['niveau_  requis'], $donnees['points_attaque_bonus']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'arme : ' . $e->getMessage());
        }
    }
}

class InventaireDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Create inventaire
    public function createInventaire(Inventaire $inventaire)
    {
        $personnage_id = $inventaire->getPersonnageId();

        try {
            $req = $this->bdd->prepare('INSERT INTO inventaire (personnage_id) VALUES (:personnage_id)');
            $req->bindParam(':personnage_id', $personnage_id, PDO::PARAM_INT);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur lors de la creation de l\'inventaire : ' . $e->getMessage());
        }
    }

    // Get inventaire by id
    public function getInventaireById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM inventaire WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);

            // Check if data is retrieved before creating an object
            if ($donnees) {
                return new Inventaire(
                    $donnees['id'],
                    $donnees['personnage_id'],
                    $donnees['arme_id'],
                    $donnees['objet_id'],
                    $donnees['taille']
                );
            } else {
                return null;
            }
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'inventaire : ' . $e->getMessage());
        }
    }

    // Get arme by id
    public function getArmeById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT A.id AS arme_id,
                A.nom AS nom_arme,
                A.niveau_requis,
                A.points_attaque_bonus
                FROM Inventaire I
                JOIN Arme A ON I.arme_id = A.id
                WHERE I.personnage_id = :personnage_id
            ');

            $req->bindParam(':personnage_id', $id, PDO::PARAM_INT);
            $req->execute();

            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            $armes = [];

            foreach ($donnees as $arme) {
                $armes[] = new Arme(
                    $arme['arme_id'],
                    $arme['nom_arme'],
                    $arme['niveau_requis'],
                    $arme['points_attaque_bonus']
                );
            }

            return $armes;
        } catch (Exception $e) {
            die('Erreur lors de la récupération de l\'arme : ' . $e->getMessage());
        }
    }

    // Get objet by id
    public function getObjetById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT OM.id AS objet_magique_id,
                OM.nom AS nom_objet_magique,
                OM.effet_special,
                OM.est_maudit
                FROM Inventaire I
                JOIN ObjetsMagiques OM ON I.objet_id = OM.id
                WHERE I.personnage_id = :personnage_id
            ');

            $req->bindParam(':personnage_id', $id, PDO::PARAM_INT); // Fix the binding parameter name
            $req->execute();

            $donnees = $req->fetchAll(PDO::FETCH_ASSOC); // Use fetchAll to get all rows
            $objetMagiques = [];

            foreach ($donnees as $objetMagique) {
                $objetMagiques[] = new ObjetMagique(
                    $objetMagique['objet_magique_id'],
                    $objetMagique['nom_objet_magique'],
                    $objetMagique['effet_special'],
                    $objetMagique['est_maudit']
                );
            }

            return $objetMagiques;
        } catch (Exception $e) {
            die('Erreur lors de la récupération de l\'objet : ' . $e->getMessage());
        }
    }


    // Modify inventaire by id
    public function modifyInventaire(Inventaire $inventaire)
    {
        $id = $inventaire->getId();
        $arme_id = $inventaire->getArmeId();
        $objet_id = $inventaire->getObjetId();
        $taille = $inventaire->getTaille();
        try {
            $req = $this->bdd->prepare('UPDATE inventaire SET arme_id = :arme_id, objet_id = :objet_id, taille = :taille WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->bindParam(':arme_id', $arme_id, PDO::PARAM_INT);
            $req->bindParam(':objet_id', $objet_id, PDO::PARAM_INT);
            $req->bindParam(':taille', $taille, PDO::PARAM_INT);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur lors de la modification de l\'inventaire : ' . $e->getMessage());
        }
    }
}

class MonstreDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Get all monstre
    public function getAllMonstre()
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM monstre');
            $req->execute();

            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            $monstres = [];

            foreach ($donnees as $monstre) {
                $monstres[] = new Monstre(
                    $monstre['id'],
                    $monstre['nom'],
                    $monstre['points_vie'],
                    $monstre['points_attaque'],
                    $monstre['points_defense'],
                    $monstre['salle_id'],
                    $monstre['arme_id'],
                );
            }
        } catch (Exception $e) {
            die('Erreur lors de la recuperation des monstres : ' . $e->getMessage());
        }
    }

    // Get monstre by id
    public function getMonstreById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM monstre WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Monstre($donnees['id'], $donnees['nom'], $donnees['points_vie'], $donnees['points_attaque'], $donnees['points_defense'], $donnees['experience'], $donnees['niveau']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation du monstre : ' . $e->getMessage());
        }
    }

    // Modify monstre
    public function modifyMonstre(Monstre $monstre)
    {
        $id = $monstre->getId();
        $nom = $monstre->getNom();
        $points_vie = $monstre->getPoints_vie();
        $points_attaque = $monstre->getPoints_attaque();
        $points_defense = $monstre->getPoints_defense();

        try {
            $req = $this->bdd->prepare('UPDATE monstre SET nom = :nom, points_vie = :points_vie, points_attaque = :points_attaque, points_defense = :points_defense, experience = :experience, niveau = :niveau WHERE id = :id');
            $req->bimParam(':id', $id, PDO::PARAM_INT);
            $req->bindParam(':nom', $nom, PDO::PARAM_STR);
            $req->bindParam(':points_vie', $points_vie, PDO::PARAM_INT);
            $req->bindParam(':points_attaque', $points_attaque, PDO::PARAM_INT);
            $req->bindParam(':points_defense', $points_defense, PDO::PARAM_INT);
            $req->execute();
        } catch (Exception $e) {
            die('Erreur lors de la modification du monstre : ' . $e->getMessage());
        }
    }
}



class PersonnageDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Create personnage
    public function createPersonnage(Personnage $personnage)
    {
        $id = $personnage->getId();
        $nom = $personnage->getNom();
        $points_vie = $personnage->getPoints_vie();
        $points_attaque = $personnage->getPoints_attaque();
        $points_defense = $personnage->getPoints_defense();
        $experience = $personnage->getExperience();
        $niveau = $personnage->getNiveau();
        $arme_equiper_id = $personnage->getArme_equiper_id();

        try {
            $req = $this->bdd->prepare('INSERT INTO personnages (
                id,
                nom,
                points_vie,
                points_attaque,
                points_defense,
                experience,
                niveau, 
                arme_equiper_id) 
                VALUES (
                    :id, 
                    :nom, 
                    :points_vie, 
                    :points_attaque, 
                    :points_defense, 
                    :experience, :niveau, 
                    :arme_equiper_id)');

            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->bindParam(':nom', $nom, PDO::PARAM_STR);
            $req->bindParam(':points_vie', $points_vie, PDO::PARAM_INT);
            $req->bindParam(':points_attaque', $points_attaque, PDO::PARAM_INT);
            $req->bindParam(':points_defense', $points_defense, PDO::PARAM_INT);
            $req->bindParam(':experience', $experience, PDO::PARAM_INT);
            $req->bindParam(':niveau', $niveau, PDO::PARAM_INT);
            $req->bindParam(':arme_equiper_id', $arme_equiper_id, PDO::PARAM_INT);

            $req->execute();
        } catch (Exception $e) {
            die('Erreur lors de la creation du personnage : ' . $e->getMessage());
        }
    }

    // Get personnage by id
    public function getPersonnageById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM personnages WHERE id = :id');

            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();

            $donnees = $req->fetch(PDO::FETCH_ASSOC);

            // Check if data is retrieved before creating an object
            if ($donnees) {
                return new Personnage(
                    $donnees['id'],
                    $donnees['nom'],
                    $donnees['points_vie'],
                    $donnees['points_attaque'],
                    $donnees['points_defense'],
                    $donnees['experience'],
                    $donnees['niveau'],
                    $donnees['arme_equiper_id']
                );
            } else {
                return null;
            }
        } catch (Exception $e) {
            die('Erreur lors de la recuperation du personnage : ' . $e->getMessage());
        }
    }


    // Get personnage by name
    public function getPersonnageByName($name)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM personnages WHERE nom = :nom');

            $req->bindParam(':nom', $name, PDO::PARAM_STR);
            $req->execute();

            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Personnage($donnees['id'], $donnees['nom'], $donnees['points_vie'], $donnees['points_attaque'], $donnees['points_defense'], $donnees['experience'], $donnees['niveau'], $donnees['arme_equiper_id']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation du personnage : ' . $e->getMessage());
        }
    }

    // Modify personnage
    public function modifyPersonnage(Personnage $personnage)
    {
        $id = $personnage->getId();
        $nom = $personnage->getNom();
        $points_vie = $personnage->getPoints_vie();
        $points_attaque = $personnage->getPoints_attaque();
        $points_defense = $personnage->getPoints_defense();
        $experience = $personnage->getExperience();
        $niveau = $personnage->getNiveau();
        $arme_equiper_id = $personnage->getArme_equiper_id();

        try {
            $req = $this->bdd->prepare('UPDATE personnages 
                SET 
                nom = :nom, 
                points_vie = :points_vie, 
                points_attaque = :points_attaque, 
                points_defense = :points_defense, 
                experience = :experience, 
                niveau = :niveau,
                arme_equiper_id = :arme_equiper_id 
                WHERE id = :id');

            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->bindParam(':nom', $nom, PDO::PARAM_STR);
            $req->bindParam(':points_vie', $points_vie, PDO::PARAM_INT);
            $req->bindParam(':points_attaque', $points_attaque, PDO::PARAM_INT);
            $req->bindParam(':points_defense', $points_defense, PDO::PARAM_INT);
            $req->bindParam(':experience', $experience, PDO::PARAM_INT);
            $req->bindParam(':niveau', $niveau, PDO::PARAM_INT);
            $req->bindParam(':arme_equiper_id', $arme_equiper_id, PDO::PARAM_INT);

            $req->execute();
        } catch (Exception $e) {
            die('Erreur lors de la modification du personnage : ' . $e->getMessage());
        }
    }
}

class SalleDAO
{

    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Get all salle
    public function getAllSalle()
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM salles');
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            $salles = [];

            foreach ($donnees as $salle) {
                $salles[] = new Salle(
                    $salle['id'],
                    $salle['type'],
                    $salle['description']
                );
            }

            return $salles;
        } catch (Exception $e) {
            die('Erreur lors de la recuperation des salles : ' . $e->getMessage());
        }
    }

    // Get salle by id
    public function getSalleById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM salles WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Salle($donnees['id'], $donnees['nom'], $donnees['description'], $donnees['id_monstre'], $donnees['id_personnage']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de la salle : ' . $e->getMessage());
        }
    }

    //Get number of salle
    public function getNbSalle()
    {
        try {
            $req = $this->bdd->prepare('SELECT COUNT(*) FROM salles');
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return $donnees['COUNT(*)'];
        } catch (Exception $e) {
            die('Erreur lors de la recuperation du nombre de salle : ' . $e->getMessage());
        }
    }
}
