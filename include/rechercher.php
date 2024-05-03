<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    
    <title>Calcul de la note du bac </title>
    <link rel="stylesheet" href="../css/rechercher.css">
</head>
<body>
<?php
require 'outils_bd.php'; // Assurez-vous que ce chemin est correct

if (isset($_GET['rechercheMention'])) {
    $rechercheMention = filter_input(INPUT_GET, 'rechercheMention');

    // Préparation de la requête pour éviter les injections SQL
    // Utilisation de TRIM pour supprimer les espaces avant et après la chaîne recherchée
    $requete = $cnx->prepare("
        SELECT eleves.nom, eleves.prenom, notes.moyenne, notes.mention
        FROM eleves
        JOIN notes ON eleves.id = notes.eleve_id
        WHERE TRIM(eleves.prenom) LIKE TRIM(?)
    ");

    // Exécution de la requête avec le prénom recherché, en enlevant les espaces avant et après
    $requete->execute(["%" . trim($rechercheMention) . "%"]);

    // Récupération des résultats
    $resultats = $requete->fetchAll();

    if ($resultats) {
        // Commencer le tableau
        echo "<table><tr><th>Nom</th><th>Prénom</th><th>Note</th><th>Mention</th></tr>";

        // Afficher chaque ligne des résultats dans le tableau
        foreach ($resultats as $ligne) {
            echo "<tr><td>" . htmlspecialchars($ligne['nom']) . "</td><td>" . htmlspecialchars($ligne['prenom']) . "</td><td>" . htmlspecialchars($ligne['moyenne']) . "</td><td>" . htmlspecialchars($ligne['mention']) . "</td></tr>";
        }

        // Fermer le tableau
        echo "</table>";
    } else {
        echo "Aucun résultat trouvé pour le prénom '$rechercheMention'.";
    }
} else {
    echo "Veuillez entrer un prénom pour la recherche.";
}

// Lien pour retourner à la page d'accueil
echo '<p><a href="../index.php">Retour</a></p>';
?>
</body>
</html>
