<?php

/* function for checking this characters in string, used on input fields for log in and registration - anti SQL injection */
function validString($str)
{
    if(strpos($str, "=")!==false) return false;
    if(strpos($str, "(")!==false) return false;
    if(strpos($str, ")")!==false) return false;
    if(strpos($str, "'")!==false) return false;
    if(strpos($str, "/")!==false) return false;
    if(strpos($str, "|")!==false) return false;
    if(strpos($str, ";")!==false) return false;
    if(strpos($str, "<")!==false) return false;
    if(strpos($str, ">")!==false) return false;
    if(strpos($str, "!")!==false) return false;
    if(strpos($str, "$")!==false) return false;
    return true;
}

/* function for checking if user is log in, if is SESSION set ( created ) */
function login()
{
    if(isset($_SESSION['users_id']) and isset($_SESSION['users_name']) and isset($_SESSION['users_status']))
        return true;
    elseif(isset($_COOKIE['users_id']) and isset($_COOKIE['users_name']) and isset($_COOKIE['users_status']))
    {
        $_SESSION['users_id'] = $_COOKIE['users_id'];
        $_SESSION['users_name' ]= $_COOKIE['users_name'];
        $_SESSION['users_status'] = $_COOKIE['users_status'];
        return true;
    }
    else
        return false;
    
}

/* function for destroying SESSIONS and COOKIES when user log off */
function destroySession()
{
    session_unset();
    session_destroy();
    setcookie("users_id", "", time()-1,"/");
    setcookie("users_name", "", time()-1,"/");
    setcookie("users_status", "", time()-1,"/");
}

/* function for create SESSIONS and COOKIES when user log in */
function createSession($users_id, $users_name, $users_lastname, $users_status, $users_email)
{
    $_SESSION['users_id'] = $users_id;
    $_SESSION['users_name'] = "$users_name $users_lastname";
    $_SESSION['users_status'] = $users_status;
    $_SESSION['users_email'] = $users_email;
	if(isset($_POST['remember']))
	{
		setcookie("users_id", $users_id, time()+86400,"/");
		setcookie("users_name", "$users_name $users_lastname", time()+86400,"/");
        setcookie("users_status", $users_status, time()+86400,"/");
        setcookie("users_email", $users_email, time()+86400,"/");
	}
}

/* function for showing news by chosen category, in relation with gordan_kranjcic/news.php */
function categoryNews($category, $db) {

    $html = "";
    $sql = "SELECT * FROM news_view WHERE categories_name = '{$category}' AND active = 1 ORDER BY news_created DESC";
    $result = $db->query($sql);

    $html .= "<h1>$category</h1>";
    if($db->num_rows($result) != 0) {

        while($row = $db->fetch_object($result)) {

            /* creating european datetime format like 01.01.2021. 01:01:01 */
            $valid_date = date( "d.m.Y H:i:s", strtotime($row->news_created));
            $html .= "<img src='images/$row->news_id.jpg' alt='NEWS$row->news_id'>";
            $html .= "<h3>$row->news_title</h3>";
            $html .= "<p>";

            /* creating first 20 words from news text and showing under news title with read more link at the end */
            $words = explode(" ", $row->news_body);

            for( $i = 0; $i < 20; $i++) {
                $html .= $words[$i]." ";
            }

            $html .= "... <a href='news.php?single_news=$row->news_id'>Pročitaje više</a>";
            $html .= "</p>";
            $html .= "<p>Autor: <a href='news.php?author=$row->users_id'>$row->users_name $row->users_lastname</a> | $valid_date</p>";
    
        }
    }
    else
    {
        $html .= "<p>Ne postoje vesti za izabranu kategoriju</p>";
    }

    return $html;
}

/* function for showing single chosen news by clicking on read more link, in relation with gordan_kranjcic/news.php */
function singleNews($single_news, $db) {

    $html = "";

    $sql = "SELECT * FROM news_view WHERE news_id = '{$single_news}' AND active = 1";
    $result = $db->query($sql);

    $html .= "<h1>Cela vest</h1>";
    while($row = $db->fetch_object($result)) {

        $valid_date = date( "d.m.Y H:i:s", strtotime($row->news_created));
        $html .= "<img src='images/$row->news_id.jpg' alt='NEWS$row->news_id'>";
        $html .= "<h3>$row->news_title</h3>";
        $html .= "<p>$row->news_body</p>";
        $html .= "<p>Autor: <a href='news.php?author=$row->users_id'>$row->users_name $row->users_lastname</a> | $valid_date</p>";

    }

    return $html;
}

/* function for showing news from chosen author by clicking on author name, in relation with gordan_kranjcic/news.php */
function authorsNews($authors, $db) {

    $html = "";

    $sql = "SELECT * FROM news_view WHERE users_id = '{$authors}' ORDER BY news_created DESC";
    $result = $db->query($sql);

    $html .= "<h1>Vesti izabranog autora</h1>";
    while($row = $db->fetch_object($result)) {

        $valid_date = date( "d.m.Y H:i:s", strtotime($row->news_created));
        $html .= "<img src='images/$row->news_id.jpg' alt='NEWS$row->news_id'>";
        $html .= "<h3>$row->news_title</h3>";
        $words = explode(" ", $row->news_body);

            for( $i = 0; $i < 20; $i++) {
                $html .= $words[$i]." ";
            }

        $html .= "... <a href='news.php?single_news=$row->news_id'>Pročitaje više</a>";
        $html .= "</p>";
        $html .= "<p>Autor: <a href='news.php?author=$row->users_id'>$row->users_name $row->users_lastname</a> | <a href='news.php?category=$row->categories_name'>$row->categories_name</a> | $valid_date</p>";

    }

    return $html;

}

/* function for showing comments for chosen single news, in relation with gordan_kranjcic/news.php */
function newsComments($single_news, $db) {

    $html = "";

    $sql = "SELECT * FROM comments_view WHERE news_id = '{$single_news}' AND aproved = 2 ORDER BY comments_created DESC";
    $result = $db->query($sql);

    if($db->num_rows($result) != 0) {

        $html .= "<p>Ukupan broj komentara za ovu vest je: " .$db->num_rows($result). "</p>";

        while($row = $db->fetch_object($result)) {

            $valid_date = date( "d.m.Y H:i:s", strtotime($row->comments_created));
            $html .= "<div class='comments'>";
            $html .= "<h6>$row->users_name $row->users_lastname</h6>";
            $html .= "<p>$row->comments_body</p>";
            $html .= "<p>$valid_date</p>";
            $html .= "</div>";

        }
    }
    else
    {
        $html .= "<p>Ova vest nema komentara. Budite prvi i ostavite komentar.</p>";
    }
    return $html;

}

?>