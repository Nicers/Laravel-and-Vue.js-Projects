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

// Delete Quote
if (isset($_GET['did'])) {
    $did = $_GET['did'];
    // echo "<script>alert($did)</script>";
    $quote_item_qry = mysqli_query($conn, "DELETE FROM quotation_items WHERE quotation_id = '" . $did . "'");
    $qrydel = mysqli_query($conn, "DELETE FROM quotations WHERE id = '" . $did . "'");
    if ($qrydel) {
        $showAlert = true;
    }else{
        $showError = true;
        $errorContent = 'Not Delete!';

    }
}
?>

 

<div class="container w-75 mx-auto d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>List of Quotations</h1>
        </div>
    </div>

     <?php
            if ($showAlert) {

                echo ' <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
  <strong> </strong> Quotation successfully created!.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
            }
            if ($showError) {

                echo ' <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
  ' . $errorContent . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
            }
            ?>

    <div class="row w-100 mx-auto">
        <div class="col mx-auto d-flex flex-column justify-content-center align-items-center">
            <table class="table table-striped w-75" style="margin-left:10rem;">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">View</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userId = $_SESSION['user_id'];
                    $query = "SELECT * from quotations WHERE user_id = '$userId'";
                    $quotation = mysqli_query($conn, $query);
                    while ($row = $quotation->fetch_assoc()) {
                        $term_id = $row['term_id'];
                        $term = mysqli_fetch_assoc(mysqli_query($conn, "SELECT terms.term from terms WHERE id='$term_id'"));
                        
                        $item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quotation_items.quantity, quotation_items.price, quotation_items.total_price from quotation_items WHERE quotation_id='".$row['id'] ."'"));
                        ?>
                        <tr>
                            <td scope="row"><?php echo $row['id'] ?></td>
                           <td>
                                <a href="/Quotation_Management_System/quotation/quote_manage/view.php?uid=<?php echo $row['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                            </td>
                           <td>
                                <!-- <a href="updateTerm.php?uid=<?php echo $row['id'] ?>" class="btn btn-success">Update</a> -->
                                <a href="#" class="btn btn-success"><i class="fa-solid fa-pencil"></i></a>
                            </td>
                            <td>
                                <a href="?did=<?php echo $row['id']; ?>" class="btn btn-danger" onClick="return confirm('Are you delete Quotation.')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php

                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>