<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Book-Linker-Page d'authentification</title>
  <link rel="stylesheet" href="code_Css/corps.css">
</head>
<body>
  <h1>Welcome to "Book-Linker"</h1>
  <div class="container">
    <h3><u>Espace Etudiant</u></h3>
<?php
$error = "";
   if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
      if(!empty($_POST['email']) && !empty($_POST['mot_de_passe'])){
          $email = $_POST['email'];
          $email = stripslashes($email);
          $email = htmlspecialchars($email);
          // $email = mysqli_real_escape_string($conn, $email); en sqli
          $mot_de_passe = $_POST['mot_de_passe'];
          $mot_de_passe = stripslashes($mot_de_passe);
          $mot_de_passe = htmlspecialchars($mot_de_passe);
        if(filter_var($email,FILTER_VALIDATE_EMAIL) && (preg_match("/^[a-zA-Z0-9.,]+$/",$mot_de_passe))){
            //inclure le fichier de la connexion à la base de données 
            require('connexion_bd.php');
            try{
            // Utilisation de requête préparée avec des déclarations paramétrées
            $stmt = $conn->prepare("SELECT * FROM etudiant WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); //éviter lea attaques par injection SQL
            // $stmt->bindParam(':Mot_de_passe', $mot_de_passe, PDO::PARAM_STR); //éviter lea attaques par injection SQL
            $stmt->execute();

            // Récupération des résultats sous forme d'un tableau associatif
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Vérification des résultats
            if (count($results) > 0) {
              $etudiant_log = $results[0];
              if (password_verify($mot_de_passe, $etudiant_log['Mot_de_passe'])) {
                // Utilisateur authentifié avec succès
                  // // session_start();
                  $etudiant = $results[0]; // Récupérer les données de l'étudiant connecté depuis les résultats
                  $_SESSION['id_etud'] = $etudiant['id_etud'];
                  $_SESSION['nom'] = $etudiant['nom'];
                  $_SESSION['prenom'] = $etudiant['prenom'];
                  $_SESSION['email'] = $etudiant['email'];
                  $_SESSION['mot_de_passe'] = $etudiant['Mot_de_passe'];
                  $_SESSION['preferences'] = $etudiant['préférences'];
                    if(isset($_POST['check'])){ //&& $_POST['check'] === '1'
                      setcookie('email', $_SESSION['email'], time() + 365*24*3600, '/');
                      // setcookie('email',$_SESSION['email'],time() + 365*24*3600, null, null, false,true);
                    }
                    header('location:rechercher_livre.php');
            }else{
                $error = 'Attention: Mot de passe est incorrect!!';
            }} else {
                // Échec de l'authentification
                $error = 'Attention: Vous n\'êtes pas inscrit!!<br>veuillez s\'inscrire pour pouvoir accéder à notre application<br>';
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
        }
        else{
          $error = 'Attention: format de email ou de mot de passe est incorrect!!<br>';
        }
      }
      else{
        $error = 'Attention: veuillez remplir tout les champs!!<br>';
      }
  }
//Fermeture de la connexion
   $conn = null;
?>
    <div class="form-container">
      <form method="POST" action=''>
        <div class="input-container">
          <label for="email">Email :</label>
          <input type="text" name="email" id="email" placeholder="Veuillez saisir votre email" value="<?php if(isset($_COOKIE['email'])) {echo $_COOKIE['email'];} ?>">
        </div>

        <div class="input-container">
          <label for="mot_de_passe">Mot de passe :</label>
          <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Veuillez saisir votre mot de passe" minlength="8" maxlength="16">
        </div>
         <span class="error"><?php echo $error; ?></span>
         <input type="submit" value="Se connecter">
         <input type="reset" name="annuler" value="Annuler">
      </form>
    </div>

    <div class="inscription-container">
      <p><center><span>Vous êtes nouveau ici ? </span><a href="inscriptionEtudiant.php">S'inscrire</a></center></p>
    </div>
    <div>
      <center><p><span>Se souvenir de moi</span><input type="checkbox" name="check" id="check" value="1"></p></center>
      <a class="lien" href="Espace admin.php"><span><center><u>Espace admin</u></center></span></a>
    </div>
  </div>
</body>
</html>


