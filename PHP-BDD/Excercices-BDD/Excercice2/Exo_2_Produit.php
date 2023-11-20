<?php

include("Exo_2_Produit_DAO");

// Classe modèle pour représenter un utilisateur
class Produit
{
    private $id;
    private $nom;
    private $prix;
    private $stock;

    public function __construct($id, $nom, $prix, $stock)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->stock = $stock;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getStock()
    {
        return $this->stock;
    }
}

// Création d'un objet Utilisateur
$Produit = new Produit("", "OUI", 20, 3);

// Instanciation de la classe UtilisateurDAO avec la connexion à la BDD
$produitDAO = new ProduitDAO($connexion);

// Envoi de l'objet Utilisateur à la BDD
$produitDAO->ajouterProduit($Produit);

$produitDAO->updateProduit(2, 1);
