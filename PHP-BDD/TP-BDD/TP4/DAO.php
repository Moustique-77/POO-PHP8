<?php

class MaisonDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function addMaison(Maison $maison)
    {
        $taille = $maison->getTaille();
        $nb_pieces = $maison->getNb_pieces();
        $liste_obj = implode(',', $maison->getListe_obj()); // Conversion du tableau en chaîne
        $cout = $maison->getCout();

        try {
            $requete = $this->bdd->prepare('INSERT INTO maison (taille, nb_pieces, liste_obj, cout) VALUES(:taille, :nb_pieces, :liste_obj, :cout)');

            $requete->bindParam(':taille', $taille, PDO::PARAM_INT);
            $requete->bindParam(':nb_pieces', $nb_pieces, PDO::PARAM_INT);
            $requete->bindParam(':liste_obj', $liste_obj, PDO::PARAM_STR);
            $requete->bindParam(':cout', $cout, PDO::PARAM_INT);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la maison : " . $e->getMessage();
            return false;
        }
    }


    //Ajout d'options à une maison
    public function addOptions($id, $liste_obj)
    {
        try {
            $requete = $this->bdd->prepare('UPDATE maison SET liste_obj = :liste_obj WHERE id = :id');

            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->bindParam(':liste_obj', $liste_obj, PDO::PARAM_STR);

            $requete->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout des options : " . $e->getMessage();
            return false;
        }
    }
}
