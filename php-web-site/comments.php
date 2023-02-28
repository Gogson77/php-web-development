<?php
$response = "";
session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");
require_once("php/comments.php");

$db = new Baza();
$db->connect();

if(!login())
{
  echo "<p>Morate biti ulogovani da biste mogli da pristupite ovoj stranici. Molimo Vas, vratite se nazad</p>";
  echo "<p><a href='index.php'>Nazad</a></p>";
  exit();
}

if($_SESSION['users_status'] != "Administrator")
{
    echo "Nemate ovlašćenja da pristupite ovoj stranici. Molimo Vas, ulogujte se sa ovlaščenim statusom da biste mogli da pristupite ovoj stranici";
    echo "<p><a href='login.php'>Log In</a></p>";
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>
  <meta charset="UTF-8">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&display=swap&subset=latin-ext" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">

  <title>No LIES | Komentari</title>
</head>

<body>

  <div class="container">

    <!--=====================  
      HEADER SECTION
    =======================-->
    <?php

    include_once("includes/header.php");

    ?>
		
    <!--=====================  
      NAVBAR SECTION
    =======================-->
    <?php

      include_once("includes/navbar.php");

    ?>

    <!--=====================  
      MAIN SECTION
    =======================-->
		<main class="main">

      <section class="section">

        <h1>Komentari</h1>
          <?php

            /* =========================================================
              * showing comments that have to be aproved or delete with default aprove coloumn 1
              * link for aprove or delete comments
              * only for Administrator
            ===========================================================*/
            $html = "";
            $sql = "SELECT * FROM comments_view WHERE aproved = 1 ORDER BY comments_created DESC";
            $result = $db->query($sql);
            echo $response;
            if($db->num_rows($result) != 0) {

                while($row = $db->fetch_object($result)) {

                  $valid_date = date( "d.m.Y H:i:s", strtotime($row->comments_created));
                  $html .= "<div class='comments'>";
                  $html .= "<p>$row->users_name $row->users_lastname $row->users_email</p>";
                  $html .= "<p>$row->comments_body</p>";
                  $html .= "<p>$valid_date</p>";
                  $html .= "<p><a href='comments.php?function=aprove&comments_id=$row->comments_id'>Odobri</a> | <a href='comments.php?function=delete&comments_id=$row->comments_id'>Obriši</a></p>";
                  $html .= "</div>";
      
              }

            }
            else
            {
              $html .= "<p>Nemate komentare za odobravanje!!</p>";
            }
            echo $html;
            
          ?>

      </section>
        


        <!--=====================  
          SIDEBAR SECTION
        =======================-->
        <?php

        include_once("includes/sidebar.php");

        ?>
		
		</main>
		

		<!--=====================  
      FOOTER SECTION
    =======================-->
    <?php

    include_once("includes/footer.php");

    ?>
		
	
	
	</div>
  <!-- end container -->

</body>

</html>