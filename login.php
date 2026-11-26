<?php
session_start();
require 'connexion.php';
// require 'login.php';

//if (!empty($_SESSION['id'])) {
// $erreur = "t2eked mn les donnee";
//header('Location: index.php');
//  exit();
//} else {
// echo "bonjouuur";
//  }


$erreur = '';
$succes = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mdp'];

    // $stmt = $connexion->prepare("SELECT * FROM admin_etudiants WHERE email  like ?");
    // $stmt->execute([$email]);
    // $admin_etudiant = $stmt->fetch();
    $stmt = $connexion->prepare("SELECT * FROM admin_etudiants where email = ? ");
    $stmt->execute([$email]);
    $admin_etudiant = $stmt->fetch();

    echo "<pre>";
    print_r($admin_etudiant);
    echo "</pre>";

    if ($admin_etudiant == null || !password_verify($mdp, $admin_etudiant['mot_de_passe'])) {
        $erreur = "the password is incorrect or the email don't exist";
    } else {
        session_regenerate_id(true);
        $_SESSION['id'] = $admin_etudiant['id'];
        setcookie("isAdmin", $admin_etudiant['id'], time() + (86400 * 30), "/");
        header("Location: /index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>login</title>
</head>

<body>



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

    <h2>Login</h2>

    <form method="POST">


        <label>Email :</label>
        <input type="email" name="email" value="" required>
        <br>

        <label>mot de passe :</label>
        <input type="password" name="mdp" pattern="{6,}" minlength="6" required>
        <br>


        <button type="submit">Login</button>

    </form>

</body>

</html>