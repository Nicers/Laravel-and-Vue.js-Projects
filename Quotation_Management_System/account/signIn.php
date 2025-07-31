<?php
session_start();

require '../include/header.php';
require_once '../include/conn.php';

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
  header("location: /Quotation_Management_System/sidebar/sidebar.php");
  exit;
}

$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $showError = true;
  } else {
    if ($conn) {
      $sql = "SELECT * from users WHERE email='$email' and password='$password'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        // echo $result->fetch_assoc();
        $row = $result->fetch_assoc();
        $_SESSION["loggedIn"] = true;
        $_SESSION["user_id"] = $row['id'];
        $_SESSION["username"] = $row['name'];

        header("location: ../sidebar/sidebar.php");
      } else {
        exit();
      }
    } else {
      exit();
    }
  }
}

?>

<div class="container-fluid">

  <div class="row w-50 mx-auto">
    <div
      class="col bg-white w-50 mx-auto my-5 py-5 rounded d-flex flex-column justify-content-center align-items-center">
      <?php
      if ($showError) {

        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
   All field are required
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';
      }
      ?>

      <h1>Login Account</h1>
      <hr>
      <form action="account/signIn.php" method="POST" class="mx-auto w-50">
        <div class="form-group">
          <label for="inputEmail"><b>Email address</b></label>
          <input type="email" name="email" class="form-control bg-black text-white" id="inputEmail"
            placeholder="Enter email">
        </div><br>
        <div class="form-group">
          <label for="inputPassword"><b>Password</b></label>
          <input type="password" name="password" class="form-control bg-black text-white" id="inputPassword"
            placeholder="Password">
        </div><br>
        <div class="form-group text-center">
          <input type="submit" value="Login" class="btn btn-primary text-center">
          <button type="button" class="btn btn-danger text-center">Cancel</button>
        </div>
        <div class="form-group my-2">
          <p>Register an account? <a href="/Quotation_Management_System/index.php">Sign Up</a></p>
        </div>
      </form>
    </div>

  </div>
</div>

<?php require '../include/footer.php'; ?>