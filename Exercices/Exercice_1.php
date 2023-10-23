<?php

//Créez une classe Personne avec des propriétés nom et prénom, ainsi qu'une méthode pour afficher le nom complet de la personne. 
//Instanciez ensuite deux objets Personne et affichez leur nom complet

class Personne
{
    public $nom;
    public $prenom;

    public function __construct($nom, $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function afficherNomComplet()
    {
        echo $this->nom . " " . $this->prenom;
    }
}

$personne1 = new Personne("Doe", "John");
$personne2 = new Personne("Doe", "Jane");

$personne1->afficherNomComplet();
$personne2->afficherNomComplet();
