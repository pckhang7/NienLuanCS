<?php
  session_start();
  include 'connection.php';
  include 'class.grade.php';
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Trang thống kê </title>
     <link rel="stylesheet" href="../css/login.css">
     <!-- include jquery --->
     <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
     <!-- include canvas.js de ve bieu do -->
     <script src="../js/canvasjs.min.js"></script>

     <!-- Định nghĩa mảng phục vụ vẽ biểu đồ -->
     <?php
      //Năm hiện tại
      $year = date("Y");
      $grade = new grade();
      //Số lượng loại
      $Xuatsac = $grade->count_rate($con,$year,3.6, 4.1);
      $Gioi = $grade->count_rate($con,$year,3.2, 3.6);
      $Kha = $grade->count_rate($con,$year,2.5, 3.2);
      $TB = $grade->count_rate($con,$year,2.0, 2.5);
      $Yeu = $grade->count_rate($con,$year,1.0, 2.0);
      $Kem = $grade->count_rate($con,$year,0, 1.0);
      $loai = array("{$Xuatsac}", "{$Gioi}", "{$Kha}", "{$TB}", "{$Yeu}");
      $tong = $Xuatsac + $Gioi + $Kha + $TB + $Yeu + $Kem;
      $round = 0;
      for($x = 0 ; $x < count($loai); $x++) {
        $round += round(($loai[$x]/$tong)*100,1);
      }
      $tile_kem = 100 - $round;
      //Tạo mảng cho việc vẽ biểu đồ
      $data = array(
        array("y" => round(($Xuatsac/$tong)*100, 1), "name" => "Xuất sắc"),
        array("y" => round(($Gioi/$tong)*100, 1), "name" => "Giỏi"),
        array("y" => round(($Kha/$tong)*100, 1), "name" => "Khá"),
        array("y" => round(($TB/$tong)*100, 1), "name" => "Trung bình"),
        array("y" => round(($Yeu/$tong)*100, 1), "name" => "Yếu"),
        array("y" => $tile_kem, "name" => "Kém")
      );
      ?>
   </head>
   <body>
     <?php
      $hk = (isset($_POST['hocki'])) ? ($_POST['hocki']) : "hk1";
      $nh = (isset($_POST['namhoc'])) ? ($_POST['namhoc']) : "2017";
      $ma_hp = (isset($_POST['ma_hp'])) ? ($_POST['ma_hp']) : "";
      $ma_nhom = (isset($_POST['ma_nhom'])) ? ($_POST['ma_nhom']) : "";;
      ?>
     <?php include 'header.php'; ?>

     <div class="main">
       <div class="statistic">
         <div id="title">
           <h2>Thống kê</h2>
         </div>
         <div id="btn">
           <button type="button" name="button"><a href="admin_index.php" style="text-decoration:none">Quay lại</a></button>
         </div>

         <div id="section">
           <div id="section-main">
             <table border="1">
               <tr>
                 <th colspan="2">Thống kê về số lượng</th>
               </tr>
               <tr>
                 <td>Số người dùng</td>
                 <td><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM user")); ?></td>
               </tr>
               <tr>
                 <td>Số sinh viên</td>
                 <td><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM sinhvien")); ?></td>
               </tr>
               <tr>
                 <td>Số giảng viên</td>
                 <td><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM giangvien")); ?></td>
               </tr>
               <tr>
                 <td>Số học phần</td>
                 <td><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM hocphan")); ?></td>
               </tr>
             </table>
           </div>
           <div id="section-main">
             <!-- ve bo do bieu thi diem qua moi nam -->
             <div id="chart">

             </div>
           </div>
         </div>
         <div id="section">
           <div id="title1">
             <h4>Bảng điểm sinh viên từng môn học</h4>
           </div>
           <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             <!-- Học kì -->
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
                <!-- Năm học -->
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
                <input type="text" name="ma_hp" placeholder="Mã học phần" value="<?php echo $ma_hp; ?>">
                <input type="text" name="ma_nhom" placeholder="Mã nhóm" value="<?php echo $ma_nhom; ?>">
                <input type="submit" name="submit" value="Thực hiện">
                <input type="submit" name="export" value="Xuất file">

           </form>

           <div class="table">
             <?php
             //Nếu người dùng nhấn nút xuất file
             if (isset($_POST["export"])) {
               header('Content-Type: application/vnd.ms-excel');
               header('Content-Disposition: attachment; filename=data.xls');
               $head = false;
               $sql2 = "SELECT Ma_SV, Diem, Diem_4
                        FROM sinhvien_hp
                        WHERE Ma_HK = 'hk1' AND Ma_NH = '2014' AND Ma_HP = 'CT171' AND Ma_Nhom = '07'";
               $result2 = mysqli_query($con,$sql2);
               while($row = mysqli_fetch_assoc($result2)) {
                 if(!$head) {

                 }
               }
               fclose($output);
             }
             //Nếu người dùng submit
             if (isset($_POST['submit'])) {
               $hk = $_POST['hocki'];
               $nh = $_POST['namhoc'];
               $ma_hp = mysqli_escape_string($con,$_POST['ma_hp']);
               $ma_nhom = mysqli_escape_string($con,$_POST['ma_nhom']);
               $sql = "SELECT * FROM sinhvien_hp
                       WHERE Ma_HK = '$hk' AND Ma_NH = '$nh' AND Ma_HP = '$ma_hp' AND Ma_Nhom = '$ma_nhom'";
               $result = mysqli_query($con,$sql);

              ?>
             <!-- Hiển thị bảng điểm của sinh viên từng nhóm học phần -->
             <table>
               <tr>
                 <th>Mã sinh viên</th>
                 <th>Điểm 10</th>
                 <th>Điểm 4</th>
               </tr>
               <?php
               while($row = mysqli_fetch_assoc($result)) {
                 echo "<tr>";
                  echo "<td>{$row['Ma_SV']}</td>";
                  echo "<td>{$row['Diem']}</td>";
                  echo "<td>{$row['Diem_4']}</td>";
                 echo "</tr>";
               }
             }
                ?>
             </table>
           </div>
           <?php
            mysqli_close($con);
            ?>
         </div>
       </div>
     </div>

     <?php include 'footer.php'; ?>

     <!-- Script vẽ biểu đồ -->
     <script type="text/javascript">
          $(function() {
            var chart = new CanvasJS.Chart("chart", {
              theme: "them2",
              title: {
                text: "Tỷ lệ xếp loại điểm trung bình năm <?php echo $year ?>"
              },
              exportFileName: "Xeploai",
              exportEnable: true,
              animation: true,
              width: 500,
              height: 300,
              data: [
                {
                  type: "pie",
                  showInLegend: true,
                  tooltipContent: "{name}: <strong>{y}%</strong>",
                  indexLabel: "{name} {y}%",
                  dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }
              ]
            });
            chart.render();
          });
     </script>
   </body>
 </html>
