<?php

include("Exo_4_PanierDAO.php");

class Produit
{
    private $id;
    private $quantite;

    public function __construct($id, $quantite)
    {
        $this->id = $id;
        $this->quantite = $quantite;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }
}

$panierDAO = new PanierDAO($connexion);

$panierDAO->ajouterArticle(3, 1);
