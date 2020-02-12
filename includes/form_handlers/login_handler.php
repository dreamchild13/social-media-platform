<?php
if(isset($_POST['login_button'])) {

  // FILTER_SANITIZE_EMAIL makes sure email is in correct format
  $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
  $email = mysqli_real_escape_string($con, $email);
  $_SESSION['log_email'] = $email; // Store email into session variable

  $password = mysqli_real_escape_string($con,($_POST['log_password']));

  $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
  $check_login_query = mysqli_num_rows($check_database_query);

  if($check_login_query == 1){
    $row = mysqli_fetch_array($check_database_query);
    $username = $row['username'];
    $hashed_password = $row['password'];

    $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND user_closed='yes' ");
    if(mysqli_num_rows($user_closed_query) == 1){
      $reopen_account = mysqli_query($con, "UPDATE users SET user_closed ='no' WHERE email = '$email'");

    }

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
      array_push($error_array, "Email or password was incorrect.<br>");
    }

  }

}
 ?>
