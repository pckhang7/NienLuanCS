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

}



 ?>
