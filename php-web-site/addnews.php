<?php
$response = "";

require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");
require_once("php/addnews.php");

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

  <title>No LIES | Dodavanje vesti</title>
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

        <h1>Dodavanje vesti</h1>
        
        <form action="addnews.php" method="POST" enctype="multipart/form-data">

          <input type="text" name="news_title" id="news_title" placeholder="Unesite naslov vesti"><br><br>
          <textarea name="news_body" id="news_body" cols="50" rows="15" placeholder="Unesite tekst vesti"></textarea><br><br>

          <select name="category" id="category">
            <option value="0">--Izaberite kategoriju za vest</option>
            <?php
              $sql = "SELECT * FROM categories";
              $result = $db->query($sql);
              while($row = $db->fetch_object($result)) {

                  echo  "<option value='$row->categories_id'>$row->categories_name</option>";

              }
            ?>
          </select><br><br>

          <input type="file" name="news_image" id="news_image"><br><br>
          <button class="btn">Pošalji</button>

        </form><br><br>

        <div> <?php echo $response ?> </div>

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