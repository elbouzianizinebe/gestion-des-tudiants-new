<?php

require 'connexion.php';
//require 'autho.php';


$etudiants = $connexion->query(
    "SELECT id, nom, prenom, email, deleted FROM etudiants WHERE deleted = 0"

)->fetchall();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
</head>

<body>
    <header>
        <h1>Liste des Étudiants</h1>
        <p>Welcome to the list of students</p>
        <a href="index.php">Accueil</a><br>
        <a href="formulaire.php">Formulaire</a><br>
        <a href="listes_des_etudiants.php">Liste des étudiants</a><br>
    </header>

    <table border="1">
        <caption>Liste de Modification:</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= (int)$etudiant['id'] ?></td>
                    <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['email']) ?></td> 
                    <td>
                        <a href="modifier.php?id=<?= $etudiant['id'] ?>">Modifier</a>
                    </td>

                    <td>
                        <form method="post" action="Supprimer.php" >
                            <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
                            <input type="hidden" name="deleted" value=1 >

                            <button type="submit">supprimer</button>
                        </form>

                    </td>
                </tr>
    
            <?php endforeach; ?>
        
        </tbody>
    </table>
    <form method="post" action="corbeille.php">
    <input type="hidden" name="deleted">
    <button type="submit">corbeille</button>
    </form>
</body>

</html>