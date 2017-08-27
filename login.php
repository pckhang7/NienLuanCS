<?php
    include_once 'site/connect.php';

    session_start();
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = mysqli_escape_string($con,$_POST['username']);
      $password = mysqli_escape_string($con,$_POST['password']);
      $password = md5($password);
      //$password = md5($password);
      $sql = "SELECT * From user WHERE username = '$username' and password = '$password'";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);

      //Tao session
      $_SESSION['userid'] = $row['id'];
      $_SESSION['type'] = $row['type'];


      $count = mysqli_num_rows($result);


      if ($count == 1) {
        $_SESSION['login_user'] = $username;
        if ($row['type'] == 'admin') {
          header ("Location: site/admin_index.php");
        }
        else if ($row['type'] == "student") {
          header ("Location: site/student_index.php");
        }
        else {
          header ("Location: site/teacher_index.php");
        }
      }
      else {
        $err = "Mã đăng nhập hoăc mật khẩu không hợp lệ!";
        echo "<script type='text/javascript'>alert('$err');</script>";
      }
      mysqli_close($con);
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
      <?php include 'site/header.php'; ?>

      <div class="main">
        <div class="content">
         <div class="login">
           <h2 class="login-header">Đăng Nhập</h2>
           <form action="login.php" method="post" class="login-container">
             <p><input type="text" name="username" placeholder="Mã đăng nhập"></p>
             <p><input type="password" name="password" placeholder="Mật khẩu"></p>
             <input type="submit" value="Đăng nhập">
           </form>
         </div>
        </div>
      </div>

      <?php include 'site/footer.php'; ?>
  </body>
</html>
