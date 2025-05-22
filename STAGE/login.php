<?php
session_start();

// Inclure la configuration de la base de données
include '_conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

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
        // Utilisateur trouvé, vérifier le mot de passe
        $user = mysqli_fetch_assoc($resultat);

        if (password_verify($password, $user['password'])) {
            // Si le mot de passe est correct, vérifier si un changement est nécessaire
            if ($user['TempMDP'] == 1) {
                // Si TempMDP est égal à 1, rediriger vers la réinitialisation
                $_SESSION['login'] = $user['login']; // On enregistre le login dans la session
                header('Location: reinitialiser_mdp2.php'); // Redirection vers la page de réinitialisation
                exit();
            } else {
                // Sinon, l'utilisateur est connecté normalement
                $_SESSION['login'] = $user['login']; // On enregistre le login dans la session
                header('Location: index.php'); // Redirection vers la page d'accueil
                exit();
            }
        } else {
            // Si le mot de passe est incorrect
            echo '<div style="color: red;">Mot de passe incorrect.</div>';
        }
    } else {
        // Si l'utilisateur n'est pas trouvé
        echo '<div style="color: red;">Utilisateur introuvable.</div>';
    }

    // Fermer la connexion à la base de données
    mysqli_close($connexion);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="signin.css">
    <title>Connexion | SUIVI DES STAGES</title>
</head>
<body>
    <div class="main">
        <h1 class="logo-title"> SUIVI DES STAGES</h1>
        <div class="card">
            <p>Connectez-vous à votre compte</p>
            <form action="login.php" method="post">
                <div class="login-input input">
                    <label for="login">Login</label>
                    <input class="input-text" type="text" name="login" required>
                </div>
                <div class="password input">
                    <label for="password">Password</label>
                    <input class="input-text" type="password" name="password" required>
                </div>
                <input class="submit-button" type="submit" name="submit" value="Se connecter">
            </form>
        </div>
        <div class="signin">
            <p>Pas de compte ? <a href="index2.php">Inscrivez-vous</a></p>
            <p>Mot de passe oublié ? <a href="index3.html">Récupérez votre mot de passe ici</a></p>
        </div>
        <div class="ref">
            <a href="">© SUIVI DES STAGES</a>
            <a href="">Contact</a>
            <a href="">Privacy & terms</a>
        </div>
    </div>
</body>
</html>
