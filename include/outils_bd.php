<?php

// Paramètres de connexion à la base MySQL
$bdHote        = "172.18.153.45";
$bdNom         = "e5";
$bdUtilisateur = "e5";	
$bdMotDePasse  = "e5";

// Configuration des options de PDO
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // Définit le jeu de caractères utf8
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active le mode d'erreur exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Définit le mode de fetch par défaut à assoc
];

// Ouverture de la connexion
try {
    $cnx = new PDO('mysql:host='.$bdHote.';dbname='.$bdNom, $bdUtilisateur, $bdMotDePasse, $options);
} catch(Exception $err) {
    echo 'Erreur de connexion à la base de données : '.$err->getMessage().'<br />';
    echo 'N° : '.$err->getCode();
    exit; // Arrête l'exécution du script en cas d'erreur de connexion
}
