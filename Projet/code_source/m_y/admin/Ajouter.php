<?php require_once('../connexion.php');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="login&Tb.css">

</head>

<body>
<div id="container">
	
	<form name="formadd" action="" method="post" class="formulaire" enctype="multipart/form-data">
		<h2 align="center">Add New Article</h2>
                
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
                
                <input type="submit" id='submit' class="submit" name="btadd" value='Add' >
                
		<p><a href="accuiel.php" class="submit" >Back to Articles & Admins</a></p>
                
                <label style="text-align: center;color: #360001;">
                	
                	<?php
	if(isset($_POST['btadd']))
	{
		$titre=mysqli_real_escape_string($conn,$_POST['titl']);
		$conte=mysqli_real_escape_string($conn,$_POST['cont']);
		$dapu=$_POST['txtdate'];
		$adid=$_POST['adid'];
		$caid=$_POST['caid'];
		$keyid=$_POST['keyid'];
	  	$img =$_POST['txtphoto'];
		
	  $add= "INSERT INTO article (Titre_article, Contenu_article, DatePubli_article,
	   Administrateur_ID, Categorie_ID, Mot_cle_ID, image_article) 
	  VALUES ('$titre', '$conte', '$dapu', '$adid', '$caid', '$keyid', '$img')";

		$resultat=mysqli_query($conn,$add);

if($resultat)
{
	echo "Inserting validated data";
}else{
	echo "Failed to insert data!";
}
  	
  }
	?>
                 </label>
	</form>
</div>

</body>
</html>