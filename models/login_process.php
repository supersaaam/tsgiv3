<?php
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  include 'connection.php';

  $stmt = $con->prepare('
    SELECT LastName, FirstName, Access FROM tbl_users WHERE Username=? AND `Password`=?
  ');
  $stmt->bind_param('ss', $username, $password);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($lname, $fname, $access);
  $stmt->fetch();

  if ($stmt->num_rows > 0) {
    //session variables
    session_start();
    $_SESSION['access'] = $access;
    $_SESSION['user_id'] = $username;
    $_SESSION['name']    = $fname . ' ' . $lname;

    //redirections
    header('location: ../records');
  } else {
    header('location: ../login?error');
  }
}
?>
