<?php

// Classe modèle pour représenter un utilisateur
class Utilisateur
{
    private $nom;
    private $prenom;
    private $mail;

    public function __construct($nom, $prenom, $mail)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getMail()
    {
        return $this->mail;
    }
}

// Classe d'accès aux données pour les utilisateurs
class UtilisateurDAO
{
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Méthode pour ajouter un utilisateur dans la BDD
    public function ajouterUtilisateur(Utilisateur $utilisateur)
    {
        try {
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO utilisateur (nom, prenom, mail) VALUES (?, ?, ?)");

            // Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getNom(), $utilisateur->getPrenom(), $utilisateur->getMail()]);

            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();

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
    $nomDeLaBase = "php_exo1";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}

// Création d'un objet Utilisateur
$nouvelUtilisateur = new Utilisateur("Doe", "John", "Doe@John.com");

// Instanciation de la classe UtilisateurDAO avec la connexion à la BDD
$utilisateurDAO = new UtilisateurDAO($connexion);

// Envoi de l'objet Utilisateur à la BDD
$utilisateurDAO->ajouterUtilisateur($nouvelUtilisateur);
