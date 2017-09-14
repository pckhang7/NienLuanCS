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
           <h2>Tạo nhóm mới</h2>
         </div>
         <div id="hr">
           <hr>
         </div>
         <form action="<?php $_SERVER['PHP_SELF']; ?>" class="form">
           <div id="input">
             <label for="Nhom_HP">Nhóm học phần</label>
             <input type="text" name="Nhom_HP" placeholder="">
           </div>
         </form>
       </div>
     </div>
     <!-- footer -->
     <?php include 'footer.php' ?>
   </body>
 </html>
