<?php

class Eleve {
    public $nom;
    public $prenom;
    public $notes;

    public function __construct($nom, $prenom) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->notes = array();
    }

    public function ajouterNote($note) {
        $this->notes[] = $note;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNotes() {
        return $this->notes;
    }

    // Calculer la mention de l'élève directement basée sur ses notes
    public function calculerMention() {
        if (empty($this->notes)) {
            return "Aucune note disponible";
        }

        $somme = 0;
        foreach ($this->notes as $note) {
            $somme += $note->getValeur();
        }
        $moyenne = $somme / count($this->notes);

        return Mention::calculerMention($moyenne);
    }
}
