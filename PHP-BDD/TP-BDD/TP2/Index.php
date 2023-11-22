<?php

include("Config.php");
include("Niveau.php");
include("Personnage.php");
include("DAO.php");

//Connexion à la base de données
$niveauDAO = new NiveauDAO($bdd);
$personnageDAO = new PersonnageDAO($bdd);

//Clear de la console
system('clear');

//Affichage des niveaux disponibles en fonction des étoiles du joueur
$personnage = $personnageDAO->GetPersonnage();
$joueur = new Personnage($personnage["nom"], $personnage["niveau_actuel"], $personnage["etoiles_collectees"]);
echo "Niveaux disponibles pour " . $joueur->getNom() . ", sachant que vous avez " . $joueur->getEtoilesCollectee() . " étoiles  : " . PHP_EOL . PHP_EOL;

//Affichage des niveaux disponibles en fonction des étoiles du joueur
echo "Nom - Difficulté - Etoiles requises - Etoiles disponibles" . PHP_EOL . PHP_EOL;
$listeNiveau = $niveauDAO->DisplayNiveauParEtoiles($joueur->getEtoilesCollectee());

// Création d'une nouvelle liste pour stocker les objets Niveau
$listeNiveauObjets = [];

// Création des objets niveau et ajout à la nouvelle liste
foreach ($listeNiveau as $niveauData) {
    $niveauObjet = new Niveau($niveauData["nom_niveau"], $niveauData["difficulte"], $niveauData["etoiles_requises"], $niveauData["etoiles_disponibles"]);
    $listeNiveauObjets[] = $niveauObjet;
}

// Affichage des niveaux à partir de la nouvelle liste contenant les objets Niveau
foreach ($listeNiveauObjets as $niveau) {
    echo $niveau->getNomNiveau() . " - " . $niveau->getDifficulte() . " - " . $niveau->getEtoilesRequises() . " - " . $niveau->getEtoilesDisponible() . PHP_EOL;
}

//Choix du niveau aléatoirement
$choixNiveau = rand(0, count($listeNiveauObjets) - 1);
$niveauChoisi = $listeNiveauObjets[$choixNiveau];

//Affichage du niveau choisi
echo PHP_EOL . "Vous avez choisi le niveau " . $niveauChoisi->getNomNiveau() . " !" . PHP_EOL . PHP_EOL;
echo "Il y a " . $niveauChoisi->getEtoilesDisponible() . " étoiles disponibles dans ce niveau, bonne chance !." . PHP_EOL;

//Calcul du nombre d'étoiles à récupérer
$etoilesARecuperer = $niveauChoisi->getEtoilesDisponible();

//Apui sur entrée pour continuer
echo PHP_EOL . "Appuyez sur entrée pour continuer...";
fgets(STDIN);
system('clear');

//Ajout des étoiles au joueur
$joueur->setEtoilesCollectee($joueur->getEtoilesCollectee() + $etoilesARecuperer);
//Mise à jour du joueur
$personnageDAO->UpdateEtoilesCollectees($joueur->getEtoilesCollectee());
echo "Vous avez récupéré " . $etoilesARecuperer . " étoiles !" . PHP_EOL . PHP_EOL;
