<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Inclure les informations de connexion à la base de données
    include '_conf.php';

    // Connexion à la base de données
    $connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);

    if (!$connexion) {
        die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
    }

    // Sécuriser le login
    $login = mysqli_real_escape_string($connexion, $login);

    // Rechercher l'utilisateur dans la base de données
    $requete = "SELECT * FROM adherent WHERE login = '$login'";
    $resultat = mysqli_query($connexion, $requete);

    if (mysqli_num_rows($resultat) == 1) {
        $user = mysqli_fetch_assoc($resultat);

        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['login'] = $user['login'];
            header('Location: reinitialiser_mdp2.php');
            exit();
        } else {
            echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; margin-top: 20px;">';
			echo "Mot de passe incorrect";
			echo '</div>';
        }
    } else {
		echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; margin-top: 20px;">';
        echo "Nom d'utilisateur introuvable.";
		echo '</div>';
    }

    // Fermer la connexion
    mysqli_close($connexion);
}
?>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="global.css">
<link rel="stylesheet" href="index.css">
<div class="signin">
<a href="logout.php"> <button class="submit-button" type="submit" name="logout"> Retour à la connexion </button> </a>
</div>
</html>