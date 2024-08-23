<?php require_once('../connexion.php');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="login&Tb.css">
<style>
	body{
    background: #BB652D;
}

	
	</style>
</head>

<body>

<div id="container">
            
            <form action="" method="post" class="formulaire">
                <h1>&emsp;Login</h1>
                
                <label><b>Email</b></label>
                <input class="zonetext" type="text" placeholder="Put your email" name="txtlogin" required>

                <label><b>password</b></label>
                <input class="zonetext" type="password" placeholder="Put your password" name="txtpw" required>

                <input type="submit" id='submit' class="submit" name="btlogin" value='LOGIN' >
                 <?php 
  if(isset($_POST['btlogin'])){
$req="select * from administrateur where AdresseEmail_admin='".$_POST['txtlogin']."' and MotDePasse_admin='".$_POST['txtpw']."'";
if($resultat=mysqli_query($conn,$req)){
$ligne=mysqli_fetch_assoc($resultat);
if($ligne!=0)
{
session_start();
$_SESSION['login']= $_POST['txtlogin'];
$_SESSION['admin_loggedin'] = true;
	header("location:index.php");
}
else {
echo "<font color='#F0001D'>Email or password is invalid!!!!</font>";
} } }
?>
            </form>
        </div>
</body>
</html>