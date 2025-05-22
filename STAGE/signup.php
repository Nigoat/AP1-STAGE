<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];
    $verif_password = $_POST['verif-password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $datedenaissance = $_POST['datedenaissance'];
    $sexe = $_POST['radio-sexe'];
    $anneeBac = $_POST['anneeBac'];
    $tel = $_POST['tel'];
	$types = $_POST['radio-types'];
    
    include '_conf.php';

    // Connexion à la base de données
    $connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);

    if (!$connexion) {
        die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
    }

    // Sécuriser les données
    $login = mysqli_real_escape_string($connexion, $login);
    $email = mysqli_real_escape_string($connexion, $email);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); 
    $datedenaissance = mysqli_real_escape_string($connexion, $datedenaissance);
    $sexe = mysqli_real_escape_string($connexion, $sexe);
    $anneeBac = mysqli_real_escape_string($connexion, $anneeBac);
	$tel = mysqli_real_escape_string($connexion, $tel);
	$types = mysqli_real_escape_string($connexion, $types);
	
	
    // Insérer l'utilisateur dans la base de données
    $requete = "INSERT INTO adherent ( nom, prenom, email, login, password, dateNaissance, Sexe, Annee_Bac, telephone, types) 
				VALUES ('$nom', '$prenom', '$email','$login', '$passwordHash','$datedenaissance', '$sexe', '$anneeBac', '$tel', '$types')";

	
   if (mysqli_query($connexion, $requete)) {
    echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; margin-top: 20px;">';
    echo "Inscription réussie ! Vous pouvez vous connecter.";
    echo '</div>';
} else {
    echo '<div style="text-align: center; font-family: Arial, sans-serif; font-size: 18px; margin-top: 20px; color: red;">';
    echo "Erreur dans la connexion : " . mysqli_error($connexion);
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
<a href="logout.php"> <button class="submit-button" type="submit" name="logout"> Se connecter </button> </a>
</div>
</html>