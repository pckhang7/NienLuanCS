<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cập nhật điểm theo danh sách sinh viên</title>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php
      session_start();
      include 'header.php';
      include 'class.user.php';
      include 'connection.php';
      include 'class.subject.php';
      $ma_gv = $_SESSION['username'];
      $ma_nhom = base64_decode($_GET['var1']);
      $ma_hp = base64_decode($_GET['var2']);
      $ma_hk = base64_decode($_GET['var3']);
      $ma_nh = base64_decode($_GET['var4']);
      $subject = new subject();
      $readonly = 'readonly';
      $style = '';
      //Nếu người dùng nhấp nút cập nhật điểm
      if (isset($_POST['update'])) {
        $stt =
        $diem_gk = $_POST['diem_gk'];
        $diem_ck = $_POST['diem_ck'];
        $diem_th = $_POST['diem_th'];
        $diem_c = $_POST['diem_c'];
        $diem = $_POST['diem'];
      }
      //Nếu người dùng nhấp nút chỉnh sửa
      if (isset($_POST['edit'])) {
        $readonly = '';
        $style = "style=background-color:white;";
      }
     ?>


     <!-- Main -->
     <?php
      $sql = $subject->select_one($ma_gv,$ma_nhom,$ma_hp,$ma_hk,$ma_nh);
      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_assoc($result)) {

      ?>
     <div class="main">
      <div class="add-student-subject">
        <div class="title">
          <h2>Cập nhật điểm sinh viên</h2>
        </div>
        <form class="" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div id="section">
            <div class="section-left">
              <div id="section-content">
                <label for="ma_hp">Mã nhóm </label>
                <div id="text">
                  <?php echo $row['Ma_Nhom'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_hp">Mã học phần</label>
                <div id="text">
                  <?php echo $row['Ma_HP'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ten_hp">Tên học phần</label>
                <div id="text">
                  <?php echo $row['Ten_HP'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="so_tc">Số tín chỉ</label>
                <div id="text">
                  <?php echo $row['So_TC'] ?>
                </div>
              </div>
            </div>

            <div class="section-right">
              <div id="section-content">
                <label for="ma_hk">Học kì</label>
                <div id="text">
                  <?php echo $row['Ten_HK'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_nh">Mã học phần</label>
                <div id="text">
                  <?php echo $row['Ten_NH'] ?>
                </div>
              </div>
              <div id="section-content">
                <label for="ma_gv">Mã giảng viên</label>
                <div id="text">
                  <?php echo $ma_gv ?>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
          <div id="section">
            <label for="ds_diem">Danh sách điểm sinh viên</label>
            <br>
            <?php
              $sql1 = $subject->get_all_student_subject($ma_nhom,$ma_hp,$ma_hk,$ma_nh);
              $result1 = mysqli_query($con,$sql1);
              while($row = mysqli_fetch_assoc($result1)) {
                $i = 1;
             ?>
            <table border="1">
              <tr>
                <th>Số thứ tự</th>
                <th>Mã sinh viên</th>
                <th>Tên sinh viên</th>
                <th>Điểm giữa kì</th>
                <th>Điểm cuối kì</th>
                <th>Điểm thực hành</th>
                <th>Điểm cộng</th>
                <th>Tổng điểm</th>
              </tr>
              <tr>
                <?php
                echo "<td>$i</td>";
                echo "<td>{$row['Ma_SV']}</td>";
                echo "<td>{$row['Ho']} . {$row['Ten']}</td>";
                echo "<td>";
                    echo "<input type='number' name='diem_gk' step='any' min='0' max='10' value='{$row['Diem_GK']}' $readonly $style>";
                echo "</td>";
                echo "<td>";
                    echo "<input type='number' name='diem_hk' step='any' min='0' max='10' value='{$row['Diem_CK']}' $readonly $style>";
                echo "</td>";
                echo "<td>";
                    echo "<input type='number' name='diem_th' step='any' min='0' max='5' value='{$row['Diem_TH']}' $readonly $style>";
                echo "</td>";
                echo "<td>";
                    echo "<input type='number' name='diem_c' step='any' min='0' max='5' value='{$row['Diem_C']}' $readonly $style>";
                echo "</td>";
                echo "<td>";
                    echo "<input type='number' name='diem' step='any' min='0' max='10' value='{$row['Diem']}' readonly>";
                echo "</td>";
                 ?>
              </tr>
            </table>
          <?php
            $i++;
            }
            ?>
          </div>
          <input type="submit" name="update" value="Cập nhật">
          <input type="submit" name="edit" value="Chỉnh sửa" onclick="onchangecolor();">
        </form>
      </div>
     </div>
     <?php
      mysqli_close($con);
      ?>
     <!-- Footer -->
     <?php
      include 'footer.php';
      ?>
  </body>
</html>
