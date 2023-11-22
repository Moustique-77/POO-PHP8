<?php

class Maison
{
    private $id;
    private $taille;
    private $nb_pieces;
    private $liste_obj = [];
    private $cout;

    public function __construct($id, $taille, $nb_pieces, $cout)
    {
        $this->id = $id;
        $this->taille = $taille;
        $this->nb_pieces = $nb_pieces;
        $this->cout = $cout;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getTaille()
    {
        return $this->taille;
    }

    public function getNb_pieces()
    {
        return $this->nb_pieces;
    }

    public function getListe_obj()
    {
        return $this->liste_obj;
    }

    public function getCout()
    {
        return $this->cout;
    }

    //Setters
    public function setTaille($taille)
    {
        return $this->taille = $taille;
    }

    public function setNb_pieces($nb_pieces)
    {
        return $this->nb_pieces = $nb_pieces;
    }

    public function setListe_obj($liste_obj)
    {
        return $this->liste_obj = $liste_obj;
    }

    public function setCout($cout)
    {
        return $this->cout = $cout;
    }
}
