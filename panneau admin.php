<?php

session_start();

if((!isset($_SESSION['login'])) && (!isset($_SESSION['mot_de_passe']))){
header('location:Espace admin.php');
}else{
           if(isset($_POST['check'])){

            setcookie('login',$_SESSION['login'],time() + 365*24*3600, null, null, false,true);
           }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Interface de l'administrateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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

.search-bar {
    margin-top: 20px;
/*    display: flex;
    align-items: center;*/
    background-color: #d5e9d8;
    border-radius: 5px;
/*    overflow: hidden;*/
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

.search-bar input[type="text"] {
    flex: 1;
    width: 84%;
    padding: 8px;
    font-size: 16px;
    border: none;
    border-radius: 5px 0 0 5px;
    background-color: #d5e9d8;
    color: #333;
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

.search-bar button i {
    font-size: 20px;
}

.search-bar button:hover {
    background-color: #44997e;
}

.add-book-button {
    position: absolute;
    top: 50%;
    right: 28px;
    transform: translateY(-50%);
    margin: 0;
    padding: 8px;
    background-color: #57bca5;
    color: #fff;
    text-decoration:  none;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-book-button i {
    font-size: 20px;
}

.add-book-button:hover {
    background-color: rgba(255,255,255,0.7);
    color: #57bca5;
}

.book-list {
    margin-top: 20px;
}

.book-item {
    font-style: italic;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    background-color: #eaf7eb;
    border-radius: 5px;
}

.book-item img {
    width: 100px;
    height: 150px;
    margin-right: 10px;
}

.book-item h3 {
    font-style: italic;
    margin: 0;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.book-item .buttons {
    margin-left: auto;
}

.book-item .buttons button {
    margin-left: 5px;
    padding: 8px;
    border: none;
    background-color: #57bca5;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    font-style: italic;
}

.book-item .buttons button:hover {
    background-color: #44997e;
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
    background-color: #57bca5;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
}

/*a {
    background-color: rgb(182, 245, 175);
}*/

.pi {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-style: italic;
    color: black;
    text-align: right;
    padding: 10px 20px;
    font-size: 16px;
    text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
}

/*.add-book-text {
    margin-left: 10px;
    font-style: italic;
}*/

.buttons {
    border: none;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-style: italic;
    padding: 10px 20px;
    font-size: 16px;
    text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
}

.buttons:hover {
    background-color: #44997e;
}
 .back-arrow {
    text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 40px;
    color: green;
    cursor: pointer;
/*    background-color: rgba(255,255,255,0.7);*/
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
            margin-bottom: 10px;
}
.logout-button {
  position: relative;
  bottom: 25px; /* Ajustez la valeur de positionnement vertical */
 right: -780px; /* Ajustez la valeur de positionnement horizontal */
}
.logout-button:hover {
        color: red;
        text-decoration: none;
        text-shadow: 2px 2px 4px #000000;
}
.section-titre {
    font-size: 25px;
    font-weight: bold;
    margin-top : -50px;
    font-family: Geneva;
    color: darkgreen;
}
.disconnect-text {
  opacity: 0;
  transition: opacity 0.3s;

}

.logout-button:hover .disconnect-text {
  opacity: 1;
}
.tooltip {
  position: absolute;
/*  z-index: 1;*/
  display: none;
  padding: 2px 2px;
  border-radius: 2px;
  margin-top: 35px;
  right: -10px;
  text-align: center;
/*  background-color: rgba(255,255,255,0.7);*/
  color: #57bca5;
  font-size: 14px;
}

.add-book-button:hover .tooltip {
  display: inline-block;
     /*background-color: #57bca5;
    color: #fff;*/
    color: #57bca5;
    text-decoration:  none;

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
.details {
        text-decoration: none;
        color: cadetblue;
    }

.details:hover {
        color: green;
        text-decoration: underline;
        text-shadow: 2px 2px 4px #000000;
}
    </style>

</head>
<body>
    <script>
    function goBack() {
        // window.location.href = "panneau admin.php";
        // window.history.back();
        window.location.reload(true);
        window.history.go(-1);
    }
    function showDisconnectText() {
  document.getElementById('disconnect-text').style.opacity = '1';
}

function hideDisconnectText() {
  document.getElementById('disconnect-text').style.opacity = '0';
}
function showTooltip(element) {
  var tooltip = element.getElementsByClassName("tooltip")[0];
  tooltip.style.display = "inline-block";
}

function hideTooltip() {
  var tooltips = document.getElementsByClassName("tooltip");
  for (var i = 0; i < tooltips.length; i++) {
    tooltips[i].style.display = "none";
  }
}
</script>
    <div class="form-group form-actions">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
         
        <!-- <span class="logout-text"><i><strong>Déconnexion</strong></i></span> -->
    <div class="container">
        <h1>Panneau d'administration des livres</h1>
        <div class="search-bar">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Rechercher un livre">
                <!-- value="<?php //echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" -->
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <a href="ajouter_un_livre.php" class="add-book-button" onmouseover="showTooltip(this)" onmouseout="hideTooltip()"><i class="fas fa-plus"></i><span class="tooltip"><b>Ajouter livre</b></span></a>    
        </div>
                 <a href="deconnexionAdmin.php" class="logout-button" onmouseover="showDisconnectText()" onmouseout="hideDisconnectText()"><i class="fas fa-sign-out-alt"></i> <span id="disconnect-text" class="disconnect-text"><br>Se déconnecter</span></a>
<?php
    // Inclure le fichier de connexion
    require('connexion_bd.php');
    try {
             // Recherche du livre en fonction des critères saisis
            if(isset($_GET['search'])){
            $books = array();
            $search = $_GET['search'];
            if(!empty($search)){
            // Requête préparée pour empêcher les attaques par injection SQL
            $stmt = $conn->prepare("SELECT * FROM livre WHERE titre LIKE :search OR auteur LIKE :search OR catégorie LIKE :search");
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($books) > 0) {
            // Affichage des résultats de recherche
            echo " <center><h2 class=\"section-titre\"><br><br><b><u>Résultats de la recherche :</u></b></h2></center>";
            echo "<div class='book-list'>";
            foreach($books as $book) {
                echo "<div class='book-item'>";
                echo "<a href='" . $book['contenu'] . "'><img src='" . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') . "' alt='Image du livre'></a>";
                echo "<div>";
                echo "<h3>" . htmlspecialchars(ucwords(strtolower($book['titre'])), ENT_QUOTES, 'UTF-8') . "</h3>";
                echo "<p>Auteur: " . htmlspecialchars(ucwords(strtolower($book['auteur'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<p>Catégorie: " . htmlspecialchars(ucwords(strtolower($book['catégorie'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $book['id_liv'] . "'>Voir détails</a>";
                echo "</div>";
                echo "<div class='buttons'>";
                echo "<button onclick='deleteBook(" . $book['id_liv'] . ")'><i><u>Supprimer</u></i></button>";
                echo "<button onclick='editBook(" . $book['id_liv'] . ")'><i><u>Modifier</u></i></button>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
            }else if(count($books) == 0) {
                // Requête préparée pour empêcher les attaques par injection SQL
                $stmt = $conn->prepare("SELECT * FROM livre");
                 $stmt->execute();
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 echo " <center><h2 class=\"section-titre\"><br><br><b><u>Résultats de la recherche :</u></b></h2></center>";
                $error = "Aucun livre trouvé.";
                echo "<span style=\"color: green; font-size: 18px;font-style: italic;\"> $error</span><hr>";
                // Affichage des résultats de recherche
            echo "<div class='book-list'>";
            foreach($books as $book) {
                echo "<div class='book-item'>";
                echo "<a href='" . $book['contenu'] . "'><img src='" . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') . "' alt='Image du livre'></a>";
                echo "<div>";
                echo "<h3>" . htmlspecialchars(ucwords(strtolower($book['titre'])), ENT_QUOTES, 'UTF-8') . "</h3>";
                echo "<p>Auteur: " . htmlspecialchars(ucwords(strtolower($book['auteur'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<p>Catégorie: " . htmlspecialchars(ucwords(strtolower($book['catégorie'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $book['id_liv'] . "'>Voir détails</a>";
                echo "</div>";
                echo "<div class='buttons'>";
                echo "<button onclick='deleteBook(" . $book['id_liv'] . ")'><i><u>Supprimer</u></i></button>";
                echo "<button onclick='editBook(" . $book['id_liv'] . ")'><i><u>Modifier</u></i></button>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
     }else{
    //            $search = isset($_GET['search']) ? $_GET['search'] : '';
    //            $books = array();
            // Requête préparée pour empêcher les attaques par injection SQL
            $stmt = $conn->prepare("SELECT * FROM livre WHERE titre LIKE :search OR auteur LIKE :search OR catégorie LIKE :search");
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $error = '<br>Veuillez saisir le titre, auteur ou la catégorie de livre que vous voulez!!<br>';
            echo "<span style=\"color: red; font-size: 18px;font-style: italic;\"> $error</span><hr>";
            // Affichage des résultats de recherche
            echo "<div class='book-list'>";
            foreach($books as $book) {
                echo "<div class='book-item'>";
                echo "<a href='" . $book['contenu'] . "'><img src='" . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') . "' alt='Image du livre'></a>";
                echo "<div>";
                echo "<h3>" . htmlspecialchars(ucwords(strtolower($book['titre'])), ENT_QUOTES, 'UTF-8') . "</h3>";
                echo "<p>Auteur: " . htmlspecialchars(ucwords(strtolower($book['auteur'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<p>Catégorie: " . htmlspecialchars(ucwords(strtolower($book['catégorie'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $book['id_liv'] . "'>Voir détails</a>";
                echo "</div>";
                echo "<div class='buttons'>";
                echo "<button onclick='deleteBook(" . $book['id_liv'] . ")'><i><u>Supprimer</u></i></button>";
                echo "<button onclick='editBook(" . $book['id_liv'] . ")'><i><u>Modifier</u></i></button>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
    }else{
             // Recherche du livre en fonction des critères saisis
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $books = array();
            // Requête préparée pour empêcher les attaques par injection SQL
            $stmt = $conn->prepare("SELECT * FROM livre WHERE titre LIKE :search OR auteur LIKE :search OR catégorie LIKE :search");
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Affichage des résultats de recherche
            echo "<div class='book-list'>";
            foreach($books as $book) {
                echo "<div class='book-item'>";
                echo "<a href='" . $book['contenu'] . "'><img src='" . htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') . "' alt='Image du livre'></a>";
                echo "<div>";
                echo "<h3>" . htmlspecialchars(ucwords(strtolower($book['titre'])), ENT_QUOTES, 'UTF-8') . "</h3>";
                echo "<p>Auteur: " . htmlspecialchars(ucwords(strtolower($book['auteur'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<p>Catégorie: " . htmlspecialchars(ucwords(strtolower($book['catégorie'])), ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<a class=\"details\" href='details_livre.php?id_liv=" . $book['id_liv'] . "'>Voir détails</a>";
                echo "</div>";
                echo "<div class='buttons'>";
                echo "<button onclick='deleteBook(" . $book['id_liv'] . ")'><i><u>Supprimer</u></i></button>";
                echo "<button onclick='editBook(" . $book['id_liv'] . ")'><i><u>Modifier</u></i></button>";
                echo "</div>";
                echo "</div>";
            }
        }
            echo "</div>";
    } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
   }
?>

    </div>

<script>
        // Fonction pour supprimer un livre
        function deleteBook(bookId) {
            if (confirm("Voulez-vous vraiment supprimer ce livre ?")) {
                // Appeler un script PHP pour supprimer le livre de la base de données
                window.location.href = "supprimer_livre.php?id=" + encodeURIComponent(bookId);
            }
        }

        // Fonction pour modifier un livre
        function editBook(bookId) {
            if (confirm("Voulez-vous vraiment modifier ce livre ?")) {
            // Rediriger vers la page de modification du livre en fonction de son ID
            window.location.href = "modifier_livre.php?id=" + encodeURIComponent(bookId);
        }
    }
    </script>
<?php

    //Fermeture de connexion
    $conn = null;
    }

?>
</body>
</html>