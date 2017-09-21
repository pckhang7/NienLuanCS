<?php
  session_start();
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
    <!--Day la phan content -->
    <div class="main">
      <?php include 'sidebar.php'; ?>
      <?php include 'section.php'; ?>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>
