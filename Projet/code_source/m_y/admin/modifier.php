<?php require_once('../connexion.php');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>modify Article</title>
<link rel="stylesheet" href="login&Tb.css">

</head>

<body>
<div id="container">
	
	<form name="formadd" action="" method="post" class="formulaire" enctype="multipart/form-data">
		<h2 align="center">Update an article</h2>
                
				<label><b>Title</b></label>
                <input class="zonetext" type="text" placeholder="Put The Title" name="titl" required>

                <label><b>Content</b></label>
                <input class="zonetext" type="text" placeholder="Add content" name="cont" required>

               	<label><b>Publication date</b></label>
            	<input class="zonetext" type="date" name="txtdate" required>
                
				<label><b>Admin ID</b></label>
                <input class="zonetext" type="number" placeholder="Put your id" name="adid" required>

				<label><b>Category ID</b></label>
                <input class="zonetext" type="number" placeholder="Put category id" name="caid" required>	

				<label><b>Keyword ID</b></label>
                <input class="zonetext" type="number" placeholder="Put keyword id" name="keyid" required>

				<label><b>Photo</b></label>
                <input class="zonetext" type="text" placeholder="choisir une photo" name="txtphoto" required>
                
                <input type="submit" id='submit' class="submit" name="btmod" value='Update' >
                
		<p><a href="accuiel.php" class="submit" >Back to Articles & Admins</a></p>
                
                <label style="text-align: center;color: #360001;">
                	
                	<?php
	if(isset($_POST['btmod']))
	{
		$titre=mysqli_real_escape_string($conn,$_POST['titl'] );
		$conte=mysqli_real_escape_string($conn,$_POST['cont'] );
		$dapu=$_POST['txtdate'];
		$adid=$_POST['adid'];
		$caid=$_POST['caid'];
		$keyid=$_POST['keyid'];
		$img =$_POST['txtphoto'];
		
		$modifier=(int) ($_GET["mod"]);
		
  	$sql = "UPDATE article SET Titre_article = '$titre', Contenu_article = '$conte' ,
	 DatePubli_article ='$dapu',Administrateur_ID ='$adid',Categorie_ID ='$caid',
	 Mot_cle_ID ='$keyid',image_article ='$img'
	 WHERE ID_article ='".$_GET["mod"]."'";
		$resultat=mysqli_query($conn,$sql);

if($resultat)
{
	echo "Update of validated data";
}else{
	echo "Failed to modify data!";
}
  	
  }
  
		
		
	?>
             	
                	
                </label>
	</form>
	
	
	
</div>



   
 
</body>
</html>