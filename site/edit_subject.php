<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Trang chỉnh sửa học phần</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
      include 'session.php';
      include 'header.php';
      include 'connection.php';
      include 'class.subject.php';
      $id = null;
      $subject = new subject();
      if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
      }
      if ($id == null) {
        header("Location: subject.php");
      }

      //Nếu người dùng submit update, tiến hành thao tác cập nhật
      if (isset($_POST['update'])) {
        $error = array();
        $ma_nhom = mysqli_escape_string($con,$_POST['Nhom_HP']);
        $ma_gv = mysqli_escape_string($con,$_POST['Ma_GV']);

        //Kiểm tra điều kiện nhập
        if (empty($_POST['Nhom_HP'])) {
          $error[] = 'Mã nhóm không được trống';
        }
        else if (strlen($ma_nhom) != 2) {
          $error[] = 'Mã nhóm học phần phải là 2 chữ số';
        }
        if (empty($_POST['Ma_GV'])) {
          $error[] = 'Mã giảng viên không được trống';
        }
        else if (strlen($ma_gv) != 8) {
          $error[] = 'Mã giảng viên phải 8 kí tự';
        }

        if (empty($error)) {
          $sql = $subject->update_subject($con,$id,$ma_nhom,$ma_gv);
          if (mysqli_query($con,$sql)) {
            echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href='{$_SERVER['PHP_SELF']}';
                  </script>";
          }
          else {
            $error[] = 'Trùng nhóm học học phần và giảng viên giảng dạy';
          }
        }
      }

      //Nếu người dùng nhấn vào cancel
      if (isset($_POST['cancel'])) {
        header("Location: subject.php");
      }
     ?>

     <div class="main">
       <div class="edit-subject">
         <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
           <?php
            $result = mysqli_query($con,"SELECT * FROM giangvien_hp WHERE Id = $id");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
           <div id="input">
             <div id="error">
               <?php
                  if (!empty($error)) {
                    $err = current($error);
                    echo $err;
                  }
                ?>
              </div>
             <label for="Nhom_HP">Nhóm học phần</label>
             <input type="text" name="Nhom_HP" placeholder="" value="<?php echo $row['Ma_Nhom']; ?>">
           </div>
           <div id="input">
             <label for="Nhom_HP">Mã học phần</label>
             <input type="text" name="Ma_HP" placeholder="" value="<?php echo $row['Ma_HP']; ?>" readonly>
           </div>
           <div id="input">
             <label for="giang vien">Mã giảng viên dạy</label>
             <input type="text" name="Ma_GV" placeholder="" value="<?php echo $row['Ma_GV']; ?>"/>
           </div>
           <div id="input">
             <label for="hoc ki">Học kì</label>
             <?php
              $query = "SELECT Ten_HK FROM giangvien_hp AS gv_hp,hocki AS hk
                        WHERE gv_hp.Id = $id AND gv_hp.Ma_HK = hk.Ma_HK";
              $ten_hk = $subject->get_term($con,$query);
              ?>
             <input type="text" name="Ma_HK" value="<?php echo $ten_hk ?>" readonly>
           </div>
           <div id="input">
             <label for="nam hoc">Năm học</label>
             <?php
              $query = "SELECT Ten_NH FROM giangvien_hp AS gv_hp,namhoc AS nh
                        WHERE gv_hp.Id = $id AND gv_hp.Ma_NH = nh.Ma_NH";
              $ten_nh = $subject->get_year($con,$query);
              ?>
              <input type="text" name="Ma_HK" value="<?php echo $ten_nh ?>" readonly>
           </div>
           <div id="input">
             <input type="submit" name="update" value="Cập nhật">
             <input type="submit" name="cancel" value="Cancel">
           </div>
         </form>
       </div>
     </div>

     <?php
        }
        mysqli_close($con);
      ?>
     <?php
      include 'footer.php';
      ?>
  </body>
</html>
