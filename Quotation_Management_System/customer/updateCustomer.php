<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: /Quotation_Management_System/account/signIn.php");
    exit;
}

require('../sidebar/sidebar_header.php');
include '../include/conn.php';
$showAlert = false;
$showError = false;
$errorContent = '';

if (isset($_GET['uid'])) {
    global $id;
    $id = $_GET['uid'];
    $qryupdate = mysqli_query($conn, "SELECT * FROM customers WHERE id='" . $id . "'");
    global $result;
    $customer = $qryupdate->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (!$conn) {
        die('Connection Failed: ' . mysqli_connect_error());
    }


    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $showError = true;
        $errorContent = 'All field are required';
    } else {
        $qry = "UPDATE customers SET 
        name = '" . $name . "', 
        email = '" . $email . "',
        phone = '" . $phone . "',
        address = '" . $address . "'
        WHERE id = '" . $id . "' ";
        if (mysqli_query($conn, $qry)) {
            $showAlert = true;
            //   header("location: listCustomer.php");
        }
        mysqli_close($conn);
    }
}



?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>Update Customer</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            if ($showAlert) {

                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong> </strong> customer successfully Updated!.
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
            <form action="updateCustomer.php" method="POST" class="w-75 mx-auto">
                <div class="mb-3">
                    <label for="csName" class="form-label"><b>Name</b></label>
                    <input type="text" name="name"
                        value="<?php echo isset($customer['name']) == true ? $customer['name'] : ''; ?>"
                        class="form-control" id="csName">
                </div>
                <div class="mb-3">
                    <label for="csEmail" class="form-label"><b>Email address</b></label>
                    <input type="email" name="email"
                        value="<?php echo isset($customer['email']) == true ? $customer['email'] : ''; ?>"
                        class="form-control" id="csEmail">
                </div>
                <div class="mb-3">
                    <label for="csPhone" class="form-label"><b>Phone</b></label>
                    <input type="tel" name="phone"
                        value="<?php echo isset($customer['phone']) == true ? $customer['phone'] : ''; ?>"
                        class="form-control" id="csPhone">
                </div>
                <div class="mb-3">
                    <label for="csAddress" class="form-label"><b>Address</b></label>
                    <textarea name="address" id="csAddress"
                        class="form-control"><?php echo isset($customer['address']) == true ? $customer['address'] : ''; ?></textarea>
                </div>
                <input type="hidden" name="id"
                    value="<?php echo isset($customer['id']) == true ? $customer['id'] : ''; ?>">
                <button type="submit" name="btnUpdate" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>