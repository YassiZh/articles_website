<?php require_once('../connexion.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Articles & Admins</title>
<link rel="stylesheet" href="login&Tb.css" type="text/css">

</head>

<body>
<div id="global">
<div id="profil">
<?php
	
	session_start();
	echo $_SESSION['login']."<br>";
	
	$req="select * from administrateur where AdresseEmail_admin='" . $_SESSION['login'] . "'";
	$resultat=mysqli_query($conn,$req);
	$ligne=mysqli_fetch_assoc($resultat);
	echo "<p><b>Hello " . $ligne['Nom_admin'] ." ". $ligne['Prenom_admin'] . "</b></p>" ;
	?>

	
<br>	
<a href="index.php"><img src="../images/99.jpg"></a>
</div>

	<div id="tableaubord">

	<?php include("tableauBord.php");?>
	</div>
</div>
</body>
</html>