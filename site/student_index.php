<?php
session_start();
//ket noi db
include 'connect.php';

//Neu nguoi dung da dang nhap bang 'admin'
if (isset($_SESSION['type']) == 'student') {
  $sql = "SELECT * FROM user WHERE id = '{$_SESSION['userid']}' and type = 'student'";
  $query = mysqli_query($con, $sql);
  $result = mysqli_fetch_array($query);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    ?>
  <html>
    <body>
      <h1>student</h1>
      <a href="logout.php">Logout</a>
<?php
    }
    else {
      header ("Location: login.php" );
    }
  }
  else {
    header("Location: login.php");
  }
?>
    </body>
  </html
