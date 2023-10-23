<?php

//Étendez l'exercice précédent en ajoutant une méthode abstraite manger() à la classe abstraite Animal. 
//Chaque sous-classe doit implémenter cette méthode pour décrire comment l'animal mange. 
//Créez également une classe Oiseau qui hérite de la classe Animal et implémentez les méthodes parler() et manger() spécifiques à un oiseau. 
//Créez une instance d'un oiseau et appelez ses méthodes parler() et manger().


abstract class Animal2
{
    abstract public function parler();
    abstract public function manger();
}

class Chien extends Animal2
{
    public function parler()
    {
        return "Woof";
    }

    public function manger()
    {
        return "Je mange de la viande";
    }
}

class Chat extends Animal2
{
    public function parler()
    {
        return "Meow";
    }

    public function manger()
    {
        return "Je mange du poisson";
    }
}

class Oisseau extends Animal2
{
    public function parler()
    {
        return "Cui cui";
    }

    public function manger()
    {
        return "Je mange des graines";
    }
}

$chien = new Chien();
$chat = new Chat();
$oiseaau = new Oisseau();

echo $chien->parler() . "\n";
echo $chien->manger() . "\n";

echo $chat->parler() . "\n";
echo $chat->manger() . "\n";

echo $oiseaau->parler() . "\n";
echo $oiseaau->manger() . "\n";
