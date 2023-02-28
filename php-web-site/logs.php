<?php

session_start();
require_once("php/classBase.php");
require_once("php/classLog.php");
require_once("php/function.php");

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

  <title>No LIES | Logovi</title>
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

          <h1>Logovi</h1>

          <form action="logs.php" method="POST">
            <select name="logs" id="logs">
                <option value="0">--Izaberite log fajl--</option>
                <option value="logovanja.txt">Logovanja</option>
                <option value="komentari.txt">Komentari</option>
                <option value="registracija.txt">Registracija</option>
                <option value="vesti.txt">Vesti</option>
            </select><br><br>
                <button class="btn">Prikaži</button>
            </form><br><br>
            
            <?php
                if(isset($_POST['logs']))
                {
                    if($_POST['logs'] != "0") {

                        $filename="logs/".$_POST['logs'];

                        if(file_exists($filename))
                        {
                            $show=file_get_contents($filename);
                            $show=str_replace("\r\n", "<br>", $show);
                            echo $show;
                        }
                        else
                        { 
                            echo "<p>Ne postoji datoteka koju ste izabrali</p>";
                        }
                    }
                    else
                    {
                        echo "<p>Niste izabrali nijednu datoteku</p>";
                    }
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