<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang tạo người dùng</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
    include 'session.php';
    include 'header.php';
    include 'connection.php';
    include 'class.student.php';
    include 'class.teacher.php';
    $student = new student();
    $teacher = new teacher();
    $loai = null;
    if (!empty($_GET['loai'])) {
      $loai = $_REQUEST['loai'];
    }
    //Kiểm tra xem loại là sinh viên hay giảng viên
    if ($loai == "giangvien") {
      $str = 'giảng viên';
    }
    else {
      $str = 'sinh viên';
    }
    $err = '';
    //Nếu nhấn submit tạo
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $ma = $_POST['ma'];
      $ho = $_POST['ho'];
      $ten = $_POST['ten'];
      $dia_chi = $_POST['dia_chi'];
      $email = $_POST['email'];
      $sdt = $_POST['sdt'];
      $ma_nganh = $_POST['ma_nganh'];
      $sql = "SELECT * FROM nganh WHERE Ma_Nganh = '$ma_nganh'";
      $result = mysqli_query($con,$sql);
      $count = mysqli_num_rows($result);
      //Kiểm tra mã và mã ngành, nếu không hợp lệ thì thông báo lỗi
      if ((strlen($ma) != 8) && ($count == 0)) {
        $err = 'Mã ' . $str . ' không hợp lệ hoặc mã ngành không tồn tại';
      }
      //Nếu hợp lệ :
      else {
        //Tạo truy vấn insert vào bảng
        $sql = "INSERT INTO $loai VALUES ('$ma', '$ho', '$ten', '$dia_chi', '$email', '$sdt', '$ma_nganh');";
        //Nếu loại là sinh viên thì thực hiện insert vào sinh viên
        if ($loai == 'sinhvien') {
          $check = $student->check_student($con,$ma);
          if ($check == TRUE) {
            $err = 'Mã ' . $str . ' đã tồn tại';
          }
          else {
            if (mysqli_query($con,$sql)) {
              echo "<script>
                    alert('Bạn đã thêm thành công!');
                    window.location.href='student.php';
                  </script>";
            }
          }
        }
        //Nếu loại là giảng viên thì thực hiện insert vào giảng viên
        else {
          $check = $teacher->check_teacher($con,$ma);
          if ($check == TRUE) {
            $err = 'Mã ' . $str . ' đã tồn tại';
          }
          else {
            if (mysqli_query($con,$sql)) {
              echo "<script>
                    alert('Bạn đã thêm thành công!');
                    window.location.href='teacher.php';
                  </script>";
            }
          }
        }
      }
    }
    mysqli_close($con);
     ?>
     <div class="main">
       <div class="create-user">
         <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
           <div id="title"><?php echo "Tạo $str mới"; ?></div>
           <div id="hr"><hr></div>
           <div id="error">
             <?php echo $err; ?>
           </div>
           <div id="section">
             <div id="label"><label><?php echo "Mã số $str :"; ?></label></div>
             <input type="text" name="ma" placeholder="<?php echo "Mã $str"; ?>">
           </div>
           <div id="section">
             <div id="label"><label>Họ :</label></div>
             <input type="text" name="ho" placeholder="Họ">
           </div>
           <div id="section">
             <div id="label"><label>Tên :</label></div>
             <input type="text" name="ten" placeholder="Tên">
           </div>
           <div id="section">
             <div id="label"><label>Địa chỉ :</label></div>
             <textarea name="dia_chi" rows="8" cols="80"></textarea>
           </div>
           <div id="section">
             <div id="label"><label>Email :</label></div>
             <input type="text" name="email" placeholder="Email">
           </div>
           <div id="section">
             <div id="label"><label>Số điện thoại :</label></div>
             <input type="text" name="sdt" placeholder="Số điện thoại">
           </div>
           <div id="section">
             <div id="label"><label>Mã ngành :</label></div>
             <input type="text" name="ma_nganh" placeholder="Mã ngành">
           </div>
           <div id="section">
             <div id="label">
               <div id="note"><div id="note-title"> Chú ý:</div>Mã số <?php echo $str; ?> phải là 8 ký tự
               </div>
             </div>
           </div>
           <div id="section">
             <input type="submit" value="Tạo">
           </div>
        </form>
      </div>
     </div>
     <!--Phần header -->
     <?php
      include 'footer.php';
      ?>
  </body>
</html>
