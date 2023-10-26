<?php

/**
 * Character class, parent of Hero and Enemy
 */
class Character
{
    protected $name;
    protected $life;
    protected $power;

    public function __construct($name, $life, $power)
    {
        $this->name = $name;
        $this->life = $life;
        $this->power = $power;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLife()
    {
        return $this->life;
    }

    public function getPower()
    {
        return $this->power;
    }
}

/**
 * Hero class, child of Character
 */
class Hero extends Character
{
    private $xp = 0;
    private $level = 1;

    public function __construct($name, $life, $power)
    {
        parent::__construct($name, $life, $power);
    }

    //All get and set for Hero class
    public function getName()
    {
        return $this->name;
    }

    public function getLife()
    {
        return $this->life;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function getXp()
    {
        return $this->xp;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLife($life)
    {
        $this->life = $life;
    }

    public function setPower($power)
    {
        $this->power = $power;
    }

    public function setXp($xp)
    {
        $this->xp = $xp;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Atack method
     * 
     * @param Enemy $enemy
     */
    public function atack(Enemy $enemy, $multiplier)
    {
        $enemy->setLife($enemy->getLife() - $multiplier * $this->power);
    }

    /**
     * Die method
     */
    public function die($heros, $enemys, $player, $display, $enemy)
    {
        if ($this->life <= 0) {
            echo "\033\143"; //clear the screen
            echo PHP_EOL . "Vous êtes mort !" . PHP_EOL . PHP_EOL;

            $display->displayEndMenu($heros, $enemys, $player, $display, $enemy);
        }
    }
}

/**
 * Enemy class, child of Character
 */
class Enemy extends Character
{

    public function __construct($name, $life, $power)
    {
        parent::__construct($name, $life, $power);
    }

    //All get and set for Enemy class
    public function getName()
    {
        return $this->name;
    }

    public function getLife()
    {
        return $this->life;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function setLife($life)
    {
        $this->life = $life;
    }

    public function setPower($power)
    {
        $this->power = $power;
    }

    /**
     * Atack method
     * 
     * @param Hero $hero
     */
    public function atack(Hero $hero, $diviser)
    {
        $hero->setLife($hero->getLife() - $this->power * $diviser);
    }

    /**
     * Take damage method
     * 
     * @param Hero $powerHero
     */
    public function takeDamage(Hero $powerHero)
    {
        $this->life -= $powerHero->getPower();
    }

    /**
     * Die method
     */
    public function die(Enemy $enemy, $player, $main)
    {
        echo PHP_EOL . "Vous avez tué l'ennemi : " . $enemy->getName() . "!" . PHP_EOL;
        $main->xpAndLevel($player);
    }
}

class Main
{
    private $numberOfFight = 0;

    /**
     * startGame method for start a new game
     */
    public function startGame($main)
    {
        $display = new Display();
        $player = $this->createCharacter();

        //HARD CODE HERO AND ENEMY FOR TEST
        $goku = new Hero("Goku", 100, 20);
        $vegeta = new Hero("Vegeta", 100, 20);
        $heros = [$goku, $vegeta];

        $freezer = new Enemy("Freezer", 100, 20);
        $cell = new Enemy("Cell", 200, 30);
        $jidBuu = new Enemy("JidBuu", 300, 40);
        $enemys = [$freezer, $cell, $jidBuu];


        $this->game($player, $display, $heros, $enemys, $main);
    }

    /**
     * createCharacter method for create a Hero
     */
    public function createCharacter()
    {
        echo "\033\143"; //clear the screen
        echo "Nouvelle partie !" . PHP_EOL . PHP_EOL;
        echo "Entrez le nom de votre héros : ";
        $name = readline();

        $player = new Hero($name, 10000, 20);
        return $player;
    }

    /**
     * game method is the main game
     */
    public function game($player, $display, $heros, $enemys, $main)
    {
        echo "\033\143"; //clear the screen
        echo "Vous allez devoir affronter des vagues d'ennemis !" . PHP_EOL . PHP_EOL;
        echo "Les vagues seront de plus en plus difficiles !" . PHP_EOL;
        echo "Lors de vos combats, vous gagnerez de l'expérience qui vous permet de monté en niveau afin de débloquer de nouvelle attaque !" . PHP_EOL . PHP_EOL;

        echo "1 - Combattre" . PHP_EOL;
        echo "2 - Fruire dans la forêt " . PHP_EOL . PHP_EOL;
        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                $this->fight($player, $display, $heros, $enemys, $main);
                break;
            case "2":
                echo "Vous êtes lache !";
                exit;
                break;
            default:
                echo "Veuillez choisir une option valide !";
                $this->game($player, $display, $heros, $enemys, $main);
                break;
        }
    }

    /**
     * fight method for fight
     * 
     * @param Hero $player
     * @param Display $display
     * @param Hero $heros
     * @param array $enemys
     */
    public function fight($player, $display, $heros, $enemys, $main)
    {
        $enemysList = [];

        //Increase number of fight and add enemy to list
        switch ($this->numberOfFight) {
            case 0:
                array_push($enemysList, $enemys[0]);
                break;
            case 1:
                array_push($enemysList, $enemys[1]);
                break;
            case 2:
                array_push($enemysList, $enemys[0], $enemys[1]);
                break;
            case 3:
                array_push($enemysList, $enemys[0], $enemys[1], $enemys[2]);
                break;
        }

        $isFight = true;

        //Fight loop
        while ($isFight) {

            //Display enemy list
            echo "\033\143"; //clear the screen
            $display->displayPlayerStat($player);
            echo "Vous allez  devoir combattre : " . PHP_EOL . PHP_EOL;
            $display->displayEnemyStat($enemysList);

            //Choose a enemy to fight, only if enemy list is more than 1
            if (sizeof($enemysList) > 1) {
                $toAttack = readline("Quel ennemi voulez-vous combattre ? : ");
                $enemy = $enemysList[$toAttack - 1];
            } else {
                $enemy = $enemysList[0];
            }

            //Choice action for fight
            echo PHP_EOL . "Sélectionner une action : " . PHP_EOL . PHP_EOL;

            echo "1 - Dragon Fist" . PHP_EOL;
            echo "2 - Kamehameha (niveau 2 requis)" . PHP_EOL;
            echo "3 - Energy Shield" . PHP_EOL;
            $choice = readline("Que voulez-vous faire ? : ");

            switch ($choice) {
                case 1:
                    $multiplier = 1;
                    $diviser = 1;
                    $player->atack($enemy, $multiplier);
                    $this->allAttack($enemys, $player, $diviser);
                    break;
                case 2:
                    if ($player->getLevel() >= 2) {
                        $multiplier = 1.2;
                        $diviser = 1;
                        $player->atack($enemy, $multiplier);
                        $this->allAttack($enemys, $player, $diviser);
                    } else {
                        echo "Vous n'avez pas le niveau requis ! (niveau 2)";
                    }
                    break;
                case 3:
                    $diviser = 1.3;
                    $this->allAttack($enemys, $player, $diviser);
                    break;
                default:
                    echo "Veuillez choisir une option valide !";
                    break;
            }

            //Check if enemy is dead
            foreach ($enemysList as $enemy) {
                if ($enemy->getLife() <= 0) {
                    $key = array_search($enemy, $enemysList);
                    unset($enemysList[$key]);
                    $enemy->die($enemy, $player, $main);
                }
            }

            //Check if all enemy is dead
            if (empty($enemysList)) {
                $this->numberOfFight = +1;
                $this->game($heros, $enemys, $player, $display, $main);
                $isFight = false;
            }

            //Check if player is dead
            if ($player->getLife() <= 0) {
                $isFight = false;
                $player->die($heros, $enemys, $player, $display, $enemy);
            }

            //Check if player win
            $this->win($heros, $enemys, $player, $display, $enemy);
        }
    }

    /**
     * allAttack method for attack all enemy
     */
    private function allAttack($enemys, $player, $diviser)
    {
        foreach ($enemys as $enemy) {
            $enemy->atack($player, $diviser);
        }
    }

    /**
     * xpAndLevel method for increase xp and level
     */
    public function xpAndLevel(Hero $player)
    {
        $player->setXp($player->getXp() + 50);
        if ($player->getXp() >= 100) {
            $player->setLevel($player->getLevel() + 1);
            $player->setXp(0);
        }
    }

    /**
     * win method for check if player finish the game
     */
    public function win($heros, $enemys, $player, $display, $enemy)
    {
        if ($this->numberOfFight == 4) {
            echo "Vous avez gagné !";
            $display->displayEndMenu($heros, $enemys, $player, $display, $enemy);
            exit;
        }
    }
}

/**
 * Display class
 */
class Display
{
    /**
     * Display player stat
     * 
     * @param Hero $hero
     */
    public function displayPlayerStat($player)
    {
        echo PHP_EOL . "Vos informations : " . PHP_EOL;
        echo PHP_EOL . "Nom : " . $player->getName() . PHP_EOL;
        echo "Vie : " . $player->getLife() . PHP_EOL;
        echo "Puissance : " . $player->getPower() . PHP_EOL;
        echo "Niveau : " . $player->getLevel() . PHP_EOL;
        echo "Expérience : " . $player->getXp() . " / 100" . PHP_EOL . PHP_EOL;
    }

    /**
     * Display enemy list
     * 
     * @param Enemy $enemysList
     */
    public function displayEnemyStat($enemysList)
    {
        //Check if enemy list is empty, if not display enemy list
        if (!empty($enemysList)) {
            foreach ($enemysList as $enemy) {
                $i = 1;
                echo $i . " - " . $enemy->getName() . " " . $enemy->getLife() . " PV" . PHP_EOL;
                $i++;
            }
        }
    }

    /**
     * displayEndMenu method for display end menu (player is dead or win)
     */
    public function displayEndMenu($main, $heros, $enemys, $player, $display, $enemy)
    {
        echo "Vous pouvez :" . PHP_EOL . PHP_EOL;

        echo "1 - Recommencer le combat" . PHP_EOL;
        echo "2 - Recommencer une partie" . PHP_EOL;
        echo "3 - Sauvegarder la partie" . PHP_EOL;
        echo "4 - Quitter" . PHP_EOL;
        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                $main->fight($heros, $enemys, $player, $display);
                break;
            case "2":
                $main->startGame();
                break;
            case "3":
                //TODO
                break;
            case "4":
                echo "A bientôt !";
                exit;
                break;
            default:
                echo "Veuillez choisir une option valide !";
                $this->displayEndMenu($main, $heros, $enemys, $player, $display, $enemy);
                break;
        }
    }
}

/**
 * Welcome class
 */
class Welcome
{

    /**
     * welcome method for display welcome menu
     */
    public function welcome()
    {
        echo "\033\143"; //clear the screen
        echo "Bienvenue dans Dragon Ball !" . PHP_EOL . PHP_EOL;
        echo "1 - Creér une partie" . PHP_EOL;
        echo "2 - Charger une partie" . PHP_EOL;
        echo "3 - Quitter" . PHP_EOL . PHP_EOL;
        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                global $main; //It's a global variable for use e
                $main = new Main();
                $main->startGame($main);
                break;
            case "2":
                //TODO
                break;
            case "3":
                echo "A bientôt !";
                exit;
                break;
            default:
                echo "Veuillez choisir une option valide !";
                $this->welcome();
                break;
        }
    }
}

/**
 * Save class
 */
class Save
{
    //TODO
}

$welcome = new Welcome();
$welcome->welcome();
