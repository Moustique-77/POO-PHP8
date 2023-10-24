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

/**
 * Class representing a character.
 */
class Personnage
{
    private string $nom;
    private string $classe;
    private int $niveau = 1;
    private Inventaire $inventaire;

    public function __construct(string $nom, string $classe)
    {
        $this->nom = $nom;
        $this->classe = $classe;
        $this->inventaire = new Inventaire();
    }

    public function afficher_infos(): void
    {
        echo "Nom: " . $this->nom . ", Classe: " . $this->classe . ", Niveau: " . $this->niveau . PHP_EOL;
    }

    public function getInventaire(): Inventaire
    {
        return $this->inventaire;
    }
}

/**
 * Class representing an inventory.
 */
class Inventaire
{
    private array $objets = [];

    public function ajouter_objet(string $objet): void
    {
        $this->objets[] = $objet;
    }

    public function afficher_inventaire(): void
    {
        echo "Inventaire: " . PHP_EOL;
        foreach ($this->objets as $objet) {
            echo "- " . $objet . PHP_EOL;
        }
    }

    public function supprimer_objet(string $objet): void
    {
        if (($key = array_search($objet, $this->objets)) !== false) {
            unset($this->objets[$key]);
        }
    }
}

$personnages = [];

while (true) {
    echo "\nMenu principal:\n";
    echo "1. Créer un nouveau personnage\n";
    echo "2. Afficher les personnages\n";
    echo "3. Gérer l'inventaire d'un personnage\n";
    echo "4. Quitter\n";
    echo "Choix : ";

    //Trim permet de supprimer les espaces en début et fin de chaîne
    $choice = trim(readline());

    switch ($choice) {
        case '1':
            echo "Nom du personnage : ";
            $nom = trim(readline());
            echo "Classe du personnage : ";
            $classe = trim(readline());
            $personnage = new Personnage($nom, $classe);
            $personnages[] = $personnage;
            echo "Personnage créé!\n";
            break;
        case '2':
            foreach ($personnages as $key => $p) {
                echo ($key + 1) . ". ";
                $p->afficher_infos();
            }
            break;
        case '3':
            if (!$personnages) {
                echo "Aucun personnage créé. Veuillez d'abord en créer un.\n";
                break;
            }
            foreach ($personnages as $key => $p) {
                echo ($key + 1) . ". ";
                $p->afficher_infos();
            }
            echo "Sélectionnez un personnage : ";
            $selection = (int)trim(readline()) - 1;

            if (!isset($personnages[$selection])) {
                echo "Choix invalide!\n";
                break;
            }

            $personnageSelected = $personnages[$selection];

            while (true) {
                echo "\nMenu inventaire:\n";
                echo "1. Ajouter un objet\n";
                echo "2. Supprimer un objet\n";
                echo "3. Afficher l'inventaire\n";
                echo "4. Retour au menu principal\n";
                echo "Choix : ";

                $choiceInventaire = trim(readline());

                switch ($choiceInventaire) {
                    case '1':
                        echo "Nom de l'objet : ";
                        $objet = trim(readline());
                        $personnageSelected->getInventaire()->ajouter_objet($objet);
                        echo "Objet ajouté!\n";
                        break;
                    case '2':
                        $personnageSelected->getInventaire()->afficher_inventaire();
                        echo "Nom de l'objet à supprimer : ";
                        $objet = trim(readline());
                        $personnageSelected->getInventaire()->supprimer_objet($objet);
                        echo "Objet supprimé!\n";
                        break;
                    case '3':
                        $personnageSelected->getInventaire()->afficher_inventaire();
                        break;
                    case '4':
                        break 2;  // Sortir de la boucle du sous-menu
                    default:
                        echo "Choix invalide.\n";
                }
            }
            break;
        case '4':
            echo "Au revoir!\n";
            exit;
        default:
            echo "Choix invalide.\n";
    }
}
