<?php
/* =========================================================

  * php page for adding news, allowed only for Administrator
  * in relation with gordan_kranjcic/addnews.php

===========================================================*/
$respone = "";
session_start();
require_once("classBase.php");
require_once("classLog.php");
require_once("function.php");

$db = new Baza();
$db->connect();

/* checking if is submit form for add news, contain binary files - if it is not show message */ 
if(isset($_POST['news_title']) AND isset($_POST['news_body']) AND isset($_POST['category']) AND isset($_FILES['news_image']['name']))
{

  
  $news_title = $_POST['news_title'];
  $news_body = $_POST['news_body'];
  $category = $_POST['category'];
  $image = $_FILES['news_image']['name'];
  $users_id = $_SESSION['users_id'];

  /* checking if input fields are empty strings, if it is show message */ 
   if($news_title != "" AND $news_body != "" AND $category != "0" AND $image != "")
  {

    /* inserting new news into database, files are uploaded in folder images */
    $sql = "INSERT INTO news (news_title, news_body, users_id, categories_id) VALUES ('{$news_title}', '{$news_body}', '{$users_id}', '{$category}')";
    $res=$db->query($sql);

    /* image is getting name same as id of new news */
    $image = $db->insert_id($db);

    /* moving image from tmp folder in folder images */
    move_uploaded_file($_FILES['news_image']['tmp_name'],"images/$image.jpg");
    $response = "Uspešno ste dodali novu vest!!";
    
    Log::upisiLog("logs/vesti.txt", "{$_SESSION['users_name']} čiji je id {$_SESSION['users_id']}  je dodao novu vest {$news_title}");
    
  }
  else
  {
    $response = "Niste popunili sva polja. Sva polja su obavezna!!";
  }
 
}
else 
{
  $response = "Dobrodošli na stranicu za dodavanje vesti.";
}

?>