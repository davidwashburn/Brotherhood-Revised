<?php

session_start();

require_once 'database.php';
require_once 'functions.php';

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = $_SESSION['loggedin'];
}

if (isset($_POST['signout']))
{
    $_SESSION = array();
    $_POST = array();
    setcookie(session_name(), '', time() - 4200);
    $user = "";
    session_destroy();    
}

?>
