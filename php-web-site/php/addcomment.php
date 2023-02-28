<?php
/* =========================================================

  * php page for adding comments from users for chosen news
  * in relation with gordan_kranjcic/news.php with single news

===========================================================*/
$respone = "";
require_once("classBase.php");
require_once("classLog.php");
require_once("function.php");

$db = new Baza();
$db->connect();

/* checking if is submit form for adding comments */
if(isset($_POST['comments_body']))
{

  /* checking if user is loged in, if it is not show message */
  if(login()) {
    
    $comments_body = $_POST['comments_body'];
    $news_id = $_GET['single_news'];
    $users_id = $_SESSION['users_id'];

    /* checking if textarea comment is empty string, if it is show message */
    if($comments_body != "")
    {

      /* inserting users comment into database - show success message for user */
      $sql = "INSERT INTO comments (comments_body, users_id, news_id) VALUES ('{$comments_body}', '{$users_id}', '{$news_id}')";
      $res=$db->query($sql);
      $response = "Uspešno ste dodali nov komentar, komentar će postati vidljiv nakon što ga odobri administrator!!";
      
      Log::upisiLog("logs/komentari.txt", "{$_SESSION['users_name']} čiji je id {$_SESSION['users_id']}  je dodao nov komentar za vest sa id {$news_id} -{$comments_body}");
      
    }
    else
    {
      $response = "Niste popunili polje za komentar!!";
    }

  }
  else
  {
    $response = "Morate biti ulogovani da biste mogli da ostavite komentar!";
  }
}  


?>