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
    private $numberOfFight = 0;

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
    public function getNumberOfFight()
    {
        return $this->numberOfFight;
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

    public function setNumberOfFight(int $numberOfFight)
    {
        $this->numberOfFight = $numberOfFight;
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
    public function die($player, $display, $main)
    {
        if ($this->life <= 0) {
            echo "\033\143"; //clear the screen
            $display->centerTxt(PHP_EOL . "Vous êtes mort !" . PHP_EOL . PHP_EOL);
            $display->displayEndMenu($main, $player, $display);
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

        $this->game($player, $display, $main);
    }

    /**
     * createCharacter method for create a Hero
     */
    private function createCharacter($display)
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
    public function game($player, $display, $main)
    {
        //Check if player win
        if ($player->getNumberOfFight() == 4) {
            $this->win($display, $main, $player);
        }

        echo "\033\143"; //clear the screen
        $display->centerTxt("1 - Combattre" . PHP_EOL . PHP_EOL);
        $display->centerTxt("2 - Sauvegarder la partie" . PHP_EOL . PHP_EOL);
        $display->centerTxt("3 - Fuire dans la forêt" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Que voulez-vous faire ? : ");
        $awser = readline();

        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                $this->fight($player, $display, $main);
                break;
            case "2":
                echo "\033\143"; //clear the screen
                $save = new Save();
                $save->save($player, $display);
                break;
            case "3":
                $display->centerTxt("Vous êtes lache !");
                exit;
                break;
            default:
                $display->centerTxt("Veillez choisir une option valide !");
                $this->game($player, $display, $main);
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
    public function fight($player, $display, $main)
    {
        $enemiesList = [];

        //Increase number of fight and add enemy to list
        switch ($player->getNumberOfFight()) {
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
            $display->displayEnemies($enemiesList);

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
            $display->centerTxt("Sélectionner une action : " . PHP_EOL);

            $display->centerTxt("1 - Dragon Fist" . PHP_EOL);
            $display->centerTxt("2 - Kamehameha (niveau 2 requis)" . PHP_EOL);
            $display->centerTxt("3 - Energy Shield" . PHP_EOL);

            $choice = readline("Que voulez-vous faire ? : ");

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
                $player->setNumberOfFight($player->getNumberOfFight() + 1);
                $this->game($player, $display,  $main);
                $isFight = false;
            }

            //Check if player is dead
            if ($player->getLife() <= 0) {
                $isFight = false;
                $player->die($player, $display, $main);
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
    private function win($display, $main, $player)
    {
        echo "\033\143"; //clear the screen
        $display->centerTxt("Vous avez gagné!" . PHP_EOL . PHP_EOL);
        $display->centerTxt("Vous pouvez :" . PHP_EOL . PHP_EOL);
        $display->centerTxt("1 - Recommencer une partie." . PHP_EOL);
        $display->centerTxt("2 - Quitter le jeux." . PHP_EOL);

        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                $player->setNumberOfFight(0);
                $main->startGame($main, $display);
                break;
            case "2":
                $display->centerTxt(PHP_EOL . "Merci d'avoir jouer, a bientôt !" . PHP_EOL);
                exit;
                break;
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
     * @param Hero player
     */
    public function displayPlayerStat($player, $display)
    {
        $display->centerTxt("------------------------------------------------------------" . PHP_EOL);
        $display->centerTxt("Vos informations :" . PHP_EOL);
        $display->centerTxt("Nom : " . $player->getName() . PHP_EOL);
        $display->centerTxt("Vie : " . $player->getLife() . PHP_EOL);
        $display->centerTxt("Puissance : " . $player->getPower() . PHP_EOL);
        $display->centerTxt("Niveau : " . $player->getLevel() . PHP_EOL);
        $display->centerTxt("Expérience : " . $player->getXp() . " / 100" . PHP_EOL . PHP_EOL);
        $display->centerTxt("------------------------------------------------------------" . PHP_EOL);
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
     * displayEndMenu method for display end menu
     */
    public function displayEndMenu($main, $player, $display)
    {
        $display->centerTxt("Vous pouvez :" . PHP_EOL . PHP_EOL);
        $display->centerTxt("1 - Recommencer le combat" . PHP_EOL);
        $display->centerTxt("2 - Recommencer une partie" . PHP_EOL);
        $display->centerTxt("3 - Sauvegarder la partie" . PHP_EOL);
        $display->centerTxt("4 - Quitter" . PHP_EOL);

        $awser = readline("Que voulez-vous faire ? : ");

        switch ($awser) {
            case "1":
                $main->fight($player, $display, $main);
                $player->setLife(500);
                break;
            case "2":
                $main->startGame($main, $display);
                unset($player);
                $main->setNumberOfFight(0);
                break;
            case "3":
                $save = new Save();
                $save->save($player, $display);
                break;
            case "4":
                echo "A bientôt !";
                exit;
                break;
            default:
                echo "Veuillez choisir une option valide !";
                $this->displayEndMenu($main, $player, $display);
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

    public function displayEnemies($enemiesList)
    {
        $freezer = false;
        $cell = false;
        $buu = false;
        $enemiesName = [];

        //Extract emeies name
        foreach ($enemiesList as $enemy) {

            array_push($enemiesName, $enemy->getName());
        }
        if (array_search('Freezer', $enemiesName) !== false) {
            $freezer = true;
        }
        if (array_search('Cell', $enemiesName) !== false) {
            $cell = true;
        }
        if (array_search('JidBuu', $enemiesName) !== false) {
            $buu = true;
        }

        //Display enemies

        switch (true) {
            case ($freezer == true && $cell == false && $buu == false):
                echo    "                                   
                                                            ░░██▒░              
                                                    ███▓░░░█░▓▓██░▒█▓▓██       
                                                        ▒░░▒█████▒▒▓           
                                                        ░▒█░██░██▒            
                                                ░░░     █░▒░██▒█▒▓     █░█░   
                                                ░░▒░ ██     ░░░▒██       ░ ▒▒░  
                                                ░▒░░░▒     ░░▒▒█▒      ░░▒▒▒   
                                                ░░░ █░░░░░░█░░░░░░░░░█ ░▒▒▓   
                                                ▒▒░▒▒▓█░░░░░▒░░▒▒▒▓▒██▒░░▓█   
                                                ░██▒▓▒█▒▒▓▓░░░██▓▒▓▒▒▓░░▒██   
                                                ▒▓░▒█▓ ░▒░█▓▓█▒▓▓ ▓▓█░▒██    
                                                    ▒░▒    ░░░░▒░░▒     ░█      
                                                        ▒██████▓             
                                                        ████████             
                                                        ▒▒▒▓██▒▒▓▓            
                                                        ▒▒▒▓▓▓▓█▒▒▓█           
                                                    ▓░░▒▒▒▒▒▓▓▓ ▓▒▒▓█           
                                                ░█▒▓▓▓▓▓░░▓▓    ▓▒░▒▒          
                                                ▒▒▓▓▓   ▓▓█▓      ▓░██▒         
                                            ░▒█▓    ░▒▓█▒▓    ░░░▓█▒▒        
                                            ░▓▓▓▒   ░▓█▒▒▓   ░░░░▒▓█▒███     
                                                █▓▓▓▓▒▒█▓█▒▓▓▓▓███░░░▓█▒      
                                                ▓▓██▒▓█▒███     ░░▓█▒        
                                                    ░▓█▒▒        ░░▒██▓       
                                                    █░░░▒▓        ▒░░░░▓       
                                                ░░▒░░▒▒░░▓     █░▒▒░▒▒▒▒█    
                                                    ▒▒▒                         
 ";
                break;
            case ($cell == true && $freezer == false && $buu == false):
                echo "    
                    ░  ▒          
                    ░█▒▓░         
                    ░▓▓▓█         
                     █▓▒          
                  █▓█████████  ░█ 
                ░████▓███▓▒▓█░▒▒  
                 ░▓█░█▓░▓█▒▓░▓█   
                 █▓█████████▓▓█   
                ▓▒██▓▒░▓▓██████▓  
                ▒▓█▒▒██▒▓█░█████  
                ░░█▓█▓░▒▒▓█░████▒ 
                ░█░▒▓▓█▓▓▓██ ▓███░
                ░█░▒█▓░▒▓▓█   ░██▓
                 █░░██  █▒▓█    ░█
                  ▒▓▒█  ▒▓██░     
                  ████  ▒█▓██     
                  ░██▒   █▓█░     
                  ░██     ▓▓█     
                 █▓█▓░    █▒▓     
               ░▒▒▓▓▓     █░░▒▓    
            ";

                break;
            case ($freezer == true && $cell == false && $buu == false):
                echo "                  
                    ▓░░░                        
                    ▓█▓▒    ░███▓██░█    ▓█▓              
                        ▓█░░░█░▓▓█░█▒▒██                  
                           ░░▓▓▒░▒▓▓▒▒                    
                          ▒▒░▒▒░█▒▒██▒      █▓            
                  ▒▒▒░▒     ▒▓░▒▓▒▒▓     █░▒░░▒▒          
                 ░▓░░░▒       ▓░░▓       ░▒▒▒░▓▒          
                  ▒▒░░▓ ▓█░░▒░█▒▒█▓▓▒███  ░░▒▒▒           
                  ░░░░▒░░░░░░░░▒░░░░░░▒▒░▒░░▒▓█           
                   ▓██▒▓▒▒▓▒░░▒▒▓▒▒▒▒▓▒▒▓█░▒▒█            
                   ░▓▓░▒▒▓▒░░▒░▓▓▓▓░░▓▓▓▓░░▒██            
                    █▓▓▒▓▓  ▒░░██▒░░▓  █▓▒▒▒█             
                     ░░▒    ░░░▒▒▒▒░▒    ▒▒               
                            ████████                      
                            ▒▓████▓▓▓                     
                           ▓▓▒▓██▒▒▒█                     
                          ▒▒▒▓▒█▓▓▒▒▒▓                    
                    ░░▒▒▒▒▒▒▓▓█▓ ▓▒▒▒▓█                   
                 ▓▒▒▒▓▓▓▓▓░░▒▓    ▒▒░░▒                   
                ░▒▓▓▓▒  ▓▓▓█▓▒     █░▒▓▒▒                 
                ▒▓▓▓    ░▒▓█▒▓    ▒░░▒▓█▒                 
                █▓▓▓▒   ░▓██▒▓  █▒▓░░░▓█▒████             
                 ▒▓▓▓▓▓▒░██▒▓▓▓████░░░██▒█     █          
                    ▓▓▓█▒▓█▒███▒    ░░▒▓█▓                
                       ░██▒▒▓       ▓░░██▒▓               
                      ▓░░░░▓▒       █░░░░▒█               
                   ▓░▒▒▒░▒▒░░▒      ░▒▒░░▒▒▒▓             
                     ▒▒▒▒          ▒                      
      
";

                break;
            case ($freezer == true && $freezer == true && $buu == false):
                echo "  
                █   ▓                  
                ░░░███░                                               ▒█ ▒▓░                 
          ███░░░█░▓▓▓██░░▓██▒                                         ▒▓▓▒██                 
             ▒█░░░▓█▒░▒▒█▒                                            ▓▓████                 
              ░▓▓░▒▓▒▓█▓▓                                             ▒█▒▒█                  
      ░▒▒ ▒    ░▒░░▓█▒▒▓      ░░▒▒▒                                   ░▒▒▒▓██▒▒▒▒  ▓ ▓ ▒     
    ░░░░▒░▒      ▓░░▓▒      ▒ ░▓▒▒▒▒                               ▓█████████████░ ▒░░░      
     ▒░░░▒▒▓░░░░░▒▒▒▒▒▓█▒░░  ▓░▒▒▓                               ██▒███▒█████▒▒▒█▓▒▒▒▒░      
      ░░░█▒░░░▓░░░▒▓░░░░░░░▒▒░░▒▒█                              ▓██▒▓█▓██▓▒▓▓█▒▒▓█▒░▒█       
      ░▓▓▒▓█▒█░░░░▒▓░▒▒▒▒▒▒▓█░░░██                               ▒▒█▒▒██▓░░▒██▒▒█▒▒▓█        
       ▒▓░▒▒▒▓░░░▒░▓▓█░░▒█▒▒░░▒▓█▒                               █▓█▒▓█████▓███▒▒▓▓▓▓        
       ░▓█░▓▓ ▒▒░░█▓█▒░▓▒ ▓▓█░▒█▒                               ▒▒▓██▒▓▓▒▓▓█▒███▓▓██▓        
        ░░▒    ░░░░▓▒▒░▓     ▒▒                                 ▒▒▓██▒▒▒▓░▓▒█▓███████▓       
               ████████▓                                        ▒▓██▒████▓▒█▓▓▒███████▓      
               ▒▒█████▓▓                                        ░██░▒█▒█▓▒▓▒█▓█ ██████▒░     
              ░▒▒▓██▒▒▒▓▓                                       ░░█▒▒███░▒▒▒▓██░ ██████▓     
             ░▒▒▒▓▓█▓▒▒▒▓▒                                        █▒▒█▓▓▓▒▒▒▓▓█▓  ██████     
       ░░▒▒▒▒▒▒▒▓▓▓▒ █▒▓▓█                                        █▒▒▓▓██▒▒▒▓█▓█   ▒████▓    
    ▒▒▒▓▓▓█▓▓░░▒▓     ▓▒░▒▓                                       █▒▓█▓█░ ▒█▓▓▓▓    ░███▓    
   ▒▒▓▓▓▒   ░▓█▒▓     █░▓▓█▒                                      █░█▓▓█   ▒▒▒██      ░██    
   ░▒▓▓▒   ░▒▓█▒▒▒    ░░░▓█▒▓                                    ▒░▒▓██▓   ▒█▓██▓            
    ▒▓▓▓▒  ░▓██▒▓  ▒▓▓░░░▓█▒▓████▒                                ▒▓████   ▒▓▓███            
     ▓▓▓▓▓▓░▓█▒▒▓▓████ ░░▒▓█▓                                     ▒▒████░  ▒█▓▓███           
        ▒▓▓█▓█▒▓█▒     ░░▒▓█▒▒                                     ▒███▓    █▓▓██░           
          ░██▓▒▓       ░░░██▓▓                                     ▓███      ▓▓██            
         ░░░░░▒▓       ▒░░░▒▒▒▓                                    ████       ▓██            
      ░░▒▒░░▒▒█▒▒█    ▒░▒▒▓▒░▒█▓█▒                                ▒████      ░▓███           
         ▒                                                       ░░█░▒▓       ▓░▒▓█          
                                                             ░░░▒▓▓▓▓▓▓       ▒▒░░▒▒▓        
";
                break;
            case ($freezer == true && $buu == true && $cell == false):
                echo "                                                                                      
                ░░░███░                                                                      
          ███░░░█░▓▓▓██░░▓██▒                                                  ▓░▒▒▒         
             ▒█░░░▓█▒░▒▒█▒                                                   ░░▒   ▓▒        
              ░▓▓░▒▓▒▓█▓▓                                                   ▒░▒▒             
      ░▒▒ ▒    ░▒░░▓█▒▒▓      ░░▓▒▒                                         ░░▒▓             
    ░░░░▒░▒▒     ▓░░▓▒      ▒ ░▓▒▒▓                                       ▒░░░▒▒▒█           
     ▒░░░▒▒▓░░░░░▒▒▒▒▒▓█▒░░  ▓░▒▒▓                                        ░░░░▒▒▒▒▒          
      ░░░█▒░░░▓░░░▒▓░░░░░░░▒▒░░▒▒█                                       ░░░░░▒░▒▒▒          
      ░▓▓▒▓█▒█░░░░▒▓░▒▒▒▒▒▒▓█░░░██                                     ░█▒░░▒░░▒▒▒░█░        
       ▒▓░▒▒▒▓░░░▒░▓▓█░░▒█▒▒░░▒▓█▒                                    ▓░░▓▒░░▒▓▒▒▒▓░░▓       
       ░▓█░▓▓ ▒▒░░█▓█▒░▓▒ ▓▓█░▒█▒                                      ░▒░░▒░░▒▒▒░░░░        
        ░░▒    ░░░░▓▒▒░▓     ▒▒                                       ░░▒▒░░░░░░░░▒▒░░       
               ████████▓                                              ░▒▓▒░░░▒▒░▒▒▒▒░░       
               ▒▒█████▓▓                                            █▒░▒  ░░▒▒▒▒░▒  ▒░▒▓     
              ░▒▒▓██▒▒▒▓▓                                        ▒░░░██  ██░▒▒▒▒▒██ ▒█░░██░░ 
             ░▒▒▒▓▓█▓▒▒▒▓▒                                      ░▓▒▓▒▒ ▒░░░░▓░░░█▒▒▒  ██░░▓▓░
       ░░▒▒▒▒▒▒▒▓▓▓▒ █▒▓▓█                                       ▒▒▒   ░░░▒░█░░█░░░░▒   █░░░▓
     ▒▒▓▓▓█▓▓░░▒▓     ▓▒░▒▓                                          ░░░░░▒░▒▒░░░▒░░░░▒      
   ▒▒▓▓▓▒   ░▓█▒▓     █░▓▓█▒                                       ▒░░▒░░░░░▒▒░░░░░░░▒░░     
   ░▒▓▓▒   ░▒▓█▒▒▒    ░░░▓█▒▓                                     ░░░░░░░░░░▒▓▒▒░░░░░░░░░░   
    ▒▓▓▓▒  ░▓██▒▓     ░░░▓█▒▓████▒                               ░░░░░░░░░░▒▒▒▒▒▒▒░░░░░░░░░  
     ▓▓▓▓▓▓░▓█▒▒▓      ░░▒▓█▓                                    ░░░░░░▒░░▒▒    ▒▒▒░░░░░▒░░▒ 
        ▒▓▓█▓█▒▓█      ░░▒▓█▒▒                                    ░▒▒░░▒▒▒        ▓░▒▒▒▒░▒▒  
          ░██▓▒▓       ░░░██▓▓                                   █░██▒                ▒████  
         ░░░░░▒▓       ▒░░░▒▒▒▓                                 ▒▒█░█                  ░░█░█ 
      ░░▒▒░░▒▒█▒▒█    ▒░▒▒▓▒░▒█▓█▒                             ▒██▒                      ███▒
         ▒                                                                      ";
                break;
            case ($buu == true && $cell == true && $freezer == false):
                echo " 
                
                
                ░▒▒▒ ▓▒                                                █   ▓                  
                ░░▒▒    ▒                                              ▒█ ▒▓░                 
               ░░▒▒                                                    ▒▓█▒██                 
               ░░▒▒                                                    ▓▓████                 
             ▒░░░▒▒▒▒                                                  ▒█▒▒█                  
            ░░░░░▒▒▒▒▒                                                  ▒▒▒▓██▒▒▒▒  ▓ ▓ ▒     
            ░░░░░░▒▒▒▒▒                                             ▓█████████████░ ▒░░░      
           ░░░░░░▒░▒▒▒░                                           ██▒███▒█████▒▒▒█▓▒▒▒▒░      
        ▓░█▒░░░░░░░▒▒▒▒░░                                        ▓██▒▓█▓██▓▒▓▓█▒▒▓█▒░▒█       
        ░░▓▒▒░█▒░░▒█▒▒▒▓░░                                        ▒▒█▒▒██▓░░▒██▒▒█▒▒▓█        
        ▓░░░░▓░░▒▒░▒▒░░░░░                                        █▓█▒▓█████▓███▒▒▓▓▓▓        
        ░░▒░░░▒▓▒▒▒▒█░░░░▒                                       ▒▒▓██▒▓▓▒▓▓█▒███▓▓██▓        
       ▓░░▒▒░░░░░░░░░░▓▒░░▓                                      ▒▒▓██▒▒▒▓░▓▒█▓███████▓       
       ░░▒▓▒▒░░░▒▒░░▒▒ ▒░░░                                      ▒▓██▒████▓▒█▓▓▒████████      
     ██▒░▒  ▒░░▒▒▒▒░░▒  ▒▒░░                                     ░██░▒█▒█▓▒▓▒█▓█ ██████▒      
 ▓░░█░░▒█▒ ██░░▒▒▒▒░▒█▒ ▓▒░▓███                                  ░░█▒▒███░▒▒▒▓██  ██████▓     
░░▒█▒░██  ▒░███▒▒▒▒███░▒ ▓██░░▓░░░░░                               █▒▒█▓▓▓▒▒▒▓▓█▓  ██████     
░░░░▒▒   ░░▒░█░█░█░░▒░▒▒▓  ▒██░▒▒░░░                               █▒▒▓▓██▒▒▒▓█▓█   ▒████▓    
        ░░▒░░▒░░░░░░░░░▒░▒    ▒█░░▒                                █▒▓█▓█  ▒█▓▓▓▓    ░███▓    
       ░░░░░░░░▒▒░░▒░░░░░▒░                                       ██░█▓▓█   ▒▒▒██      ░██    
     ░░▒░░░░░░░▒▓▒░░░░░░░░░░░                                     ▒░▒▓██▓   ▒█▓██▓            
    ░░░░░░░░░░░▒▒▒░░░░░░░░▓░░░░                                    ▒▓████   ▒▓▓███            
 ▓░░░░░░░░░░░░░▒▒▒▒▒░░░░░░░░░▒░░░                                  ▒▒████░  ▒█▓▓███           
 ▓░░░░░░░░░▒░░▒▒▒▒▒▒▒▒░░░░░░░░░░░                                   ▒███▓    █▓▓██            
 ▒░░░░░░░▓░░▓▒      ▒▒▒░░░░░░░░░░▒                                  ▓███      ▓▓██            
  ░░▓▒▒░░▒▒▒          ▒░░░░░░░▒░▒                                   ████      ░▓██            
  ████▓▒                  ▒░░░▒██                                  ▒████      ░▓███           
 █░▒██                      ███▒█▓                                ░░█░▒▓       ▓░▒▓█          
█▓███▒                      ▒██░░█                            ░░░▒▓▓▓▓▓▓       ▒▒░░▒▒▓        
";
                break;

            case ($freezer == true && $buu == true && $cell == true):
                echo "                                                                                                                              
                                                                                                                                                                   
                                                                                                                                                       
                                                                    ░▒▒  ▒                                           █  ▒▒             
                                                                    ░░▒    ▒▒                                        ▒▓▒ ██             
                     ░░░░██░▒                                      ▒░▒▒                                              ▒▓▓▒▓▓             
                ▒██░░▓░▓▓▓██░▒██▒                                  ░░▒▒                                              ▒█▒▒██             
                   ▒░░▒░░░▒▓▒█                                   ▒░░░▒▒▒▒                                            ░▓▓▓▒             
                   ░▒▓░░▒▒▒▓▓▓     ▒░▒                          ▒░░░░░▒▒▒▒                                            ██▓▓███████▒▒░▒▒▒  
           ░░▒░▒▒    ▓▒░▒▒▒▓▒    ▓▒▒▒▒▒▒                        ▒░█░░░░▒▒▒                                        ▓█▒████████████░░▒▒▒   
          ▓▓░░░▓▒     ▒▓░▓▒     ▒░▒▒▒▒▒▒                      ░░░░░░░░░▒▒▒░░                                     ████▒███▒▓▓█▒▒▓█░▒▒▒   
           ▒░░░▒░▓░░░░░░▓░░░░▒░▓█ ░▒▒▒▒                      ░░█▒░█▒░░░█▒▒░░░▒                                  ▓▒▓▒▒██▓░▒▓█▒▓█▒▓█▒    
           ▒█░░▒░▒▒░░░░░▓░░▒▒▒▒▓▒▒░▒▒█▒                      ▒░░░░░░▒▒░▒▓░░░░                                  ▒▓█▓▓████▓████▓▓▓█     
            ░▓▓▒▓▒▒▓▒▒▒▓▒█▓█▓▓▓▒▓░░▒██                       ░░▒░░▒▒░▒▒▒▒░▒░░                                   ▒▓▓██▒▒▒▓░▓▒██▓▓█▓▒▒    
             ▒▓░▒▓▓▒░▒░░▓▓█▓▒▓▒▓▓░▒▒█▒                      ▒░▓▒▒░░░░░░░░▒▒▒░▒                                  ▒▒▓███▒▒░░▓▒▓███████▒   
              ▒█▒▒   ░░░▒▒░░▓   ▒░▒█                       ░░▒▒▒▒░░▒▒░▒▒▒▒▒░░▒                                 ▓▓█▓▒▓▒██▒▓▓█▒██████▓   
               ▓     ▒▓▓▓▓▓▓▓                          ██░░▒ ▒░░▒▒▒▒░▒▓▒▒▒░░█                                 ▒█░▒█▒█▒▒▒▓▓▓ ██████▒  
                    ▒████████                        ▒░▒░░██ ▒██░▒▒▒▒░██▒▒░█░░██▓░░                           ▒▓█▒▒▓██▓▒▒▓██▒ ██████  
                    ▓▒▒███▒▓▓▒                      ▓▒▒▒▒▒█  ▒░▒█░░░░░██▒░▒ ▒██░░░█░░░                          ▒█▒▒▓██░▓▓▓▓█▓  █████▒ 
                   █▒▒▓▓▓▓▓▒▒▓▒                      ░▒▒▒  ▒░▒░▒░░░░▒▒▒░▒░▓   █░░░▒░                            █▒▒█▓█ ▒▓▓██▒   ▒███░ 
             ▒░░▒▒▓▒▓▒▓▓▓ █▓▒▓▓                           ░░░░░▒░▒▒▓▒░░░░░░░                                    ██▓▒▓▒  ▓▓▓▓▓     ▓█░ 
           ▒▒▒▓▓▓▓▓░▒▒▓   ▒▓▒░▒▒                        ▒░░░░░░░░▒▒▒░░░░░░░░░                                   █▒▓██▒   ▓▓██▒        
          ▒▓▓▓▒  ▒▒▓█▓▒    ▓░▒▓▒▒                      ░░░░░░░░░░▒▒▒░░░░░░░░░░░▒                                ▒██▒█▓  ▒▓▓███        
         ▓▒▓▓▒   ░▓▓█ █    ░░█▓█▒▒                  ░░░░░░░░▒░░░▒▓▒▒▒░░▒░░░░░░░░▒                              ▒█████  ▒█▓███        
          ▒▓▓▓▒ ▒░██▒▒  ░▓▓░░░▓█▒█████            ░░░░░░░░▒▒░░▒▓▒▓▒▒▒░░░░░░▓░░▒                               ████▒   ▒▒▓██        
           ▓▓▓█▓▓█▓█ ▓████▓ ░░▓▓▒▓                 ░▓░░░░░░░▒▒      ▒░░░░░░░▒░░▒                               ▓███     ▒▓██        
              ▒█░▒█▒▒█▒     ░░▒▓█▓                  ▒▒▒░░░▒▒          ▒▒▓▒░░░▒▒                                ███░      ▓██▒       
                ░░█▒▒▒      ░░░▒▒▓▒                   █▓███                  ▒████▒                              ▒████     ▓█▒▒▓       
              ░░░░░░▒▓      ▓░░▒▒▒░█                  ▒██▒░                    ░▓█░█                           ▒░░▓▒▒▓░     ▒█░█▒▓      
            ▒█▒░░▒▒  ▒▒▒   █▒▒  ▒▒▒▒▒▓                                                                                                                 
                                                                                                                                                       

                                                                                                                              
";
                break;
        }
    }
}

/**
 * Save class, for save and open save
 */
class Save
{
    /**
     * save method for save the game and all progress
     */
    public function save($player, $display)
    {
        //Ask for save name
        echo "\033\143"; //clear the screen

        $nameSave = readline("Entrez le nom de la sauvegarde : ");

        //Check if the save name is not empty, or if the save name is not already used
        while (empty($nameSave) || file_exists($nameSave . ".txt")) {
            $display->centerTxt("Veuillez entrer un nom de sauvegarde valide !");
            $nameSave = readline("Entrez le nom de la sauvegarde : ");
        }

        //Create save file
        $save = fopen($nameSave . ".txt", "w");

        //Save player info's
        fwrite($save, $player->getName() . "\n");
        fwrite($save, $player->getLife() . "\n");
        fwrite($save, $player->getPower() . "\n");
        fwrite($save, $player->getXp() . "\n");
        fwrite($save, $player->getLevel() . "\n");
        fwrite($save, $player->getNumberOfFight() . "\n");

        fclose($save);

        echo (PHP_EOL . "La partie a bien été sauvegardée !" . PHP_EOL);
    }

    /**
     * openSave method for open a save and load all progress
     */
    public function openSave($main, $display)
    {
        //Display all save
        echo "\033\143"; //clear the screen
        $display->centerTxt("------------------------------------------------------------" . PHP_EOL);
        $display->centerTxt("Listes des sauvegardes :" . PHP_EOL);
        foreach (glob("*.txt") as $fileName) {

            $display->centerTxt($fileName . "\n");
        }
        $display->centerTxt("------------------------------------------------------------" . PHP_EOL);

        //Ask for save name
        $nameSave = readline($display->centerTxt("Entrez le nom de la sauvegarde : "));


        //Check if the save name is not empty, or if the save name exist
        while (empty($nameSave) || !file_exists($nameSave . ".txt")) {
            echo "\033\143"; //clear the screen
            $display->centerTxt("------------------------------------------------------------" . PHP_EOL);
            $display->centerTxt("Veuillez entrer un nom de sauvegarde valide !" . PHP_EOL);
            //Display all save
            foreach (glob("*.txt") as $fileName) {
                $display->centerTxt(PHP_EOL . "Listes des sauvegardes :" . PHP_EOL . PHP_EOL);
                $display->centerTxt($fileName . "\n");
            }
            $display->centerTxt("------------------------------------------------------------" . PHP_EOL);

            $nameSave = readline($display->centerTxt(PHP_EOL . "Entrez le nom de la sauvegarde : "));
        }

        //Open save file
        $save = fopen($nameSave . ".txt", "r");

        //Load player info's
        $player = new Hero(fgets($save), fgets($save), fgets($save), fgets($save), fgets($save), fgets($save));

        fclose($save);

        $main->game($player, $display, $main);

        return $player;
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

        global $main; //It's a global variable for use everywhere
        $main = new Main();

        switch ($awser) {
            case "1":
                echo "\033\143"; //clear the screen
                $main->startGame($main, $display);
                break;
            case "2":
                $openSave = new Save();
                $openSave->openSave($main, $display);
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
