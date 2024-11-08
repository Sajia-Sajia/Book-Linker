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
    <h3><u>Espace Admin</u></h3>
<?php
$error = "";
   if (isset($_POST['login']) && isset($_POST['mot_de_passe'])) {
      if(!empty($_POST['login']) && !empty($_POST['mot_de_passe'])){
          $login = $_POST['login'];
          $login = htmlspecialchars($login);
          $login = stripslashes($login);
          $mot_de_passe = $_POST['mot_de_passe'];
          $mot_de_passe = htmlspecialchars($mot_de_passe);
          $mot_de_passe = stripslashes($mot_de_passe);
        if((preg_match("/^[a-zA-Z]+$/",$login)) && (preg_match("/^[a-zA-Z0-9.]+$/",$mot_de_passe))){
          if(($login == "admin" || $login == "ADMIN")&& ($mot_de_passe == "Sajia.j1" || $mot_de_passe == "Douae.k2")){
                  // Utilisateur authentifié avec succès
                  $_SESSION['login'] = $_POST['login'];
                  $_SESSION['mot_de_passe'] = $_POST['mot_de_passe'];
                  // if(isset($_POST['check'])){

                  //   setcookie('login',$_SESSION['login'],time() + 365*24*3600, null, null, false,true);
                  // }
                  header('location:panneau admin.php');
          }
          else{
            $error = 'Attention: login ou mot de passe incorrect!!<br>';
          }
        }
        else{
          $error = 'Attention: format de login ou de mot de passe est incorrect!!<br>';
        }
      }
      else{
        $error = 'Attention: veuillez remplir tout les champs!!<br>';
      }
  }

?>
    <div>
      <form method="POST" action="">
        <div class="input-container">
          <label for="login">Login</label>
          <input type="text" name="login" id="login" placeholder="Veuillez saisir votre login" value=<?php if(isset($_COOKIE['login'])) echo $_COOKIE['login']; ?>>
        </div>

        <div class="input-container">
          <label for="mot_de_passe">Mot de passe :</label>
          <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Veuillez saisir votre mot de passe" minlength="8" maxlength="8">
        </div>
          <span class="error"><?php echo $error; ?></span>
         <input type="submit" value="Se connecter">
         <input type="reset" name="annuler" value="Annuler">
      </form>
    </div>
    <div>
      <p><center><span>Se souvenir de moi</span><input type="checkbox" name="check" id="check"></center></p>
      <a class="lien" href="login.php"><span><center><u>Page d'accueil</u></center></span></a>
    </div>
  </div>
</body>
</html>


