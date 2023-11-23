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

    // Get inventaire by id
    public function getInventaireById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM Inventaire WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Inventaire($donnees['id'], $donnees['personnage_id'], $donnees['arme_id'], $donnees['objet_id'], $donnees['taille']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'inventaire : ' . $e->getMessage());
        }
    }

    // Get arme by id
    public function getArmeById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM arme WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Arme($donnees['id'], $donnees['nom'], $donnees['niveau_requis'], $donnees['points_attaque_bonus']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'arme : ' . $e->getMessage());
        }
    }

    // Get objet by id
    public function getObjetById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM objet WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new ObjetMagique($donnees['id'], $donnees['nom'], $donnees['niveau_requis'], $donnees['points_defense_bonus']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'objet : ' . $e->getMessage());
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

class ObjetMagiqueDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Get objet magique by id
    public function getObjetMagiqueById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM objet_magique WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new ObjetMagique($donnees['id'], $donnees['nom'], $donnees['niveau_requis'], $donnees['points_vie_bonus']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de l\'objet magique : ' . $e->getMessage());
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
            $req = $this->bdd->prepare('INSERT INTO personnage (
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
            $req = $this->bdd->prepare('SELECT * FROM personnage WHERE id = :id');

            $req->bimdParam(':id', $id, PDO::PARAM_INT);
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
            $req = $this->bdd->prepare('UPDATE personnage 
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

    // Get salle by id
    public function getSalleById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM salle WHERE id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $donnees = $req->fetch(PDO::FETCH_ASSOC);
            return new Salle($donnees['id'], $donnees['nom'], $donnees['description'], $donnees['id_monstre'], $donnees['id_personnage']);
        } catch (Exception $e) {
            die('Erreur lors de la recuperation de la salle : ' . $e->getMessage());
        }
    }
}
