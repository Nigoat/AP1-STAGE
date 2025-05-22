<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

include '_conf.php';
$connexion = mysqli_connect($serveur, $user, $mdp, $nomBDD);

if (!$connexion) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

$login = mysqli_real_escape_string($connexion, $_SESSION['login']);

// Récupérer l'id de l'utilisateur connecté
$id_sql = "SELECT id FROM adherent WHERE login = '$login'";
$id_result = mysqli_query($connexion, $id_sql);

if ($id_result && mysqli_num_rows($id_result) > 0) {
    $row = mysqli_fetch_assoc($id_result);
    $id = $row['id'];
} else {
    die("Utilisateur inconnu !");
}

// Initialisation des variables
$date_selected = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$descriptif = "";
$message = "";

// Récupérer le compte rendu pour la date sélectionnée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'load') {
    $check_sql = "SELECT descriptif FROM compterendu WHERE id = '$id' AND date = '$date_selected'";
    $check_result = mysqli_query($connexion, $check_sql);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        $descriptif = $row['descriptif'];
    } else {
        $descriptif = "";
    }
}

// Enregistrer ou mettre à jour le compte rendu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $new_descriptif = mysqli_real_escape_string($connexion, $_POST['descriptif']);

    $check_sql = "SELECT * FROM compterendu WHERE id = '$id' AND date = '$date_selected'";
    $check_result = mysqli_query($connexion, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Modifier (UPDATE)
        $update_sql = "UPDATE compterendu SET descriptif = '$new_descriptif' WHERE id = '$id' AND date = '$date_selected'";
        if (mysqli_query($connexion, $update_sql)) {
            $message = "Compte rendu mis à jour avec succès.";
        } else {
            $message = "Erreur lors de la mise à jour : " . mysqli_error($connexion);
        }
    } else {
        // Insérer (INSERT)
        $insert_sql = "INSERT INTO compterendu (id, login, date, descriptif) VALUES ('$id', '$login', '$date_selected', '$new_descriptif')";
        if (mysqli_query($connexion, $insert_sql)) {
            $message = "Compte rendu ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout : " . mysqli_error($connexion);
        }
    }

    // Recharger le descriptif mis à jour
    $descriptif = $new_descriptif;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte Rendu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 pt-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Ajouter ou Modifier un Compte Rendu</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="card p-4 shadow-sm">
        <input type="hidden" name="action" id="action" value="load">

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date"
                   value="<?php echo htmlspecialchars($date_selected); ?>" required
                   onchange="document.getElementById('action').value='load'; this.form.submit();">
        </div>

        <div class="mb-3">
            <label for="descriptif" class="form-label">Descriptif</label>
            <textarea class="form-control" id="descriptif" name="descriptif" rows="5" required><?php echo htmlspecialchars($descriptif); ?></textarea>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary" onclick="document.getElementById('action').value='save';">Enregistrer</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">← Retour à l'accueil</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>