<?php

include("TP_1_PersonnageDAO.php");

//Personnage class
class Personnage
{
    private $nom;
    private $puissance;

    //constructor
    public function __construct($nom, $puissance)
    {
        $this->nom = $nom;
        $this->puissance = $puissance;
    }

    //getters
    public function getNom()
    {
        return $this->nom;
    }

    public function getPuissance()
    {
        return $this->puissance;
    }

    //setters
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
    }
}

//Hollows class
class Hollows extends Personnage
{
    private $transformation;
    private $type = "Hollows";

    //constructor
    public function __construct($nom, $puissance, $transformation, $type)
    {
        parent::__construct($nom, $puissance);
        $this->transformation = $transformation;
        $this->type = $type;
    }

    //getters
    public function getTransformation()
    {
        return $this->transformation;
    }

    public function getType()
    {
        return $this->type;
    }

    //setters
    public function setTransformation($transformation)
    {
        $this->transformation = $transformation;
    }
}

//Shinigami class
class Shinigami extends Personnage
{
    private $arme;
    private $type = "Shinigami";

    //constructor
    public function __construct($nom, $puissance, $arme, $type)
    {
        parent::__construct($nom, $puissance);
        $this->arme = $arme;
        $this->type = $type;
    }

    //getters
    public function getAttributs()
    {
        return $this->arme;
    }

    public function getType()
    {
        return $this->type;
    }

    //setters
    public function setarme($arme)
    {
        $this->arme = $arme;
    }
}

//Welcome message and check if there is already a character in DB
function welcome($connexion, $resultat)
{
    echo "Bienvenue dans le monde de Bleach !\n";

    //Check if they are already a character in DB
    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    if ($listePersonnage == false) {
        echo "Il n'y a pas encore de personnage dans la base de données." . PHP_EOL;
        menu($connexion, $resultat);
    } else {
        echo "Voici la liste des personnages déjà présents dans la base de données :" . PHP_EOL;
        foreach ($listePersonnage as $personnage) {
            echo $personnage['nom'] . "\n";
        }
        menu($connexion, $resultat);
    }
}

//Display the menu
function menu($connexion, $resultat)
{
    echo "Que voulez-vous faire ?" . PHP_EOL;
    echo "1. Créer un personnage" . PHP_EOL;
    echo "2. Modifier un personnage" . PHP_EOL;
    echo "3. Supprimer un personnage" . PHP_EOL;
    echo "4. Combattre" . PHP_EOL;
    echo "5. Quitter" . PHP_EOL;

    $choix = readline("Votre choix : ");

    switch ($choix) {
        case 1:
            create($connexion, $resultat);
            break;
        case 2:
            update($connexion, $resultat);
            break;
        case 3:
            delete($connexion, $resultat);
            break;
        case 4:
            fight($connexion, $resultat);
        case 5:
            echo "A bientôt !";
            break;
        default:
            echo "Veuillez choisir une option valide." . PHP_EOL;
            menu($connexion, $resultat);
    }
}

//Create a new character
function create($connexion, $resultat)
{
    echo "Vous avez choisi de créer un personnage." . PHP_EOL;

    $nom = readline("Nom du personnage : ");
    $puissance = readline("Puissance du personnage : ");
    $type = readline("Type du personnage (Hollows ou Shinigami) : ");

    //Check if the type is correct
    if ($type != "Hollows" && $type != "Shinigami") {
        echo "Veuillez choisir entre Hollows et Shinigami." . PHP_EOL;
        create($connexion, $resultat);
    }

    //Check if the type is Hollows
    if ($type == "Hollows") {
        $attributs = readline("Transformation du personnage (Gamuza, Pantera, Giralda ou Los Lobos) : ");

        //Check if the attributs is correct
        if ($attributs != "Gamuza" && $attributs != "Pantera" && $attributs != "Giralda" && $attributs != "Los Lobos") {
            echo "Veuillez choisir entre Gamuza, Pantera, Giralda ou Los Lobos." . PHP_EOL;
            create($connexion, $resultat);
        }

        $personnage = new Hollows($nom, $puissance, $type, $attributs);

        //Push the character in DB
        $personnageDAO = new PersonnageDAO($connexion);
        $personnageDAO->ajoutPersonnage($personnage->getNom(), $personnage->getPuissance(), $personnage->getType(), $personnage->getTransformation());
        menu($connexion, $resultat);
    } else if ($type == "Shinigami") {
        $attributs = readline("Arme du personnage (Zangetsu, Sōgyo no Kotowari, Senbonzakura, Kyōka Suigetsu ou Tensa Zangetsu) : ");

        //Check if the attributs is correct
        if ($attributs != "Zangetsu" && $attributs != "Sōgyo no Kotowari" && $attributs != "Senbonzakura" && $attributs != "Kyōka Suigetsu" && $attributs != "Tensa Zangetsu") {
            echo "Veuillez choisir entre Zangetsu, Sōgyo no Kotowari, Senbonzakura, Kyōka Suigetsu ou Tensa Zangetsu." . PHP_EOL;
            create($connexion, $resultat);
        }

        $personnage = new Shinigami($nom, $puissance, $type, $attributs);

        //Push the character in DB
        $personnageDAO = new PersonnageDAO($connexion);
        $personnageDAO->ajoutPersonnage($personnage->getNom(), $personnage->getPuissance(), $personnage->getType(), $personnage->getAttributs());
        menu($connexion, $resultat);
    } else {
        echo "Veuillez choisir entre Hollows et Shinigami." . PHP_EOL;
        create($connexion, $resultat);
    }
}

//Update a character
function update($connexion, $resultat)
{
    echo "Vous avez choisi de modifier un personnage." . PHP_EOL;

    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    //Display list of characters with their id (user can choose with id)
    echo "Voici la liste des personnages :" . PHP_EOL;
    foreach ($listePersonnage as $personnage) {
        echo $personnage['id'] . " - " . $personnage['nom'] . "\n";
    }

    $toModify = readline("ID du personnage à modifier : ");

    //Check if the character exist
    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    $exist = false;
    foreach ($listePersonnage as $personnage) {
        if ($personnage['id'] == $toModify) {
            $exist = true;
        }
    }

    if ($exist == false) {
        echo "Ce personnage n'existe pas." . PHP_EOL;
        delete($connexion, $resultat);
    }

    //Display the choosen character (with id) with his attributs
    $personnageDAO = new PersonnageDAO($connexion);
    $toModify = $personnageDAO->listePersonnageParId($toModify);

    if ($toModify) {
        echo "Vous allez modifier le personnage suivant :" . PHP_EOL;

        echo "Nom : " . ($toModify['nom'] ?? '') . "\n";
        echo "Puissance : " . ($toModify['puissance'] ?? '') . "\n";
        echo "Type : " . ($toModify['type'] ?? '') . "\n";
        echo "Attributs : " . ($toModify['attributs'] ?? '') . "\n";

        $nom = readline("Nom du personnage : ");
        $puissance = readline("Puissance du personnage : ");

        //Push the character in DB
        $personnageDAO = new PersonnageDAO($connexion);
        $personnageDAO->modifPersonnage($toModify['id'], $nom, $puissance, $toModify['types'], $toModify['attributs']);

        echo "Le personnage a bien été modifié." . PHP_EOL;

        menu($connexion, $resultat);
    } else {
        echo "Ce personnage n'existe pas." . PHP_EOL;
        delete($connexion, $resultat);
    }
}

function delete($connexion, $resultat)
{
    echo "Vous avez choisi de supprimer un personnage." . PHP_EOL;

    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    //Display list of characters with their id (user can choose with id)
    echo "Voici la liste des personnages :" . PHP_EOL;
    foreach ($listePersonnage as $personnage) {
        echo $personnage['id'] . " - " . $personnage['nom'] . "\n";
    }

    $toDelete = readline("ID du personnage à supprimer : ");

    //Check if the character exist
    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    $exist = false;
    foreach ($listePersonnage as $personnage) {
        if ($personnage['id'] == $toDelete) {
            $exist = true;
        }
    }

    if ($exist == false) {
        echo "Ce personnage n'existe pas." . PHP_EOL;
        delete($connexion, $resultat);
    }

    //-1 to the id because the id in DB start at 1 and the array start at 0


    //Delete the character in DB
    $personnageDAO = new PersonnageDAO($connexion);
    $personnageDAO->supprPersonnage($toDelete - 1);

    echo "Le personnage a bien été supprimé." . PHP_EOL;

    menu($connexion, $resultat);
}

function fight($connexion, $resultat)
{
    echo "Vous avez choisi de combattre." . PHP_EOL;

    //Select 2 random characters from DB
    $personnageDAO = new PersonnageDAO($connexion);
    $listePersonnage = $personnageDAO->listePersonnage();

    $random1 = rand(0, count($listePersonnage) - 1);
    $random2 = rand(0, count($listePersonnage) - 1);

    //Check if the 2 random characters are the same
    if ($random1 == $random2) {
        $random2 = rand(0, count($listePersonnage) - 1);
    }

    //Display the 2 random characters
    echo "Voici les 2 personnages qui vont combattre :" . PHP_EOL;
    echo $listePersonnage[$random1]['nom'] . " VS " . $listePersonnage[$random2]['nom'] . "\n";

    //The character with the highest power win
    if ($listePersonnage[$random1]['puissance'] > $listePersonnage[$random2]['puissance']) {
        echo $listePersonnage[$random1]['nom'] . " a gagné !" . PHP_EOL;
    } else if ($listePersonnage[$random1]['puissance'] < $listePersonnage[$random2]['puissance']) {
        echo $listePersonnage[$random2]['nom'] . " a gagné !" . PHP_EOL;
    } else {
        echo "Egalité !" . PHP_EOL;
    }

    menu($connexion, $resultat);
}

welcome($connexion, $resultat);
