<?php
session_start();
//inclure le fichier de la connexion à la base de données
require('connexion_bd.php');
if((!isset($_SESSION['id_etud'])) && (!isset($_SESSION['nom'])) && (!isset($_SESSION['prenom'])) && (!isset($_SESSION['email'])) && (!isset($_SESSION['mot_de_passe'])) && (!isset($_SESSION['preferences']))){
header('location:login.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<title>Book-Linker-Détails du livre</title>
</head>
    <style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-image: url("code_Css/R.jpg");
  background-color: cadetblue;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.7);
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
  font-style: italic;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 2rem;
  font-weight: 700;
  color: #f9f7f7;
  letter-spacing: 2px;
  text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
  line-height: 1.2;
  text-align: center;
  background-color: #45a049;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
}

.back-arrow {
  text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
  border-radius: 50px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  top: 40px;
  left: 20px;
  font-size: 40px;
  color: green;
  cursor: pointer;
}

.back-arrow:hover {
  background-color: #45a049;
  color: #ffffff;
}

.form-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.form-group {
  margin-top: 10px;
}

.details-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.image-section,
.info-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 10px;
}

.image-section img {
  max-width: 200px;
  height: auto;
}

p {
  font-style: italic;
}

a{
    font-style:italic;
    color:green;
    cursor: pointer;
            text-decoration: none;
}
a:hover{
        color: red;
        text-decoration: underline;
        text-shadow: 2px 2px 4px #000000;
}
.logout-button {
  position: relative;
  bottom: 65px; /* Ajustez la valeur de positionnement vertical */
 right: -1480px; /* Ajustez la valeur de positionnement horizontal */
}
.logout-button:hover {
        color: beige;
        text-decoration: none;
        text-shadow: 2px 2px 4px #000000;
}
.back-arrow:hover:after {
  content: "Retourner";
  position: absolute;
  margin-top: 10px;
  right: -85px;
/*  width: 100%;*/
  text-align: center;
  background-color: #45a049;
  color: white;
  padding: 4px;
  border-radius: 5px;
  font-size: 16px;
}
.logout-button {
  color: beige;
    font-size: 18px;
  position: relative;
/*  left: 250px;*/
bottom: 67px; /* Ajustez la valeur de positionnement vertical */
right: -1380px; /* Ajustez la valeur de positionnement horizontal */
}
.logout-button:hover {
        color: red;
        text-decoration: none;
        text-shadow: 2px 2px 4px #000000;
}
	</style>
<body>
<div class="form-group form-actions">
               <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
            </div>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
<?php
// inclure le fichier de connexion
require('connexion_bd.php');

$error = '';
try{
if (isset($_GET['id_liv'])) {
    $livreId = $_GET['id_liv'];
        // Préparer et exécuter la requête pour récupérer les détails du livre
        $requete = "SELECT * FROM livre WHERE id_liv = :id_liv";
        $statement = $conn->prepare($requete);
        $statement->bindParam(':id_liv', $livreId, PDO::PARAM_INT);
        $statement->execute();
		// Vérifier s'il y a des résultats
        if ($statement->rowCount() > 0) {
            $livre = $statement->fetch(PDO::FETCH_ASSOC);

            // Afficher les détails du livre
            echo "<h1>S'informer sur le livre choisi📙:</h1><a href=\"deconnexionAdmin.php\" class=\"logout-button\"><i class=\"fas fa-sign-out-alt\">Déconnexion</i></a>";
            echo "<div class=\"container\">";
            echo " <div class=\"datails-container\">";
            echo " <div class=\"image-section\">";
            echo "<p><strong>Image de la couverture :</strong><img src='" . $livre['image'] . "' alt=\"Image du livre\" style=\"max-width: 200px; height: auto;\"></p>";
            echo  " </div>";
            echo "  <div class=\"info-section\">";
            echo "<p><strong>Titre :</strong> " . $livre['titre'] . "</p>";
            echo "<p><strong>Auteur :</strong> " . $livre['auteur'] . "</p>";
            echo "<p><strong>ISBN :</strong> " . $livre['isbn'] . "</p>";
            echo "<p><strong>Description :</strong> " . $livre['description'] . "</p>";
            echo "<p><strong>Contenu : </strong><a href='" . $livre['contenu'] . "'>Voir le livre.</a></p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "Aucun livre trouvé avec cet ID.";
        }
        }else {
    echo "ID de livre manquant.";
}
}catch (PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit();
}

// Fermeture de la connexion
$conn = null;
}
?>