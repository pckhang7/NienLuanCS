<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Thêm sinh viên vào nhóm học phần</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
      session_start();
      include 'header.php';
      include 'connection.php';
      include 'class.subject.php';
      $id = null;
      $subject = new subject();
      if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
      }
      if ($id == null) {
        header("Location: subject.php");
      }
      if (isset($_POST['add'])) {
        $ma_sv = mysqli_escape_string($con,$_POST['ma_sv']);
        $sql = $subject->add_student_subject($con,$id,$ma_sv);
        if (mysqli_query($con,$sql)) {
          $sql = $subject->add_student_grade($con,$id,$ma_sv);
          if (mysqli_query($con,$sql)) {
            echo "<script>
                  alert('Thêm sinh viên thành công!');
                  window.location.href='add_student_subject.php';
                </script>";
          }
          else {
            echo "<script>
                  alert('Thêm sinh viên thành công!');
                  window.location.href='add_student_subject.php';
                </script>";
          }
        }
        else {
          echo "<script>
                alert('Có lỗi trong việc thêm sinh viên!');
                window.location.href='add_student_subject.php';
              </script>";
        }
      }
     ?>


     <!-- Main -->
     <?php
      $sql = $subject->select_one_id($id);
      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_assoc($result)) {

      ?>
     <div class="main">
      <div class="add-student-subject">
        <div class="title">
          <h2>Thêm sinh viên vào nhóm học phần</h2>
        </div>
        <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div id="section">
            <div class="section-left">
              <div id="section-content">
                <label for="ma_hp">Mã nhóm </label>
                <div id="text">
                  <?php echo $row['Ma_Nhom'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_hp">Mã học phần</label>
                <div id="text">
                  <?php echo $row['Ma_HP'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ten_hp">Tên học phần</label>
                <div id="text">
                  <?php echo $row['Ten_HP'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="so_tc">Số tín chỉ</label>
                <div id="text">
                  <?php echo $row['So_TC'] ?>
                </div>
              </div>
            </div>

            <div class="section-right">
              <div id="section-content">
                <label for="ma_hk">Học kì</label>
                <div id="text">
                  <?php echo $row['Ten_HK'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_nh">Mã học phần</label>
                <div id="text">
                  <?php echo $row['Ten_NH'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_gv">Mã giảng viên</label>
                <div id="text">
                  <?php echo $row['Ma_GV'] ?>
                </div>
              </div>
            </div>
          </div>

          <div id="section">
            <label for="ma_hp">Mã sinh viên</label>
            <input type="text" name="ma_sv" placeholder="">
          </div>
          <input type="submit" name="add" value="Thêm">
        </form>
      </div>
     </div>
     <?php
      }
      mysqli_close($con);
      ?>
     <!-- Footer -->
     <?php
      include 'footer.php';
      ?>
  </body>
</html>
