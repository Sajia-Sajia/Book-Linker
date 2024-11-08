<?php

session_start();

if((!isset($_SESSION['login'])) && (!isset($_SESSION['mot_de_passe']))){
header('location:Espace admin.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un livre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styles CSS */
        body {
            background-image:url("code_Css/R.jpg");
            font-family: Arial, sans-serif;
            background-position: center;
   background-repeat: no-repeat, repeat;
   background-size: cover;
   position: relative;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

       
        form {
            margin-top: 20px;
        }

        label {
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
            display: block;
            font-weight: bold;
            color: rgb(70, 68, 68);
            margin-bottom: 5px;
            font-style:italic;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        input[type="text"],
        textarea,select,input[type="file"] {
            font-style:italic;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            background-color:#d8f5da;
        }

        button[type="submit"]{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-style:italic;
            padding: 10px 20px;
            border: none;
            background-color: #45a049;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
             
        }

        button[type="submit"]:hover {
            background-color: #4dcd54;
        }

        .error-message {
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
            color: red;
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-style:italic;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
       
        h1{
            font-style:italic;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 2rem;
  font-weight: 700; 
  color:  #f9f7f7; 
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
            color: #ffffff;}
        .form-actions{

            justify-content: space-between;
            align-items: center;
        }
        span.error-message{
            color: red;
            font-size: 18px;
            font-style: italic;
        }
        span.succes-message{
  text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
            color: green;
            display: block;
            font-weight: bold;
/*            color: rgb(70, 68, 68);*/
            margin-bottom: 5px;
            font-style:italic;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
.back-arrow:hover:after {
  content: "Retourner";
  position: absolute;
/*  margin-top: 48px;
  right: -23px;*/
  text-align: center;
/*  background-color: green;*/
  color: white;
  padding: 4px;
  border-radius: 5px;
  font-size: 16px;
  margin-top: 10px;
  right: -85px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un livre</h1>
<?php
$error = '';
$succes = '';
// Inclure le fichier de connexion
require('connexion_bd.php');

// Fonction pour nettoyer et valider les données d'entrée
function sanitizeInput($input)
{
$input = trim($input);
$input = stripslashes($input);
$input = htmlspecialchars($input);
return $input;
}

try{
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $isbn = sanitizeInput($_POST["isbn"]);
    $titre = sanitizeInput(ucwords(strtolower($_POST["titre"])));
    $auteur = sanitizeInput(ucwords(strtolower($_POST["auteur"])));
    $categorie = sanitizeInput(ucwords(strtolower($_POST["categorie"])));
    $description = sanitizeInput($_POST["description"]);
    // Récupérer les données de l'image
    $imageName = $_FILES['image']['name'];
    $image = $_FILES["image"]["tmp_name"];
    $imageType = $_FILES['image']['type'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];
    // Récupérer les données du fichier
    $livreName = $_FILES['livre']['name'];
    $livre = $_FILES['livre']['tmp_name'];
    $livreType = $_FILES['livre']['type'];
    $livreSize = $_FILES['livre']['size'];
    $livreError = $_FILES['livre']['error'];

    // Validation des données
    if (empty($isbn) || empty($titre) || empty($auteur) || empty($categorie) || empty($description) || empty($image) || empty($livre)) {
        $error = 'Attention: Veuillez remplir tous les champs du formulaire !!<br><br>';
    } else {
        // Vérification des valeurs avec preg_match            "<div class='error-message'>
        if (!preg_match("/^[0-9]{1,5}-?[0-9]{1,7}-?[0-9]{1,6}-?[0-9X]$/", $isbn) || strlen($isbn) == 11 || strlen($isbn) == 12) {
            $error = 'Attention: ISBN invalide !! Veuillez saisir un ISBN valide avec un minimum de 10 chiffres et un maximum de 13 chiffres.<br><br>';
        } elseif (!preg_match("/^[A-Za-z0-9\s\-',.:!?ÈÉéèàêëîïôöùüç]+$/", $titre)) {
            $error = 'Attention: titre invalide !! Veuillez saisir un titre valide.<br><br>';
        } elseif (!preg_match("/^[A-Za-z\s\-'ç]+$/", $auteur)) {
            $error = 'Attention: auteur invalide !! Veuillez saisir un auteur valide.<br><br>';
        } elseif (!preg_match("/^[A-Za-z0-9\s\-',.:!?ÈÉéèàêëîïôöùüç]+$/", $description)) {
            $error = 'Attention: description invalide !! Veuillez saisir une description valide.<br><br>';
        } else {
            // Vérifier le type de fichier image
            if ($imageType !== 'image/jpeg' && $imageType !== 'image/png' && $imageType !== 'image/jpg') {
                $error = 'Attention: Le format de fichier image n\'est pas pris en charge.<br><br>';
                // exit;
            }else{
                // Vérifier s'il y a une erreur lors du téléchargement de l'image
                if ($imageError === UPLOAD_ERR_OK) {
                    // Vérifier la taille de l'image (par exemple, ne pas dépasser 10 Mo)
                    if ($imageSize <= 20485760) {
                        // Générer un nom de fichier unique pour éviter les conflits
                        $imageDestination = 'photos/' . uniqid('', true) . '-' . $imageName;
                        // si tous les champs precedants sont corrects, on passe au fichier du livre
                        // Vérifier le type de fichier livre
                        if ($livreType !== 'application/pdf') {
                            $error = 'Attention: Le format de fichier livre n\'est pas pris en charge !!<br><br>';
                            // exit;
                        }else{
                        // Vérifier s'il y a une erreur lors du téléchargement de l'image
                        if ($livreError === UPLOAD_ERR_OK) {
                            // Vérifier la taille du livre (par exemple, ne pas dépasser 10 Mo)
                            if ($livreSize <= 20485760) {
                                   // Générer un nom de fichier unique pour éviter les conflits
                                   $livreDestination = 'uploads/' . uniqid('', true) . '-' . $livreName;                    
                                   // Si on a arrive ici donc tous ca se passe bien 
                                   // Déplacer le fichier téléchargé vers le répertoire de destination
                                if (move_uploaded_file($image, $imageDestination) && move_uploaded_file($livre, $livreDestination)) {
                                    // Le fichier a été téléchargé avec succès, enregistrer le chemin dans la base de données si l'isbn est nouveau
                                    // Vérifier si l'isbn existe déjà
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM livre WHERE isbn = :isbn");
                                $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
                                $stmt->execute();
                                $result = $stmt->fetchColumn();

                                if ($result > 0) {
                                  // L'isbn existe déjà, afficher un message d'erreur approprié
                                  $error = 'Attention : cet ISBN est déjà utilisé !! Veuillez vérifier vos données.<br><br>';
                                } else {
                                    // Requête SQL pour insérer le nouveau livre dans la base de données
                                        $stmt = $conn->prepare("INSERT INTO livre (isbn, titre, auteur, catégorie, image, description, contenu) VALUES (:isbn, :titre, :auteur, :categorie, :image, :description, :livre)");
                                        $stmt->bindParam(':isbn', $isbn);
                                        $stmt->bindParam(':titre', $titre);
                                        $stmt->bindParam(':auteur', $auteur);
                                        $stmt->bindParam(':categorie', $categorie);
                                        $stmt->bindParam(':description', $description);
                                        $stmt->bindParam(':image', $imageDestination);
                                        $stmt->bindParam(':livre', $livreDestination);
                                        $stmt->execute();
                                        $succes = 'Le livre a été ajouté avec succès !!<br><br>';
                               }
                           }else{
                                $error = 'Le livre n\'a pas encore ajouté !! Veuillez ressaiyer une autre fois<br><br>'; 
                               }
                           }else{
                            $error = 'Attention: la taille du fichier du livre est trop grande !! Veuillez sélectionner un fichier de taille inférieure ou égale à 20 Mo.<br><br>'; 
                           }
                       }elseif($livreError === UPLOAD_ERR_NO_FILE){
                        $error = 'Attention: aucun livre n\'a été sélectionner<br><br>'; 
                       }else{
                        $error = 'Attention: une erreur s\'est produite lors de l\'enregistrement du fichier du livre !!<br><br>';
                       }
                   }
                }else{
                            $error = 'Attention: la taille du fichier de l\'image est trop grand !! Veuillez sélectionner une image de taille inférieure ou égale à 20 Mo.<br><br>'; 
                    }
                }elseif($imageError === UPLOAD_ERR_NO_FILE){
                    $error = 'Attention: aucune image n\'a été sélectionner<br><br>'; 
                }else{
                    $error = "Attention: une erreur s\'est produite lors de l\'enregistrement du fichier de l\'image !!<br><br>";
                   }
               }
           }
       
   }}}catch(PDOException $e) {
echo "<div class='error-message'>Erreur de connexion à la base de données: " . $e->getMessage() . "</div>";
}

?>
<script>
    function goBack() {
        window.location.href = "panneau admin.php";
    }
</script>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" placeholder="Veuillez saisir le ISBN" maxlength="13" minlength="10"><br><br>

            <label for="titre">Titre:</label>
            <input type="text" name="titre" id="titre" placeholder="Veuillez saisir le titre"><br><br>

            <label for="auteur">Auteur:</label>
            <input type="text" name="auteur" id="auteur" placeholder="Veuillez saisir l'auteur"><br><br>

            <label>Catégorie :</label>
            <select name="categorie" id="categorie">
            <option value="Sélectionner">Sélectionner :</option>
                <option value="Mathématiques">Mathématique</option>
                <option value="Informatiques">Informatiques</option>
                <option value="Physique">Physique</option>
            </select><br><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5" placeholder="Veuillez saisir la description"></textarea><br><br>

            <label for="image">Image:</label>
<input type="file" name="image" id="image"><br><br>

            <label class="cou" for="livre">Fichier du livre:</label>
            <input  type="file" name="livre" id="livre"><br><br>
            <span class="error-message"><?php echo $error;?></span>
            <span class="succes-message"><?php echo $succes;?></span>

            <div class="form-actions">
                <center><button class="oui" type="submit">Ajouter le livre</button></center>

                <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
           
            </div>
        </form>
    </div>
    <?php
                // Fermeture de la connexion
            $conn = null;
        }
            ?>
</body>
</html>