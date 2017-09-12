<?php

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
          <div id="title"><h2 id="title">Quản lý tài khoản người dùng</h2></div>
          <div id="button"><a href="create_user.php">Tạo tài khoản người dùng</a></div>
          <p id="search">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
              Tìm theo mã đăng nhập: <input type="text" name="keyword"/>
              <input type="submit" name="search" value="Tìm">
            </form>
          </p>
        </div>
        <div class="section-table">
          <?php
          include 'connection.php';
          include 'class.user.php';
          $user = new user();
          $sql = "SELECT * FROM user WHERE type= 'sinhvien' OR  type = 'giangvien' ";
          if (isset($_POST['search'])) {
            $keyword = $_POST['keyword'];
            $check = $user->check_user_exist($con,$keyword);
            if ($check == TRUE) {
              $sql = "SELECT * FROM user WHERE username='$keyword'";
            }
            else {
              echo "<script>
                  alert('Mã đăng nhập không tồn tại!');
                  window.location.href='user.php';
              </script>";
            }
          }
          $result = $user->get_all_user($con,$sql);
          ?>
          <table border="1">
            <tr>
              <th>Số thứ tự</th>
              <th>Mã đăng nhập</th>
              <th>Mật khẩu</th>
              <th>Loại tài khoản</th>
              <th>Ngày tạo</th>
              <th colspan="3">Thao tác</th>
            </tr>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['username']}</td>";
              echo "<td>{$row['password']}</td>";
              echo "<td>{$row['type']}</td>";
              echo "<td>{$row['date_create']}</td>";
              echo '<td><a id="info" href="view_user.php?id=' . $row['username'] . '">Xem chi tiết</a></td>';
              echo '<td><a id="edit" href="edit_user.php?id=' . $row['username'] . '">Sửa</a></td>';
              echo "<td><a id='delete' href='delete_user.php?id={$row["username"]}' onclick='return confirm(\"Ban co chac xoa \")'>Xóa</a></td>";
            echo "</tr>";
          }

          mysqli_close($con);
           ?>
         </table>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>
