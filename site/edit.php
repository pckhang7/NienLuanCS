 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Tranh chỉnh sửa thông tin</title>
     <link rel="stylesheet" href="../css/login.css">
   </head>
   <body>
     <?php
       session_start();
       include 'connection.php';
       include 'class.student.php';
       include 'class.teacher.php';
       include 'header.php';
       $teacher = new teacher();
       $student = new student();
       $username = null;
       if (!empty($_GET['id'])) {
         $username = $_REQUEST['id'];
       }
       if ($username == null) {
         header ("Location: student.php");
       }
       //Kiểm tra xem username có phải sinh viên hay không
       $check = $student->check_student($con,$username);
       /*Nếu người dùng submit cập nhật thông tin*/
       if (isset($_POST['submit'])) {
         $error = array();
         //Kiểm tra các thông tin cập nhật có bị rỗng hay khong
         if (empty($_POST['ho']) or strlen($_POST['ho']) > 10) {
           $error[] = 'Họ không được để trống và ít hơn 10 ký tự';
         }
         else {
           $Ho = mysqli_escape_string($con,$_POST['ho']);
         }
         if (empty($_POST['ten'])) {
           $error[] = 'Tên không được để trống';
         }
         else {
           $Ten = mysqli_escape_string($con,$_POST['ten']);
         }
         if (empty($_POST['dia_chi'])) {
           $error[] = 'Địa chỉ không được trống';
         }
         else {
           $Dia_Chi = mysqli_escape_string($con,$_POST['dia_chi']);
         }
         if (empty($_POST['email'])) {
           $error[] = 'Email không được trống';
         }
         else {
           $Email = mysqli_escape_string($con,$_POST['email']);
         }
         if (empty($_POST['sdt']) or strlen($_POST['sdt']) != 11) {
           $error[] = 'Số điện thoại không được trống và phải là 11 số';
         }
         else {
           $Sdt = mysqli_escape_string($con,$_POST['sdt']);
         }
         if (empty($error)) {
           //Nếu như username này là sinh viên(tức $check == TRUE)
           if ($check == TRUE) {
               //Kiểm tra update thành công
               $check_update = $student->check_update_student($con,$username,$Ho,$Ten,$Dia_Chi,$Email,$Sdt);
               if ($check_update == TRUE) {
                 $sql = $student->update_student($con,$username,$Ho,$Ten,$Dia_Chi,$Email,$Sdt);
                 if (mysqli_query($con,$sql)) {
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
             //Ngươc lại username là giảng viên (tức là $check==FALSE), cập nhật bảng giảng viên
             else {
               //Kiểm tra update thành công
               $check_update = $teacher->check_update_teacher($con,$username,$Ho,$Ten,$Dia_Chi,$Email,$Sdt);
               if ($check_update == TRUE) {
                 $sql = $teacher->update_teacher($con,$username,$Ho,$Ten,$Dia_Chi,$Email,$Sdt);
                 if (mysqli_query($con,$sql)) {
                       echo "<script>
                          alert('Cập nhật thành công!');
                          window.location.href='teacher.php';
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
         }
       }//Đóng submit
       if (isset($_POST['cancel'])) {
         if ($check == TRUE) {
           echo "<script>
              window.location.href='student.php';
           </script>";
         }
         else {
           echo "<script>
              window.location.href='teacher.php';
           </script>";
         }
       }
       if ($check == TRUE) {
         $query = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
         $result = $student->get_all_student($con,$query);
         $str = 'Mã sinh viên';
       }
       else {
         $query = "SELECT * FROM giangvien WHERE Ma_GV = '$username'";
         $result = $teacher->get_all_teacher($con,$query);
         $str = 'Mã giảng viên';
       }
       while ($row = mysqli_fetch_assoc($result)) {
      ?>
     <div class="main">
       <div class="main-edit">
         <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
           <label for="error">
             <div id="error">
               <?php
                if (!empty($error)) {
                  $err = current($error);
                  echo $err;
                }
               ?>
             </div>
           </label>
           <label for="username"><?php echo $str; ?></label>
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
           <input type="text" name="ma_nganh" value="<?php echo $row['Ma_Nganh'] ?>" disabled>
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
