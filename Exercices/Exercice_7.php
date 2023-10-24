<?php

//BORGES PEREIRA ENZO BTC25.1

// Define classes to represent characters, specifically heroes and villains.
// Start by creating a base class called "Character" with the following attributes:

// Base Character class
class Personnage
{
    // Attributes of the class
    public $nom;
    public $pouvoir;
    public $niveau_sante = 100;  // Default health level set to 100

    // Constructor to initialize the character's name and power
    public function __construct($Nom, $Pouvoir)
    {
        $this->nom = $Nom;
        $this->pouvoir = $Pouvoir;
    }

    // Method to display the character's name and health level
    public function afficher_infos()
    {
        echo "The character's name is: " . $this->nom . "\n";
        echo "The character's health level is: " . $this->niveau_sante . "\n";
    }
}

// Hero class that inherits from the base Character class
class Heros extends Personnage
{
    public $avantage;

    // Constructor to initialize the hero's name, power, and advantage
    public function __construct($Nom, $Pouvoir, $Avantage)
    {
        parent::__construct($Nom, $Pouvoir);  // Call the parent constructor to set name and power
        $this->avantage = $Avantage;
    }

    // Method to display the hero's information, including advantage
    public function afficher_infos()
    {
        parent::afficher_infos();  // Call the parent's display method
        echo "The hero's advantage is: " . $this->avantage . "\n";
    }
}

// Villain class that inherits from the base Character class
class Vilain extends Personnage
{
    public $destructeur;

    // Constructor to initialize the villain's name, power, and destructive power
    public function __construct($Nom, $Pouvoir, $Destructeur)
    {
        parent::__construct($Nom, $Pouvoir);
        $this->destructeur = $Destructeur;
    }

    // Method to display the villain's information, including destructive power
    public function afficher_infos()
    {
        parent::afficher_infos();
        echo "The villain's destructive power is: " . $this->destructeur . "\n";
    }
}

// Create a hero object and display its information
$heros = new Heros("bob", "Flying", "I can fly");
$heros->afficher_infos();

// Create a villain object and display its information
$vilain = new Vilain("bobi", "Intelligence", "I can destroy things with a single look");
$vilain->afficher_infos();
