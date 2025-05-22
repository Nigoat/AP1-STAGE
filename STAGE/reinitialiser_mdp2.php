<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

include '_conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les nouveaux mots de passe
    $password = $_POST['password'];
    $verif_password = $_POST['verif-password'];
    $login = $_SESSION['login']; // Récupérer le login de la session

    // Vérifier si les mots de passe correspondent
    if ($password == $verif_password) {
        // Hasher le nouveau mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données
        $connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);
        if (!$connexion) {
            die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
        }

        // Mettre à jour le mot de passe et réinitialiser TempMDP
        $requete = "UPDATE adherent SET password = '$passwordHash', TempMDP = 0 WHERE login = '$login'";
        if (mysqli_query($connexion, $requete)) {
            echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; color: green;">';
            echo "Mot de passe modifié avec succès !";
            echo '</div>';
            header('Location: login.php'); // Redirection vers la page d'accueil après le changement
        } else {
            echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; color: red;">';
            echo "Erreur dans la modification du mot de passe.";
            echo '</div>';
        }

        // Fermer la connexion
        mysqli_close($connexion);
    } else {
        echo '<div style="color: red;">Les mots de passe ne correspondent pas.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="signup.css">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <div class="main">
        <h1 class="logo-title">Réinitialisation du mot de passe</h1>
        <div class="card">
            <p>Entrez votre nouveau mot de passe</p>
            <form action="reinitialiser_mdp2.php" method="post">
                <div class="password input">
                    <label for="password">Nouveau mot de passe</label>
                    <input class="input-text" type="password" name="password" required>
                </div>
                <div class="verif-password input">
                    <label for="verif-password">Répéter le mot de passe</label>
                    <input class="input-text" type="password" name="verif-password" required>
                </div>
                <input class="submit-button" type="submit" name="submit" value="Valider">
            </form>
        </div>
    </div>
</body>
</html>
