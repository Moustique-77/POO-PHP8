<?php

//Créez une classe CompteBancaire avec une propriété de solde initial, et des méthodes pour déposer et retirer de l'argent. 
//Assurez-vous que le solde ne puisse pas devenir négatif.

class CompteBancaire
{
    public $solde;

    public function __construct($solde)
    {
        $this->solde = $solde;
    }

    public function deposer($montant)
    {
        $this->solde += $montant;
    }

    public function retirer($montant)
    {
        if ($this->solde - $montant < 0) {
            throw new InvalidArgumentException("Le solde ne peut pas être négatif.");
        }
        $this->solde -= $montant;
    }
}

$compte = new CompteBancaire(100);

echo "Solde initial: " . $compte->solde . "\n";
echo "Dépôt de 50€ ";
$compte->deposer(50);
echo "Nouveau solde: " . $compte->solde . "\n";
echo "Retrait de 25€ ";
$compte->retirer(25);
echo "Nouveau solde: " . $compte->solde . "\n";
