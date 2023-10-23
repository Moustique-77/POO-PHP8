<?php

//Créez une classe abstraite Animal avec une méthode abstraite parler(). 
//Ensuite, créez deux sous- classes Chien et Chat qui héritent de la classe Animal. 
//Implémentez la méthode parler() dans ces sous-classes pour qu'elle retourne le cri du chien ("Woof") et du chat ("Meow").
//Créez ensuite une instance de chaque sous-classe et appelez la méthode parler() pour vérifier le cri de chaque animal.

abstract class Animal
{
    abstract public function parler();
}

class Chien extends Animal
{
    public function parler()
    {
        return "Woof";
    }
}

class Chat extends Animal
{
    public function parler()
    {
        return "Meow";
    }
}

$chien = new Chien();
$chat = new Chat();

echo $chien->parler() . "\n";
echo $chat->parler() . "\n";
