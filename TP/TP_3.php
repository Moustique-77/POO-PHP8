<?php
//Onepiece
//TP : Gestion des Quêtes de Pirates de "One Piece" et Mini-Jeu de Chasse au Trésor Partie 1 : 

//Création de la classe Quest

//Créez une classe Quest qui représente une quête de pirate. La classe doit avoir les propriétés suivantes :

//id (identifiant unique de la quête)
//title (titre de la quête)
//description (description de la quête)
//completed (indicateur si la quête est terminée ou non)


//Partie 2 : Création de la classe PirateQuestManager

//Créez une classe PirateQuestManager qui permet de gérer une liste de quêtes de pirates.
//La classe PirateQuestManager doit inclure les fonctionnalités suivantes :

//Ajouter une quête à la liste.
//Supprimer une quête de la liste en fonction de son identifiant.
//Marquer une quête comme terminée en fonction de son identifiant.
//Afficher la liste des quêtes, en montrant si chaque quête est terminée ou non.


//Parie 3 : Mini-Jeu de Chasse au Trésor

//Utilisez les classes Quest et PirateQuestManager pour créer un mini-jeu de chasse au trésor basé sur "One Piece".

//Le jeu consiste en une série de quêtes dans l'univers de "One Piece" qui forment une histoire.

//Le joueur doit résoudre des énigmes, prendre des décisions et interagir avec les quêtes pour progresser dans l'histoire.
//L'objectif du joueur est de trouver le trésor légendaire en accomplissant toutes les quêtes.

//Sauvegarde Obligatoire avec Message : Implémentez une fonctionnalité de sauvegarde automatique du jeu à des points clés de l'histoire
//Lorsqu'une sauvegarde est effectuée, affichez un message au joueur pour l'informer de la sauvegarde réussie.

/**
 * Represent a quest of a pirate
 */
class Quest
{
    /**
     * Represent the id of the quest
     * 
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $completed = false;

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param bool $completed
     */
    public function __construct(int $id, string $title, string $description, bool $completed)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }
}

/**
 * Manage a list of pirate quests
 */
class PirateQuestManager
{
    /**
     * @var Quest[]
     */
    private $quests = [];

    private $endQuests = [];

    /**
     * Add a quest to the quests list
     * 
     * @param Quest $quest
     */
    public function addQuest(Quest $quest): void
    {
        $this->quests[] = $quest;
    }

    /**
     * Remove a quest from the quests list
     * 
     * @param int $id
     */
    public function removeQuest(int $id): void
    {
        foreach ($this->quests as $key => $quest) {
            if ($quest->getId() === $id) {
                unset($this->quests[$key]);
            }
        }
    }

    /**
     * Mark a quest as completed
     * 
     * @param int $id
     */
    public function markQuestAsCompleted(int $id): void
    {
        foreach ($this->quests as $quest) {
            if ($quest->getId() === $id) {
                $quest->setCompleted(true);
                array_push($this->endQuests, $quest);
                $this->removeQuest($id);
            }
        }
    }

    /**
     * Display all quests
     */
    public function displayAllQuests(): void
    {
        foreach ($this->quests as $quest) {
            echo PHP_EOL . 'List of current quests : ' . PHP_EOL;
            echo $quest->getTitle() . ' : ' . $quest->getDescription() . ' : ' . $quest->isCompleted() . '<br>';
        }
        foreach ($this->endQuests as $endQuest) {
            echo PHP_EOL . 'List of end quests : ' . PHP_EOL;
            echo $endQuest->getTitle() . ' : ' . $endQuest->getDescription() . ' : ' . $endQuest->isCompleted() . '<br>';
        }
    }
}

class TreasureHuntGame
{
    private $quests;
    private $questsList;
    private $currentQuestIndex;
    private $progress;

    public function __construct()
    {
        $this->quests = [
            new Quest(1, "Capitaine", "Je suis le capitaine du navire 'Le Chapeau de Paille'. Qui suis-je?", false),
            new Quest(2, "Épéiste", "Je suis connu pour être le meilleur épéiste du monde. Qui suis-je?", false),
            new Quest(3, "ÉNavigatrice", "Je suis une navigatrice qui rêve de dessiner une carte du monde entier. Qui suis-je?", false),
            new Quest(4, "Cuisinier", "Je suis un cuisinier qui se bat principalement avec mes jambes. Qui suis-je?", false),
            new Quest(5, "Homme-poisson", "J'ai mangé le fruit de l'homme-poisson et je suis un tireur d'élite. Qui suis-je?", false),
            new Quest(6, "Cyborg", "Je suis un cyborg connu sous le nom de 'Franky le Cyborg'. Qui suis-je?", false),
        ];
        $this->questsList = new PirateQuestManager();
        $this->currentQuestIndex = 0;
        $this->progress = [];
    }

    public function welcome()
    {
        echo "\033\143"; //clear the screen
        echo "Bienvenue dans le mini-jeu de chasse au trésor de One Piece!\n";

        echo "Voulez-vous commencer une nouvelle partie ou charger une partie existante?\n";
        echo "1. Nouvelle partie\n";
        echo "2. Charger une partie\n";
        $answer = readline("Votre réponse: ");

        if ($answer == "1") {
            $this->startGame();
        } else {
            $this->loadGame();
        }
    }

    public function startGame()
    {
        echo "\033\143"; //clear the screen
        echo "Vous êtes un pirate qui cherche le trésor légendaire de One Piece.\n";
        echo "Voici la liste des quêtes possibles, choississez-en au minimum 2 pour commencer votre aventure !\n";

        //Display all quests available
        foreach ($this->quests as $quest) {
            echo $quest->getId() . ". " . $quest->getTitle() . "\n";
        }

        $answer = readline("Entrez les numéros des quêtes séparés par une virgule: ");

        //Convert the answer into an array
        $answer = explode(",", $answer);

        //Remove spaces
        $answer = array_map('trim', $answer);

        //Remove duplicates
        $answer = array_unique($answer);

        //Remove empty values
        $answer = array_filter($answer);

        //Check if the answer is valid
        if (count($answer) < 2) {
            echo "Vous devez choisir au minimum 2 quêtes!\n";
            $this->startGame();
        } else {
            //Check if the answer is valid
            foreach ($answer as $value) {
                if (!is_numeric($value) || $value < 1 || $value > count($this->quests)) {
                    echo "Vous devez choisir des numéros de quêtes valides!\n";
                    $this->startGame();
                }
            }

            //Add the quests to the quests list
            foreach ($answer as $value) {
                $this->questsList->addQuest($this->quests[$value - 1]);
            }

            //Start the game
            while ($this->questsList < count($this->quests)) {
                $this->askQuestion();
            }
            echo "Félicitations! Vous avez trouvé le trésor légendaire!";
        }
    }

    private function askQuestion()
    {
        $quest = $this->quests[$this->currentQuestIndex];
        echo $quest->getDescription() . "\n";
        $answer = readline("Votre réponse: ");

        switch ($this->currentQuestIndex) {
            case 0:
                if (strtolower($answer) == "luffy") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
            case 1:
                if (strtolower($answer) == "zoro") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
            case 2:
                if (strtolower($answer) == "nami") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
            case 3:
                if (strtolower($answer) == "sanji") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
            case 4:
                if (strtolower($answer) == "usopp") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
            case 5:
                if (strtolower($answer) == "franky") {
                    $this->progressQuest();
                } else {
                    $this->wrongAnswer();
                }
                break;
        }
    }

    public function loadGame()
    {
        $this->progress = [0, 1, 2, 3, 4, 5];
        $this->currentQuestIndex = count($this->progress);
        $this->startGame();
    }

    private function progressQuest()
    {
        echo "Bonne réponse!\n";
        $this->quests[$this->currentQuestIndex]->setCompleted(true);
        $this->currentQuestIndex++;
        if ($this->currentQuestIndex % 2 == 0) {
            $this->saveGame();
        }
    }

    private function wrongAnswer()
    {
        echo "Mauvaise réponse, essayez à nouveau!\n";
    }

    private function saveGame()
    {
        $this->progress[] = $this->currentQuestIndex;
        echo "Sauvegarde du jeu effectuée!\n";
    }
}

$game = new TreasureHuntGame();
$game->welcome();
