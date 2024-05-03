<?php
require 'Eleve.php';
require 'Note.php';
require 'Mention.php';

// Intégration de la connexion à la base de données
require 'outils_bd.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['note'])) {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $noteValeur = filter_input(INPUT_POST, 'note', FILTER_VALIDATE_FLOAT);

    if ($noteValeur !== false) {
        // Insertion de l'élève dans la base de données
        $stmtEleve = $cnx->prepare('INSERT INTO eleves (nom, prenom) VALUES (?, ?)');
        $stmtEleve->execute([$nom, $prenom]);
        $eleveId = $cnx->lastInsertId(); // Récupère l'ID de l'élève inséré

        // Insertion de la note dans la base de données
        $stmtNote = $cnx->prepare('INSERT INTO notes (eleve_id, valeur) VALUES (?, ?)');
        $stmtNote->execute([$eleveId, $noteValeur]);
        
        // Détermination du statut basé sur la note
        $statut = $noteValeur >= 10 ? 'Admis' : 'Recalé';

        // Modification du message de résultat pour inclure la note et le statut
        $_SESSION['resultat'] = "$nom $prenom : $statut avec une note de $noteValeur.";
    } else {
        $_SESSION['resultat'] = 'Note invalide.';
    }
} else {
    $_SESSION['resultat'] = 'Veuillez remplir tous les champs.';
}

header('Location: ../index.php');
exit;
?>
