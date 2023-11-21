<?php

include("Exo_5_DAO.php");

class Article
{
    private $id;
    private $nom;
    private $prix;
    private $quantite;

    public function __construct($id, $nom, $prix, $quantite)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantite = $quantite;
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

    public function getQuantite()
    {
        return $this->quantite;
    }
}

class Commande
{
    private $id;
    private $montantTotal;
    private $articles;

    public function __construct($id, $montantTotal)
    {
        $this->id = $id;
        $this->montantTotal = $montantTotal;
        $this->articles = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMontantTotal()
    {
        return $this->montantTotal;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function setArtcile($articles)
    {
        $this->articles = $articles;
    }
}

// Création d'une commande
$commande = new Commande("", "", 0);

// Récupération des articles
$articleDAO = new ArticleDAO($connexion);
$articles = $articleDAO->recupererArticles();

//Création d'un tableau d'objet d'articles 
$articlesObjet = [];
foreach ($articles as $article) {
    $articlesObjet[] = new Article($article["id"], $article["nom"], $article["prix_unitaire"], $article["quantite_disponible"]);
}

// Affichage des articles
echo "Liste des articles:" . PHP_EOL;
foreach ($articles as $article) {
    echo $article["id"] . " - " . $article["nom"] . " - " . $article["prix_unitaire"] . "€ - " . $article["quantite_disponible"] . " en stock" . PHP_EOL;
}

// Demande à l'utilisateur de choisir un article
$articleChoisi = readline("Choisissez un article: ");

// Vérification de l'existence de l'article
$articleExiste = false;
foreach ($articles as $article) {
    if ($article["id"] == $articleChoisi) {
        $articleExiste = true;
        break;
    }
}

// Si l'article n'existe pas, on affiche un message d'erreur et on arrête le script
if (!$articleExiste) {
    echo "L'article choisi n'existe pas." . PHP_EOL;
    exit();
}

// Demande à l'utilisateur de choisir une quantité
$quantiteChoisie = readline("Choisissez une quantité: ");

// Vérification de la quantité disponible
$quantiteDisponible = 0;

foreach ($articles as $article) {
    if ($article["id"] == $articleChoisi) {
        $quantiteDisponible = $article["quantite_disponible"];
        break;
    }
}

// Si la quantité n'est pas disponible, on affiche un message d'erreur et on arrête le script
if ($quantiteChoisie > $quantiteDisponible) {
    echo "La quantité choisie n'est pas disponible." . PHP_EOL;
    exit();
}

// Ajout de l'article à la commande et calcul du montant total
$montantTotal = 0;
foreach ($articles as $article) {
    if ($article["id"] == $articleChoisi) {
        $montantTotal = $article["prix_unitaire"] * $quantiteChoisie;
        break;
    }
}

// Ajout de la commande à la base de données
$commandeDAO = new CommandeDAO($connexion);
$commande->setArtcile($articlesObjet);
$commandeDAO->ajoutCommande($montantTotal);

// Affichage de la commande
echo "Votre commande:" . PHP_EOL;
echo "Montant total: " . $montantTotal . "€" . PHP_EOL;
foreach ($articles as $article) {
    if ($article["id"] == $articleChoisi) {
        echo "Article: " . $article["nom"] . PHP_EOL;
        echo "Quantité: " . $quantiteChoisie . PHP_EOL;
        break;
    }
}
