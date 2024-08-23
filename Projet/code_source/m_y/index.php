<?php
require_once('connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
    <script src="script.js"></script>
    <title>M & Y articles</title>
</head>
<body>
<header>
    <a href="http://localhost/m_y/" class="logo"><span> M & Y</span><br>articles</a>
    <div class="menuToggle" onclick="toggleMenu();"></div>
    <ul class="navbar">
        <li><a href="http://localhost/m_y/#banniere" onclick="toggleMenu();">Home</a></li>
        <li><a href="http://localhost/m_y/#apropos" onclick="toggleMenu();">About</a></li>
        <li><a href="http://localhost/m_y/#menu" onclick="toggleMenu();">Menu</a></li>
        <li><a href="http://localhost/m_y/admin" target="_blank" onclick="toggleMenu();">Admin</a></li>
    </ul> 
    <div class="search">
        <form name="search" method="post" action="">
            <input class="srch" type="search" name="motcle" placeholder="Type To text">
            <a href="http://localhost/m_y/index.php#menu" > <button name="btsubmit" class="btn">Search</button></a>
        </form>
    </div>
</header>
<section class="banniere" id="banniere">
    <div class="contenu">
        <h2>WELCOME TO OUR WEB SITE</h2>
        <p>Discover captivating articles that ignite 
            curiosity and expand your horizons.<br>
            Welcome to our website, where knowledge awaits.</p>
    </div>
</section>
<section class="apropos" id="apropos">
    <div class="row">
        <div class="col50">
            <h2 class="titre-texte"><span>A</span> Propos De Nous</h2>
            <p class="about" > Welcome to our website! Here at <strong><span>M & Y </span></strong><strong>articles</strong> ,
                we are dedicated to providing you with engaging 
                and informative articles. Our team of passionate 
                writers and researchers is committed to delivering 
                high-quality content on a wide range of topics.
                Whether you're seeking the latest news, insightful analysis,
                helpful tips, or inspiring stories, you'll find it all here. 
                We believe in the power of knowledge and aim to empower our 
                readers with valuable information that can enrich their lives. 
                Join us on this journey of exploration and discovery as we delve into 
                the world of captivating articles that are sure to inspire, educate, and entertain.
            </p>
        </div>
        <div class="col50">
            <div class="img">
                <img src="./images/kk.png" alt="image">
            </div>
        </div>
    </div>
</section>
<section class="menu" id="menu">
    <div class="titre">
        <h2 class="titre-texte"><span>M</span>enu</h2>
        <p>HERE YOU WILL FIND ALL THE ARTICLES THAT WE POST. </p>
    </div>
    <div class="contenu">
    <?php 
   if(isset($_POST['btsubmit'])){
        $mc=$_POST['motcle'];
        $reqSelect = "SELECT Article.ID_article,Article.Titre_article, Article.DatePubli_article,
         Categorie.Nom_categorie, Article.image_article , Administrateur.Nom_admin, Administrateur.Prenom_admin
        FROM Article
        INNER JOIN Categorie ON Article.Categorie_ID = Categorie.ID_categorie
        INNER JOIN Administrateur ON Article.Administrateur_ID = Administrateur.ID_admin
        INNER JOIN mot_cle ON Article.Mot_cle_ID = mot_cle.ID_mot_cle
        WHERE Categorie.Nom_categorie LIKE '%$mc%' OR Article.Titre_article LIKE '%$mc%'
         OR mot_cle.libelle LIKE '%$mc%'";

    } 
    else{
        $reqSelect="SELECT Article.ID_article,Article.Titre_article, Article.DatePubli_article, 
        Categorie.Nom_categorie, Article.image_article  , Administrateur.Nom_admin, Administrateur.Prenom_admin
        FROM Article
        INNER JOIN Categorie ON Article.Categorie_ID = Categorie.ID_categorie
        INNER JOIN Administrateur ON Article.Administrateur_ID = Administrateur.ID_admin ";  
    }
    $result = mysqli_query($conn, $reqSelect);
    $nbr=mysqli_num_rows($result);
   
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

while ($ligne = mysqli_fetch_assoc($result)) { 
    ?>
            <div class="box">
                <div class="imbox">
               
                <a href="article.php?article_id=<?php echo $ligne['ID_article']; ?>"> <img src="<?php echo $ligne['image_article']; ?>" ></a>
                </div>
                <div class="text">

                <h3><a href="article.php?article_id=<?php echo $ligne['ID_article']; ?>"><?php echo $ligne['Titre_article']; ?></a></h3>

            <?php   
                    echo "<br><p><strong>Category :</strong> " . $ligne['Nom_categorie'] . "</p>";
                    echo "<p><strong>Published by :</strong> " . $ligne["Nom_admin"] . " " . $ligne["Prenom_admin"] . "</p>";
                    echo "<p><strong>Publication date :</strong> " . $ligne["DatePubli_article"] . "</p>";
                ?>
                </div>
            </div>
    <?php }   ?>
       
    </div>
 </div>
<?php echo "<p><b> ".$nbr."</b> Articles</p><br>"; ?>
</section>


 <div class="copyright">
     <p>© copyright 2023 <a href="#">Yassine Zirh & Mohamed Skaf </a> All rights reserved</p>
 </div>
 
</body>
</html>