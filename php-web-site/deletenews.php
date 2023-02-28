<?php
$response = "";
session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");
require_once("php/deletenews.php");

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
    echo "Nemate ovlašćenja da pristupite ovoj stranici. Molimo Vas ulogujte se sa ovlaščenim statusom da biste mogli da pristupite ovoj stranici";
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

  <title>No LIES | Brisanje Vesti</title>
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

          <h1>Brisanje vesti</h1>
          <?php

              /* =========================================================
                * showing news that have to be delete with default active coloumn 1
                * link for delete news
                * only for Administrator
              ===========================================================*/
              echo $response;
              $html = "";
              $sql = "SELECT * FROM news_view WHERE active = 1 ORDER BY news_created DESC";
              $result = $db->query($sql);

              while($row=$db->fetch_object($result)) {

                $valid_date = date( "d.m.Y H:i:s", strtotime($row->news_created));
                $html .= "<div class='comments'>";
                $html .= "<h5>$row->news_title</h5>";
                $html .= "<p>";
                $words = explode(" ", $row->news_body);

                for( $i = 0; $i < 20; $i++) {
                    $html .= $words[$i]." ";
                }

                $html .= "...";
                $html .= "</p>";
                $html .= "<p>Autor: <a href='news.php?author=$row->users_id'>$row->users_name $row->users_lastname</a> | <a href='news.php?category=$row->categories_name'>$row->categories_name</a> | $valid_date | Vest broj: $row->news_id</p>";
                $html .= "<p><a href='deletenews.php?function=delete&news_id=$row->news_id'>Obriši vest</a>";
                $html .= "</div>";
            
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