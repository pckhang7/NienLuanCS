<?php
  session_start();
  include 'connection.php';
  include 'header.php';
  include 'class.subject.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang xem danh sách học phần của từng giảng viên</title>
    <link rel="stylesheet" href="../css/login.css">

  </head>
  <body>
    <?php
      $subject = new subject();
      $ma_gv = $_SESSION['username'];
      $sql = $subject->get_all_subject_teacher($ma_gv);
      $result = mysqli_query($con,$sql);
     ?>

     <!-- main -->
     <div class="main">
       <div class="view-subject">
         <div id="title">
           <h2>Danh sách nhóm học phần giảng dạy sinh viên</h2>
         </div>
         <?php
            while($row = mysqli_fetch_assoc($result)) {
              //base64_encode : mã hóa dữ liệu bằng cơ sở MIME base64
              $ma_nhom = base64_encode($row['Ma_Nhom']);
              $ma_hp = base64_encode($row['Ma_HP']);
              $ma_hk = base64_encode($row['Ma_HK']);
              $ma_nh = base64_encode($row['Ma_NH']);
          ?>
         <table border="1">
           <tr>
             <th>Mã nhóm</th>
             <th>Mã học phần</th>
             <th>Tên học phần</th>
             <th>Học kì</th>
             <th>Năm học</th>
             <th>Thao tác</th>
           </tr>
           <?php
           echo "<tr>";
                echo "<td>{$row['Ma_Nhom']}</td>";
                echo "<td>{$row['Ma_HP']}</td>";
                echo "<td>{$row['Ten_HP']}</td>";
                echo "<td>{$row['Ten_HK']}</td>";
                echo "<td>{$row['Ten_NH']}</td>";
                echo "<td><a href='update_grade.php?var1={$ma_nhom}&amp;var2={$ma_hp}&amp;var3={$ma_hk}&amp;var4={$ma_nh}'>Cập nhật điểm sinh viên</td>";
           echo "</tr>";
            ?>
         </table>
       </div>

       <?php
        }
        mysqli_close($con);
        ?>
     </div>


     <?php
      include 'footer.php';
      ?>
  </body>
</html>
