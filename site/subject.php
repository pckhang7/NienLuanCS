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
    <?php
      $sql = "SELECT *
              FROM nhom_hp AS n, hocphan AS hp, hocki AS hk , namhoc AS nh
              WHERE n.Ma_HP = hp.Ma_HP AND n.Ma_HK = hk.Ma_HK AND n.Ma_NH = nh.Ma_NH";
      //Mặc định hiển thị học kì và năm học trong phần option
      $hk = (isset($_POST['hocki'])) ? $_POST['hocki'] : "hk1";
      $nh = (isset($_POST['namhoc'])) ? $_POST['namhoc'] : "2014-2015";
      //Nếu submit form
      if (isset($_POST['submit'])) {
        $sql = "SELECT *
                FROM nhom_hp AS n, hocphan AS hp, hocki AS hk , namhoc AS nh
                WHERE n.Ma_HP = hp.Ma_HP AND n.Ma_HK = hk.Ma_HK AND n.Ma_NH = nh.Ma_NH
                AND n.Ma_HK = '$hk' AND n.Ma_NH = '$nh'";
      }

     ?>
    <div class="main">
      <div class="main-subject">
        <div class="menu">
          <div id="section">
            <a href="#">Xem danh sách học phần</a>
          </div>
          <div id="section">
            <a href="#">Thêm nhóm học phần </a>
          </div>
          <div id="section">
            <a href="#">Cập nhật sinh viên học phần</a>
          </div>
        </div>

        <div class="search">
          <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <select name="hocki" id="hk">
              <option value="hk1" <?php if($hk == "hk1") echo 'selected';?>>Học kì 1</option>
              <option value="hk2" <?php if($hk == "hk2") echo 'selected';?>>Học kì 2</option>
              <option value="hk3" <?php if($hk == "hk3") echo 'selected';?>>Học kì 3</option>
            </select>
            <select name="namhoc" id="nh">
              <option value="2014" <?php if($nh == "2014") echo 'selected';?>>2014-2015</option>
              <option value="2015" <?php if($nh == "2015") echo 'selected';?>>2015-2016</option>
              <option value="2016" <?php if($nh == "2016") echo 'selected';?>>2016-2017</option>
              <option value="2017" <?php if($nh == "2017") echo 'selected';?>>2017-2018</option>
            </select>
            <input type="submit" name="submit" value="Thực hiện">
          </form>
        </div>
        <?php
        $result = mysqli_query($con,$sql);
         ?>
        <div class="table">
          <table border="1">
            <tr>
              <th>Mã học phần</th>
              <th>Tên học phần</th>
              <th>Số tín chỉ</th>
              <th>Học kì</th>
              <th>Năm học</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
                echo "<td>{$row['Ma_HP']}</td>";
                echo "<td>{$row["Ten_HP"]}</td>";
                echo "<td>{$row['So_TC']}</td>";
                echo "<td>{$row['Ten_HK']}</td>";
                echo "<td>{$row['Ten_NH']}</td>";
              echo "</tr>";
            }

            mysqli_close($con);
             ?>
          </table>
        </div>
      </div>
    </div>
    <?php
      include 'footer.php';
     ?>
  </body>
</html>
