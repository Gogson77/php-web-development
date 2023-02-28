<?php
$response = "";

session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");
require_once("php/registration.php");

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

  <title>No LIES | Registracija</title>
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

          <h1>Registrujte se</h1>
          
          <form action="registration.php" method="POST">

            <input type="text" name="users_name" id="users_name" placeholder="Unesite svoje ime"><br><br>
            <input type="text" name="users_lastname" id="users_lastname" placeholder="Unesite svoje prezime"><br><br>
            <input type="email" name="users_email" id="users_email" placeholder="Unesite svoju E-mail adresu"><br><br>
            <input type="password" name="users_password" id="users_password" placeholder="Unesite svoju lozinku"><br><br>
            <input type="password" name="users_repassword" id="users_repassword" placeholder="Ponovite lozinku"><br><br>
            <button type="submit" class="btn">Pošalji</button>

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