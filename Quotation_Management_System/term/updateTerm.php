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
    $qryupdate = mysqli_query($conn, "SELECT * FROM terms WHERE id='" . $id . "'");
 global  $result;
 $result = $qryupdate->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $id = $_POST['id'];
  $term = $_POST['term'];

     if (empty($name) || empty($term)) {
    $showError = true;
    $errorContent = 'All field are required';
  } else {
    $sql = "UPDATE terms SET 
        name = '" . $name . "', 
        term = '" . $term . "'
        WHERE id = '" . $id . "' ";
    if (mysqli_query($conn, $sql)) {
      $showAlert = true;
    //   header("location: listCustomer.php");
    }
  }

 
}
?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>Update Terms & Conditions</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            if ($showAlert) {

                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong> </strong> Term successfully Updated!.
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
            <form action="updateTerm.php" method="POST" class="w-75 mx-auto">
                <div class="mb-3">
                    <label for="csName" class="form-label"><b>Name</b></label>
                    <input type="text" value="<?php echo isset($result['name']) == true ? $result['name'] : ''; ?>" name="name" class="form-control" id="csName">
                </div>
                <div class="mb-3">
                    <label for="csCategory" class="form-label"><b>Term</b></label>
                    <input type="text" value="<?php echo isset($result['term']) == true ? $result['term'] : ''; ?>" name="term" class="form-control" id="csCategory">
                </div>
                 <input type="hidden" name="id" value="<?php echo isset($result['id']) == true ? $result['id'] : ''; ?>">
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>