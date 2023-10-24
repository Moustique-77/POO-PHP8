<?php
//Gestionnaire de Collection de Films

//Description : Concevez une application de gestion de collection de films en utilisant la programmation orientée objet en PHP.

//Fonctionnalités :

//Créez une classe Film avec des propriétés telles que le titre, la date de sortie, le réalisateur, le genre, etc.
//Utilisez une classe abstraite Media pour gérer les médias (peut également inclure d'autres médias, comme des livres ou des séries TV).
//Implémentez des méthodes pour ajouter, supprimer et lister des films dans la collection.
//Ajoutez une fonction de recherche basée sur le titre, le réalisateur ou le genre.
//Utilisez une interface pour noter les films sur une échelle de 1 à 5 étoiles.

/**
 * Abstract class representing any form of media.
 */
abstract class Media
{
    //This property is protected so that it can be accessed by child classes
    protected string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}

/**
 * Interface for rating media.
 */
interface IRating
{
    public function setRating(int $rating): void;
}

/**
 * Class representing a film, extending the Media class.
 */
class Film extends Media implements IRating
{
    private string $releaseDate;
    private string $director;
    private string $genre;
    private int $rating = 0;

    public function __construct(string $title, string $releaseDate, string $director, string $genre)
    {
        parent::__construct($title);
        $this->releaseDate = $releaseDate;
        $this->director = $director;
        $this->genre = $genre;
    }

    public function setRating(int $rating): void
    {
        if ($rating >= 1 && $rating <= 5) {
            $this->rating = $rating;
        } else {
            throw new Exception("La note doit être en 1 et 5.");
        }
    }

    public function getInformations(): string
    {
        return "Titre: $this->title, Date de sortie: $this->releaseDate, Réalisateur: $this->director, Genre: $this->genre, Note: $this->rating étoiles";
    }
}

/**
 * Class representing a collection of films.
 */
class CollectionFilms
{
    public array $films = [];

    public function ajouterFilm(Film $film): void
    {
        $this->films[] = $film;
    }

    public function supprimerFilm(Film $film): void
    {
        $index = array_search($film, $this->films);
        if ($index !== false) {
            unset($this->films[$index]);
        }
    }

    public function listerFilms(): array
    {
        return $this->films;
    }

    public function rechercher(string $criteria, string $value): array
    {
        $found = [];
        foreach ($this->films as $film) {
            if (strtolower($film->$criteria) === strtolower($value)) {
                $found[] = $film;
            }
        }
        return $found;
    }

    public function rechercheAvecFiltre(callable $filtre)
    {
        $result = [];
        foreach ($this->films as $film) {
            if ($filtre($film)) {
                $result[] = $film;
            }
        }
        return $result;
    }
}

/**
 * Class for managing collections of films.
 */
class GestionCollection
{
    private array $collections = [];

    public function creerCollection(string $nom): void
    {
        $this->collections[$nom] = new CollectionFilms();
    }

    public function supprimerCollection(string $nom): void
    {
        unset($this->collections[$nom]);
    }

    public function ajouterFilmACollection(string $nom, Film $film): void
    {
        if (isset($this->collections[$nom])) {
            $this->collections[$nom]->ajouterFilm($film);
        } else {
            throw new Exception("La collection $nom n'existe pas.");
        }
    }

    public function supprimerFilmDeCollection(string $nom, Film $film): void
    {
        if (isset($this->collections[$nom])) {
            $this->collections[$nom]->supprimerFilm($film);
        } else {
            throw new Exception("La collection $nom n'existe pas.");
        }
    }

    public function getCollection(string $nom): ?CollectionFilms
    {
        return $this->collections[$nom] ?? null;
    }

    public function listerCollections(): array
    {
        return array_keys($this->collections);
    }
}

/**
 * CLI menu class for interacting with the film collection system.
 */
class Main
{
    private GestionCollection $gestion;
    private CollectionFilms $collection;

    public function __construct()
    {
        $this->gestion = new GestionCollection();
    }

    public function afficherMenu()
    {
        echo "\nApplication de gestion de Films\n";
        echo "--------------------------------------\n";
        echo "1. Créer une nouvelle collection de films\n";
        echo "2. Rechercher un film\n";
        echo "3. Ajouter un film à une collection\n";
        echo "4. Supprimer un film d'une collection\n";
        echo "5. Affihcher la liste des films dans une collection\n";
        echo "6. Afficher la liste des collections\n";
        echo "7. Supprimer une collection\n";
        echo "8. Quitter\n";
        echo "Choissir une options : ";
        $choice = trim(fgets(STDIN));
        $this->traiterChoix($choice);
    }

    /**
     * This method is not part of the menu, but is used to process the user's choice
     */
    private function traiterChoix($choice)
    {
        switch ($choice) {
            case '1':
                $this->creerCollection();
                break;
            case '2':
                $this->rechercherFilm();
                break;
            case '3':
                $this->ajouterFilmACollection();
                break;
            case '4':
                $this->supprimerFilmDeCollection();
                break;
            case '5':
                $this->listerFilmsDansCollection();
                break;
            case '6':
                $this->listerCollections();
                break;
            case '7':
                $this->supprimerCollection();
                break;
            case '8':
                echo "Au revoir !\n";
                exit;
            default:
                echo "Merci de choisir une autre option !\n";
        }
        $this->afficherMenu();
    }

    /**
     * This method is not part of the menu, but is used to create a new collection
     */
    private function creerCollection()
    {
        echo "Nom de la nouvelle collection: ";
        $nom = trim(fgets(STDIN));
        $this->gestion->creerCollection($nom);
        echo "Collection créée avec succès!\n";
    }

    /**
     * This method is not part of the menu, but is used to add a film to a collection
     */
    private function ajouterFilmACollection()
    {
        echo "Nom de la collection: ";
        $nom = trim(fgets(STDIN));
        $collection = $this->gestion->getCollection($nom);
        if (!$collection) {
            echo "Cette collection n'existe pas.\n";
            return;
        }

        $film = $this->saisirFilm();
        $this->gestion->ajouterFilmACollection($nom, $film);
        echo "Film ajouté à la collection!\n";
    }

    /**
     * This method is not part of the menu, but is used to search for a film in a collection
     */
    private function rechercherFilm()
    {
        echo "Rechercher par titre, réalisateur ou genre ? ";
        $critere = trim(fgets(STDIN));
        echo "Entrez votre recherche : ";
        $recherche = trim(fgets(STDIN));

        $result = $this->collection->rechercheAvecFiltre(function ($film) use ($critere, $recherche) {
            switch ($critere) {
                case 'titre':
                    return strtolower($film->titre) === strtolower($recherche);
                case 'realisateur':
                    return strtolower($film->realisateur) === strtolower($recherche);
                case 'genre':
                    return strtolower($film->genre) === strtolower($recherche);
                default:
                    return false;
            }
        });
    }

    /**
     * This method is not part of the menu, but is used to delete a film from a collection
     */
    private function supprimerFilmDeCollection()
    {
        echo "Nom de la collection: ";
        $nom = trim(fgets(STDIN));
        $collection = $this->gestion->getCollection($nom);
        if (!$collection) {
            echo "Cette collection n'existe pas.\n";
            return;
        }

        echo "Titre du film à supprimer: ";
        $titreFilm = trim(fgets(STDIN));

        $films = $collection->rechercher('titre', $titreFilm);
        if (!empty($films)) {
            $this->gestion->supprimerFilmDeCollection($nom, $films[0]);
            echo "Film supprimé de la collection!\n";
        } else {
            echo "Film non trouvé dans la collection.\n";
        }
    }

    /**
     * This method is not part of the menu, but is used to list all collections
     */
    private function listerCollections()
    {
        echo "\nListe des collections:\n\n";
        $collections = $this->gestion->listerCollections();
        foreach ($collections as $collection) {
            echo "$collection\n";
        }
    }

    /**
     * This method is not part of the menu, but is used to list all films in a collection
     */
    private function listerFilmsDansCollection()
    {
        echo "Nom de la collection: ";
        $nom = trim(fgets(STDIN));
        $collection = $this->gestion->getCollection($nom);
        if (!$collection) {
            echo "Cette collection n'existe pas.\n";
            return;
        }

        $films = $collection->listerFilms();
        if (empty($films)) {
            echo "Aucun film dans cette collection.\n";
            return;
        }

        foreach ($films as $film) {
            echo $film->getInformations() . "\n";
        }
    }

    /**
     * This method is not part of the menu, but is used to delete a collection
     */
    private function supprimerCollection()
    {
        echo "Nom de la collection à supprimer: ";
        $nom = trim(fgets(STDIN));
        $this->gestion->supprimerCollection($nom);
        echo "Collection supprimée avec succès!\n";
    }

    /**
     * This method is not part of the menu, but is used to create a film object from user input
     */
    private function saisirFilm(): Film
    {
        echo "Titre du film : ";
        $titre = trim(fgets(STDIN));
        echo "Date de sortie (YYYY-MM-DD) : ";
        $dateSortie = trim(fgets(STDIN));
        echo "Réalisateur : ";
        $realisateur = trim(fgets(STDIN));
        echo "Genre : ";
        $genre = trim(fgets(STDIN));

        return new Film($titre, $dateSortie, $realisateur, $genre);
    }
}

// Execution of the menu
$menu = new Main();
$menu->afficherMenu();
