<?php

include_once("DAO.php");
include_once("Maison.php");
include_once("Config.php");

//Connexion à la base de données
$maisonDAO = new MaisonDAO($bdd);




//Ajout d'une maison
$maison1 = new Maison("", 100, 5, "tondeuse, piscine", 100000);
//Ajout de la maison à la BDD
$maisonDAO->addMaison($maison1);

$maison2 = new Maison("", 150, 6, "TEST", 150000);
$maisonDAO->addMaison($maison2);

$maison3 = new Maison("", 200, 7, "OUI", 200000);
$maisonDAO->addMaison($maison3);
