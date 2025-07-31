<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}
require '../sidebar/sidebar_header.php';
include '../include/conn.php';

$showAlert = false;
$showError = false;
$errorContent = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $checkEmail = mysqli_query($conn, "SELECT * from customers WHERE email = '$email'");

    if (mysqli_num_rows($checkEmail) == 0) {
        if (empty($username) || empty($email) || empty($phone) || empty($address)) {
            $showError = true;
            $errorContent = 'All field are required';
        } else {
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO `customers`(`name`, `email`, `phone`, `address`, `user_id`) VALUES('$username', '$email', '$phone', '$address', '$user_id')";
            if (mysqli_query($conn, $sql)) {
                $showAlert = true;
                //   header("location: listCustomer.php");
            }
        }
    } else {
        $showError = true;
        $errorContent = "Email already exists!";
    }

}
?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>Create new Customer</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            if ($showAlert) {

                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong> </strong> customer successfully created!.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
            }
            if ($showError) {

                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
  ' . $errorContent . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
            }
            ?>
        </div>
    </div>

    <div class="row w-50">
        <div class="col">
            <form action="addCustomer.php" method="POST" class="w-75 mx-auto">
                <div class="mb-3">
                    <label for="csName" class="form-label"><b>Name</b></label>
                    <input type="text" name="name" class="form-control" id="csName">
                </div>
                <div class="mb-3">
                    <label for="csEmail" class="form-label"><b>Email address</b></label>
                    <input type="email" name="email" class="form-control" id="csEmail">
                </div>
                <div class="mb-3">
                    <label for="csPhone" class="form-label"><b>Phone</b></label>
                    <input type="tel" name="phone" class="form-control" id="csPhone">
                </div>
                <div class="mb-3">
                    <label for="csAddress" class="form-label"><b>Address</b></label>
                    <textarea name="address" id="csAddress" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
<?php
require '../sidebar/sidebar_footer.php';
?>