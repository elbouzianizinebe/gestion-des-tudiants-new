<?php 
require 'connexion.php';
require 'auth.php';

$erreur = '';
$nom = $prenom =$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nom = trim($_POST['nom'] ??'');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    if ($nom === '' || $prenom === '' || $email === '' || $mot_de_passe === '') {
        $erreur = "Tous les champs sont obligatoires.";}
    elseif (!filter_var($email , FILTER_VALIDATE_EMAIL)){
        $erreur = "email invalide.";
    }
    elseif(strlen($mot_de_passe)<6){
        $erreur ="le mot de passe doit contenir au moins 6 caractéres.";
    }
    else {
        try {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $connexion->prepare(
                "INSERT INTO etudiants (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$nom, $prenom, $email, $hash]);
            header('Location: listes_des_etudiants.php');
            exit;

        }
        catch (PDOException $e) {
            $erreur = ($e->getCode() == 23000) ? "Cet e-mail existe déjà." : "Erreur lors de l'ajout.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="formulaire.css">
    <title>Formulaire d'inscription</title>
</head>
<body>
<header>
    <h1>Formulaire</h1>
    <p>Welcome to the registration form</p>
    <nav>
        <a href="index.php">Accueil</a><br>
        <a href="formulaire.php">Formulaire</a><br>
        <a href="listes_des_etudiants.php">Liste des étudiants</a><br>
    </nav>

</header>
    <h2>Formulaire d'inscription: </h2>
    <?php if ($erreur): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>
    <form class="student-form" action="formulaire.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"  value="<?= htmlspecialchars($nom) ?>"  required>
        <br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value ="<?= htmlspecialchars($prenom) ?>" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        <br>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe"  required>
        <br>

        <input type="submit" name="inscrire">
    </form>
    <footer>© 2026 Student Manager. </footer>
</body>
</html>