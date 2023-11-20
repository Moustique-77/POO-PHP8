<?php
include_once "userDAO.php";

class user
{
    private $nom;
    private $prenom;
    private $id;

    public function __construct($id, $nom, $prenom)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Exo 1</title>
</head>

<body>
    <h2>Ajouter un utilisateur</h2>
    <form action="user.php" method="post">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required>
        <input type="submit" value="Ajouter">
    </form>
    <h2>Afficher / Modifier / Supprimer</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db = new Database();
            $userDAO = new userDAO($db->getConnection());

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["modifier"])) {
                    $id = $_POST["modifier"];
                    $utilisateur = $userDAO->listerUtilisateurs();
                    if ($utilisateur) {
                        echo "<tr>";
                        echo "<form action='user.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . (isset($utilisateur["id"]) ? $utilisateur["id"] : "") . "'>";
                        echo "<td><input type='text' name='nom' value='" . (isset($utilisateur["nom"]) ? $utilisateur["nom"] : "") . "'></td>";
                        echo "<td><input type='text' name='prenom' value='" . (isset($utilisateur["prenom"]) ? $utilisateur["prenom"] : "") . "'></td>";
                        echo "<td><input type='submit' value='Valider'></td>";
                        echo "</form>";
                        echo "<td><form action='user.php' method='post'><input type='hidden' name='supprimer' value='" . (isset($utilisateur["id"]) ? $utilisateur["id"] : "") . "'><input type='submit' value='Supprimer'></form></td>";
                        echo "</tr>";
                    }
                } elseif (isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"])) {
                    $id = $_POST["id"];
                    $nom = $_POST["nom"];
                    $prenom = $_POST["prenom"];
                    $user = new user($id, $nom, $prenom);
                    $userDAO->modifierUtilisateur($user);
                } elseif (isset($_POST["supprimer"])) {
                    $id = $_POST["supprimer"];
                    $userDAO->supprimerUtilisateur(new user($id, '', ''));
                }
            }

            $utilisateurs = $userDAO->listerUtilisateurs();

            if ($utilisateurs) {
                foreach ($utilisateurs as $utilisateur) {
                    echo "<tr>";
                    echo "<td>" . $utilisateur["nom"] . "</td>";
                    echo "<td>" . $utilisateur["prenom"] . "</td>";
                    echo "<td><form action='user.php' method='post'><input type='hidden' name='modifier' value='" . $utilisateur["id"] . "'><input type='submit' value='Modifier'></form></td>";
                    echo "<td><form action='user.php' method='post'><input type='hidden' name='supprimer' value='" . $utilisateur["id"] . "'><input type='submit' value='Supprimer'></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucun utilisateur</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>