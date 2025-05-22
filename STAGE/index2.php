<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="signup.css">
    <title>Inscription | SUIVI DES STAGES</title>
</head>
<body>
    <div class="main">
        <h1 class="logo-title">Inscription</h1>
        <div class="card">
            <p>Créer votre compte</p>
            <form action="signup.php" method="post">
                <div class="login-input input">
                    <label for="login">Login</label>
                    <input class="input-text" type="text" name="login" required>
                </div>
                <div class="password input">
                    <label for="password">Password</label>
                    <input class="input-text" type="password" name="password" required>
                </div>
                <div class="verif-password input">
                    <label for="verif-password">Répéter le mot de passe</label>
                    <input class="input-text" type="password" name="verif-password" required>
                </div>
                <div class="nom input">
                    <label for="nom">Nom</label>
                    <input class="input-text" type="text" name="nom" required>
                </div>
                <div class="prenom input">
                    <label for="prenom">Prénom</label>
                    <input class="input-text" type="text" name="prenom" required>
                </div>
                <div class="email input">
                    <label for="email">Email</label>
                    <input class="input-text" type="text" name="email" required>
                </div>
                <div class="datedenaissance input">
                    <label for="datedenaissance">Date de naissance</label>
                    <input class="input-text" type="date" name="datedenaissance" required id="dateInput">   
                </div>
                <div class="sexe input">
                    <label for="sexe-homme">Sexe</label>
                    <div class="all-radios">
                        <div class="sexe-homme radio">
                            <label for="Homme">Homme</label>
                            <input class="input-radio" type="radio" value="Homme" name="radio-sexe" required>
                        </div>
                        <div class="sexe-femme radio">
                            <label for="Femme">Femme</label>
                            <input class="input-radio" type="radio" value="Femme" name="radio-sexe" required>
                        </div>
                    </div>
                </div>
				
				<div class="tel input">
                    <label for="telephone">Telephone</label>
                    <input class="input-text" type="text" name="tel" >
                </div>
								
                <div class="anneeBac select">
                    <label for="anneeBac">Année du bac</label>
                    <select name="anneeBac" class="anneeBac year" required>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
						<option value="2018">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                        <option value="2010">2010</option>
                        <option value="2009">2009</option>
                        <option value="2008">2008</option>
                        <option value="2007">2007</option>
                        <option value="2006">2006</option>
                        <option value="2005">2005</option>
                        <option value="2004">2004</option>
                        <option value="2003">2003</option>
                        <option value="2002">2002</option>
                        <option value="2001">2001</option>
                        <option value="2000">2000</option>
                    </select>
                </div>
				<div class="type input">
                    <label for="Etudiant">Statut</label>
                    <div class="all-radios">
                        <div class="sexe-homme radio">
                            <label for="Etudiant">Etudiant</label>
                            <input class="input-radio" type="radio" value="Etudiant" name="radio-types" required>
                        </div>
                        <div class="sexe-femme radio">
                            <label for="Professeur">Professeur</label>
                            <input class="input-radio" type="radio" value="Professeur" name="radio-types" required>
                        </div>
                    </div>
                </div>
                                <input class="submit-button" type="submit" name="submit" value="S'inscrire">
            </form>
        </div>
        <div class="login">
            <p>Déjà inscrit ? <a href="login.php">Se connectez</a></p>
        </div>
        <div class="ref">
            <a href="">© SUIVI DES STAGES</a>
            <a href="">Contact</a>
            <a href="">Privacy & terms</a>
        </div>
    </div>
    <script>
    const today = new Date().toISOString().split('T')[0];
    
    document.getElementById('dateInput').setAttribute('max', today);
</script>
</body>
</html>