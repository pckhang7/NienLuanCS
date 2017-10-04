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
     $sql = $grade->get_all_grade($ma_sv,$hk,$nh);
     if (isset($_POST['submit'])) {
       $sql = $grade->get_all_grade($ma_sv,$hk,$nh);
     }
     //truy van tat ca nhung mon hoc
     if (isset($_POST['all'])) {
       $sql = $grade->get_all_grade($ma_sv,$hk,$nh);
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

         <div class="table">
           <table border="1">
             <tr>
               <th>Mã học phần</th>
               <th>Tên học phần</th>
               <th>Số tín chỉ</th>
               <th>Điểm số</th>
               <th>Điểm Chữ</th>
             </tr>
             <?php
              $result = mysqli_query($con,$sql);
              while($row = mysqli_fetch_assoc($result)) {
                $diem_chu = $grade->change_grade_number_text($row['Diem']);
                echo "<tr>";
                  echo "<td>{$row['Ma_HP']}</td>";
                  echo "<td>{$row['Ten_HP']}</td>";
                  echo "<td>{$row['So_TC']}</td>";
                  echo "<td>{$row['Diem']}</td>";
                  echo "<td>{$diem_chu}</td>";
                echo "</tr>";
              }
              ?>
           </table>
           <br>
           <form>
             <label for="dtb">Điểm trung bình học kì:
               <?php
               $sql = $grade->average_grade($ma_sv,$hk,$nh);
               $result = mysqli_query($con,$sql);
               $row = mysqli_fetch_array($result);
               //Lam tron 2 chu so thap phan
               echo round($row[0], 2, PHP_ROUND_HALF_EVEN);
               ?>
             </label>
             <br>
             <label for="dtb">Điểm trung tích lũy
               <span>
               <?php
               $sql = $grade->average_grade_all($ma_sv,$hk,$nh);
               $result = mysqli_query($con,$sql);
               $row = mysqli_fetch_array($result);
               //Lam tron 2 chu so thap phan
               echo round($row[0], 2, PHP_ROUND_HALF_EVEN);
               ?>
             </span>
             </label>
           </form>
         </div>
       </div>
     </div>

     <!-- footer-->
     <?php include 'footer.php' ?>
   </body>
 </html>
