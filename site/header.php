<div class="header">
  <h2 class="title">Hệ Thống Quản Lý Điểm Sinh Viên</h2>
  <div class="right">
    <?php
      if(isset($_SESSION['login_user'])) {
    ?>
    <p><?php echo $_SESSION['login_user']; ?></p>
    <p><a href="logout.php">Đăng Xuất</a></p>
  <?php } ?>
    <p><a href="logout.php">Trang Chủ</a></p>
  </div>
</div>
