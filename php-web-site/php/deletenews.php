<?php
/* =========================================================

  * php page for  delete ( update ) news, allowed only for Administrator
  * in relation with gordan_kranjcic/deletenews.php - only for Administrator

===========================================================*/
$respone = "";
require_once("classBase.php");
require_once("classLog.php");
require_once("function.php");

$db = new Baza();
$db->connect();

/* check if is set parameter from URL, function and news id - GET method */ 
if(isset($_GET['function']) AND isset($_GET['news_id']))
{
    $function = $_GET['function'];
    $news_id = $_GET['news_id'];

    if($function == "delete")
    {
        /* delete news - update active coloumn to 0, default is 1 */ 
        $sql = "UPDATE news SET active = 0 WHERE news_id = '$news_id'";
        $db->query($sql);
        Log::upisiLog("logs/vesti.txt", "{$_SESSION['users_name']} je uspešno obrisao vest sa id {$news_id}");
        $response = "<p>Uspešno ste obrisali vest!</p>";
    }
        
    
}
   

?>