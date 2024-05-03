<?php
require 'Eleve.php';
require 'Note.php';
require 'Mention.php';
require 'Matiere.php';

// Intégration de la connexion à la base de données
require 'outils_bd.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification et nettoyage du nom et du prénom
    $nom = trim(filter_input(INPUT_POST, 'nom'));
    $prenom = trim(filter_input(INPUT_POST, 'prenom'));
    
    // Vérification si les champs nom et prénom ne sont pas vides
    if (!empty($nom) && !empty($prenom)) {
        // Vérification et récupération des notes
        $note_francais_ecrit = filter_input(INPUT_POST, 'note_francais_ecrit', FILTER_VALIDATE_FLOAT);
        $note_francais_oral = filter_input(INPUT_POST, 'note_francais_oral', FILTER_VALIDATE_FLOAT);
        $note_philosophie = filter_input(INPUT_POST, 'note_philosophie', FILTER_VALIDATE_FLOAT);
        $note_orale_terminale = filter_input(INPUT_POST, 'note_orale_terminale', FILTER_VALIDATE_FLOAT);
        $note_specialite = filter_input(INPUT_POST, 'note_specialite', FILTER_VALIDATE_FLOAT);

        // Vérification si les notes sont valides (comprises entre 0 et 20)
        if ($note_francais_ecrit !== false && $note_francais_oral !== false && $note_philosophie !== false && 
            $note_orale_terminale !== false && $note_specialite !== false &&
            $note_francais_ecrit >= 0 && $note_francais_ecrit <= 20 &&
            $note_francais_oral >= 0 && $note_francais_oral <= 20 &&
            $note_philosophie >= 0 && $note_philosophie <= 20 &&
            $note_orale_terminale >= 0 && $note_orale_terminale <= 20 &&
            $note_specialite >= 0 && $note_specialite <= 20) {

            // Initialisation de la somme des notes et du nombre de matières
            $totalNotes = 0;
            $nbMatieres = 0;

            // Calcul de la somme des notes et du nombre de matières
            $totalNotes += $note_francais_ecrit;
            $totalNotes += $note_francais_oral;
            $totalNotes += $note_philosophie;
            $totalNotes += $note_orale_terminale;
            $totalNotes += $note_specialite;
            $nbMatieres = 5;

            // Insertion de l'élève dans la base de données
            $stmtEleve = $cnx->prepare('INSERT INTO eleves (nom, prenom) VALUES (?, ?)');
            $stmtEleve->execute([$nom, $prenom]);
            $eleveId = $cnx->lastInsertId(); // Récupère l'ID de l'élève inséré

            // Récupération de l'ID des matières
            $matiereIds = [];
            $matieres = ['Français (écrit)', 'Français (oral)', 'Philosophie', 'Épreuve orale terminale', 'Épreuves de spécialité'];
            foreach ($matieres as $matiereNom) {
                $stmtMatiereId = $cnx->prepare('SELECT id FROM matieres WHERE nom = ?');
                $stmtMatiereId->execute([$matiereNom]);
                $matiereId = $stmtMatiereId->fetchColumn();
                $matiereIds[] = $matiereId;
            }

            // Insertion de chaque note dans la base de données
            $notes = [$note_francais_ecrit, $note_francais_oral, $note_philosophie, $note_orale_terminale, $note_specialite];
            foreach ($notes as $index => $noteValeur) {
                // Insertion de la note dans la base de données
                $stmtNote = $cnx->prepare('INSERT INTO notes (eleve_id, matiere_id, valeur) VALUES (?, ?, ?)');
                $stmtNote->execute([$eleveId, $matiereIds[$index], $noteValeur]);
            }
            
            // Appel de la procédure stockée pour calculer la moyenne générale
            $stmtMoyenne = $cnx->prepare('CALL calculer_moyenne_generale(?)');
            $stmtMoyenne->execute([$eleveId]);
            
            // Récupération de la moyenne générale calculée par la procédure stockée
            $row = $stmtMoyenne->fetch();
            $moyenneGenerale = $row['moyenne_generale'];
        
            // Détermination du statut basé sur la moyenne générale
            $statut = ($moyenneGenerale >= 10) ? 'Admis' : 'Recalé';
        
            // Modification du message de résultat pour inclure la moyenne générale et le statut
            $_SESSION['resultat'] = "$nom $prenom : $statut avec une moyenne générale de $moyenneGenerale.";
        } else {
            $_SESSION['resultat'] = 'Veuillez entrer des notes valides (comprises entre 0 et 20).';
        }
    } else {
        $_SESSION['resultat'] = 'Veuillez remplir tous les champs.';
    }
} else {
    $_SESSION['resultat'] = 'Une erreur s\'est produite lors de la soumission du formulaire.';
}

header('Location: ../index.php');
exit;
