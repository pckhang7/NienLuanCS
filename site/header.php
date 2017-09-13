<?php
  $homepage = '';
  if (isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 'admin'){
      $homepage = 'admin_index.php';
    }
    if ($_SESSION['type'] == 'student'){
      $homepage = 'student_index.php';
    }
    if ($_SESSION['type'] == 'teacher'){
      $homepage = 'teacher_index.php';
    }
  }
  else {
    $homepage = 'login.php';
  }
 ?>
<div class="header">
  <h2 class="title">Hệ Thống Quản Lý Điểm Sinh Viên</h2>
  <div class="right">
    <?php
      if(isset($_SESSION['username'])) {
    ?>
    <p><?php echo $_SESSION['username']; ?></p>
    <p><a href="logout.php">Đăng Xuất</a></p>
  <?php
    }
   ?>
    <p><a href="<?php echo $homepage; ?>">Trang chủ</a></p>
  </div>
</div>
