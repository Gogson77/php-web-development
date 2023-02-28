<?php
/* =========================================================

  * php page registration
  * in relation with gordan_kranjcic/registration.php

===========================================================*/
require_once("function.php");
require_once("classBase.php");
require_once("classLog.php");

$db=new Baza();
$db->connect();

/* checking if form for registraion is submit, if it not show welcome message */
if( isset($_POST['users_name']) AND isset($_POST['users_lastname']) AND isset($_POST['users_email']) AND isset($_POST['users_password']) AND isset($_POST['users_repassword']))
{

    $users_name = $_POST['users_name'];
    $users_lastname = $_POST['users_lastname'];
    $users_email = $_POST['users_email'];
    $users_password = $_POST['users_password'];
    $users_repassword = $_POST['users_repassword'];
    $users_status = "Korisnik";

    /* checking if input fields are empty strings, if it is show message */
    if($users_name != "" AND $users_lastname != "" AND $users_email != "" AND $users_password != "" AND $users_repassword != "")
    {

      /* checking if strings have some characters that are not allowed, if thay have show message - validString function */
      if(validString($users_name) AND validString($users_lastname) AND validString($users_email) AND validString($users_password) AND validString($users_repassword))
      {

        $sql = "SELECT * FROM users WHERE users_email = '{$users_email}' LIMIT 1";
        $result = $db->query($sql);

        /* checking if users email exists in database, if exists show message */
        if($db->num_rows($result) != 1 )
        {

          /* checking if users password and repeated password are same, if is not show message */
          if( $users_password == $users_repassword )
          {

            /* user is registrated, inserting users datas in database */
            $sql="INSERT INTO users (users_name, users_lastname, users_email, users_password, users_repassword, users_status) VALUES ('{$users_name}', '{$users_lastname}', '{$users_email}', '{$users_password}','{$users_repassword}', '{$users_status}')";
            $db->query($sql);

            Log::upisiLog("logs/registracija.txt", "$users_name $users_lastname $users_email je uspešno kreirao nalog kao novi korisnik poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
            $response = "Uspešno ste kreirali nalog. Hvala Vam na poverenju!";

          }
          else
          {
            $response = "Lozinka i ponovljena lozinka se ne poklapaju!!";
          }
        }  
        else
        {
          $response = "Korisnik sa E-mail adresom <b> " .$users_email. "</b> već postoji!!";
          
          Log::upisiLog("logs/registracija.txt", "$users_name $users_lastname je pokušao da se registruje sa postojećom E-mail adresom $users_email -  poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']); 
        }
      }
      else
      {
        $response = "U jednom od polja za unos postoje nedozvoljeni karakteri";
        Log::upisiLog("logs/registracija.txt", "Nedozvoljeni karakteri pri registraciji - poslato sa IP adrese - ".$_SERVER['REMOTE_ADDR']);
      } 
    }
    else
    {
      $response = "Niste uneli sve podatke. Svi podaci su obavezni!!";

    }
}  
else
{
  $response = "Dobrodošli na stranicu za registraciju!";
}
?>