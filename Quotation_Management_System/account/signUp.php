<?php
session_start();
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
  header("location: /Quotation_Management_System/sidebar/sidebar.php");
  exit;
}


$showAlert = false;
$showError = false;
$errorContent = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $checkEmail = mysqli_query($conn, "SELECT * from users WHERE email = '$email'");

  if (mysqli_num_rows($checkEmail) == 0) {
    if (empty($username) || empty($email) || empty($password)) {
      $showError = true;
      $errorContent = 'All field are required';
    } else {
      $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES('$username', '$email', '$password')";
      if (mysqli_query($conn, $sql)) {
        $showAlert = true;
      }
    }
  } else {
    $showError = true;
    $errorContent = "Email already exists!";
  }


}

?>

<div class="container-fluid">

  <div class="row w-50 mx-auto">
    <div
      class="col bg-white w-50 mx-auto my-5 py-5 rounded d-flex flex-column justify-content-center align-items-center">
      <?php

      if ($showAlert) {

        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>' . $username . '</strong> Your account is
            now created and you can login.
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

      <h1>Sign Up</h1>
      <p>Please fill the form to create an account.</p>
      <hr>
      <form action="index.php" method="POST" class="mx-auto w-50">
        <div class="form-group">
          <label for="inputName"><b>Name</b></label>
          <input type="text" name="name" class="form-control bg-black text-white" id="inputName"
            placeholder="Enter Name">
        </div><br>
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
          <button type="submit" class="btn btn-primary text-center">Sign Up</button>
          <button type="button" class="btn btn-danger text-center">Cancel</button>
        </div>
        <div class="form-group my-2">
          <p>Already have an account? <a href="account/signIn.php">Sign in</a></p>
        </div>
      </form>
    </div>

  </div>
</div>