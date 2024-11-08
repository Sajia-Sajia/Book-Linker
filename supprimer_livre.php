<?php

session_start();

// Inclure le fichier de connexion
require('connexion_bd.php');

if((!isset($_SESSION['login'])) && (!isset($_SESSION['mot_de_passe']))){
header('location:Espace admin.php');
}else{

// Vérifier si l'ID du livre à supprimer est présent dans l'URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    try {

        // Vérifier si le livre existe avant de le supprimer
        $stmt = $conn->prepare("SELECT * FROM livre WHERE id_liv = :id");
        $stmt->bindParam(':id', $bookId);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book) {
            // Afficher une alerte de confirmation de suppression
            echo "<script>alert('Êtes-vous sûr de vouloir supprimer ce livre ?')</script>";

            // Supprimer le livre de la base de données
            $deleteStmt = $conn->prepare("DELETE FROM livre WHERE id_liv = :id");
            $deleteStmt->bindParam(':id', $bookId);
            $deleteStmt->execute();

            // Afficher une alerte pour indiquer que la suppression est réussie
            echo "<script>alert('Suppression réussie.')</script>";
        } else {
            // Afficher une alerte pour indiquer que le livre n'existe pas
            echo "<script>alert('Ce livre n'existe pas.')</script>";
        }

        // Rediriger vers la page de recherche des livres
        echo "<script>window.location.href = 'panneau admin.php';</script>";
    } catch (PDOException $e) {
        // Afficher une alerte pour indiquer une erreur de connexion à la base de données
        echo "<script>alert('Erreur de connexion à la base de données.')</script>";

        // Rediriger vers la page de recherche des livres
        echo "<script>window.location.href = 'panneau admin.php';</script>";
    }
} else {
    // Afficher une alerte pour indiquer une erreur de l'ID du livre
    echo "<script>alert('ID du livre manquant.')</script>";

    // Rediriger vers la page de recherche des livres
    echo "<script>window.location.href = 'panneau admin.php';</script>";
}
}
?>
