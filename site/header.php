<?php
  $homepage = '';
  if ($_SESSION['type'] == 'admin') {
      $homepage = 'admin_index.php';
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
