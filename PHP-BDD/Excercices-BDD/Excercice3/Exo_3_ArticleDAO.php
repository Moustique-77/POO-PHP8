<?php

class ArticleDAO
{
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Méthode pour ajouter un produit dans la BDD
    public function ajouterArticle(Article $article)
    {
        try {
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO article (titre, contenue) VALUES (?, ?)");

            // Exécution de la requête avec les valeurs de l'objet produit
            $requete->execute([$article->getTitre(), $article->getContenue()]);

            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout du produit: " . $e->getMessage();

            // Retourne faux en cas d'échec
            return false;
        }
    }

    //Get all article by date DESC
    public function listerArticles()
    {
        try {
            $requete = $this->bdd->query("SELECT * FROM article ORDER BY date DESC");
            return $requete->fetchAll(PDO::FETCH_ASSOC);
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
    $nomDeLaBase = "php_exo3";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
