<?php
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session et les cookies
session_destroy();
setcookie('email', '', time() - 3600);

// Rediriger vers la page de connexion
header('location:Espace admin.php');
?>