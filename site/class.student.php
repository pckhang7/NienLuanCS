<?php
class student {
  private $Ma_SV;
  private $Ho;
  private $Ten;
  private $Dia_Chi;
  private $Email;
  private $Sdt;
  private $Ma_Nganh;

  public function getMaSV() {
    return $this->Ma_SV;
  }
  public function getHo() {
    return $this->Ho;
  }
  public function getTen() {
    return $this->Ten;
  }

  //Ham tra ve tat ca sinh vien
  public function get_all_student($con,$sql) {
    $result = mysqli_query($con,$sql);
    return $result;
  }

  //Ham kiem tra xem ma sinh vien co ton tai trong bang sinh vien hay khong
  public function check_student($con,$username) {
    $sql = "SELECT * FROM sinhvien WHERE Ma_SV = '$username'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  //Hàm kiểm tra update thông tin sinh viên với mã sinh viên, và mã ngành
  public function check_update_student($con,$ma_sv,$ho,$ten,$dia_chi,$email,$sdt) {
    $sql = "UPDATE sinhvien
            SET Ho='$ho', Ten='$ten', Dia_Chi='$dia_chi',Email='$email', sdt='$sdt'
            WHERE Ma_SV='$ma_sv'";
    $result = mysqli_query($con,$sql);
    if ($result) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  //Hàm update sinh viên
  public function update_student($con,$ma_sv,$ho,$ten,$dia_chi,$email,$sdt) {
    $sql = "UPDATE sinhvien
            SET Ho='$ho', Ten='$ten', Dia_Chi='$dia_chi',Email='$email', sdt='$sdt'
            WHERE Ma_SV='$ma_sv'";
    return $sql;
  }

  //Hàm xóa một sinh viên (đồng thời xóa lun tài khoản đăng nhập)
  public function delete_student($con,$ma_sv) {
    $query = "SELECT * FROM user WHERE username='$ma_sv'";
    $result = mysqli_query($con,$query);
    $count = mysqli_fetch_assoc($result);
    if ($count > 0) {
      $sql = "DELETE sinhvien, user FROM sinhvien, user
              WHERE sinhvien.Ma_SV = user.username AND sinhvien.Ma_SV = '$ma_sv'";
    }
    else {
      $sql = "DELETE FROM sinhvien
              WHERE sinhvien.Ma_SV = '$ma_sv'";
    }
    $result1 = mysqli_query($con,$sql);
    return $result1;
  }

}



 ?>
