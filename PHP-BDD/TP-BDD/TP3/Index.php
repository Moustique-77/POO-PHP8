<?php

//Include des fichiers
include_once("DAO.php");
include_once("Employer.php");
include_once("Config.php");

//Connexion
$employersDAO = new EmployerDAO($bdd);

echo "Gestion RH : " . PHP_EOL . PHP_EOL;

//Ajout d'un employer
// $employer0 = new Employer("Dupont", "Jean", "PDG", 10000);
// $employersDAO->AddEmployer($employer0);

//Affichage de tous les employers
echo "Ajout d'un employer, voici la liste des employers : " . PHP_EOL . PHP_EOL;
$allEmployers = $employersDAO->GetAllEmployer();
$listeEmployers = [];

foreach ($allEmployers as $employer) {
    $employerObjet = new Employer($employer["id"], $employer["nom"], $employer["prenom"], $employer["poste"], $employer["salaire"]);
    $listeEmployers[] = $employerObjet;
}

foreach ($listeEmployers as $employer) {
    echo $employer->getNom() . " - " . $employer->getPrenom() . " - " . $employer->getPoste() . " - " . $employer->getSalaire() . PHP_EOL;
}

//Modification d'un employer (augmentation de salaire)
echo PHP_EOL . "Modification d'un employer, augmentation de 1000€ pour un employer aléatoire : " . PHP_EOL . PHP_EOL;

//On récupère un employer aléatoire
$employerAleatoire = $listeEmployers[rand(0, count($listeEmployers) - 1)];

//On augmente son salaire
$employerAleatoire->setSalaire($employerAleatoire->getSalaire() + 1000);

//On update l'employer
$employersDAO->UpdateEmployer($employerAleatoire);

//On affiche l'employer modifié
$employerModifie = $employersDAO->GetEmployerById($employerAleatoire->getId());

// Vérification si des données ont été récupérées
if ($employerModifie !== null) {
    // Création d'un objet Employer avec les données obtenues
    $employerModifie = new Employer(
        "",
        $employerModifie['nom'],
        $employerModifie['prenom'],
        $employerModifie['poste'],
        $employerModifie['salaire']
    );

    echo $employerModifie->getNom() . " - " . $employerModifie->getPrenom() . " - " . $employerModifie->getPoste() . " - " . $employerModifie->getSalaire() . PHP_EOL;
} else {
    echo "Aucun employé trouvé avec cet ID.";
}
