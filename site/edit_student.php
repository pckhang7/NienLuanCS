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
       include 'session.php';
       include 'class.student.php';
       include 'header.php';
       $student = new student();
       $username = null;
       if (!empty($_GET['id'])) {
         $username = $_REQUEST['id'];
       }
       if ($username == null) {
         header ("Location: student.php");
       }
       /*Nếu người dùng submit cập nhật thông tin*/
       if (isset($_POST['submit'])) {
         $Ho = $_POST['ho'];
         $Ten = $_POST['ten'];
         $Dia_Chi = $_POST['dia_chi'];
         $Email = $_POST['email'];
         $Sdt = $_POST['sdt'];
         $Ma_Nganh = $_POST['ma_nganh'];
         //Kiểm tra update thành công
         $check_update = $student->update_student($con,$username,$Ho,$Ten,$Dia_Chi,$Email,$Sdt,$Ma_Nganh);
         if ($check_update == TRUE) {
           $query1 = "UPDATE sinhvien
                   SET Ho='$Ho', Ten='$Ten', Dia_Chi='$Dia_Chi',Email='$Email', Sdt='$Sdt'
                   WHERE Ma_SV='$username'";
           $result1 = mysqli_query($con,$query1);
           if ($result1) {
                 echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href='student.php';
                 </script>";
           }
         }
         else {
           echo "<script>
              alert('Có lỗi trong việc cập nhật!');
              window.location.href={$_SERVER["PHP_SELF"]};
           </script>";
         }
       }
       if (isset($_POST['cancel'])) {
         echo "<script>
            window.location.href='student.php';
         </script>";
       }
       $query = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
       $result = $student->get_all_student($con,$query);
       while ($row = mysqli_fetch_assoc($result)) {
      ?>
     <div class="main">
       <div class="main-edit">
         <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
           <label for="username">Mã sinh viên</label>
           <input type="text" name="ma_sv" value="<?php echo $username ?>" disabled>
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
           <input type="submit" name="cancel" value="Cancel">
         </form>
       </div>
     </div>
     <?php }
     mysqli_close($con);
      ?>
      <!--Phần footer -->
      <?php
      include 'footer.php';
       ?>
   </body>
 </html>
