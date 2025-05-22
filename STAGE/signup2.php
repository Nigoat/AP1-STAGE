<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les données envoyées par le formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login']; // Récupérer le login depuis le champ caché
    $password = $_POST['password'];
    $verif_password = $_POST['verif-password'];

    // Vérifier que les mots de passe correspondent
    if ($password !== $verif_password) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        // Inclure les informations de connexion à la base de données
        include '_conf.php';
        
        // Connexion à la base de données
        $connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);
        if (!$connexion) {
            die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
        }

        // Hacher le nouveau mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $requete = "UPDATE adherent2 SET password = '$passwordHash', TempMDP = 0 WHERE login = '$login'";

        if (mysqli_query($connexion, $requete)) {
            echo "Mot de passe modifié avec succès !";
            // Détruire la session après modification du mot de passe pour forcer la reconnexion
            session_destroy();
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($connexion);
        }

        // Fermer la connexion à la base
        mysqli_close($connexion);
    }
}
?>
