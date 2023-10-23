<?php

//Imaginez que vous développez un jeu vidéo de type RPG (jeu de rôle). Vous devez créer des classes pour représenter les personnages jouables et leurs inventaires.

//Créez une classe "Personnage" avec les attributs suivants : 

//nom : Le nom du personnage.
//classe : La classe du personnage (guerrier, mage, voleur, etc.). 
//niveau : Le niveau du personnage (initialisé à 1).

//Dans cette classe, ajoutez une méthode afficher_infos() qui permet d'afficher les informations du personnage.

//Créez une classe "Inventaire" qui représente l'inventaire d'un personnage. 
//L'inventaire doit contenir une liste d'objets (par exemple, des potions, des armes, des armures, etc.). 
//Ajoutez les méthodes suivantes à la classe "Inventaire" :

//ajouter_objet(objet) : Cette méthode permet d'ajouter un objet à l'inventaire.
//afficher_inventaire() : Cette méthode affiche la liste des objets dans l'inventaire.
//supprimer_objet(objet) : Cette méthode permet de supprimer un objet de l'inventaire.

//Créez des instances de la classe "Personnage" pour représenter différents personnages jouables, puis créez des instances de la classe "Inventaire" pour chacun de ces personnages. Utilisez les méthodes de la classe "Inventaire" pour ajouter, afficher et supprimer des objets de l'inventaire des personnages.

class Personnage
{
    public $nom;
    public $classe;
    public $niveau = 1;

    public function __construct($Nom, $Classe)
    {
        $this->nom = $Nom;
        $this->classe = $Classe;
    }

    public function afficher_infos()
    {
        echo "Le nom du personnage est : " . $this->nom . "\n";
        echo "La classe du personnage est : " . $this->classe . "\n";
        echo "Le niveau du personnage est : " . $this->niveau . "\n";
    }
}

class Inventaire
{
    public $liste_objets = array();

    public function afficher_inventaire()
    {
        echo "Voici la liste des objets de l'inventaire : \n";
        foreach ($this->liste_objets as $objet) {
            echo $objet . "\n";
        }
    }

    public function ajouter_objet($objet)
    {
        array_push($this->liste_objets, $objet);
    }

    public function supprimer_objet($objet)
    {
        $index = array_search($objet, $this->liste_objets);
        unset($this->liste_objets[$index]);
    }
}

$personnage1 = new Personnage("Gandalf", "Mage");
$personnage1->afficher_infos();

$inventaire1 = new Inventaire();
$inventaire1->ajouter_objet("Potion de soin");
$inventaire1->ajouter_objet("Potion de mana");
$inventaire1->ajouter_objet("Potion de force");
$inventaire1->ajouter_objet("Potion de vitesse");

$inventaire1->afficher_inventaire();

$inventaire1->supprimer_objet("Potion de force");

$inventaire1->afficher_inventaire();
