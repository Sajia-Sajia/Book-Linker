<?php
$servername = "localhost";
$username = "root";
$password = "votremotdepasse";
$dbname="BDDPROJECT";
try {
	// Connexion à la base de données
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username,$password);
	// le mode d'erreur PDO sur Exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo " Connection réussie.<br>";
} catch(PDOException $e) {
	echo "Connexion échouée: " . $e->getMessage() . "<br>";
	exit();
}

// Fermer la connexion PDO
// $conn = null;
?>
