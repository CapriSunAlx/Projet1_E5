<?php

class Note {
    private $valeur;

    public function __construct($valeur) {
        $this->valeur = $valeur;
    }

    public function getValeur() {
        return $this->valeur;
    }
}
?>
