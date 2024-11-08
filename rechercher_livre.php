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
    <title>Book-Linker-Page de recherche</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            padding: 20px 200px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.search-bar {
    margin-top: 0;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    background-color: #d5e9d8;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.search-bar input[type="text"] {
      background-color: #d5e9d8;
      color: color: #333;
      padding: 10px;
      font-style: italic;
      border: none;
      border-radius: 5px 0 0 5px;
      font-size: 16px;
      flex: 1;
      width: 100%;
      display: block;
      border: 1px solid #ccc;
      margin: auto;
}

.search-bar button {
    padding: 8px 12px;
    border: none;
    background: none;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    background-color: #57bca5;
    color: #fff;
    transition: background-color 0.3s ease;
}

.search-bar button:hover {
    background-color: #44997e;
}

.search-bar .search-icon {
    padding: 8px 12px;
    background: none;
    border: none;
    cursor: pointer;
}

.book-list {
    margin-top: 20px;
}

.book-item {
    display: inline-block;
    width: 200px;
    margin: 10px;
    text-align: center;
}

.book-image {
    width: 150px;
    position: relative;
    overflow: hidden; 
    height: 200px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
/*    transition: transform 0.3s ease;
   transform: translate(0, -5px);*/
}

span.error {
    font-size: 14px;
    color: red;
}

h1 {
            font-style: italic;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #f9f7f7;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
            line-height: 1.2;
            text-align: center;
            background-color: #45a049;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
}

hr {
    border: 3px solid #57bca5;
    border-radius: 3px;
    margin: 20px 0;
}

.titre , .auteur{
    font-style: italic;
    text-align: center;
}
.section-titre {
    font-size: 25px;
    font-weight: bold;
    margin-bottom: 10px;
    font-family: Geneva;
    color: darkgreen;
}
 .back-arrow {
    text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
    border-radius: 50px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 40px;
    color: green;
    cursor: pointer;
}
.back-arrow:hover {
    background-color: #45a049;
    color: #ffffff;
}
.form-actions{
           
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-group {
            margin-bottom: 20px;
}
.details {
        text-decoration: none;
        color: cadetblue;
    }

.details:hover {
        color: green;
        text-decoration: underline;
        text-shadow: 2px 2px 4px #000000;
}
.image-container {
  display: flex;
  flex-wrap: wrap;
}

.image {
  flex-basis: 33.33%; /* Pour afficher 3 images par ligne, utilisez 33.33% pour chaque image */
  padding: 10px;
  box-sizing: border-box;
    display: block;
  width: 100%;
  height: auto;
}

.image img {
  display: block;
  width: 100%;
  height: auto;
}
.logout-button {
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

    </style>
</head>
<body>
	<h1>Bienvenue <?php echo $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '  to Book-Linker&#128522;!!'; //&#128521;&#129309; ?></h1><a href="deconnexion.php" class="logout-button"><i class="fas fa-sign-out-alt">Déconnexion</i></a>
	<div class="container">
	<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Rechercher un livre par titre, auteur ou catégorie">
    <button type="submit" class="search-icon">&#128270;</button>
</form>
            <div class="form-group form-actions">
                <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
            </div>
<script>
    function goBack() {
        window.history.back();
    }
</script>

    <?php 
$error = '';
$error2 = '';
	try{
    /******************Resultats du recherche de l'étudiant****************************/
        // Recherche du livre en fonction des critères saisis
        if(isset($_GET['search'])) {
            if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $id_etud = $_SESSION['id_etud'];
            // Requête préparée pour empêcher les attaques par injection SQL
            $stmt = $conn->prepare("SELECT * FROM livre WHERE titre LIKE :search OR auteur LIKE :search OR catégorie LIKE :search");
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();
            // Récupérer les résultats de la recherche
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            /**************************conserver les recherches de l'etudiant*************/
            if(count($books) > 0){	// Vérifier si le livre recherché existe ou non
            	// Vérifier si le livre existe déjà dans l'historique de l'étudiant
			    $livresDejaAjoutes = array();
			    // Récupérer les ID des livres déjà présents dans l'historique de l'étudiant
			    $stmt = $conn->prepare("SELECT id_liv FROM historique WHERE id_etud = :id_etud");
			    $stmt->bindParam(':id_etud', $id_etud, PDO::PARAM_INT);
			    $stmt->execute();
			    $livresHistorique = $stmt->fetchAll(PDO::FETCH_COLUMN);
				foreach ($books as $livre) {
				    $id_liv = $livre['id_liv'];
				    if (!in_array($id_liv, $livresHistorique)) {
				    	// Le livre n'existe pas dans l'historique,donc ajouter l'ID du livre au tableau livresDejaAjoutes

				    	// Insérer les données dans la table "historique"
					    $stmt = $conn->prepare("INSERT INTO historique (id_etud, id_liv) VALUES (:id_etud, :id_liv)");
			            $stmt->bindParam(':id_etud', $id_etud, PDO::PARAM_INT);
			            $stmt->bindParam(':id_liv', $id_liv, PDO::PARAM_INT);
			            $stmt->execute();
			            // Ajouter l'ID du livre à $livresDejaAjoutes
			            $livresHistorique[] = $id_liv;
			            // Recherche ajoutée à l'historique avec succès.
				    }
				}
			
            	// Affichage des résultats de recherche
	            echo " <center><h2 class=\"section-titre\"><br><br><b><u>Résultats de la recherche :</u></b></h2></center>";
	            echo "<div class=\"book-list\">";
                 echo "<div class=\"image-container\">";
	           foreach ($books as $livre) {
                 echo "<div class=\"image\">";
	           	echo "<div class=\"book-item\">";
                echo "<a href='" . $livre['contenu'] . "'>"; 
                echo '<img src="' . $livre['image'] . '" alt="Image du livre" class=\'book-image\'>';
                echo "</a>";
                echo "<h3 class=\"titre\">" . $livre['titre'] . "</h3>";
                echo "<h3 class=\"auteur\">". $livre['auteur'] . "</h3>"; //. 'Auteur: ' 
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $livre['id_liv'] . "'>Voir détails</a>";
                echo "</div></div>";
			   }echo "</div></div><hr>";
            }else{
                echo " <center><h2 class='section-titre'><br><br><b><u>Résultats de la recherche :</u></b></h2></center>";
            	echo "<br><h3>Aucun livre correspondant à la recherche n'a été trouvé.<br><br></h3><hr>";
            }
		    }else{
                $error = 'Veuillez remplir la barre de recherche si voulez-vous rechercher un livre spécifié !!<br><hr>';
            }
        }
echo "<span class='error'>" . $error . "</span><br>";
	/********************Recommandations basees sur les preferences***********************/
		// Récupérer les préférences de l'étudiant à partir de la session
		$preferences = $_SESSION['preferences'];

		// Utiliser les préférences pour obtenir les livres correspondants depuis la base de données
		$stmt = $conn->prepare("SELECT * FROM livre WHERE catégorie = :preferences");
		$stmt->bindParam(':preferences', $preferences, PDO::PARAM_STR);
		$stmt->execute();
		$livresRecommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// Afficher les livres recommandés
		echo "<center><h2 class=\"section-titre\"><b><u>Recommandations pour vous :</u></b></h2></center>";
		echo "<div class=\"book-list\">";
        echo "<div class=\"image-container\">";
		foreach ($livresRecommandes as $livre) {
                echo "<div class=\"image\">";
	           	echo "<div class=\"book-item\">";
                echo "<a href='" . $livre['contenu'] . "'>";
                echo '<img src="' . $livre['image'] . '" alt="Image du livre" class=\'book-image\'>';
                echo "</a>";
                echo "<h3 class=\"titre\">" . $livre['titre'] . "</h3>";
                echo "<h3 class=\"auteur\">" . $livre['auteur'] . "</h3>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $livre['id_liv'] . "'>Voir détails</a>";
                echo "</div>";
                echo "</div>";
		}
         // echo "</div>";
		/******************Recommandations basees sur l'historique*************************/
		// Récupérer l'ID de l'étudiant à partir de la session
		$id_etud = $_SESSION['id_etud'];

		// Utiliser l'ID de l'étudiant pour récupérer son historique depuis la base de données
		$stmt = $conn->prepare("SELECT livre.* FROM livre
		                        INNER JOIN historique ON livre.id_liv = historique.id_liv
		                        WHERE historique.id_etud = :id_etud");
		$stmt->bindParam(':id_etud', $id_etud, PDO::PARAM_INT);
		$stmt->execute();
		$livresHistorique = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Afficher les livres de l'historique
		// echo " <h2>Résultats de la recommandation de l'historique :</h2>";
		// echo "<div class='book-list'>";
        // Vérifier si le livre existe déjà dans les préférences de l'étudiant
        $livreExisteDansPreferences = array();
		foreach ($livresHistorique as $livre) {
            $existe = false;
            foreach ($livresRecommandes as $livrePrefere) {
                if ( $livre['id_liv'] == $livrePrefere['id_liv']) {
                    // Ajouter l'ID du livre à $livreExisteDansPreferences
                    $livreExisteDansPreferences[] = $livrePrefere['id_liv'];
                    $existe = true;
                    break;
                }
            }
        }
        foreach ($livresHistorique as $livre) {
             $id_liv = $livre['id_liv'];
             if (!in_array($id_liv, $livreExisteDansPreferences)) {
                echo "<div class=\"image\">";
	           	echo "<div class=\"book-item\">";
                echo "<a href='" . $livre['contenu'] . "'>";
                echo '<img src="' . $livre['image'] . '" alt="Image du livre" class=\'book-image\'>';
                echo "</a>";
                echo "<h3 class=\"titre\">" . $livre['titre'] . "</h3>";
                echo "<h3 class=\"auteur\">" . $livre['auteur'] . "</h3>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $livre['id_liv'] . "'>Voir détails</a>";
                echo "</div></div>";
            }
		}echo "</div></div>";
		echo "<br>";
    }catch (PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit();
    }
}
// Fermeture de la connexion
$conn = null;
?>
</div>
</body>
</html>