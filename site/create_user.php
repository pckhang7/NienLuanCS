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
    $err = '';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $user = new user();
      $username = mysqli_escape_string($con,$_POST['username']);
      $password = mysqli_escape_string($con,$_POST['password']);
      $md5password = md5($password);
      $type = $_POST['type'] ? $_POST['type'] : false;
      //Kiểm tra người dùng có chọn loại tài khoản hay chưa
      if ($type) {
        $check = $user->check_user_exist($con,$username);
        //Kiểm tra xem người dùng đã tồn tại chưa
        if ($check === FALSE) {
          $table_name = $user->return_table($con,$username);
          //Kiem tra mã đăng nhập phài nằm trong loại tài khoản
          if ($type == $table_name) {
            $query = $user->insert_user($con, $username,$md5password, $password,$type);
            if ($query === TRUE){
              echo "<script type='text/javascript'>
                      alert('Tạo người dùng thành công');
                      window.location.href='create_user.php';
                    </script>";
            }
          }
          else {
            $err = 'Mã đăng nhập không cùng loại tài khoản';
          }
        }
        else {
          $err = 'Tên người dùng đã tồn tại';
        }
      }
      else {
        $err='Bạn chưa loại tài khoản người dùng';
      }
    }
    mysqli_close($con);
     ?>

     <div class="main">
       <div class="create-user">
         <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
           <div id="title">Tạo tài khoản người dùng mới</div>
           <div id="hr"><hr></div>
           <div id="error">
             <?php echo $err; ?>
           </div>
           <div id="section">
             <div id="label"><label>Mã đăng nhập :</label></div>
             <input type="text" name="username" placeholder="mã đăng nhập">
           </div>
           <div id="section">
             <div id="label"><label>Mật khẩu :</label></div>
             <input type="text" name="password" placeholder="mật khẩu">
           </div>
           <div id="section">
             <div id="label"><label>Loại tài khoản :</label></div>
             <select name="type">
               <option value="sinhvien">Sinh viên</option>
               <option value="giangvien">Giảng viên</option>
             </select>
           </div>
           <div id="section">
             <div id="label">
               <div id="note"><div id="note-title"> Chú ý:</div>Mã đăng nhập phải là mã sinh viên hay
                 là mã giảng viên tùy vào loại tài khoản.
               </div>
             </div>
           </div>
           <div id="section">
             <input type="submit" value="Tạo">
           </div>
        </form>
      </div>
     </div>
  </body>
</html>
