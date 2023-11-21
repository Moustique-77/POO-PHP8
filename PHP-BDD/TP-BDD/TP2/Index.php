<?php

include("Config.php");
include("Niveau.php");
include("Personnage.php");
include("DAO.php");

//Connexion à la base de données
$niveauDAO = new NiveauDAO($bdd);
$personnageDAO = new PersonnageDAO($bdd);
