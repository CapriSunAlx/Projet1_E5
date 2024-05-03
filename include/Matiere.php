<?php

class Matiere {
    public $nom;
    public $coefficient;

    public function __construct($nom, $coefficient) {
        $this->nom = $nom;
        $this->coefficient = $coefficient;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getCoefficient() {
        return $this->coefficient;
    }
}

?>
