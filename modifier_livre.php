<?php

session_start();

if((!isset($_SESSION['login'])) && (!isset($_SESSION['mot_de_passe']))){
header('location:Espace admin.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book-Linker-Modifier le livre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        /* Styles CSS pour la mise en page */
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

        body {
            background-image: url("code_Css/R.jpg");
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: rgb(70, 68, 68);
            margin-bottom: 5px;
            font-style: italic;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            font-style: italic;
            display: block;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #d8f5da;
        }
        .wow {
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

        .form-group button {
            padding: 8px 12px;
            border: none;
            background: #4caf50;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
}        span.error-message{
            color: red;
            font-size: 18px;
            font-style: italic;
        }
    </style>
</head>
<body>
<?php
$error = '';
// inclure le fichier de connexion
 require('connexion_bd.php');

 $id_livre = $_GET['id'];
// Fonction pour échapper les caractères spéciaux
function escapeString($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $titre = escapeString(ucwords(strtolower($_POST['titre'])));
    $auteur = escapeString(ucwords(strtolower($_POST['auteur'])));
    $categorie = escapeString(ucwords(strtolower($_POST['categorie'])));
    $description = escapeString($_POST['description']);
    $isbn = escapeString($_POST['isbn']);
    // Requête de recherche

try {
    // Vérifier si tous les champs sont vides
    if (empty($titre) || empty($isbn) || empty($auteur) || empty($categorie) || empty($description)) {
        $error = "Attention: Veuillez remplir tous les champs du formulaire !!";
    } elseif ((!preg_match("/^[0-9]{1,5}-?[0-9]{1,7}-?[0-9]{1,6}-?[0-9X]$/", $isbn))|| strlen($isbn) == 11 || strlen($isbn) == 12) {
       $error = "Attention: ISBN invalide !! Veuillez saisir un ISBN valide avec un minimum de 10 chiffres et un maximum de 13 chiffres.";
    } elseif (!preg_match("/^[A-Za-z0-9\s\-'',.:!?ÈÉéèàêëîïôöùüç]+$/", $titre)) {
        $error = "Format de titre invalide !! Veuillez saisir un titre alphabétique avec espaces et chiffres.";
    } elseif (!preg_match("/^[A-Za-z\s\-'çéèàêëîïôöùüç]+$/", $auteur)) {
        $error = "Format d'auteur invalide !! Veuillez saisir un nom d'auteur alphabétique avec espaces.";
    } elseif (!preg_match("/^[A-Za-z0-9\s\-',.:!?ÈÉéèàêëîïôöùüç]+$/u", $description)) {
        $error = "Format de description invalide. Veuillez saisir une description alphanumérique avec espaces et ponctuation.";
    } else {
            $sqlSearch = "SELECT id_liv FROM livre WHERE isbn = :isbn";
            $stmtSearch = $conn->prepare($sqlSearch);
            $stmtSearch->bindParam(':isbn', $isbn);
            $stmtSearch->execute();

            if ($stmtSearch->rowCount() > 0) {
                echo '<script>alert("ISBN déjà existant. Veuillez saisir un ISBN unique."); goBack();</script>';
                
            }else{
            // echo "<script>alert('Êtes-vous sûr de vouloir modifier ce livre ?')</script>";
        // Préparer et exécuter la requête d'update
$sql = "UPDATE livre SET titre = :titre, auteur = :auteur, catégorie = :categorie, isbn = :isbn , description = :description WHERE id_liv = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':auteur', $auteur);
$stmt->bindParam(':categorie', $categorie);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':isbn', $isbn);
$stmt->bindParam(':id', $id_livre);
    $stmt->execute();
    echo '<script>alert("Livre modifié avec succès.");</script>';
    // Rediriger l'utilisateur vers une autre page après le traitement du formulaire

    // Assurez-vous d'appeler exit après la redirection
}
}
} catch (PDOException $e) {
    echo '<script>alert("Erreur lors de la modification du livre: ' . $e->getMessage() . '");</script>';
}
    }
// Fermer la connexion à la base de données
$conn = null;
}
?>
<div class="container">
    <h1 class="form-title">Modifier le livre</h2>
    <form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $id_livre; ?>">
    <div class="form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" placeholder="Veuillez saisir le nouveau ISBN"  maxlength="13" minlength="10">
        </div>
        <div class="form-group">
            <label>Titre :</label>
            <input type="text" name="titre" placeholder="Veuillez saisir le nouveau titre">
        </div>
      
        <div class="form-group">
            <label>Auteur :</label>
            <input type="text" name="auteur" placeholder="Veuillez saisir le nouveau auteur">
        </div>
        <div class="form-group">
            <label>Catégorie :</label>
            <select name="categorie" >
            <option value="Sélectionner">Sélectionner :</option>
                <option value="Mathématiques">Mathématique</option>
                <option value="Informatiques">Informatiques</option>
                <option value="Physique">Physique</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description :</label>
            <textarea name="description"placeholder="Veuillez saisir la nouvelle description" ></textarea>
        </div>
       <span class="error-message"><?php echo $error .'<br>'; ?></span>
        <!-- <div class="form-actions"> -->
        <center><button type="submit" class="wow form-actions">Modifier</button></center>
            <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
        <!-- </div> -->
    </form>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>


</body>
</html>