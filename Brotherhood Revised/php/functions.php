<?php

function page_auth()
{
   if(!isset($_SESSION['user']) && $_SESSION['loggedin'] !== TRUE)
   {
      $_SESSION['lasturl'] = $_SERVER['REQUEST_URI'];
      header('HTTP/1.1 302 Redirect');
      header ("Location: login.php");
   }
}

function auth()
{
   if(isset($_SESSION['user']) && $_SESSION['loggedin'] == TRUE)
   
   return TRUE;
}
?>