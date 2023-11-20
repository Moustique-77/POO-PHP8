<?php

class PanierDAO
{
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    //check si le produit est encore en stock
    public function checkStock($id_produit)
    {
        $requete = $this->bdd->prepare("SELECT quantite FROM produits WHERE id = ?");
        $requete->execute([$id_produit]);
        $quantite = $requete->fetch(PDO::FETCH_ASSOC);
        if ($quantite['quantite'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Retire la quantité du produit dans la BDD
    public function retirerStock($id_produit, $quantite)
    {
        $requete = $this->bdd->prepare("UPDATE produits SET quantite = quantite - ? WHERE id = ?");
        $requete->execute([$quantite, $id_produit]);
    }

    // Méthode pour ajouter un produit dans la BDD
    public function ajouterArticle($id_produit, $quantite)
    {
        try {
            if ($this->checkStock($id_produit) == false) {
                echo "Le produit n'est plus en stock";
                return false;
            }
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO panier (id_produit, quantite) VALUES (?, ?)");

            // Exécution de la requête avec les valeurs de l'objet produit
            $requete->execute([$id_produit, $quantite]);

            // Retire la quantité du produit dans la BDD
            $this->retirerStock($id_produit, $quantite);

            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout du produit: " . $e->getMessage();

            // Retourne faux en cas d'échec
            return false;
        }
    }
}

// Connexion à la base de données avec PDO
try {
    $hote = "127.0.0.1";
    $utilisateur = "enzo";
    $motDePasse = "221218";
    $nomDeLaBase = "php_exo4";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
