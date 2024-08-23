<?php require_once('connexion.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Article </title>    
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="comments.css">
    <script src="script.js"></script>
</head>
<body>
    <section class="back">
<header>
<a href="http://localhost/m_y/" class="logo"><span> M & Y</span><br>articles</a>
    <div class="menuToggle" onclick="toggleMenu();"></div>
    <ul class="navbar">
        <li><a href="http://localhost/m_y/#banniere" onclick="toggleMenu();">Home</a></li>
        <li><a href="http://localhost/m_y/#apropos" onclick="toggleMenu();">About</a></li>
        <li><a href="http://localhost/m_y/#menu" onclick="toggleMenu();">Menu</a></li>
        <li><a href="http://localhost/m_y/admin" target="_blank" onclick="toggleMenu();">Admin</a></li>
    </ul> 
</header>
<section>

<?php

if (isset($_GET['article_id'])) {
    $articleId = $_GET['article_id'];

    $selectArticleQuery = " SELECT * 
                            FROM Article 
                            INNER JOIN Categorie ON Article.Categorie_ID = Categorie.ID_categorie
                            INNER JOIN Administrateur ON Article.Administrateur_ID = Administrateur.ID_admin
                            INNER JOIN mot_cle ON Article.Mot_cle_ID = mot_cle.ID_mot_cle
                            WHERE ID_article = $articleId";
    $articleResult = mysqli_query($conn, $selectArticleQuery);

    if ($articleResult && mysqli_num_rows($articleResult) > 0) {
        $article = mysqli_fetch_assoc($articleResult);

        echo "<br><br><h1>" . $article['Titre_article'] . "</h1>"; ?>

        <img src="<?php echo $article['image_article']; ?>" >
        <section class="info" id="info" > 

<?php   
            echo "<p><strong>Catégorie: </strong>" . $article['Nom_categorie'] . "</p><br>";
            echo "<p><strong>Date de publication: </strong>" . $article['DatePubli_article'] . "</p><br>";
            echo "<p><strong>Publié par: </strong>" . $article['Nom_admin'] . 
            " " . $article['Prenom_admin'] . "</p>";
       
?>        </section>

<?php       
        echo "<div class='artivle'><p><span>" . $article['Contenu_article'] . "</span></p></div>";
    } else {
        echo "Article not found.";
    }
} else {
    echo "Invalid article ID.";
}


?>
</section>
</section>
<section class="comments">
<script src="comments.js"></script>
<script>
			new Comments({
				article_id: <?php echo $articleId; ?>
			});
			</script>
</section>            
<div class="copyright">
<p>© copyright 2023 <a href="#">Yassine Zirh & Mohamed Skaf </a> All rights reserved</p>
 </div>
</body>
</html>



