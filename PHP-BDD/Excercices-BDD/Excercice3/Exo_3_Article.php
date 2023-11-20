<?php

include("Exo_3_ArticleDAO.php");

class Article
{
    private $id;
    private $titre;
    private $contenue;
    private $date;

    public function __construct($id, $titre, $contenue, $date)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenue = $contenue;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getContenue()
    {
        return $this->contenue;
    }

    public function getDate()
    {
        return $this->date;
    }
}

$Article1 = new Article("", "Titre", "Contenue", "");

$articleDAO = new ArticleDAO($connexion);

$articleDAO->ajouterArticle($Article1);

$articleDAO->listerArticles();

foreach ($articleDAO->listerArticles() as $article) {
    echo $article["titre"];
    echo $article["contenue"];
    echo $article["date"];
}
