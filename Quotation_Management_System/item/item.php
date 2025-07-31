<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}
require('../sidebar/sidebar_header.php');
?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>Item Management</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="addItem.php" class="btn btn-primary btn-lg mx-5">Create Item</a>
            <a href="listItem.php" class="btn btn-primary btn-lg">List Of Items</a>
        </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>