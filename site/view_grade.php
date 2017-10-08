<?php
  session_start();
  include 'connection.php';
  include 'class.user.php';
  include 'class.subject.php';
  include 'class.grade.php';
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Trang kết quả học tập</title>
     <link rel="stylesheet" href="../css/login.css">
   </head>
   <body>
     <?php
     $ma_sv = $_GET['id'];
     $subject = new subject();
     $grade = new grade();
     //Mặc định hiển thị học kì và năm học trong phần option
     $hk = (isset($_POST['hocki'])) ? ($_POST['hocki']) : "hk1";
     $nh = (isset($_POST['namhoc'])) ? ($_POST['namhoc']) : "2017";
     //Nếu submit form , hiển thì điểm học phần tại học kì năm học hiện tại
     $sql1  = $grade->get_all_grade_term($ma_sv,$hk,$nh);
     $sql2 = $grade->get_all_grade_average($ma_sv,$hk,$nh);
     if (isset($_POST['submit'])) {
       $sql1 = $grade->get_all_grade_term($ma_sv,$hk,$nh);
       $sql2 = $grade->get_all_grade_average($ma_sv,$hk,$nh);
     }
     //truy van tat ca nhung mon hoc
     if (isset($_POST['all'])) {
       $hk1 = "'' OR '' = '";
       $nh = "' OR '' = '";
       $sql1 = $grade->get_all_grade_term($ma_sv,$hk,$nh);
       $sql2 = $grade->get_all_grade_average($ma_sv,$hk,$nh);
       $hk = "hk1";
       $nh = "2017";
     }
      ?>
     <!--header-->
     <?php include 'header.php' ?>

     <!--Main-->
     <div class="main">
       <div class="view-grade">
         <form class="" action="<?php $_SERVER['PHP_SELF']?>" method="post">
           <select name="hocki" id="hk">
             <?php
                //Truy vấn tất cả học kì
                $result = mysqli_query($con,"SELECT * FROM hocki");
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['Ma_HK'] == $hk) $selected1 = ' selected="selected"';
                  else {
                    $selected1 = "";
                  }
                  echo '<option value="' . $row['Ma_HK'] . '"' . $selected1 . '>' . $row['Ten_HK'] . '</option>';
                }
              ?>
           </select>
           <select name="namhoc" id="nh">
             <?php
             //Hiển thị năm học
               $result = mysqli_query($con,"SELECT * FROM namhoc");
               while ($row = mysqli_fetch_assoc($result)) {
                 if ($row['Ma_NH'] == $nh) $selected2 = ' selected="selected"';
                 else {
                   $selected2 = "";
                 }
                 echo '<option value="' . $row['Ma_NH'] . '"' . $selected2 . '>' . $row['Ten_NH'] . '</option>';
               }
              ?>
           </select>
           <input type="submit" name="submit" value="Thực hiện">
           <input type="submit" name="all" value="Xem tất cả">
         </form>

         <?php
          $result2 = mysqli_query($con,$sql2);
          $count = mysqli_num_rows($result2);
          while ($row2 = mysqli_fetch_assoc($result2)) {
            $hk = $row2['Ma_HK'];
            $nh = $row2['Ma_NH'];
            $sql1 = $grade->get_all_grade_term($ma_sv,$hk,$nh);
            $result1 = mysqli_query($con,$sql1);
            echo "<div class='table'>";
            echo "{$row2['Ma_HK']}";
            echo "{$row2['Ma_NH']}";
            echo "<table border='1'>";
              echo "<tr>";
                echo "<th>Mã Học Phần</th>";
                echo "<th>Tên Học Phần</th>";
                echo "<th>Số tín chỉ</th>";
                echo "<th>Điểm số</th>";
                echo "<th>Điểm chữ</th>";
              echo "</tr>";
            while ($row = mysqli_fetch_assoc($result1)) {
                  echo "<tr>";
                    echo "<td>{$row['Ma_HP']}</td>";
                    echo "<td>{$row['Ten_HP']}</td>";
                    echo "<td>{$row['So_TC']}</td>";
                    echo "<td>{$row['Diem_4']}</td>";
                    echo "<td>{$row['Diem']}</td>";
                  echo "</tr>";
              }
              echo "</table>";
              echo "</br>";
              echo "<form>";
                  echo "<label>Điểm trung bình học kì:{$row2['DiemTBHK']}</label></br>";
                  echo "<label>Điểm trung bình tích lũy:{$row2['DiemTBTL']}</label></br>";
                  echo "<label>Số tín chỉ tích lũy học kì: {$row2['Tong_TCTLHK']}</label></br>";
                  echo "<label>Tổng số tín chỉ tích lũy: {$row2['Tong_TCTL']}</label></br>";
              echo "</form>";
            echo "</div>";
          }
            mysqli_close($con);
          ?>
       </div>
     </div>

     <!-- footer-->
     <?php include 'footer.php' ?>
   </body>
 </html>
