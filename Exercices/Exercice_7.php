<?php

//Vous devez créer des classes pour représenter des personnages, en particulier des héros et des vilains. 
//Commencez par créer une classe de base appelée "Personnage" avec les attributs suivants :

//nom : Le nom du personnage.
//pouvoir : Le pouvoir spécial du personnage.
//niveau_sante : Le niveau de santé du personnage, initialement fixé à 100.

//Dans cette classe, ajoutez des méthodes pour afficher le nom et le niveau de santé du personnage. 
//Par exemple, vous pouvez créer une méthode afficher_infos() qui affiche ces informations.
//Ensuite, créez deux classes spécifiques, "Heros" et "Vilain", qui héritent de la classe "Personnage". 

//Dans la classe "Heros", ajoutez un attribut supplémentaire avantage pour représenter l'avantage spécial du héros. 
//Dans la classe "Vilain", ajoutez un attribut supplémentaire destructeur pour représenter le pouvoir destructeur du vilain.

class Personnage
{
    public $nom;
    public $pouvoir;
    public $niveau_sante = 100;

    public function __construct($Nom, $Pouvoir)
    {
        $this->nom = $Nom;
        $this->pouvoir = $Pouvoir;
    }

    public function afficher_infos()
    {
        echo "Le nom du personnage est : " . $this->nom . "\n";
        echo "Le niveau de santé du personnage est : " . $this->niveau_sante . "\n";
    }
}

class Heros extends Personnage
{
    public $avantage = "Je peux devenir invisible";

    public function __construct($Nom, $Pouvoir, $Avantage)
    {
        parent::__construct($Nom, $Pouvoir);
        $this->avantage = $Avantage;
    }

    public function afficher_infos()
    {
        parent::afficher_infos();
        echo "L'avantage du héros est : " . $this->avantage . "\n";
    }
}

class Vilain extends Personnage
{
    public $destructeur = "Je peux détruire les choses d'un seul regard";

    public function __construct($Nom, $Pouvoir, $Destructeur)
    {
        parent::__construct($Nom, $Pouvoir);
        $this->destructeur = $Destructeur;
    }

    public function afficher_infos()
    {
        parent::afficher_infos();
        echo "Le pouvoir destructeur du vilain est : " . $this->destructeur . "\n";
    }
}

$heros = new Heros("bob", "Vol", "Je peux voler");
$heros->afficher_infos();

$vilain = new Vilain("bobi", "Intelligence", "Je peux détruire les choses d'un seul regard");
$vilain->afficher_infos();
