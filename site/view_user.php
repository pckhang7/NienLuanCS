<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang thông tin người dùng</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
      session_start();
      include 'connection.php';
      include 'header.php';
      include 'class.user.php';
      $user = new user();
      $username = $_REQUEST['id'];
      $table_name = $user->return_table($con,$username);
      if ($table_name == "sinhvien") {
        $query = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
        $str = 'Mã sinh viên:';
        $ma = 'Ma_SV';
      }
      else {
        $query = "SELECT * FROM giangvien WHERE Ma_GV = '$username'";
        $str = 'Mã giảng viên:';
        $ma = 'Ma_GV';
      }
      $result = mysqli_query($con,$query);
      $rows = mysqli_fetch_assoc($result);
      if ($rows) {
    ?>
    <div class="main">
      <div class="user-profile">
          <div id="profile">
            <div id="element">Thông tin chi tiết</div>
          </div>
          <div id="profile">
            <div id="element">
              <?php echo $str; ?>
            </div>
            <div id="element">
              <?php echo $rows[$ma]; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Họ:
            </div>
            <div id="element">
              <?php echo $rows['Ho']; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Tên:
            </div>
            <div id="element">
              <?php echo $rows['Ten']; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Địa chỉ:
            </div>
            <div id="element">
              <?php echo $rows['Dia_Chi']; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Email:
            </div>
            <div id="element">
              <?php echo $rows['Email']; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Số Điện Thoại:
            </div>
            <div id="element">
              <?php echo $rows['Sdt']; ?>
            </div>
          </div>
          <div id="hr"><hr></div>
          <div id="profile">
            <div id="element">
              Mã Ngành:
            </div>
            <div id="element">
              <?php echo $rows['Ma_Nganh']; ?>
            </div>
          </div>
      </div>
    </div>
    <?php
      }
      mysqli_close($con);
     ?>
     <?php
     include 'footer.php';
      ?>
  </body>
</html>
