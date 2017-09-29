<?php
  session_start();
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
      $hk = (isset($_POST['hocki'])) ? ($_POST['hocki']) : "hk1";
      $nh = (isset($_POST['namhoc'])) ? ($_POST['namhoc']) : "2017";;
      $sql = $subject->get_all_subject($hk,$nh);
      //Nếu submit form , hiển thì học phần tại học kì năm học hiện tại
      if (isset($_POST['submit'])) {
        $sql = $subject->get_all_subject($hk,$nh);
      }
      //truy van tat ca nhung mon hoc
      if (isset($_POST['all'])) {
        $sql = $subject->get_all();
        $hk = "hk1";
        $nh = "2017";
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
        </div>

        <div class="search">
          <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <select name="hocki" id="hk">
              <?php
                 //Truy vấn tất cả học kì
                 $result = mysqli_query($con,"SELECT * FROM hocki");
                 while ($row = mysqli_fetch_assoc($result)) {
                   if ($row['Ma_HK'] == $hk) $selected1 = ' selected="selected"';
                   else {
                     $selected1 = "";
                   }
                   echo '<option value="' . $row['Ma_HK'] . '"' . $selected1 . '>' . $row['Ten_HK'] . '</option>';
                 }
               ?>
            </select>
            <select name="namhoc" id="nh">
              <?php
              //Hiển thị năm học
                $result = mysqli_query($con,"SELECT * FROM namhoc");
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['Ma_NH'] == $nh) $selected2 = ' selected="selected"';
                  else {
                    $selected2 = "";
                  }
                  echo '<option value="' . $row['Ma_NH'] . '"' . $selected2 . '>' . $row['Ten_NH'] . '</option>';
                }
               ?>
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
              <th colspan="3">Thao tác</th>
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
                echo "<td><a href='add_student_subject.php?id={$row["Id"]}'>Thêm sinh viên</a></td>";
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
