<div class="header">
  <h2 class="title">Hệ Thống Quản Lý Điểm Sinh Viên</h2>
  <div class="right">
    <?php
      if(isset($_SESSION['username'])) {
    ?>
    <p><?php echo $_SESSION['username']; ?></p>
    <p><a href="logout.php">Đăng Xuất</a></p>
  <?php } ?>
    <p><a href="<?php $_SERVER['PHP_SELF']; ?>">Trang Chủ</a></p>
  </div>
</div>
