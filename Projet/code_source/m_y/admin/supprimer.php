<?php require('../connexion.php');?>
<!doctype html>

<meta charset="utf-8">
<?php
 
if (isset($_GET['supar'])) {

	$sup=(int) ($_GET["supar"]);
	
    $reqDelete1="DELETE FROM article WHERE ID_article =".$sup;
    $reqDelete2="DELETE FROM comments WHERE article_id =".$sup;

    $result1 = mysqli_query($conn, $reqDelete1);
    $result2 = mysqli_query($conn, $reqDelete2);
	
    }
 
  if($reqDelete1&&$reqDelete2)
  {
    echo "<h2>The deletion was successful go back</h2><a href='accuiel.php'><img src=../images/99.jpg></a>" ;
  }
  else
  {
    echo"<h2>Deletion failed <a href='accuiel.php'><img src=../images/99.jpg></a>" ;
  }
?>