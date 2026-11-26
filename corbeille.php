<?php 
require "connexion.php";
require 'auth.php';
session_start();
$etudiants = $connexion->query(
    "SELECT id, nom, prenom, email, deleted FROM etudiants WHERE deleted = 1"
)->fetchall();
if($_SERVER["REQUEST_METHOD"]==="POST"){

    if (isset($_POST["id"]) || $_SESSION['id'] == true) {
    $id = $_POST["id"];

    $stmt = $connexion->prepare("UPDATE etudiants SET deleted = 0  WHERE ID = ?");
    $stmt->execute([$id]);

    header("Location: corbeille.php");
    exit;}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table border="1">
<thead>

    <tr><th>id</th>
    <th>nom</th>
    <th>prenom</th>
    <th>email</th>
    <th>action</th></tr>
</thead>

<?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= (int)$etudiant['id'] ?></td>
                    <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                    <td><?= htmlspecialchars($etudiant['email']) ?></td> 
                    <td>
                        <form method="post" action="corbeille.php" >
                            <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
                            <input type="hidden" name="deleted" value=0 >

                            <button type="submit">return</button>
                        </form>

                    </td>
                </tr>
    
            <?php endforeach; ?>
        
    </table>
    
</body>
</html>