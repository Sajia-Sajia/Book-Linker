<?php
//inclure le fichier de la connexion à la base de données 
require('connexion_bd.php');
try{
// creation de la table 'livre'
	$sql = "CREATE TABLE livre (
    id_liv INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(40) NOT NULL UNIQUE,
    titre VARCHAR(70) NOT NULL,
    auteur VARCHAR(50) NOT NULL,
    catégorie VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    contenu VARCHAR(255) NOT NULL

)";
	$conn->exec($sql);
	echo "Table 'livre' a été créée avec succès.<br>";
} catch(PDOException $e) {
	echo " Erreur de la création de la table livre :<br>" . $e->getMessage() . "<br>";
}
try{
// creation de la table 'etudiant'
	$sql = "CREATE TABLE etudiant (
    id_etud INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    Mot_de_passe VARCHAR(50) NOT NULL,
    préférences VARCHAR(50) NOT NULL
)";
	$conn->exec($sql);
	echo "Table 'etudiant' a été créée avec succès.<br>";
} catch(PDOException $e) {
	echo "Erreur de la création de la table etudiant :<br>" . $e->getMessage() . "<br>";
}
try {
// Création de la table historique
    $sql = "CREATE TABLE historique (
    id INT(10)  UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_etud INT(10) UNSIGNED NOT NULL,
    id_liv INT(10) UNSIGNED NOT NULL,
    FOREIGN KEY (id_etud) REFERENCES etudiant(id),
    FOREIGN KEY (id_liv) REFERENCES livre(id)
)";
    $conn->exec($sql);
    echo "Table 'historique' a été créée avec succès.<br>";
} catch(PDOException $e) {
    echo "Erreur de la création de la table historique :<br>" . $e->getMessage();
}

// Fermer la connexion PDO
$conn = null;
?>