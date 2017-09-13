<?php
class teacher {
  //Ham tra ve tat ca giảng viên
  public function get_all_teacher($con,$sql) {
    $result = mysqli_query($con,$sql);
    return $result;
  }

  //Hàm kiểm tra update một giảng viên
  public function check_update_teacher($con,$ma_gv,$ho,$ten,$dia_chi,$email,$sdt) {
    $sql = "UPDATE giangvien
            SET Ho='$ho', Ten='$ten', Dia_Chi='$dia_chi',Email='$email', Sdt='$sdt'
            WHERE Ma_GV='$ma_gv'";
    $result = mysqli_query($con,$sql);
    if ($result) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  //Hàm update giảng viên
  public function update_teacher($con,$ma_gv,$ho,$ten,$dia_chi,$email,$sdt) {
    $sql = "UPDATE giangvien
            SET Ho='$ho', Ten='$ten', Dia_Chi='$dia_chi',Email='$email', Sdt='$sdt'
            WHERE Ma_GV='$ma_gv'";
    return $sql;
  }

  //Hàm xóa một giảng viên (đồng thời xóa lun tài khoản đăng nhập)
  public function delete_teacher($con,$ma_gv) {
    $query = "SELECT * FROM user WHERE username='$ma_gv'";
    $result = mysqli_query($con,$query);
    $count = mysqli_fetch_assoc($result);
    if ($count > 0) {
      $sql = "DELETE giangvien, user FROM giangvien, user
              WHERE giangvien.Ma_GV = user.username AND giangvien.Ma_GV = '$ma_gv'";
    }
    else {
      $sql = "DELETE FROM giangvien
              WHERE giangvien.Ma_GV = '$ma_gv'";
    }
    $result1 = mysqli_query($con,$sql);
    return $result1;
  }

  //Ham kiem tra xem ma giang co ton tai trong bang sinh vien hay khong
  public function check_teacher($con,$username) {
    $sql = "SELECT * FROM giangvien WHERE Ma_GV = '$username'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
}

 ?>
