<?php
session_start();
session_unset();
session_destroy();
header("location: /Quotation_Management_System/index.php");
?>