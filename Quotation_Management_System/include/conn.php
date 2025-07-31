<?php
$conn = mysqli_connect('localhost', 'root', '', 'Quotation_Management_System');

if($conn == false){
    die('Connection Error'. mysqli_connect_error());
}
?>