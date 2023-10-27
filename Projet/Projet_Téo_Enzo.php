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
    public function atack($enemy, $multiplier)
    {
        $enemy->setLife($enemy->getLife() - $multiplier * $this->power);
    }

    /**
     * Die method
     */
    public function die($heros, $enemies, $player, $display, $enemy)
    {
        if ($this->life <= 0) {
            echo "\033\143"; //clear the screen
            $display->centerTxt(PHP_EOL . "Vous êtes mort !" . PHP_EOL . PHP_EOL);
            $display->displayEndMenu($heros, $enemies, $player, $display, $enemy);
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

    public function __destruct()
    {
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
     * @param Hero player
     */
    public function atack($player, $diviser)
    {
        $player->setLife($player->getLife() - $this->power * $diviser);
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
    public function die($player, $main)
    {
        $main->xpAndLevel($player);
    }
}

class Main
{
    private $numberOfFight = 0;

    /**
     * startGame method for start a new game
     */
    public function startGame($main, $display)
    {

        $player = $this->createCharacter($display);

        //HARD CODE HERO AND ENEMY FOR TEST
        $goku = new Hero("Goku", 100, 20);
        $vegeta = new Hero("Vegeta", 100, 20);
        $heros = [$goku, $vegeta];

        $enemies = [];

        $this->game($player, $display, $heros, $enemies, $main);
    }

    /**
     * createCharacter method for create a Hero
     */
    public function createCharacter($display)
    {
        echo "\033\143"; //clear the screen
        $display->centerTxt("Nouvelle partie !" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Entrez le nom de votre héros : ");
        $name = readline();

        $player = new Hero($name, 1000, 20);

        echo "\033\143"; //clear the screen
        $display->centerTxt("Bienvenue dans le jeu " . $player->getName() . " !" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Vous avez créé votre héro : " . $player->getName() . PHP_EOL . PHP_EOL);
        $display->centerTxt("Vous allez devoir affronter des vagues d'ennemis, les vagues seront de plus en plus difficiles." . PHP_EOL . PHP_EOL);
        $display->centerTxt("lors de vos combats, vous gagnerez de l'expérience qui vous permet de monter en niveau afin de débloquer de nouvelle attaque !" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Bonne chance " . PHP_EOL . PHP_EOL);
        $display->centerTxt("Vous êtes dans la forêt, vous entendez des bruits de pas qui se rapprochent..." . PHP_EOL . PHP_EOL);

        echo "Appuyez sur entrée pour commencer votre aventure...";
        readline();
        return $player;
    }

    /**
     * game method is the main game
     */
    public function game($player, $display, $heros, $enemies, $main)
    {
        //Check if player win
        if ($this->numberOfFight == 4) {
            $this->win($heros, $enemies, $player, $display, $main);
        }

        echo "\033\143"; //clear the screen
        $display->centerTxt("1 - Combattre" . PHP_EOL . PHP_EOL);
        $display->centerTxt("2 - Fuire dans la forêt" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Que voulez-vous faire ? : ");
        $awser = readline();

        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                $this->fight($player, $display, $heros, $enemies, $main);
                break;
            case "2":
                $display->centerTxt("Vous êtes lache !");
                exit;
                break;
            default:
                $display->centerTxt("Veillez choisir une option valide !");
                $this->game($player, $display, $heros, $enemies, $main);
                break;
        }
    }

    /**
     * createEnemy method for create a enemy
     */
    function createEnemy($type, $count)
    {
        $enemies = [];

        switch ($type) {
            case 'Freezer':
                for ($i = 0; $i < $count; $i++) {
                    $enemies[] = new Enemy("Freezer", 100, 20);
                }
                break;

            case 'Cell':
                for ($i = 0; $i < $count; $i++) {
                    $enemies[] = new Enemy("Cell", 200, 30);
                }
                break;

            case 'JidBuu':
                for ($i = 0; $i < $count; $i++) {
                    $enemies[] = new Enemy("JidBuu", 300, 40);
                }
                break;

            default:
                echo "Type d'ennemi non reconnu.";
                break;
        }
        return $enemies;
    }

    /**
     * fight method for fight
     * 
     * @param Hero $player
     * @param Display $display
     * @param Hero $heros
     * @param array $enemies
     */
    public function fight($player, $display, $heros, $enemies, $main)
    {
        $enemiesList = [];

        //Increase number of fight and add enemy to list
        switch ($this->numberOfFight) {
            case 0:
                $freezer = $this->createEnemy('Freezer', 1);
                $enemiesList = array_merge($freezer);
                break;
            case 1:
                $cell = $this->createEnemy('Cell', 1);
                $enemiesList =  array_merge($cell);
                break;
            case 2:
                $freezer = $this->createEnemy('Freezer', 1);
                $cell = $this->createEnemy('Cell', 1);
                $enemiesList =  array_merge($freezer, $cell);
                break;
            case 3:
                $freezer = $this->createEnemy('Freezer', 1);
                $cell = $this->createEnemy('Cell', 1);
                $jidBuu = $this->createEnemy('JidBuu', 1);
                $enemiesList =  array_merge($freezer, $cell, $jidBuu);
                break;
        }

        $isFight = true;

        //Fight loop
        while ($isFight) {

            //Display enemy list
            echo "\033\143"; //clear the screen
            $display->displayPlayerStat($player, $display);
            $display->centerTxt("Vous allez  devoir combattre : " . PHP_EOL . PHP_EOL);
            $display->displayEnemyStat($enemiesList, $display);

            //Choose a enemy to fight, only if enemy list is more than 1
            if (sizeof($enemiesList) > 1) {
                $display->centerTxt(PHP_EOL . "Quel ennemi voulez-vous combattre ? :");
                $toAttack = readline();
                //check if the choice is valid
                while ($toAttack > sizeof($enemiesList) || $toAttack < 1) {
                    $display->centerTxt("Veuillez choisir une option valide !");
                    $display->centerTxt(PHP_EOL . "Quel ennemi voulez-vous combattre ? : ");
                    $toAttack = readline();
                }
                $enemy = $enemiesList[$toAttack - 1];
                $display->centerTxt("Vous avez choisi de combattre : " . $enemy->getName() . PHP_EOL . PHP_EOL);
            } else {
                //Update enemy if enemy list is 1
                $enemiesList = array_values($enemiesList);
                $enemy = $enemiesList[0];
            }

            //Choice action for fight
            $display->centerTxt(PHP_EOL . "Sélectionner une action : " . PHP_EOL . PHP_EOL);

            $display->centerTxt("1 - Dragon Fist" . PHP_EOL);
            $display->centerTxt("2 - Kamehameha (niveau 2 requis)" . PHP_EOL);
            $display->centerTxt("3 - Energy Shield" . PHP_EOL);

            $choice = readline("Que voulez-vous faire?");

            switch ($choice) {
                case 1:
                    $multiplier = 1;
                    $diviser = 1;
                    $player->atack($enemy, $multiplier);
                    $this->allAttack($enemiesList, $player, $diviser, $display);
                    break;
                case 2:
                    if ($player->getLevel() >= 2) {
                        $multiplier = 2.5;
                        $diviser = 1;
                        $player->atack($enemy, $multiplier);
                        $this->allAttack($enemiesList, $player, $diviser, $display);
                    } else {
                        $display->centerTxt("Vous n'avez pas le niveau requis ! (niveau 2)");
                    }
                    break;
                case 3:
                    $diviser = 1.3;
                    $this->allAttack($enemiesList, $player, $diviser, $display);
                    break;
                default:
                    $display->centerTxt("Veuillez choisir une option valide !");
                    break;
            }

            //Check if enemy is dead
            foreach ($enemiesList as $enemy) {
                if ($enemy->getLife() <= 0) {
                    $key = array_search($enemy, $enemiesList);
                    unset($enemiesList[$key]);
                    //Update array index
                    $enemiesList = array_values($enemiesList);
                    $enemy->die($player, $main);
                }
            }

            //Check if all enemy is dead
            if (empty($enemiesList)) {
                $this->numberOfFight++;
                $this->game($player, $display, $heros, $enemies, $main);
                $isFight = false;
            }

            //Check if player is dead
            if ($player->getLife() <= 0) {
                $isFight = false;
                $player->die($heros, $enemies, $player, $display, $enemy);
            }
        }
    }

    /**
     * allAttack method for attack all enemy
     */
    private function allAttack($enemiesList, $player, $diviser, $display)
    {
        foreach ($enemiesList as $enemy) {
            $display->centerTxt($enemy->getName() . " vous attaque !" . PHP_EOL);
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
            $player->setPower($player->getPower() + 10);
            $player->setXp(0);
        }
    }

    /**
     * win method for check if player finish the game
     */
    public function win($heros, $enemies, $player, $display, $main)
    {
        echo "\033\143"; //clear the screen
        $display->centerTxt("Vous avez gagné!" . PHP_EOL . PHP_EOL);
        $display->displayEndMenu($main, $heros, $enemies, $player, $display);
        exit;
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
     * @param Hero player
     */
    public function displayPlayerStat($player, $display)
    {
        $display->centerTxt("Vos informations :" . PHP_EOL);
        $display->centerTxt("Nom : " . $player->getName() . PHP_EOL);
        $display->centerTxt("Vie : " . $player->getLife() . PHP_EOL);
        $display->centerTxt("Puissance : " . $player->getPower() . PHP_EOL);
        $display->centerTxt("Niveau : " . $player->getLevel() . PHP_EOL);
        $display->centerTxt("Expérience : " . $player->getXp() . " / 100" . PHP_EOL . PHP_EOL);
    }

    /**
     * Display enemy list
     * 
     * @param Enemy $enemiesList
     */
    public function displayEnemyStat($enemiesList, $display)
    {
        // Vérifiez si la liste est un tableau et n'est pas vide
        if (!empty($enemiesList)) {
            $i = 1;
            foreach ($enemiesList as $enemy) {
                $display->centerTxt($i . " - " . $enemy->getName() . " " . $enemy->getLife() . " PV" . PHP_EOL);
                $i++;
            }
        }
    }

    /**
     * displayEndMenu method for display end menu (player is dead or win)
     */
    public function displayEndMenu($main, $heros, $enemies, $player, $display)
    {
        $display->centerTxt("Vous pouvez :" . PHP_EOL . PHP_EOL);
        $display->centerTxt("1 - Recommencer le combat" . PHP_EOL);
        $display->centerTxt("2 - Recommencer une partie" . PHP_EOL);
        $display->centerTxt("3 - Sauvegarder la partie" . PHP_EOL);
        $display->centerTxt("4 - Quitter" . PHP_EOL);

        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                $main->fight($heros, $enemies, $player, $display);
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
                $this->displayEndMenu($main, $heros, $enemies, $player, $display);
                break;
        }
    }

    /**
     * centerTxt method for center text
     */
    public function centerTxt($txt)
    {
        $terminal_width = exec('tput cols'); //get the terminal width
        $spaces_before = max(0, floor(($terminal_width - strlen($txt)) / 2)); //calculate the number of spaces before the text
        echo str_repeat(' ', $spaces_before) . $txt . PHP_EOL;
    }
}

/**
 * Save class
 */
class Save
{
    //TODO
}

/**
 * Welcome class
 */
class Welcome
{


    /**
     * welcome method for display welcome menu
     */
    public function welcome($display)
    {
        echo "\033\143"; //clear the screen


        $image = "                                         
                                                                                █████████             
                                                                        █   █████████                
                                                                        ███ ██████████                 
                                                                        ██████████████ █ ░░░            
                                                                    ██████████████████ ██░░░░░          
                                                        █     ████████████████████████████▓▒▒          
                                                        ███   █████████████████████████░░▓▓▓            
                                                        ███  ███████████████████████████░░▓             
                                                    ███████████████████████████████████              
                                                    █   ███████████████████████████████████             
                                                        █████████████████████▓░░░██████████             
                                                        ██████████████████████░░░░███████              
                                                        ████████████▒█░░░░█████░██░░█████               
                                                    ████████░█████░░█░░░░░░███▒░░██▒░                
                                                        ██████░░░███░░░░░░░░░░█▓░░█░░▒░                
                                                        ███████░░░░░██░░░░░░░░█░░░░░░░▒░▒               
                                                        ██████░░░█████░░░░░░██░░░░░▒░░▒▒              
                                                        ███████░░░░░░░░██░░░░░░░░░░▒▒░░░                                             
                                                        ███░░█░░░░░░░░░░░░░░░░░░░░▒▒░▒░              
                                                        ███████░░░░░░░▓░▒░░░░░▓░░░░░░░▒░▒█              
                                                        ██████░░░▒░░░░░░░░░▓▒▒▒▒░░░█░░░░▒█             
                                                        ██████░░░░░░░░░░░░░░░░▒█░░░░░░░░▒██             
                                                        ███████░░░░░░░░▒░░░░░░░░░░░░░░░▒▒██             
                                                        ███████░▓░░░░░░░░░░░░░░░░░░░░▒░░▒█              
                                                        █████░░░░░░░░░█░░░░░░░░░░░░░▒████             
                                                        ████▓░░░░░░░░░░░▒▒░░░░░░░░████▓██            
                                                            ██▓▓▓▓▓▓▓▓░░▓░░░░░░░░░░████▓███████        
                                                            ▓▓▓▓▓░░░░░░░░████▓▓▓███▓▓▓██▓▓▓████      
                                                            ▓▓░░░░░░░░░░░░▒██▓▓██▓▓██████▓▓▓▓████    
                                                            ▓██░░░░░░░░░░░░░░░▒▓▓░░░░░█▓▓▓▓▓▓▓▓███   
                                                                ██░░░░░░░░░░░░░▓▓▓░░░░░░░░▓▓▓▓▓▓▓▓██   
                                                                █▓█░░░░░░░░░░▓▓▓░░░░░░░░▒░▓▓▓▓▓▓███   
                                                                    ░░░░░░░░▓▓▓░░░░░░░░░▒▓▓▓▓▓▓▓███   
                                                                        ▒░░░░▓▓▓░▓░░░░░░█▓██▓▓▓▓███    
                                                                        ░░░░▓▓░░▒░░░░█ ██▓▓▓███      
                                                                            ▓███▓▓░░░░░███     █▒▓      
                                                                            ▓▓█▓▓▓▓▓▓▓█████             
                                                                            ▓▓█▓▓▓▓▓▓▓██████           
                                                                            ▓▓▓▓▓▓▓▓▓███▓███          
                                                                            ▓▓▓▓▓▓▓▓█▓█▓███          
                                                                                ▓▓▓▓▓▓▓██▓██           
                                                                                █▓▓▓▓▓█▓██▓           
                                                                                ▓▓▓▓▓▓▓█▒▓▓          
                                                                                        ▒▒▒▒▒▒         
                                                                                        ▒▒▒▒▓        
                                                                                            █▒▓      " . PHP_EOL . PHP_EOL;


        $display->centerTxt("Bienvenue dans Dragon Ball CLI by Enzo & Téo !");
        echo $image;
        $enter = readline("Appuyez sur entrée pour continuer : ");
        echo "\033\143"; //clear the screen

        $display->centerTxt("1 - Creér une partie" . PHP_EOL);
        $display->centerTxt("2 - Charger une partie" . PHP_EOL);
        $display->centerTxt("3 - Quitter" . PHP_EOL . PHP_EOL);
        $awser = readline("Que voulez-vous faire ? : ");



        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                global $main; //It's a global variable for use e
                $main = new Main();
                $main->startGame($main, $display);
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
                $this->welcome($display);
                break;
        }
    }
}
$display = new Display();
$welcome = new Welcome();
$welcome->welcome($display);
