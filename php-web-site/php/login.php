<?php
/* =========================================================

  * php page log in
  * in relation with gordan_kranjcic/login.php

===========================================================*/
require_once("classBase.php");
require_once("classLog.php");
require_once("function.php");

$db = new Baza();
$db->connect();

if(isset($_GET['logoff']))
{
    Log::upisiLog("logs/logovanja.txt", "Uspešna odjava korisnika {$_SESSION['users_name']} - poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
    destroySession();
    header("location: index.php");
    
}

/* checking if form for log in is submit, if it not show welcome message */
if(isset($_POST["users_email"]) AND isset($_POST["users_password"]))
{

  $username = $_POST["users_email"];
  $password = $_POST["users_password"];

  /* checking if input fields are empty strings, if it is show message */
  if( $username != "" AND $_POST["users_password"] != "")
  {

    /* checking if strings have some characters that are not allowed, if thay have show message - validString function */
    if(validString($username) and validString($password))
    {

      $sql = "SELECT * FROM users WHERE users_email = '{$username}' LIMIT 1";

      /* checking if users email exists in database, if not exists show message */
      $result = $db->query($sql);
      if( $db->num_rows($result) == 1)
      {

        $row = $db->fetch_object($result);

        /* checking if users password is valid, if it is not show message */
        if( $password == $row->users_password )
        {

          /* users is loged in and create SESSION - createSession function  */
          createSession($row->users_id, $row->users_name, $row->users_lastname, $row->users_status, $row->users_email);
          Log::upisiLog("logs/logovanja.txt", "{$_SESSION['users_name']} se uspešno ulogovao - poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
          header("location: index.php"); 
              
        }
        else
        {
          $response = "Nije ispravna E-mail adresa ili lozinka za korisnika <b>" .$username. "</b>";

          Log::upisiLog("logs/logovanja.txt", "Pogrešna lozinka {$username} - otkucana lozinka je {$password}, poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
        }
      }
      else
      {
        $response = "Nije ispravna E-mail adresa ili lozinka za korisnika <b>" .$username. "</b>";

        Log::upisiLog("logs/logovanja.txt", "Pogrešno korisničko ime {$username} - poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
      }
    }
    else
    {
      $response = "E-mail adresa ili lozinka sadrže nedozvoljene karaktere";
      
      Log::upisiLog("logs/logovanja.txt", "Nedozvoljeni karakteri pri logovanju - poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
    }
  }
  else
  {
    $response = "Niste popunili sva polja. Sva polja su obavezna!!";
  }

}
else 
{
  $response = "Dobrodošli na stranicu za logovanje.";
}

?>