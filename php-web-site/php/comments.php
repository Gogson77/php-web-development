<?php
/* =========================================================

  * php page for allow or delete ( update ) users comments, allowed only for Administrator
  * php page for delete ( update ) personal users comments
  * in relation with gordan_kranjcic/comments.php - only for Administrator
  * in relation with gordan_kranjcic/userscomments.php - for Users

===========================================================*/
$respone = "";
require_once("classBase.php");
require_once("classLog.php");
require_once("function.php");

$db = new Baza();
$db->connect();

/* check if is set parameter from URL, function and comments id - GET method */ 
if(isset($_GET['function']) AND isset($_GET['comments_id']))
{
    $function = $_GET['function'];
    $comments_id = $_GET['comments_id'];

    /* check type of function - aprove or delete */ 
    if($function == "aprove")
    {

        /* aproving comments - update aproved coloumn to 2, default is 1 */ 
        $sql = "UPDATE comments SET aproved = 2 WHERE comments_id = '$comments_id'";
        $db->query($sql);
        Log::upisiLog("logs/komentari.txt", "{$_SESSION['users_name']} je uspešno odobrio komentar sa id {$comments_id}");
        $response = "<p>Uspešno ste odobrili komentar!</p>";

    } 
    else
    {
        /* deleting comments - update aproved coloumn to 0, default is 1 */ 
        $sql = "UPDATE comments SET aproved = 0 WHERE comments_id = '$comments_id'";
        $db->query($sql);
        Log::upisiLog("logs/komentari.txt", "{$_SESSION['users_name']} je uspešno obrisao komentar sa id {$comments_id}");
        $response = "<p>Uspešno ste obrisali komentar!</p>";
    }
        
    
}
   

?>