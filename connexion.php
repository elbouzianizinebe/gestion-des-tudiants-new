<?php

$serveur = "localhost";
$base_de_donnees = "gestion_etudiants";
$utilisateur = "root";
$mot_de_passe = "";
  
try {
    $connexion = new PDO(
        "mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8mb4",
        $utilisateur,
        $mot_de_passe,
           [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     
    ]
    );



} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>