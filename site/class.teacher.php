<?php
class teacher {
  //Ham tra ve tat ca sinh vien
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
