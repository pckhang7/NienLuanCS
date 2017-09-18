<?php
  include 'connection.php';
  include 'session.php';
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Trang tạo nhóm học phần mới</title>
     <link rel="stylesheet" href="../css/login.css">
   </head>
   <body>
     <!-- header -->
     <?php include 'header.php' ?>

     <!-- main -->
     <div class="main">
       <div class="create-subject">
         <div id="title">
           <h2>Tạo nhóm học phần mới</h2>
         </div>
         <div id="hr">
           <hr>
         </div>
         <form action="<?php $_SERVER['PHP_SELF']; ?>" class="form">
           <div id="input">
             <label for="Nhom_HP">Nhóm học phần</label>
             <input type="text" name="Nhom_HP" placeholder="">
           </div>
           <div id="input">
             <label for="Nhom_HP">Mã học phần</label>
             <input type="text" name="Ma_HP" placeholder="">
           </div>
           <div id="input">
             <label for="hoc ki">Học kì</label>
             <select class="hk" name="hk">
               <?php
                  //Truy vấn tất cả học kì
                  $result = mysqli_query($con,"SELECT * FROM hocki");
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['Ma_HK'] == $hk) $selected = "selected";
                    echo '<option value="' . $row['Ma_HK'] . '"' . $selected . '>' . $row['Ten_HK'] . '</option>';
                  }
                ?>
             </select>
           </div>
           <div id="input">
             <label for="nam hoc">Năm học</label>
             <select class="nh" name="nh">
               <?php
                  //Truy vấn tất cả học kì
                  $result = mysqli_query($con,"SELECT * FROM namhoc");
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['Ma_NH'] == $nh) $selected = "selected";
                    echo '<option value="' . $row['Ma_NH'] . '"' . $selected . '>' . $row['Ten_NH'] . '</option>';
                  }
                ?>
             </select>
           </div>
           <div id="input">
             <label for="giang vien">Mã giảng viên dạy</label>
             <input type="text" name="Ma_GV" placeholder=""/>
           </div>
         </form>
       </div>
     </div>
     <!-- footer -->
     <?php include 'footer.php' ?>
   </body>
 </html>
