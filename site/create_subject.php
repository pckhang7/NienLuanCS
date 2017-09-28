<?php
  session_start();
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
     <!-- Xử lý -->
     <?php
          include 'connection.php';
          include 'class.teacher.php';
          include 'class.subject.php';

          //nếu người dùng submit form
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ma_nhom = mysqli_escape_string($con,$_POST['Nhom_HP']);
            $ma_hp = mysqli_escape_string($con,$_POST['Ma_HP']);
            $ma_gv = $_POST['Ma_GV'];
            $error = array();
            //Kiểm tra điều kiện khi người dùng nhập trống
            if (strlen($ma_nhom) != 2) {
              $error[] = 'Mã nhóm phải 2 ký tự';
            }
            if (strlen($ma_hp) != 5) {
              $error[] = 'Mã học phần phải 5 ký tự';
            }
            if (strlen($ma_gv) != 8) {
              $error[] = 'Mã giảng viên phải 8 ký tự';
            }
            if (isset($_POST['hk'])) {
                $ma_hk = $_POST['hk'];
            }
            if (isset($_POST['nh'])) {
                $ma_nh = $_POST['nh'];
            }

            //Nếu như không có lỗi
            if (empty($error)) {
              //Nếu người dùng nhất nhút tạo
              if (isset($_POST["create"])) {
                $subject = new subject();
                //Học phần phải tồn tại
                $check_subject = $subject->check_subject($con,$ma_hp);
                if ($check_subject == TRUE) {//Nếu như học phần đã tồn tại
                  $check_group_subject = $subject->check_group_subject($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh);
                  //Nếu nhóm học phần không tồn tại thì thêm nhóm học phần đó
                  if ($check_group_subject == FALSE) {
                    $sql1 = $subject->insert_group_subject($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh);
                    $sql2 = $subject->insert_subject_teacher($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh,$ma_gv);
                    if (mysqli_query($con,$sql1)) {
                      if (mysqli_query($con,$sql2)) {
                        echo "<script>
                                alert('Tạo nhóm học phần thành công');
                                window.location.href='subject.php';
                             </script>";
                      }
                    }
                  }
                  /*Nếu nhóm học phần tồn tại, xét 2 trường hợp:
                    +TH1 : nhóm học phần đã có giảng viên giảng dạy
                    +TH2 : nhóm hp chưa có giảng viên giảng dạy thì thêm học phần vào
                  */
                  else {
                    $check_subject_teacher = $subject->check_subject_teacher($con,$ma_nhom, $ma_hp, $ma_hk, $ma_nh);
                    //Nếu như ko tồn tại
                    if ($check_subject_teacher == FALSE) {
                      $sql2 = $subject->insert_subject_teacher($con,$ma_nhom,$ma_hp,$ma_hk,$ma_nh,$ma_gv);
                      if (mysqli_query($con,$sql2)) {
                        echo "<script>
                                alert('Tạo nhóm học phần thành công');
                                window.location.href='subject.php';
                             </script>";
                      }
                    }
                    else {
                      echo "<script>
                              alert('Nhóm học phần đã tồn tại');
                              window.location.href='create_subject.php';
                        </script>";
                    }
                  }
                  //Ngược lại nhóm học phần không tồn tại
                }
                //Kiểm tra nhóm học phần đã tồn tại trong bảng nhóm học phần hay chưa
                else {
                  $error[] = 'Mã học phần không tồn tại';
                }
              }
            }
          }

          //Nếu như người dùng nhấn nút hủy , quay lai trang trước đó

          if (isset($_POST["cancel"]) ) {
            header("Location: subject.php");
          }
      ?>
     <!-- main -->
     <div class="main">
       <div class="create-subject">
         <div id="title">
           <h2>Tạo nhóm học phần mới</h2>
         </div>
         <div id="hr">
           <hr>
         </div>
         <div id="error">
           <?php
            if (!empty($error)) {
                  $err = current($error);
                  echo $err;
                }
            ?>
         </div>
         <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="form">
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
           <div id="input">
             <input type="submit" name="create" value="Tạo">
             <input type="submit" name="cancel" value="Cancel">
           </div>
         </form>
       </div>
     </div>
     <!-- footer -->
     <?php include 'footer.php' ?>
   </body>
 </html>
