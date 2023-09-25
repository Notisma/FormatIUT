<?php
require_once 'Configuration.php';

// Cette ligne sert à se connecter à la base de données
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die('Erreur de connexion (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

echo 'Succès... ' . $mysqli->host_info . "\n";

$login = $_POST['login'];
$mdp = $_POST['mdp'];

$typeClient = "";



$requete = "SELECT * FROM `Etudiants` WHERE `loginEtudiant` = ? AND `mdpEtudiant` = ?";
if ($stmt = $mysqli->prepare($requete)) {
    $stmt->bind_param("ss", $login, $mdp); //
    if ($stmt->execute()) {
        $resultat = $stmt->get_result();
        if ($resultat->num_rows > 0) {
            $typeClient = "etudiant";
        }
    } else {
        echo 'Erreur de requête : ' . $stmt->error;
        sleep(2);
        header('Location: index.html');
        exit; // Assurez-vous de quitter le script après une redirection
    }
    $stmt->close();
}

if (empty($typeClient)) {
    $requete = "SELECT * FROM `Profs` WHERE `loginProf` = ? AND `mdpProf` = ?";
    if ($stmt = $mysqli->prepare($requete)) {
        $stmt->bind_param("ss", $login, $mdp);
        if ($stmt->execute()) {
            $resultat = $stmt->get_result();
            if ($resultat->num_rows > 0) {
                $typeClient = "prof";
            }
        } else {
            echo 'Erreur de requête : ' . $stmt->error;
            sleep(2);
            header('Location: index.html');
            exit;
        }
        $stmt->close();
    }
}

if (empty($typeClient)) {
    $requete = "SELECT * FROM `Admins` WHERE `loginAdmin` = ? AND `mdpAdmin` = ?";
    if ($stmt = $mysqli->prepare($requete)) {
        $stmt->bind_param("ss", $login, $mdp);
        if ($stmt->execute()) {
            $resultat = $stmt->get_result();
            if ($resultat->num_rows > 0) {
                $typeClient = "admin";
            }
        } else {
            echo 'Erreur de requête : ' . $stmt->error;
            sleep(2);
            header('Location: index.html');
            exit;
        }
        $stmt->close();
    }
}

$mysqli->close(); // N'oubliez pas de fermer la connexion à la base de données lorsque vous avez terminé.

echo "<br> <p>typeClient = $typeClient </p> <br>";
?>
