<?php
  include 'session.php';
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Quản lý user</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/sidebar.css">
  </head>
  <body>
    <?php include 'header.php'; ?>
    <!--Day la phan content -->
    <div class="main">
      <?php include 'sidebar.php'; ?>
      <div class="section">
        <div class="section-header">
          <h2 id="title">Quản lý tài khoản người dùng</h2>
          <button type="button" name="create">Tạo user mới</button>
        </div>
        <hr>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>
