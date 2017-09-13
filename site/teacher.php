<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang thông tin sinh viên</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
    include 'connection.php';
    include 'session.php';
    include 'header.php';
    include 'class.teacher.php';
    $teacher = new teacher();
    $sql = "SELECT * FROM giangvien";
    if (isset($_POST['search'])) {
      $keyword = $_POST['keyword'];
      $check = $teacher->check_teacher($con,$keyword);
      if ($check == TRUE) {
        $sql = "SELECT * FROM giangvien WHERE Ma_GV='$keyword'";
      }
      else {
        echo "<script>
            alert('Mã giảng viên không tồn tại!');
            window.location.href='{$_SERVER['PHP_SELF']}';
        </script>";
      }
    }
    $result = $teacher->get_all_teacher($con,$sql);
     ?>
     <div class="main">
       <div class="section">
         <div class="section-header">
           <div id="title"><h2 id="title">Quản lý giảng viên</h2></div>
           <div id="button"><a href="create_student.php">Tạo giảng viên mới</a></div>
           <p id="search">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
               Tìm theo mã giảng viên: <input type="text" name="keyword"/>
               <input type="submit" name="search" value="Tìm">
             </form>
           </p>
         </div>
         <div class="section-table">
           <table border=1>
             <tr>
               <th>Mã giảng viên</th>
               <th>Họ</th>
               <th>Tên</th>
               <th>Địa chỉ</th>
               <th>Email</th>
               <th>Số Điện thoại</th>
               <th>Mã ngành</th>
               <th colspan="3">Thao tác</th>
             </tr>
             <?php
             while ($row = mysqli_fetch_assoc($result)) {
               echo "<tr>";
                 echo "<td>{$row['Ma_GV']}</td>";
                 echo "<td>{$row['Ho']}</td>";
                 echo "<td>{$row['Ten']}</td>";
                 echo "<td>{$row['Dia_Chi']}</td>";
                 echo "<td>{$row['Email']}</td>";
                 echo "<td>{$row['Sdt']}</td>";
                 echo "<td>{$row['Ma_Nganh']}</td>";
                 echo '<td><a id="info" href="view_user.php?id=' . $row['Ma_GV'] . '">Xem chi tiết</a></td>';
                 echo '<td><a id="edit" href="edit.php?id=' . $row['Ma_GV'] . '">Sửa</a></td>';
                 echo "<td><a id='delete' href='delete_student.php?id={$row["Ma_GV"]}' onclick='return confirm(\"Bạn có chắc xóa giảng viên cùng với tài khoản đăng nhập! \")'>Xóa</a></td>";
               echo "</tr>";
             }
             mysqli_close($con);
              ?>
           </table>
         </div>
       </div>
     </div>
     <!-- Phần footer -->
     <?php
     include 'footer.php';
      ?>
  </body>
</html>
