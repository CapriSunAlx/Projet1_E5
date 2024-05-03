<?php
require 'outils_bd.php'; // Assurez-vous que ce chemin est correct

if (isset($_GET['rechercheMention'])) {
    $rechercheMention = filter_input(INPUT_GET, 'rechercheMention', FILTER_SANITIZE_STRING);

    // Préparation de la requête pour éviter les injections SQL
    // Utilisation de TRIM pour supprimer les espaces avant et après la chaîne recherchée
    $requete = $cnx->prepare("
        SELECT eleves.nom, eleves.prenom, notes.valeur, notes.mention
        FROM eleves
        JOIN notes ON eleves.id = notes.eleve_id
        WHERE TRIM(eleves.prenom) LIKE TRIM(?)
    ");

    // Exécution de la requête avec le prénom recherché, en enlevant les espaces avant et après
    $requete->execute(["%" . trim($rechercheMention) . "%"]);

    // Récupération des résultats
    $resultats = $requete->fetchAll();

    if ($resultats) {
        echo "<table><tr><th>Nom</th><th>Prénom</th><th>Note</th><th>Mention</th></tr>";
        foreach ($resultats as $ligne) {
            echo "<tr><td>" . htmlspecialchars($ligne['nom']) . "</td><td>" . htmlspecialchars($ligne['prenom']) . "</td><td>" . htmlspecialchars($ligne['valeur']) . "</td><td>" . htmlspecialchars($ligne['mention']) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun résultat trouvé pour le prénom '$rechercheMention'.";
    }
} else {
    echo "Veuillez entrer un prénom pour la recherche.";
}

echo '<p><a href="../index.php">Retour</a></p>';
?>
