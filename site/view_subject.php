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
    <link rel="stylesheet" href="../js/jquery/theme/smoothness/jquery-ui.css">
    <script src="../js/jquery/jquery-ui-1.11.4.js"></script>
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
      $ma_gv = $_SESSION['username'];
      $sql = $subject->get_all_subject_teacher($ma_gv);
      //Nếu người dùng tìm kiếm
      if (isset($_POST['tim'])) {
        $ma_hp = mysqli_escape_string($con,$_POST['search']);
        if ($ma_hp != '') {
          $sql = $subject->get_all_subject_teacher_id($ma_gv,$ma_hp);
        }
      }
      $result = mysqli_query($con,$sql);
     ?>

     <!-- main -->
     <div class="main">
       <div class="view-subject">
         <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
           <div class="ui-widget">
             <input type="text" name="search" id="search">
             <input type="submit" name="tim" value="Tìm">
           </div>
         </form>
         <table border="1">
           <tr>
             <th>Mã nhóm</th>
             <th>Mã học phần</th>
             <th>Tên học phần</th>
             <th>Học kì</th>
             <th>Năm học</th>
             <th>Số sinh viên</th>
           </tr>
           <?php
           while($row = mysqli_fetch_assoc($result)) {
             $count = $subject->count_student_subject($con,$row['Ma_Nhom'],$row['Ma_HP'],
                                 $row['Ma_HK'],$row['Ma_NH']);
           echo "<tr>";
                echo "<td>{$row['Ma_Nhom']}</td>";
                echo "<td>{$row['Ma_HP']}</td>";
                echo "<td>{$row['Ten_HP']}</td>";
                echo "<td>{$row['Ten_HK']}</td>";
                echo "<td>{$row['Ten_NH']}</td>";
                echo "<td>{$count}</td>";
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
