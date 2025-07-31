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


// Delete Term
    if (isset($_GET['did'])) {
        $did = $_GET['did'];
        $qrydel = mysqli_query($conn, "DELETE FROM terms WHERE id = '" . $did . "'");
        if ($qrydel) {
            
        } else {
            echo '<script>alert("Error: ' . $sql . "<br>" . mysqli_error($conn) . '")</script>';
            // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>
<div class="container d-flex flex-column justify-content-center align-items-center gap-5">
    <div class="row">
        <div class="col">
            <h1>List of Terms & Conditions</h1>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex flex-column justify-content-center align-items-center">
           <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Term & Conditions</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $userId = $_SESSION['user_id'];
    $terms = mysqli_query($conn, "SELECT * from terms WHERE user_id = '$userId'");
    while( $row = $terms-> fetch_assoc()){
    ?>
    <tr>
      <td scope="row"><?php echo $row['id'] ?></td>
      <td><?php echo $row['name'] ?></td>
      <td><?php echo $row['term'] ?></td>
      <td>
        <a href="updateTerm.php?uid=<?php echo $row['id']?>" class="btn btn-success">Update</a>
      </td>
      <td>
        <a href="?did=<?php echo $row['id']?>" class="btn btn-danger" onClick="return confirm('Are you delete Item.')">Delete</a>
        </td>
    </tr>
    <?php 
    
    }?>
  </tbody>
</table>
    </div>
    </div>
</div>
<?php
require('../sidebar/sidebar_footer.php');
?>