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
     <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
     <?php include 'header.php'; ?>

     <div class="main">
       <div class="statistic">
         <div id="title">
           <h2>Thống kê</h2>
         </div>
         <div id="btn">
           <button type="button" name="button">Quay lại</button>
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
                text: "Tỷ lệ xếp loại năm <?php echo $year ?>"
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
