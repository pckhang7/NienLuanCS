<?php
  include 'session.php';
  include 'connection.php';
  include 'header.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html"; charset="utf-8" />
    <title>Trang quản lý môn học</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <div class="main">
      <div class="main-subject">
        <div class="menu">
          <div id="section">
            <a href="#">Xem danh sách học phần</a>
          </div>
          <div id="section">
            <a href="#">Xem danh nhóm học phần</a>
          </div>
          <div id="section">
            <a href="#">Cập nhật giảng viên</a>
          </div>
          <div id="section">
            <a href="#">Cập nhật sinh viên</a>
          </div>
        </div>

        <div class="search">
          <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <select name="hocki" id="hk">
              <option value="hk1">Học kì 1</option>
              <option value="hk2">Học kì 2</option>
              <option value="hk3">Học kì 3</option>
            </select>
            <select name="namhoc" id="nh">
            <?php
                $sql2 = "SELECT * From namhoc";
                $result2 = mysqli_query($con,$sql2);
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo "<option value='{$row["Ma_NH"]}'>{$row["Ten_NH"]}</option>";
                }
            ?>
            </select>
            <input type="submit" name="submit" value="Thực hiện">
          </form>
        </div>
      </div>
    </div>
    <?php
      include 'footer.php';
     ?>
  </body>
</html>
