-- Creation base de données E5 Projet 1
CREATE TABLE eleves (
    id INT AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    CONSTRAINT PK_ELEVE_ID PRIMARY KEY (id)
);

-- Création de la table des matières
CREATE TABLE matieres (
    id INT AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    coefficient DECIMAL(5, 2),
    CONSTRAINT PK_MATIERE_ID PRIMARY KEY (id)
);

-- Modification de la table des notes pour inclure la référence à l'élève et à la matière
CREATE TABLE notes (
    id INT AUTO_INCREMENT,
    eleve_id INT NOT NULL,
    matiere_id INT NOT NULL,
    valeur DECIMAL(5, 2) NOT NULL,
    mention VARCHAR(255),
    CONSTRAINT PK_NOTES_ID PRIMARY KEY (id),
    FOREIGN KEY (eleve_id) REFERENCES eleves(id),
    FOREIGN KEY (matiere_id) REFERENCES matieres(id)
);



-- Trigger pour calculer la mention
DELIMITER $$

CREATE TRIGGER calcul_mention_before_insert
BEFORE INSERT ON notes
FOR EACH ROW
BEGIN
    IF NEW.valeur > 16 THEN
        SET NEW.mention = 'Admis - mention TB';
    ELSEIF NEW.valeur >= 14 THEN
        SET NEW.mention = 'Admis - mention B';
    ELSEIF NEW.valeur >= 12 THEN
        SET NEW.mention = 'Admis - mention AB';
    ELSEIF NEW.valeur >= 10 THEN
        SET NEW.mention = 'Admis - pas de mention';
    ELSE
        SET NEW.mention = 'Recalé';
    END IF;
END$$

DELIMITER ;

-- Procedure stockee pour calculer la moyenne generale
DELIMITER $$

CREATE PROCEDURE calculer_moyenne_generale(IN eleve_id INT)
BEGIN
    SELECT AVG(valeur) AS moyenne_generale
    FROM notes
    WHERE eleve_id = eleve_id;
END$$

DELIMITER ;


