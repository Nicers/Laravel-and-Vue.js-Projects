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
    $qryupdate = mysqli_query($conn, "SELECT * FROM items WHERE id='" . $id . "'");
 global  $result;
 $result = $qryupdate->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $id = $_POST['id'];
  $name = $_POST['name'];
  $category = $_POST['category'];
  $cost_price = $_POST['cost_price'];
  $sale_price = $_POST['sale_price'];
  $gst = $_POST['gst'];
  $bar_code = $_POST['bar_code'];

     if (empty($name) || empty($category) || empty($cost_price) || empty($sale_price) || empty($gst) || empty($bar_code)) {
    $showError = true;
    $errorContent = 'All field are required';
  } else {
    $sql = "UPDATE items SET 
        name = '" . $name . "', 
        category = '" . $category . "',
        cost_price = '" . $cost_price . "',
        sale_price = '" . $sale_price . "',
        gst = '" . $gst . "',
        bar_code = '" . $bar_code . "'
        WHERE id = '" . $id . "' ";
    if (mysqli_query($conn, $sql)) {
      $showAlert = true;
    }
     mysqli_close($conn);
  }

 
}
?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>Update Item</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            if ($showAlert) {

                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong> </strong> Item successfully Updated!.
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
            <form action="updateItem.php" method="POST" class="w-75 mx-auto">
                <div class="mb-3">
                    <label for="csName" class="form-label"><b>Name</b></label>
                    <input type="text" value="<?php echo isset($result['name']) == true ? $result['name'] : '';?>" name="name" class="form-control" id="csName">
                </div>
                <div class="mb-3">
                    <label for="csCategory" class="form-label"><b>Category</b></label>
                    <input type="text" value="<?php echo isset($result['category']) == true ? $result['category'] : ''; ?>" name="category" class="form-control" id="csCategory">
                </div>
                <div class="mb-3">
                    <label for="cscost_price" class="form-label"><b>cost price</b></label>
                    <input type="text" value="<?php echo isset($result['cost_price']) == true ? $result['cost_price'] : ''; ?>" name="cost_price" class="form-control" id="cscost_price">
                </div>
                <div class="mb-3">
                    <label for="cssale_price" class="form-label"><b>sale price</b></label>
                    <input type="text" value="<?php echo isset($result['sale_price']) == true ? $result['sale_price'] : ''; ?>" name="sale_price" class="form-control" id="cssale_price">
                </div>
                <div class="mb-3">
                    <label for="csGST" class="form-label"><b>GST</b></label>
                    <input type="text" value="<?php echo isset($result['gst']) == true ? $result['gst'] : ''; ?>" name="gst" class="form-control" id="csGST">
                </div>
                <div class="mb-3">
                    <label for="csGST" class="form-label"><b>bar_code</b></label>
                    <input type="text" value="<?php echo isset($result['bar_code']) == true ? $result['bar_code'] : ''; ?>" name="bar_code" class="form-control" id="bar_code">
                </div>
                 <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>