<?php

class Personnage
{
    private $nom;
    private $niveau_actuel;
    private $etoiles_collectee;

    public function __construct($nom, $niveau_actuel, $etoiles_collectee)
    {
        $this->nom = $nom;
        $this->niveau_actuel = $niveau_actuel;
        $this->etoiles_collectee = $etoiles_collectee;
    }

    //Getters
    public function getNom()
    {
        return $this->nom;
    }

    public function getNiveauActuel()
    {
        return $this->niveau_actuel;
    }

    public function getEtoilesCollectee()
    {
        return $this->etoiles_collectee;
    }
}
