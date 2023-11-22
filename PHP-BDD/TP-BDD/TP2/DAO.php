<?php

class NiveauDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    //Liste des niveaux
    public function DisplayNiveau()
    {
        try {
            $listeNiveau = $this->bdd->query("SELECT * FROM niveaux");
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
            $requete = $this->bdd->prepare("SELECT * FROM niveaux WHERE id = :id");
            $requete->execute([$id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du niveau: " . $e->getMessage();
            return false;
        }
    }

    //Get niveau par etoiles_requises
    public function DisplayNiveauParEtoiles($etoiles)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM niveaux WHERE etoiles_requises <= :etoiles");

            $requete->bindParam(':etoiles', $etoiles, PDO::PARAM_INT);
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des niveaux: " . $e->getMessage();
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

    //Get personnage
    public function GetPersonnage()
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM personnages");
            $requete->execute();
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du personnage: " . $e->getMessage();
            return false;
        }
    }

    //Update etoiles_collectees
    public function UpdateEtoilesCollectees($etoiles)
    {
        try {
            $requete = $this->bdd->prepare("UPDATE personnages SET etoiles_collectees = :etoiles WHERE id = 1");
            $requete->bindParam(':etoiles', $etoiles, PDO::PARAM_INT);
            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour des étoiles collectées: " . $e->getMessage();
            return false;
        }
    }
}
?>
//hello