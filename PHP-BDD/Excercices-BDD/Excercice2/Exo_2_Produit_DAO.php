<?php

// Classe d'accès aux données pour les produits
class ProduitDAO
{
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Méthode pour ajouter un produit dans la BDD
    public function ajouterProduit(Produit $produit)
    {
        try {
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO produit (nom, prix, stock) VALUES (?, ?, ?)");

            // Exécution de la requête avec les valeurs de l'objet produit
            $requete->execute([$produit->getNom(), $produit->getPrix(), $produit->getStock()]);

            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout du produit: " . $e->getMessage();

            // Retourne faux en cas d'échec
            return false;
        }
    }

    //Méthode pour mettre à jour un produit dans la BDD
    public function updateProduit($stock, $id)
    {
        try {
            $requete = $this->bdd->prepare("UPDATE produit SET stock = ? WHERE id = ?");
            $requete->execute([$stock, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du produit: " . $e->getMessage();
            return false;
        }
    }
}

// Connexion à la base de données avec PDO
try {
    $hote = "127.0.0.1";
    $utilisateur = "enzo";
    $motDePasse = "221218";
    $nomDeLaBase = "php_exo2";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
