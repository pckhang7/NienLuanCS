<?php
  session_start();
  include 'connection.php';
  include 'class.subject.php';
  include 'class.user.php';
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang Admin</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/sidebar.css">
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
      /*Mã giảng viên chính là $_SESSION['username'] */
      $ma_sv = $_SESSION['username'];
      $subject = new subject();
      //Lấy tất cả học phần của giảng viên
      $sql = $subject->get_all_subject_student($ma_sv);
      $result = mysqli_query($con,$sql);
     ?>
    <!--Day la phan content -->
    <div class="main">
      <div class="container">
        <div id="title">
          <h2>Trang kết quả học tập</h2>
        </div>
        <div id="hr">
          <hr>
        </div>
        <div id="section">
          <div id="section-content">
            <div id="img">
              <img src="../img/icon/profile.png" alt="">
            </div>
            <div id="text">
              <a href="view_user.php?id=<?php echo $_SESSION['username'] ?>">Xem thông tin cá nhân</a>
            </div>
          </div>
          <div id="section-content">
            <div id="img">
              <img src="../img/icon/list.png" alt="">
            </div>
            <div id="text">
              <a href="view_subject_student.php?id=<?php echo $ma_sv ?>">Xem danh sách nhóm học phần học</a>
            </div>
          </div>
          <div id="section-content">
            <div id="img">
              <img src="../img/icon/edit.png" alt="">
            </div>
            <div id="text">
              <a href="view_grade.php?id=<?php echo $ma_sv ?>">Xem kết quả học tập</a>
            </div>
          </div>
        </div>
        <div id="section">
          <p><h4>::Danh sách nhóm học phần được học::</h4></p><br>
          <div class="table">
            <table border="1">
              <tr>
                <th>Mã nhóm</th>
                <th>Mã học phần</th>
                <th>Học kì</th>
                <th>Năm học</th>
              </tr>
              <?php
              while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
                   echo "<td>{$row['Ma_Nhom']}</td>";
                   echo "<td>{$row['Ma_HP']}</td>";
                   echo "<td>{$row['Ten_HK']}</td>";
                   echo "<td>{$row['Ten_NH']}</td>";
              echo "</tr>";
              }
              ?>
            </table>
          </div>
          <?php
            mysqli_close($con);
           ?>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>
