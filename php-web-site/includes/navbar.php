
<nav class="nav">
  <ul>
    <li><a href="index.php">Naslovna</a></li>

    <!-- select categories from db and show in navbar  -->
    <?php
      $html = "";
      $sql = "SELECT * FROM categories";
      $result = $db->query($sql);
      while($row = $db->fetch_object($result)) {

          $html .= "<li><a href='news.php?category=$row->categories_name'>$row->categories_name</a></li>";

      }

    ?>

    <?php

      /* =========================================================
          * if user is login show users name lastname and status from SESSIONS
          * dropdown menu depends on users status
          * showing in navbar
      =========================================================== */
      if(login()) {

        $html .= "<li> <a href='#'>{$_SESSION['users_name']} ({$_SESSION['users_status']}) </a>";
          $html .= "<ul>";

            /*  dropdown for users status administrator  */
            if($_SESSION['users_status'] == "Administrator") {

              $html .= "<li><a href='addnews.php'>Dodaj novu vest</a></li>";
              $html .= "<li><a href='deletenews.php'>Obriši vest</a></li>";
              $html .= "<li><a href='comments.php'>Komentari</a></li>";
              $html .= "<li><a href='logs.php'>Logovi</a></li>";
              $html .= "<li><a href='login.php?logoff'>Odjava</a></li>";

            }
            else {

              /*  dropdown for users status korisnik  */
              $html .= "<li><a href='userscomments.php'>Vaši komentari</a></li>";
              $html .= "<li><a href='login.php?logoff'>Odjava</a></li>";

            }

          $html .= "</ul>";
        $html .= "</li>";
      }
      else 
      {
        /*  if user is not log in than show buttons for log in and registration in navbar */
        $html .= "<li><a href='login.php'>Log In</a></li>";
        $html .= "<li><a href='registration.php'>Registracija</a></li>";
      }

    echo $html;
    ?>

  </ul>
</nav>