<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	
	<title>Calcul de la note du bac </title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Votre note du bac</h1>
	<div class="contenu">
    <form method="POST" action="include/calculer_mention.php">
    <p>Votre nom : <input type="text" name="nom" required placeholder="Votre nom"></p>                   
    <p>Votre prénom : <input type="text" name="prenom" required placeholder="Votre prénom"></p>
    <p>Français (écrit) : <input type="number" name="note_francais_ecrit" required placeholder="Votre note"></p>
    <p>Français (oral) : <input type="number" name="note_francais_oral" required placeholder="Votre note"></p>
    <p>Philosophie : <input type="number" name="note_philosophie" required placeholder="Votre note"></p>
    <p>Épreuve orale terminale : <input type="number" name="note_orale_terminale" required placeholder="Votre note"></p>
    <p>Épreuves de spécialité : <input type="number" name="note_specialite" required placeholder="Votre note"></p>

    
    <input type="submit" value="Résultat">
</form>



	<p id="resultat">
    <?php
    session_start();
    if (isset($_SESSION['resultat'])) {
        echo htmlspecialchars($_SESSION['resultat']);
        unset($_SESSION['resultat']);
    }
    ?>
    </p>

	<div class="recherche">
    <form method="GET" action="include/rechercher.php">
        <p>Recherchez une mention par prénom : <input type="text" name="rechercheMention" required placeholder="Entrez un prénom">
        </p>
        <input type="submit" value="Rechercher">
    </form>
</div>

</body>
</html>