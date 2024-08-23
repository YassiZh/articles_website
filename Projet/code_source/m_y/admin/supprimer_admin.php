<?php require('../connexion.php');?>
<!doctype html>

<meta charset="utf-8">
<?php
 
if (isset($_GET['supad'])) {

	$sup=(int) ($_GET["supad"]);
	
    $reqDelete="DELETE FROM administrateur WHERE ID_admin =".$sup;

    $result1 = mysqli_query($conn, $reqDelete);

	
    }
 
  if($reqDelete)
  {
    echo "<h2>The deletion was successful go back</h2><a href='accuiel.php'><img src=../images/99.jpg></a>" ;
  }
  else
  {
    echo"<h2>Deletion failed <a href='accuiel.php'><img src=../images/99.jpg></a>" ;
  }
?>