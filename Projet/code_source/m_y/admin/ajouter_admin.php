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
		<h2 align="center">Add New Admin</h2>
                
                <label><b>Last Name</b></label>
                <input class="zonetext" type="text" placeholder="Put a last name" name="last" required>

                <label><b>First Name</b></label>
                <input class="zonetext" type="text" placeholder="Put a first name" name="first" required>

                <label><b>Email</b></label>
                <input class="zonetext" type="text" placeholder="Put an email address" name="email" required>
                
				<label><b>Password</b></label>
                <input class="zonetext" type="password" placeholder="Put the password" name="pw" required>

                <input type="submit" id='submit' class="submit" name="btadd" value='Add' >
                
		<p><a href="accuiel.php" class="submit" >Back to Articles & Admins</a></p>
                
                <label style="text-align: center;color: #360001;">
                	
                	<?php
	if(isset($_POST['btadd']))
	{
		$last=mysqli_real_escape_string($conn,$_POST['last']);
		$first=mysqli_real_escape_string($conn,$_POST['first']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $n=0; $m=0;
if (empty($email)) {
    echo "<br>Email address is required.<br>"; exit();
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<br>The email address is invalid.<br>";
} elseif (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
    echo "<br>The email address is not in a valid format.<br>";
} else { $n=1; }

        $psw = mysqli_real_escape_string($conn, $_POST['pw']);

if (empty($psw)) {
    echo "<br>Password is required.<br>";
} elseif (strlen($psw) < 8) {
    echo "<br>The password must contain at least 8 characters.<br>";
} elseif (!preg_match("/[a-z]/", $psw) || !preg_match("/[A-Z]/", $psw) || !preg_match("/[0-9]/", $psw) || !preg_match("/[\*\.\,\/\\\[\]\'\@]/", $psw))
{
    echo "<br>The password must contain at least one lowercase letter, one uppercase letter and one number and one characters like *, ., /, \, [], ', @.<br>";
} else { $m=1; }

if($n==$m){
	  $add= "INSERT INTO administrateur (Nom_admin, Prenom_admin, AdresseEmail_admin,
	   MotDePasse_admin) 
	  VALUES ('$last', '$first', '$email', '$psw')";

		$resultat=mysqli_query($conn,$add);

if($resultat)
{
	echo "Inserting validated data";
}else{
	echo "Failed to insert data!";
}
  
  }	}
	?>
                 </label>
	</form>
</div>

</body>
</html>