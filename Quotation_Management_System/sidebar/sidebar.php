<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

require('../sidebar/sidebar_header.php');
require('../sidebar/sidebar_footer.php');
?>