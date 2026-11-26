<?PHP 
require 'connexion.php';
require 'autho.php';
session_start();
if (empty($_SESSION['id'])) {
   header('Location: login.php');
   exit;
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <title>student manager</title>
    
</head>
<body>
   <header>
    <h1>Student Manager</h1>
    <p class="desc"> Welcome to the home page</p>
    <nav>
        <a href="index.php">Accueil</a><br>
        <a href="formulaire.php">Formulaire d'inscription</a><br>
        <a href="listes_des_etudiants.php">Liste des étudiants</a><br>
        <a href="Supprimer.php">delete</a>
        <a href="logout.php">logout</a>
    </nav>
  </header>
 
<main>

</main>
    <footer>© 2026 Student Manager</footer>

</body>
</html>