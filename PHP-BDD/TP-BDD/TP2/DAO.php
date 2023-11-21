<?php

class NiveauDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    //Ajout d'un niveau
    public function AddNiveau($niveau)
    {
        try {
            $requete = $this->bdd->prepare("INSERT INTO niveau (nom, difficulte, etoiles_requises, etoiles_disponibles) VALUES (:nom, :difficulte, :etoiles_requises, :etoiles_disponibles)");

            $requete->excute([$niveau->getNom(), $niveau->getDifficulte(), $niveau->getEtoilesRequises(), $niveau->getEtoilesDisponibles()]);

            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du niveau: " . $e->getMessage();

            return false;
        }
    }

    //Liste des niveaux
    public function DisplayNiveau()
    {
        try {
            $listeNiveau = $this->bdd->query("SELECT * FROM niveau");
            return $listeNiveau->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de l'affichage des niveaux: " . $e->getMessage();

            return false;
        }
    }

    //Get niveau par id
    public function GetNiveauParId($id)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM niveau WHERE id = :id");
            $requete->execute([$id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du niveau: " . $e->getMessage();
            return false;
        }
    }
}

class PersonnageDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    //Ajout d'un personnage
    public function AddPersonnage($personnage)
    {
        try {
            $requete = $this->bdd->prepare("INSERT INTO personnage (nom) VALUES (:nom)");
            $requete->execute([$personnage->getNom()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du personnage: " . $e->getMessage();
            return false;
        }
    }

    //Get personnage par id
    public function GetPersonnageParId($id)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM personnage WHERE id = :id");
            $requete->execute([$id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du personnage: " . $e->getMessage();
            return false;
        }
    }
}
