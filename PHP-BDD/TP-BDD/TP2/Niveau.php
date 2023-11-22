<?php

class Niveau
{
    private $nom_niveau;
    private $difficulte;
    private $etoiles_requises;
    private $etoiles_disponible;

    public function __construct($nom_niveau, $difficulte, $etoiles_requises, $etoiles_disponible)
    {
        $this->nom_niveau = $nom_niveau;
        $this->difficulte = $difficulte;
        $this->etoiles_requises = $etoiles_requises;
        $this->etoiles_disponible = $etoiles_disponible;
    }

    //Getters
    public function getNomNiveau()
    {
        return $this->nom_niveau;
    }

    public function getDifficulte()
    {
        return $this->difficulte;
    }

    public function getEtoilesRequises()
    {
        return $this->etoiles_requises;
    }

    public function getEtoilesDisponible()
    {
        return $this->etoiles_disponible;
    }
}
?>
//hello