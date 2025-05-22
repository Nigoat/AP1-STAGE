<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

// Inclure les informations de connexion à la base de données
include '_conf.php';

// Connexion à la base de données
$connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);
if (!$connexion) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

// Récupérer les informations de l'utilisateur connecté
$login = $_SESSION['login'];
$sql = "SELECT * FROM adherent WHERE login = '$login'";
$result = mysqli_query($connexion, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Aucune information trouvée pour cet utilisateur.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Suivi des Stages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Suivi des Stages</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
					<?php if ($user['types']== "Professeur"): ?>
						<li class="nav-item"><a href="crprofesseur.php" class="nav-link">Sélection du compte rendu</a></li>
					<?php endif; ?>
					<?php if ($user['types']== "Etudiant"): ?>
						<li class="nav-item"><a class="nav-link" href="ListeCR.php">Liste de mes Comptes Rendus</a></li>
					<?php endif; ?>
					<?php if ($user['types']== "Etudiant"): ?>
						<li class="nav-item"><a class="nav-link" href="CompteRenduM.php">Créer/Modifier mes Comptes Rendus</a></li>
					<?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Mon Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Se Déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <!-- Message d'accueil personnalisé -->
        <div class="alert alert-success mt-4" role="alert">
            <h4 class="alert-heading">Bienvenue, <?= htmlspecialchars($user['prenom']); ?> !</h4>
            <p>Vous êtes connecté à votre espace personnel. Utilisez le menu ci-dessus pour gérer vos comptes rendus ou consulter vos informations.</p>
        </div>

        <!-- Affichage des informations utilisateur -->
        <div class="card shadow my-4">
            <div class="card-body">
                <?php if (!empty($user['types'])): ?>
                    <p class="text-center fw-bold fs-2 text-danger mb-3">PARTIE <?= htmlspecialchars($user['types']); ?></p>
                <?php endif; ?>
                <h2 class="mb-4 text-center">Bienvenue dans votre espace de suivi, <?= htmlspecialchars($user['login']); ?> !</h2>
                <h5 class="logo-title text-center mb-3">Vos informations</h5>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><strong>Login :</strong> <?= htmlspecialchars($user['login']); ?></li>
                    <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user['nom']); ?></li>
                    <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']); ?></li>
                    <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></li>
                    <li class="list-group-item"><strong>Date de naissance :</strong> <?= htmlspecialchars($user['dateNaissance']); ?></li>
                    <li class="list-group-item"><strong>Sexe :</strong> <?= htmlspecialchars($user['Sexe']); ?></li>
                    <li class="list-group-item"><strong>Année du bac :</strong> <?= htmlspecialchars($user['Annee_Bac']); ?></li>
                    <li class="list-group-item">
                        <strong>Téléphone :</strong>
                        <?= !empty($user['telephone']) ? htmlspecialchars($user['telephone']) : 'non renseigné'; ?>
                    </li>
                </ul>
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <?php if ($user['types'] == "Etudiant"): ?>
                        <a href="CompteRenduM.php" class="btn btn-primary">Création de compte rendu</a>
                    <?php else: ?>
                        <a href="crprofesseur.php" class="btn btn-primary">Sélection du compte rendu</a>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>