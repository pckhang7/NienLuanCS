<?php
  include 'connection.php';
  include 'session.php';
  include 'class.user.php';
  $user = new user();
  $username = null;
  if (!empty($_GET['id'])) {
    $username = $_REQUEST['id'];
  }
  if ($username == null) {
    header("Location: user.php");
  }
  $check = $user->delete_user($con,$username);
  if ($check === TRUE) {
    echo '<script type="text/javascript">
            alert("Bạn đã xóa thành công!");
            window.location.href="user.php";
          </script>';
  }
  mysqli_close($con);
 ?>
