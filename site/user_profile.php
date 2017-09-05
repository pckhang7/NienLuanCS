<?php
include 'connection.php';
include 'header.php';
include 'footer.php';
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang thông tin người dùng</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
      include 'class.user.php';
      $user = new user();
      $username = $_REQUEST['id'];
      $type = $user->get_type($con,$username);
      if ($type == 'sinhvien') {
        $query = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
      }
      else {
        $query = "SELECT * FROM giangvien WHERE Ma_GV = '$username'";
      }
      $result = mysqli_query($con,$query);
      $rows = mysqli_fetch_assoc($result);
      if ($rows) {
    ?>
      <div class="user-profile">
        <div class="table">
        <table border="1">
          <tr>
            <td>Mã Sinh viên : </td>
            <td><?php echo $rows['Ma_SV']; ?></td>
          </tr>
          <tr>
            <td>Họ : </td>
            <td><?php echo $rows['Ho']; ?></td>
          </tr>
          <tr>
            <td>Tên : </td>
            <td><?php echo $rows['Ten']; ?></td>
          </tr>
          <tr>
            <td>Địa chỉ : </td>
            <td><?php echo $rows['Dia_Chi']; ?></td>
          </tr>
          <tr>
            <td>Email : </td>
            <td><?php echo $rows['Email']; ?></td>
          </tr>
          <tr>
            <td>Số điện thoại : </td>
            <td><?php echo $rows['Sdt']; ?></td>
          </tr>
          <tr>
            <td>Mã ngành : </td>
            <td><?php echo $rows['Ma_Nganh']; ?></td>
          </tr>
        </table>
      </div>
      </div>
    <?php
      }
      mysqli_close($con);
     ?>
  </body>
</html>
