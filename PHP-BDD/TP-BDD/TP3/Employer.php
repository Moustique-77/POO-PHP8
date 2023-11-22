<?php

class Employer
{
    private $id;
    private $nom;
    private $prenom;
    private $poste;
    private $salaire;

    public function __construct($id, $nom, $prenom, $poste, $salaire)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->poste = $poste;
        $this->salaire = $salaire;
    }

    //Getters 
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getPoste()
    {
        return $this->poste;
    }

    public function getSalaire()
    {
        return $this->salaire;
    }

    //Setters

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPrenom($prenom)
    {
        return $this->prenom = $prenom;
    }

    public function setPoste($poste)
    {
        return $this->poste = $poste;
    }

    public function setSalaire($salaire)
    {
        return $this->salaire = $salaire;
    }
}
