<?php
//Jeu de Trivia de Films et de Séries TV
//Description : Développez un jeu de trivia (questions-réponses) sur des films et des séries TV en utilisant la POO en PHP.

//Fonctionnalités :

//Créez une classe Question pour stocker des questions de trivia avec des propriétés telles que le texte de la question, les options de réponse et la réponse correcte.

//Concevez une classe Jeu pour gérer le jeu de trivia, les scores des joueurs et les questions.

//Utilisez une interface utilisateur pour afficher les questions et permettre aux joueurs de sélectionner leurs réponses.

//Gérez plusieurs joueurs et enregistrez leurs scores.

//Implémentez un système de minuterie pour limiter le temps de réponse à chaque question.

//Concevez un tableau de classement pour afficher les meilleurs scores des joueurs.

//Ajoutez des questions de trivia sur des films, des séries TV, des acteurs célèbres, des répliques emblématiques, etc.


/**
 * Class representing a question in a trivia game.
 */
class Question
{
    /**
     * The question text.
     *
     * @var string
     */
    private $text;

    /**
     * The possible answers.
     *
     * @var array
     */
    private $answers = [];

    /**
     * The index of the correct answer.
     *
     * @var int
     */
    private $correctAnswer;

    /**
     * Question constructor.
     *
     * @param string $text
     * @param array $answers
     * @param int $correctAnswer
     */
    public function __construct(string $text, array $answers, int $correctAnswer)
    {
        $this->text = $text;
        $this->answers = $answers;
        $this->correctAnswer = $correctAnswer;
    }

    /**
     * Returns the question text.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Returns the possible answers.
     *
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * Returns the index of the correct answer.
     *
     * @return int
     */
    public function getCorrectAnswer(): int
    {
        return $this->correctAnswer;
    }
}

/**
 * Class representing a trivia game.
 */
class Player
{
    /**
     * The players in the game.
     *
     * @var array
     */
    private $playerName;

    /**
     * Score.
     *
     * @var int
     */
    private $playerScore = 0;

    /**
     * Game constructor.
     *
     * @param array $questions
     * @param array $players
     */
    public function __construct($playerName)
    {
        $this->playerName = $playerName;
    }

    /**
     * Returns the current player.
     *
     * @return string
     */
    public function getName()
    {
        return $this->playerName;
    }

    /**
     * Returns the number of correct answers.
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->playerScore;
    }

    public function incrementScore(): void
    {
        $this->playerScore++;
    }
}

/**
 * Interface representing a game display.
 */
interface GameDisplay
{
    /**
     * Displays the question.
     *
     * @param Question $question
     */
    public function displayQuestion(Question $question): void;

    /**
     * Displays the possible answers.
     *
     * @param array $answers
     */
    public function displayAnswers(array $answers): void;

    /**
     * Displays the correct answer.
     *
     * @param int $answer
     */
    public function displayCorrectAnswer(string $correctAnswer): void;

    /**
     * Displays the current player.
     *
     * @param string $player
     */
    public function displayPlayer(string $player): void;

    /**
     * Displays the current score.
     *
     * @param int $score
     */
    public function displayScore(int $score): void;

    /**
     * Displays the game over message.
     */
    public function displayGameOver(): void;
}

/**
 * Class representing a trivia game.
 */
class Game
{
    /**
     * The questions in the game.
     *
     * @var array
     */
    private $questions;

    /**
     * The players in the game.
     *
     * @var array
     */
    private $players;

    /**
     * The game display.
     *
     * @var GameDisplay
     */
    private $display;

    /**
     * Game constructor.
     *
     * @param array $questions
     * @param array $players
     * @param GameDisplay $display
     */
    public function __construct(array $questions, array $players, GameDisplay $display)
    {
        $this->questions = $questions;
        $this->players = $players;
        $this->display = $display;
    }

    /**
     * Starts the game.
     */
    public function start(): void
    {
        foreach ($this->players as $player) {
            $this->display->displayPlayer($player->getName());
            $this->display->displayScore($player->getScore());

            foreach ($this->questions as $question) {
                $this->display->displayQuestion($question);
                $this->display->displayAnswers($question->getAnswers());

                echo 'Your answer (you have 10 seconds):';
                $answer = $this->getAnswerWithTimeout(10);

                if ($answer !== null) {
                    if ($answer == $question->getCorrectAnswer()) {
                        $player->incrementScore();
                        $this->display->displayCorrectAnswer('Correct!' . PHP_EOL);
                    } else {
                        $this->display->displayCorrectAnswer('Incorrect!' . PHP_EOL);
                    }
                } else {
                    $this->display->displayCorrectAnswer(PHP_EOL . "Time's up ! Moving to the next question." . PHP_EOL);
                }
            }
        }

        //Display the final score for each player
        foreach ($this->players as $player) {
            $this->display->displayPlayer($player->getName());
            $this->display->displayScore($player->getScore());
        }

        $this->display->displayGameOver();
    }

    private function getAnswerWithTimeout(int $seconds): ?string
    {
        $read = [STDIN];
        $write = $except = null;
        $result = stream_select($read, $write, $except, $seconds);

        if ($result === false) {
            throw new Exception('stream_select failed');
        }

        if ($result === 0) {
            return null;  // timeout has occurred
        }

        return trim(fgets(STDIN));
    }
}

/**
 * Class representing a game display.
 */
class ConsoleGameDisplay implements GameDisplay
{
    /**
     * Displays the question.
     *
     * @param Question $question
     */
    public function displayQuestion(Question $question): void
    {
        echo $question->getText() . PHP_EOL;
    }

    /**
     * Displays the possible answers.
     *
     * @param array $answers
     */
    public function displayAnswers(array $answers): void
    {
        foreach ($answers as $key => $answer) {
            echo $key . '. ' . $answer . PHP_EOL;
        }
    }

    /**
     * Displays the correct answer.
     *
     * @param int $answer
     */
    public function displayCorrectAnswer(string $correctAnswer): void
    {
        echo $correctAnswer . PHP_EOL;
    }

    /**
     * Displays the current player.
     *
     * @param string $player
     */
    public function displayPlayer(string $player): void
    {
        echo $player . PHP_EOL;
    }

    /**
     * Displays the current score.
     *
     * @param int $score
     */
    public function displayScore(int $score): void
    {
        echo ("Score : " . $score . PHP_EOL);
    }

    /**
     * Displays the game over message.
     */
    public function displayGameOver(): void
    {
        echo PHP_EOL . 'Game over!' . PHP_EOL;
    }
}

$player1 = new Player('Player 1');
$player2 = new Player('Player 2');

$player = [$player1, $player2];

$question1 = new Question('What is the capital of France?', ['1' => 'Paris', '2' => 'London', '3' => 'Rome'], 1);
$question2 = new Question('Who is the creator of PHP?', ['1' => 'Rasmus Lerdorf', '2' => 'Bill Gates', '3' => 'Steve Jobs'], 1);
$question3 = new Question('What is the result of 2+2?', ['1' => '4', '2' => '5', '3' => '6'], 1);

$questions = [$question1, $question2, $question3];

$game = new Game($questions, [$player1, $player2], new ConsoleGameDisplay());

$game->start();
