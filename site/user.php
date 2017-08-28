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
        <div class="section-table">
          <?php
          include 'connect.php';
          $sql = "Select * from user";
          $result = mysqli_query($con,$sql);
          ?>
          <table border="1">
            <tr>
              <th>Userid</th>
              <th>Username</th>
              <th>Password</th>
              <th>Loai</th>
            </tr>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['username']}</td>";
              echo "<td>{$row['password']}</td>";
              echo "<td>{$row['type']}</td>";
              echo "<td><a href='#'>Xem chi tiết</a></td>";
              echo "<td><a href='#'>Sửa</a></td>";
              echo "<td><a href='#'>Xóa</a></td>";
            echo "</tr>";
          }
           ?>
         </table>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>
