<?php

// Classe modèle pour représenter un utilisateur
class Utilisateur {
    private $nom;
    private $prenom;

    public function __construct($nom, $prenom) {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }
}

// Classe d'accès aux données pour les utilisateurs
class UtilisateurDAO {
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    // Méthode pour ajouter un utilisateur dans la BDD
    public function ajouterUtilisateur(Utilisateur $utilisateur) {
        try {
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("INSERT INTO utilisateurs (nom, prenom) VALUES (?, ?)");
            
            // Exécution de la requête avec les valeurs de l'objet Utilisateur
            $requete->execute([$utilisateur->getNom(), $utilisateur->getPrenom()]);
            
            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
            return false;
        }
    }

    // Méthode pour lister tous les utilisateurs de la BDD
    public function listerUtilisateurs() {
        try {
            // Exécution d'une requête de sélection pour récupérer tous les utilisateurs
            $requete = $this->bdd->query("SELECT * FROM utilisateurs");
            
            // Retourne un tableau associatif avec les utilisateurs
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur de récupération des utilisateurs: " . $e->getMessage();
            
            // Retourne un tableau vide en cas d'échec
            return [];
        }
    }
}

// Connexion à la base de données avec PDO
try {
    $hote = "localhost";
    $utilisateur = "utilisateur";
    $motDePasse = "motdepasse";
    $nomDeLaBase = "nomdelabase";
    
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
$nouvelUtilisateur = new Utilisateur("Doe", "John");

// Instanciation de la classe UtilisateurDAO avec la connexion à la BDD
$utilisateurDAO = new UtilisateurDAO($connexion);

// Envoi de l'objet Utilisateur à la BDD
$utilisateurDAO->ajouterUtilisateur($nouvelUtilisateur);

// Récupération de tous les utilisateurs sous forme d'objets
$utilisateurs = $utilisateurDAO->listerUtilisateurs();
print_r($utilisateurs);
?>