<?php
session_start();
include '_conf.php';

// Connexion à la base de donnée
$connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);
if (!$connexion) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

// Récupérer les informations de l'utilisateur connecté
$login = $_SESSION['login'];
$sql = "SELECT * FROM adherent WHERE login = '$login'";
$resultat = mysqli_query($connexion, $sql);
$user = mysqli_fetch_assoc($resultat);

$success = false;
if (isset($_POST['update'])) {
    $newLogin = mysqli_real_escape_string($connexion, $_POST['login']);
    $newNom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $newPrenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $newEmail = mysqli_real_escape_string($connexion, $_POST['email']);

    $updateSQL = "UPDATE adherent SET 
                    login = '$newLogin',
                    nom = '$newNom',
                    prenom = '$newPrenom',
                    email = '$newEmail'
                  WHERE login = '$login'";

    if (mysqli_query($connexion, $updateSQL)) {
        $_SESSION['login'] = $newLogin; // Si login change
        $success = true;
        // Rafraîchir les données utilisateur
        $sql = "SELECT * FROM adherent WHERE login = '$newLogin'";
        $resultat = mysqli_query($connexion, $sql);
        $user = mysqli_fetch_assoc($resultat);
    } else {
        $error = "Erreur lors de la mise à jour : " . mysqli_error($connexion);
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="global.css">
<div class="container mt-5" style="max-width: 450px;">
    <h1 class="text-center mb-4 logo-title">Vos informations</h1>

    <div class="card shadow">
        <div class="card-body">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">Mise à jour réussie !</div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger" role="alert"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="login" class="form-label">Login :</label>
                    <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catégorie :</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['types']) ?>" readonly>
                </div>
                <button type="submit" name="update" class="btn btn-primary w-100">Mettre à jour</button>
            </form>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Revenir à l'accueil</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>