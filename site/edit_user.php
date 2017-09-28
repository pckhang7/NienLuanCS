<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Chỉnh Sửa user</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
    session_start();
    include 'connection.php';
    include 'class.user.php';
    include 'header.php';
    $user = new user();
    $username = null;
    if (!empty($_GET['id'])) {
      $username = $_REQUEST['id'];
    }
    if ($username == null) {
      header ("Location: user.php");
    }
    $err='';
    if (!empty($_POST)) {
      if  (empty($_POST['password1'])) {
        $err = 'Xin hãy nhập mật khẩu';
      }
      else {
        if(strlen($_POST['password1']) < 6) {
          $err = 'mật khẩu ít nhất 8 kí tự';
        }
        else {
          $password1 = mysqli_escape_string($con,$_POST['password1']);
        }
      }
      if (empty($_POST['password2'])) {
        $err = 'Xin hãy nhập lại mật khẩu';
      }
      else {
        $password2 = mysqli_escape_string($con,$_POST['password2']);
      }
      if ($err == '') {
        if ($password1 == $password2) {
          $md5password = md5($password1);
          $check = $user->update_user($con,$username,$password1,$md5password);
          if ($check === TRUE) {
            echo '<script type="text/javascript">
                  alert("Cập nhật tài khoản thành công!");
                  window.location.href="user.php";
                  </script>';
          }
          else {
            echo "<script type='text/javascript'>
                  alert('Có lỗi trong việc cập nhật tài khoản');
                  window.location.href='user.php';
                  </script>";
          }
        }
        else {
          $err = "Nhập lại mật khẩu bị sai. Xin nhập lại!";
        }
      }
    }
    if (isset($_POST['cancel'])) {
      header("Location: user.php");
    }
    mysqli_close($con);
     ?>

     <div class="main">
       <div class="main-edit">
         <form method="post" action="edit_user.php?id=<?php echo $username ?>" >
           <div id="error"><?php echo $err; ?></div>
           <label for="username">Mã đăng nhập</label>
           <input type="text" name="username" value="<?php echo $username ?>" disabled>
           <label for="password">Mật khẩu</label>
           <input type="text" name="password1">
           <label for="password">Nhập lại mật khẩu</label>
           <input type="text" name="password2">
           <input type="submit" name="submit" value="Cập nhật">
           <input type="submit" name="cancel" value="Cancel">
         </form>
       </div>
     </div>
     <!--Phần footer-->
     <?php include 'footer.php'; ?>
  </body>
</html>
