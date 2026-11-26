
<?php
require 'connexion.php';
require 'auth.php';

$id = (int)($_GET['id'] ?? 0);

$erreur = '';
$succes = '';

// Get student
$stmt = $connexion->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

if (!$etudiant) {
    die("Étudiant introuvable.");
}

// Update student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $nouveau_mdp = $_POST['new_mdp'];
    $confirmation = $_POST['confirmation'];


    // Check new password confirmation
    if ($nouveau_mdp != $confirmation) {

        $erreur = "Les mots de passe ne correspondent pas.";

    }
    else {

        // Keep old password if new password is empty
        $password = $etudiant['mot_de_passe'];

        if ($nouveau_mdp != '') {
           $password = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
        }

        // Update database
        $upd = $connexion->prepare(
            "UPDATE etudiants
             SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?
             WHERE id = ?"
        );

        $upd->execute([
            $nom,
            $prenom,
            $email,
            $password,
            $id
        ]);

        $succes = "Données modifiées avec succès.";

        // Update displayed information
        $etudiant['nom'] = $nom;
        $etudiant['prenom'] = $prenom;
        $etudiant['email'] = $email;
        $etudiant['mot_de_passe'] = $password;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier étudiant</title>
</head>

<body>

    <h1>Modifier les données de l'étudiant</h1>

    <a href="index.php">Accueil</a>

    <?php if ($erreur): ?>
        <p style="color:red;">
            <?= htmlspecialchars($erreur) ?>
        </p>
    <?php endif; ?>

    <?php if ($succes): ?>
        <p style="color:green;">
            <?= htmlspecialchars($succes) ?>
        </p>
    <?php endif; ?>

    <h2>Modification</h2>

    <form method="POST">

        <label>Nom :</label>
        <input type="text" name="nom"
            value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
        <br>

        <label>Prénom :</label>
        <input type="text" name="prenom"
            value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
        <br>

        <label>Email :</label>
        <input type="email" name="email"
            value="<?= htmlspecialchars($etudiant['email']) ?>" required>
        <br>

        <label>Nouveau mot de passe :</label>
        <input type="password" name="new_mdp" pattern="{6,}" minlength="6" required >
        <br>

        <label>Confirmer le nouveau mot de passe :</label>
        <input type="password" name="confirmation"pattern="{6,}" minlength="6" required >
        <br>

        <button type="submit">Modifier</button>

    </form>

</body>
</html>
