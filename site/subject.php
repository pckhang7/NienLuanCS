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
      //include lớp subject
      include 'class.subject.php';
      $subject = new subject();
      //Mặc định hiển thị học kì và năm học trong phần option
      $hk = (isset($_POST['hocki'])) ? $_POST['hocki'] : "hk1";
      $nh = (isset($_POST['namhoc'])) ? $_POST['namhoc'] : "2014-2015";
      $sql = $subject->get_all_subject($hk,$nh);
      //Nếu submit form , hiển thì học phần tại học kì năm học hiện tại
      if (isset($_POST['submit'])) {
        $sql = $subject->get_all_subject($hk,$nh);
      }
      if (isset($_POST['all'])) {
        $sql = $subject->get_all();
      }
     ?>
    <div class="main">
      <div class="main-title">
        <h1>Danh sách nhóm học phần</h1>
      </div>
      <div class="main-subject">
        <div class="menu">
          <div id="section">
            <a href="subject.php">Xem danh sách học phần</a>
          </div>
          <div id="section">
            <a href="create_subject.php">Thêm nhóm học phần </a>
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
            <input type="submit" name="all" value="Xem tất cả">
          </form>
        </div>
        <?php
        $result = mysqli_query($con,$sql);
         ?>
        <div class="table">
          <table border="1">
            <tr>
              <th>Số thứ tự</th>
              <th>Mã nhóm học phần</th>
              <th>Mã học phần</th>
              <th>Tên học phần</th>
              <th>Số tín chỉ</th>
              <th>Học kì</th>
              <th>Năm học</th>
              <th>Mã giảng viên</th>
              <th colspan="2">Thao tác</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
                echo "<td>{$row['Id']}</td>";
                echo "<td>{$row['Ma_Nhom']}</td>";
                echo "<td>{$row['Ma_HP']}</td>";
                echo "<td>{$row["Ten_HP"]}</td>";
                echo "<td>{$row['So_TC']}</td>";
                echo "<td>{$row['Ten_HK']}</td>";
                echo "<td>{$row['Ten_NH']}</td>";
                echo "<td>{$row['Ma_GV']}</td>";
                echo "<td><a href='edit_subject.php?id={$row["Id"]}'>Sửa</a></td>";
                echo "<td><a href='delete_subject.php?id={$row["Id"]}' onclick='return confirm(\"Bạn có chắc nhóm học phần ! \")'>Xóa</a></td>";
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
