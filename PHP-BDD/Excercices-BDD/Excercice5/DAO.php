<?php

class CommandeDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajoutCommande($montantTotal)
    {
        try {
            $requete = $this->bdd->prepare("INSERT INTO commandes (montant_total) VALUES (:montant_total)");
            $requete->bindParam(":montant_total", $montantTotal);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de la commande: " . $e->getMessage();
            return false;
        }
    }
}

class ArticleDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function recupererArticles()
    {
        try {
            $requete = $this->bdd->query("SELECT * FROM articles");
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des articles: " . $e->getMessage();
            return false;
        }
    }

    public function recupererArticleParId($id)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM articles WHERE id = :id");
            $requete->bindParam(":id", $id);
            $requete->execute();
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des articles: " . $e->getMessage();
            return false;
        }
    }
}

// Connexion à la base de données avec PDO
try {
    $hote = "127.0.0.1";
    $utilisateur = "enzo";
    $motDePasse = "221218";
    $nomDeLaBase = "php_exo5";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
