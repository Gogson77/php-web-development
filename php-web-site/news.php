<?php
$response = "";
session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");
require_once("php/addcomment.php");

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

  <title>No LIES | Vesti</title>
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

          <?php
            /* this response is for showing message when user wants to add comments */
            echo "<h5>$response</h5>";

            if(isset($_GET['category'])) 
            {

              /* if user chose news by category either from navbar or link bellow the news - categoryNews function */
              $category = $_GET['category'];
              echo categoryNews($category, $db);

            }
            elseif (isset($_GET['single_news'])) {

              /* if user chose news on read more - singleNews function */
              $single_news = $_GET['single_news'];
              echo singleNews($single_news, $db);
            ?>

              <!-- form for add new comment -->
              <p>Ostavite komentar:</p>
              <form action="news.php?single_news=<?= $single_news ?>" method='POST'>
                  <textarea name="comments_body" id="comments_body" cols="65" rows="5" placeholder="Unesite tekst komentara"></textarea><br><br>
                  <button type='submit' class='btn'>Pošalji</button>
              </form><br><br>

            <?php 

              /* showing all aproved comments for chosen single news - newsComments function */ 
              echo newsComments($single_news, $db);
            
            }
            elseif (isset($_GET['author'])) {

              /* showing all news created by chosen author - authorsNews function */
              $authors = $_GET['author'];
              echo authorsNews($authors, $db);

            }
            else
            {
              echo "<h1>Ne možete da ovako pristupite stranici. Molimo Vas, vratite se nazad <br> <a href='index.php'>Nazad</a></h1>";
            }
            
              
              
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