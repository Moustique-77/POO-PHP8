<?php

//Créez une classe abstraite Forme avec deux méthodes abstraites : calculerAire() et calculerPerimetre(). 
//Ensuite, créez des sous-classes pour représenter différentes formes géométriques, comme un cercle, un rectangle et un triangle. 
//Chacune de ces sous-classes doit hériter de la classe Forme et implémenter les méthodes abstraites pour calculer l'aire et le périmètre spécifiques à chaque forme. 
//Créez des instances de ces sous-classes et appelez les méthodes pour calculer l'aire et le périmètre de chaque forme.

abstract class Forme
{
    abstract public function calculerAire();
    abstract public function calculerPerimetre();
}

class Cercle
{
    public function calculerAire()
    {
        $rayon = 5;
        $aire = pi() * pow($rayon, 2);
        echo "L'aire du cercle est : " . $aire;
    }

    public function calculerPerimetre()
    {
        $rayon = 5;
        $perimetre = 2 * pi() * $rayon;
        echo "Le périmètre du cercle est : " . $perimetre;
    }
}

class Rectangle
{
    public function calculerAire()
    {
        $longueur = 5;
        $largeur = 3;
        $aire = $longueur * $largeur;
        echo "L'aire du rectangle est : " . $aire;
    }

    public function calculerPerimetre()
    {
        $longueur = 5;
        $largeur = 3;
        $perimetre = 2 * ($longueur + $largeur);
        echo "Le périmètre du rectangle est : " . $perimetre;
    }
}

class Triangle
{
    public function calculerAire()
    {
        $base = 5;
        $hauteur = 3;
        $aire = ($base * $hauteur) / 2;
        echo "L'aire du triangle est : " . $aire;
    }

    public function calculerPerimetre()
    {
        $cote1 = 5;
        $cote2 = 3;
        $cote3 = 4;
        $perimetre = $cote1 + $cote2 + $cote3;
        echo "Le périmètre du triangle est : " . $perimetre;
    }
}

$cercle = new Cercle();
$rectangle = new Rectangle();
$triangle = new Triangle();

echo $cercle->calculerAire() . "\n";
echo $cercle->calculerPerimetre() . "\n";

echo $rectangle->calculerAire() . "\n";
echo $rectangle->calculerPerimetre() . "\n";

echo $triangle->calculerAire() . "\n";
echo $triangle->calculerPerimetre() . "\n";
