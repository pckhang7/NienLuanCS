<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Tao nguoi dung moi</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
    include "header.php";
    include 'footer.php';
    include 'connection.php';
    include 'class.user.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $user = new user();
      $username = mysqli_escape_string($con,$_POST['username']);
      $password = mysqli_escape_string($con,$_POST['password']);
      $md5password = md5($password);
      $type = $_POST['type'] ? $_POST['type'] : false;
      if ($type) {
        $check = $user->check_user_exist($con,$username);
        if ($check === TRUE) {
          $check_table = $user->check_user_exist_table($con,$username,$type);
          if ($check_table === TRUE) {
            $query = $user->insert_user($con, $username,$md5password, $password,$type);
            if ($query === TRUE){
              echo "<script type='text/javascript'>alert('Tạo người dùng thành công');</script>";
            }
          }
          else {
            echo "<div id='error'>Mã đăng nhập phải là mã $type </div>";
          }

        }
        else {
          echo "<div id='error'>Tên người dùng đã tồn tại</div>";
        }
      }
      else {
        echo "<div id='error'>Bạn chưa loại tài khoản người dùng</div>";
      }
    }
    else {
        echo "<div id='error'>Bạn chưa nhập thông tin</div>";
    }
    mysqli_close($con);
     ?>

     <div class="main">
       <form action="create_user.php" method="post">
         <p>Mã đăng nhập :</p>
         <p><input type="text" name="username" placeholder="mã đăng nhập"></p>
         <p>Mật khẩu : </p><p><input type="text" name="password" placeholder="mật khẩu"></p>
         <p>Loại tài khoản :</p>
          <p>
            <select name="type">
              <option value="sinhvien">Sinh viên</option>
              <option value="giangvien">Giảng viên</option>
            </select>
          </p>
         <p><input type="submit" value="Tạo"></p>
       </form>
     </div>
  </body>
</html>
