<?php

// Connexion à la base de données avec PDO
try {
    $hote = "127.0.0.1";
    $utilisateur = "php_exam";
    $motDePasse = "php_exam";
    $nomDeLaBase = "php_exam";

    // Création d'une instance de PDO pour la connexion à la BDD
    $bdd = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
