<?php require_once('../connexion.php');?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard...</title>
<link rel="stylesheet" href="login&Tb.css">
<style>
	

.photoar{
	width: 130px;height: 100px;border-radius: 5%;border: 1px solid;
} 
	</style>
</head>

<body>
<p><h1><b>Category and Keyword ...</b></h1>
<?php 
$req="select * from categorie";
$req1="select * from mot_cle";

$res=mysqli_query($conn,$req);
$res1=mysqli_query($conn,$req1);
?>
</p>
<table width="100%" border="1">
  <tbody>
    <tr>
      <th>Category Id</th>
      <th>Category Name</th>
     
    </tr>
    
   
	<?php
	while($row=mysqli_fetch_assoc($res))
	{
	?>
	   
    <tr>
      <td><?php echo $row['ID_categorie']; ?></td>
      <td><?php echo $row['Nom_categorie']; ?></td>
      
    
    <?php } ?>
      </tbody>
      </table>
      <table width="100%" border="1">
  <tbody>
    <tr>
    <th>Keyword Id</th>
      <th>Keyword</th>
    </tr>
    
	<?php
    while($row1=mysqli_fetch_assoc($res1))
    {
    ?>
      <td><?php echo $row1['ID_mot_cle']; ?></td>
      <td><?php echo $row1['Libelle']; ?></td>
  </tr>
  <?php } ?>
  </tbody>
</table>

<p><h1><b>List of Articles ...</b></h1>
 <?php
	
	$reqselect="select * from article
  INNER JOIN Categorie ON Article.Categorie_ID = Categorie.ID_categorie
  INNER JOIN Administrateur ON Article.Administrateur_ID = Administrateur.ID_admin
  INNER JOIN mot_cle ON Article.Mot_cle_ID = mot_cle.ID_mot_cle
  ";

	$resultat=mysqli_query($conn,$reqselect);
	
	$nbr=mysqli_num_rows($resultat);
	echo "<p><b> ".$nbr."</b> Articles</p>";
	  ?>
	</p>
	<p><a href="Ajouter.php"><img src="../images/add.jpg" width="50px" height="50px"></a></p>
<table width="100%" border="1">
  <tbody>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Category</th>
      <th>Keyword</th>
      <th>Photo</th>
      <th>Admin</th>
      <th>Publication date</th> 
      <th>Delete</th>
      <th>modify</th>
    </tr>
    
   
	<?php
	while($ligne=mysqli_fetch_assoc($resultat))
	{
	?>
	   
    <tr>
      <td><?php echo $ligne['ID_article']; ?></td>
      <td><?php echo $ligne['Titre_article']; ?></td>
      <td><?php echo $ligne['Nom_categorie']; ?></td>
      <td><?php echo $ligne['Libelle']; ?></td>
      <td><img class="photoar"  src="<?php echo $ligne['image_article']; ?>"></td>
      <td><?php echo $ligne['Nom_admin'] ." " .$ligne['Prenom_admin']; ?></td>
      <td><?php echo $ligne['DatePubli_article']; ?></td>
      <td><a href="supprimer.php?supar=<?php echo $ligne['ID_article']; ?>"><img src="../images/remov.jpg" width="50px" height="50px"></a></td>
      <td><a href="modifier.php?mod=<?php echo $ligne['ID_article']; ?>"><img src="../images/modify.jpg" width="50px" height="50px"></a></td>

    </tr>
    <?php } ?>
  </tbody>
</table>

<p><h1><b>List of Admins ...</b></h1>
 <?php
	
	$req2="select * from administrateur ";

	$res2=mysqli_query($conn,$req2);
	
	$nbr1=mysqli_num_rows($res2);
	echo "<p><b> ".$nbr1."</b> Admins</p>";
	  ?>
	</p>
	<p><a href="Ajouter_admin.php"><img src="../images/add.jpg" width="50px" height="50px"></a></p>
<table width="100%" border="1">
  <tbody>
    <tr>
      <th>ID</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Email</th>
      <th>Password</th> 
      <th>Delete</th>
      <th>modify</th>
    </tr>
    
   
	<?php
	while($ligne1=mysqli_fetch_assoc($res2))
	{
	?>
	   
    <tr>
      <td><?php echo $ligne1['ID_admin']; ?></td>
      <td><?php echo $ligne1['Nom_admin']; ?></td>
      <td><?php echo $ligne1['Prenom_admin']; ?></td>
      <td><?php echo $ligne1['AdresseEmail_admin']; ?></td>
      <td><?php echo $ligne1['MotDePasse_admin']; ?></td>
      <td><a href="supprimer_admin.php?supad=<?php echo $ligne1['ID_admin']; ?>"><img src="../images/remov.jpg" width="50px" height="50px"></a></td>
      <td><a href="modifier_admin.php?mod=<?php echo $ligne1['ID_admin']; ?>"><img src="../images/modify.jpg" width="50px" height="50px"></a></td>

    </tr>
    <?php } ?>
  </tbody>
</table>


</body>
</html>