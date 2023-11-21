<?php

class PersonnageDAO
{
    private $bdd;

    // Constructeur prenant une connexion PDO en paramètre
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Méthode pour ajouter un personnage dans la BDD
    public function ajoutPersonnage($nom, $puissance, $types, $attributs)
    {
        try {
            $requete = $this->bdd->prepare("INSERT INTO Personnages (nom, puissance, types, attributs) VALUES (:nom, :puissance, :types, :attributs)");

            $requete->bindParam(":nom", $nom);
            $requete->bindParam(":puissance", $puissance);
            $requete->bindParam(":types", $types);
            $requete->bindParam(":attributs", $attributs);

            $requete->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout du personnage: " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour récupérer tous les personnages dans la BDD
    public function listePersonnage()
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM personnages");

            $requete->execute();

            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur de récupération des personnages: " . $e->getMessage();
            return false;
        }
    }

    public function listePersonnageParId($id)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM personnages WHERE id = :id");

            $requete->bindParam(":id", $id);

            $requete->execute();

            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            echo $resultat['id'] . " - " . $resultat['nom'] . "\n";

            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur de récupération des personnages: " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour mettre à jours un personnage dans la BDD
    public function modifPersonnage($id, $nom, $puissance, $types, $attributs)
    {
        try {
            $requete = $this->bdd->prepare("UPDATE personnages SET nom = :nom, puissance = :puissance, types = :types, attributs = :attributs WHERE id = :id");

            $requete->bindParam(":id", $id);
            $requete->bindParam(":nom", $nom);
            $requete->bindParam(":puissance", $puissance);
            $requete->bindParam(":types", $types);
            $requete->bindParam(":attributs", $attributs);

            $requete->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du personnage: " . $e->getMessage();
            return false;
        }
    }

    public function supprPersonnage($id)
    {
        try {
            $requete = $this->bdd->prepare("DELETE FROM personnages WHERE id = :id");

            $requete->bindParam(":id", $id);

            $requete->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur de suppression du personnage: " . $e->getMessage();
            return false;
        }
    }
}


// Connexion à la base de données avec PDO
try {
    $hote = "127.0.0.1";
    $utilisateur = "enzo";
    $motDePasse = "221218";
    $nomDeLaBase = "php_tp1";

    // Création d'une instance de PDO pour la connexion à la BDD
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);

    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, affiche un message d'erreur et arrête le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
