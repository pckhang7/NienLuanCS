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
    <!-- Include JQuery , JQuery UI -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- Autocomplete search box -->
    <script type="text/javascript">
      $(function() {
        $("#search").autocomplete({
          source : 'search.php'
        });
      });
    </script>
  </head>
  <body>
    <?php
      $subject = new subject();
      $ma_sv = $_GET['id'];
      $sql = $subject->get_all_subject_student($ma_sv);
      $result1 = mysqli_query($con,$sql);
      //Nếu người dùng nhấn nút thực hiện
      if (isset($_POST['submit'])) {
        $hk = $_POST['hocki'];
        $nh = $_POST['namhoc'];
        $sql = $subject->get_all_subject_student_term($ma_sv,$hk,$nh);
        $result1 = mysqli_query($con,$sql);
      }
      //Nếu người dùng xem tất cả
      if (isset($_POST['all'])) {
        $result1 = mysqli_query($con,$sql);
      }
     ?>

     <!-- main -->
     <div class="main">
       <div class="view-subject-student">
         <div id="title">
           <p>Danh sách học phần</p>
         </div>
         <form class="" action='<?php $_SERVER["PHP_SELF"]?>' method="post">
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
         <table border="1">
           <tr>
             <th>Mã nhóm</th>
             <th>Mã học phần</th>
             <th>Tên học phần</th>
             <th>Học kì</th>
             <th>Năm học</th>
           </tr>
           <?php
           while($row = mysqli_fetch_assoc($result1)) {
           echo "<tr>";
                echo "<td>{$row['Ma_Nhom']}</td>";
                echo "<td>{$row['Ma_HP']}</td>";
                echo "<td>{$row['Ten_HP']}</td>";
                echo "<td>{$row['Ten_HK']}</td>";
                echo "<td>{$row['Ten_NH']}</td>";
           echo "</tr>";
         }
            ?>
         </table>
       </div>
       <?php
        mysqli_close($con);
        ?>
     </div>


     <?php
      include 'footer.php';
      ?>
  </body>
</html>
