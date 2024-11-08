<?php

$servername = "localhost";
$username = "root";
$password = "votremotdepasse";

try {
    // Création de la connexion
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer notre base de données BD_PROJECT
    $sql = "CREATE DATABASE BDDPROJECT";
    $conn->exec($sql);
    echo "La base de données a été créée avec succès<br>";
    
} catch(PDOException $e) {
    echo  $sql . "<br>" . $e->getMessage();
}

// Fermer la connexion PDO
$conn = null;

?>