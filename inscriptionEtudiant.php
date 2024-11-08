<?php
//inclure le fichier de la connexion à la base de données 
require('connexion_bd.php');
// vérifier si le formulaire a été soumis
$error = '';
if(isset($_POST['submit'])) { 
  // valider les données du formulaire
 			if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe']) && !empty($_POST['preferences'])){
 				  // récupérer les données du formulaire
          $nom = trim(ucwords(strtolower($_POST['nom'])));
          $nom = stripslashes($nom);
          $nom = htmlspecialchars($nom);
          $prenom = trim(ucwords(strtolower($_POST['prenom'])));
          $prenom = stripslashes($prenom);
          $prenom = htmlspecialchars($prenom);
          $email = $_POST['email'];
          $email = stripslashes($email);
          $email = htmlspecialchars($email);
          $mot_de_passe = $_POST['mot_de_passe'];
          $mot_de_passe = stripslashes($mot_de_passe);
          $mot_de_passe = htmlspecialchars($mot_de_passe);
          $preferences = $_POST['preferences'];
          $preferences = stripslashes($preferences);
          $preferences = htmlspecialchars($preferences);
        if((preg_match("/^[a-zA-Z]+$/",$nom)) && (preg_match("/^[a-zA-Z]+$/", $prenom)) && filter_var($email,FILTER_VALIDATE_EMAIL) && (preg_match("/^[a-zA-Z0-9.,]+$/",$mot_de_passe))){
          try{
            // Hasher le mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            // Vérifier si l'email existe déjà
            $stmt = $conn->prepare("SELECT COUNT(*) FROM etudiant WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            if ($result > 0) {
              // L'email existe déjà, afficher un message d'erreur approprié
              $error = "Attentio: Cet email est déjà utilisé !!<br>Veuillez en choisir un autre.";
            } else {
              // L'email n'existe pas encore, procéder à l'insertion des données

          	  // Utilisation de requête préparée avec des déclarations paramétrées
                $stmt = $conn->prepare("INSERT INTO etudiant (nom, prenom, email, mot_de_passe, préférences) VALUES (:nom, :prenom, :email, :mot_de_passe, :preferences)");

                // Liaison des valeurs aux paramètres
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':mot_de_passe', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':preferences', $preferences, PDO::PARAM_STR);
                // Exécution de la requête
                $stmt->execute();
                // Récuppérer l'id de l'étudiant
                $id_etud = $conn->lastInsertId();
                // Succès de l'insertion
                echo "<script>alert('Vous êtes bien inscrit!!')</script>";
              }

          } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
          }
        }
        else{
          $error = 'Attention: format de nom, prénom, email ou de mot de passe est incorrect!!<br>';
        }
      }
      else{
        $error = 'Attention: veuillez remplir tout les champs!!<br>';
      }
  }
//Fermeture de la connexion
   $conn = null;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book-Linker-Page d'inscription</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="code_Css/corps.css">
</head>
<body>
	<div class="container">
		<h1>Inscription</h1>
		<form method="POST" action="">
			<label for="nom">Nom:</label>
			<input type="text" id="nom" name="nom" placeholder="Veuillez saisir votre nom" maxlength="30">

			<label for="prenom">Prénom:</label>
			<input type="text" id="prenom" name="prenom" placeholder="Veuillez saisir votre prénom" maxlength="30">

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" placeholder="Veuillez saisir votre email">

			<label for="mot_de_passe">Mot de passe:</label>
			<input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Veuillez saisir votre mot de passe" minlength="8" maxlength="16">

			<label for="preferences">Préférences:</label>
			<select id="preferences" name="preferences">
			  <option value="">Sélectionner</option>
			  <option value="Mathématiques">Mathématiques</option>
			  <option value="Informatiques">Informatiques</option>
			  <option value="Physique">Physique</option>
			</select>
      <span class="error"><?php echo $error; ?></span>
			<input type="submit" name="submit" value="S'inscrire">
			<input type="reset" name="annuler" value="Annuler">
		</form>
		<p><center><span>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></span></center></p>
	</div>
</body>
</html>

