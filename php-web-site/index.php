<?php

session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");

$db = new Baza();
$db->connect();


?>

<!DOCTYPE html>
<html lang="sr">

<head>
  <meta charset="UTF-8">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&display=swap&subset=latin-ext" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">

  <title>No LIES | Naslovna</title>
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

          <h1>Naslovna</h1>
          <?php

            $html = "";
            $sql = "SELECT * FROM news_view WHERE active = 1 ORDER BY news_created DESC";
            $result = $db->query($sql);

            while($row=$db->fetch_object($result)) {

              $valid_date = date( "d.m.Y H:i:s", strtotime($row->news_created));

              $html .= "<img src='images/$row->news_id.jpg' alt='NEWS$row->news_id'>";
              $html .= "<h3>$row->news_title</h3>";
              $html .= "<p>";
              $words = explode(" ", $row->news_body);

              for( $i = 0; $i < 20; $i++) {
                  $html .= $words[$i]." ";
              }

              $html .= "... <a href='news.php?single_news=$row->news_id'>Pročitaje više</a>";
              $html .= "</p>";
              $html .= "<p>Autor: <a href='news.php?author=$row->users_id'>$row->users_name $row->users_lastname</a> | <a href='news.php?category=$row->categories_name'>$row->categories_name</a> | $valid_date</p>";
          
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