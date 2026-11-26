<?php 
require 'connexion.php';

$erreur = '';
if ($_SERVER["REQUEST_METHOD"] === "POST"){  
if (isset($_POST["id"]))
{
   $id = $_POST["id"];
   $stmt = $connexion->prepare(" UPDATE etudiants SET deleted = 1 WHERE ID = ? " );
   $stmt->execute([$id]);

   header("Location: listes_des_etudiants.php");
    exit();
}
}
?>
