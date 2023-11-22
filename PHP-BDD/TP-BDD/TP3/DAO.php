<?php

class EmployerDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    //Ajout d'un employé
    public function AddEmployer($employer)
    {
        try {
            $nom = $employer->getNom();
            $prenom = $employer->getPrenom();
            $poste = $employer->getPoste();
            $salaire = $employer->getSalaire();

            $requete = $this->bdd->prepare("INSERT INTO employer (nom, prenom, poste, salaire) VALUES (:nom, :prenom, :poste, :salaire)");

            $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
            $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $requete->bindParam(':poste', $poste, PDO::PARAM_STR);
            $requete->bindParam(':salaire', $salaire, PDO::PARAM_INT);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'employé : " . $e->getMessage();
            return false;
        }
    }

    //Update d'un employer
    public function UpdateEmployer($employer)
    {
        $id = $employer->getId();
        $nom = $employer->getNom();
        $prenom = $employer->getPrenom();
        $poste = $employer->getPoste();
        $salaire = $employer->getSalaire();
        try {
            $requete = $this->bdd->prepare("UPDATE employer SET nom = :nom, prenom = :prenom, poste = :poste, salaire = :salaire WHERE id = :id");

            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
            $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $requete->bindParam(':poste', $poste, PDO::PARAM_STR);
            $requete->bindParam(':salaire', $salaire, PDO::PARAM_INT);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la modification de l'employer: " . $e->getMessage();
            return false;
        }
    }

    //Get de tous les employers
    public function GetAllEmployer()
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM employer");

            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de tous les employers: " . $e->getMessage();
            return null;
        }
    }

    //Get par id d'un employer
    public function GetEmployerById($id)
    {
        try {
            $requete = $this->bdd->prepare("SELECT * FROM employer WHERE id = :id");

            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->execute();
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'employer: " . $e->getMessage();
            return null;
        }
    }
}
