 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Tranh chỉnh sửa thông tin</title>
     <link rel="stylesheet" href="../css/login.css">
   </head>
   <body>
     <?php
       include 'connection.php';
       include 'class.student.php';
       include 'header.php';
       include 'footer.php';
       $student = new student();
       $username = null;
       if (!empty($_GET['id'])) {
         $username = $_REQUEST['id'];
       }
       if ($username == null) {
         header ("Location: student.php");
       }
       $query = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
       $result = $student->get_all_student($con,$query);
       while ($row = mysqli_fetch_assoc($result)) {
      ?>
     <div class="main">
       <div class="main-edit">
         <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
           <label for="username">Mã sinh viên</label>
           <input type="text" name="username" value="<?php echo $username ?>" disabled>
           <label for="ho">Họ</label>
           <input type="text" name="ho" value="<?php echo $row['Ho']; ?>">
           <label for="ten">Tên</label>
           <input type="text" name="ten" value="<?php echo $row['Ten']; ?>">
           <label for="dia_chi">Địa chỉ</label>
           <input type="text" name="dia_chi" value="<?php echo $row['Dia_Chi']; ?>">
           <label for="email">Email</label>
           <input type="text" name="email" value="<?php echo $row['Email']; ?>">
           <label for="sdt">Số điện thoại</label>
           <input type="text" name="sdt" value="<?php echo $row['Sdt']; ?>">
           <label for="ma_nganh">Mã ngành</label>
           <input type="text" name="ma_nganh" value="<?php echo $row['Ma_Nganh']; ?>" disabled>
           <input type="submit" name="submit" value="Cập nhật">
           <input type="button" name="cancle" value="Cancel">
         </form>
       </div>
     </div>
     <?php }
     mysqli_close($con);
      ?>
   </body>
 </html>
