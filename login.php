<?php
    session_start();
    include 'site/connection.php';
    include 'site/class.user.php';
    $err = "";
    $user = new user();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];
      //Tranh tan cong bang SQL Injection
      $username = stripcslashes($username);
      $password = stripcslashes($password);
      $username = mysqli_escape_string($con,$username);
      $password = mysqli_escape_string($con,$password);
      $login = $user->login($con,$username, $password);
      if ($login) {
        header ("Location: site/admin_index.php");
      }
      else {
        $err = "Mã đăng nhập hoăc mật khẩu không hợp lệ!";
        echo "<script type='text/javascript'>alert('$err');</script>";
      }
    }

    mysqli_close($con);
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
