<?php

//Créez une classe Calculatrice avec des méthodes pour additionner, soustraire, multiplier et diviser deux nombres. 
//Testez ces méthodes avec différentes valeurs.

class Calculatrice
{

    public function additionner($a, $b)
    {
        return $a + $b;
    }

    public function soustraire($a, $b)
    {
        return $a - $b;
    }

    public function multiplier($a, $b)
    {
        return $a * $b;
    }

    public function diviser($a, $b)
    {
        if ($b == 0) {
            throw new InvalidArgumentException("Le dénominateur ne peut pas être zéro.");
        }
        return $a / $b;
    }
}

// Test de la classe Calculatrice
$calc = new Calculatrice();

echo "Addition de 5 + 3: " . $calc->additionner(5, 3) . "\n";
echo "Soustraction de 5 - 3: " . $calc->soustraire(5, 3) . "\n";
echo "Multiplication de 5 * 3: " . $calc->multiplier(5, 3) . "\n";
echo "Division de 5 / 3: " . $calc->diviser(5, 3) . "\n";
