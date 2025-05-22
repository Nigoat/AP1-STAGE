<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    include '_conf.php';
    
    // Connexion à la base de données
    $conn = mysqli_connect($serveur, $user, $mdp, $nomBDD);
    
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }
    
    // Générer un mdpp provisoir
    $temporary_password = bin2hex(random_bytes(4)); // Génère un mot de passe de 8 caractères
    $hashed_password = password_hash($temporary_password, PASSWORD_DEFAULT);
    
    // Changement mddp dans la base de données
    $update_stmt = $conn->prepare("UPDATE adherent SET password = ?, TempMDP = 1 WHERE email = ?");
    $update_stmt->bind_param("ss", $hashed_password, $email);
    
    if ($update_stmt->execute() && $update_stmt->affected_rows > 0) {
        // Envoie d'e-mail avec mdp provisoir
        $to = $email;
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour,\n\nVotre nouveau mot de passe provisoire est : $temporary_password\n\nVeuillez le modifier dès que possible.";
        $header;
        
        mail($to, $subject, $message, $header);
        
        echo "Un e-mail contenant votre nouveau mot de passe a été envoyé.";
		echo "$email";
		echo "</br >";
		echo "$subject";
		echo "</br >";
		echo "$message";
		echo "</br >";
		echo "$header";
    } else {
        echo "Aucun compte trouvé avec cet e-mail ou erreur lors de la mise à jour.";
    }
    
    $update_stmt->close();
    $conn->close();
} else {
    echo "Accès non autorisé.";
}
?>
<html>
	<div>
		<a href="index.php" class="btn btn-secondary mt-3">← Retour à l'accueil</a>
	</div>
</html>