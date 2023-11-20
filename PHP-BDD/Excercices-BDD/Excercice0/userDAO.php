<?php
include_once "config.php";
include_once "user.php";

class userDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterUtilisateur(user $user)
    {
        try {
            $requete = $this->bdd->prepare("INSERT INTO utilisateur (nom, prenom) VALUES (?, ?)");
            $requete->execute([$user->getNom(), $user->getPrenom()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout d'utilisateur: " . $e->getMessage();
            return false;
        }
    }

    public function listerUtilisateurs()
    {
        try {
            $requete = $this->bdd->query("SELECT * FROM utilisateur");
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des utilisateurs: " . $e->getMessage();
            return false;
        }
    }

    public function modifierUtilisateur(user $user)
    {
        try {
            $requete = $this->bdd->prepare("UPDATE utilisateur SET nom = ?, prenom = ? WHERE id = ?");
            $requete->execute([$user->getNom(), $user->getPrenom(), $user->getId()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification d'utilisateur: " . $e->getMessage();
            return false;
        }
    }

    public function supprimerUtilisateur(user $user)
    {
        try {
            $requete = $this->bdd->prepare("DELETE FROM utilisateur WHERE id = ?");
            $requete->execute([$user->getId()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de suppression d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
}

class Database
{
    private $host;
    private $user;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->host = HOTE;
        $this->user = UTILISATEUR;
        $this->password = MOT_DE_PASSE;
        $this->dbname = NOM_DE_LA_BASE;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
