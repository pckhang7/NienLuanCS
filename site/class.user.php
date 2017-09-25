<?php
class user {
  //Ham kiem tra dang nhap
  public function login($con,$username, $password) {
    $password = md5($password);
    $sql = "Select * From user Where username = '$username' and md5password ='$password'";
    $query = mysqli_query($con, $sql);
    $rows = mysqli_fetch_assoc($query);
    $num_row = mysqli_num_rows($query);

    if ($num_row == 1) {
      $_SESSION['login'] = true;
      $_SESSION['id'] = $rows['id'];
      $_SESSION['username'] = $rows['username'];
      $_SESSION['password'] = $rows['password'];
      $_SESSION['type'] = $rows['type'];
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  //Ham lay username
  public function get_username($con,$id) {
    $result = mysqli_query($con, "SELECT * FROM user WHERE id = '$id'");
    $rows = mysqli_fetch_array($result);
    return $rows['username'];
  }
  public function get_type($con,$username) {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    return $row['type'];
  }
  //Start session
  public function get_session() {
    return $_SESSION['login'];
  }

  public function user_logout() {
    $_SESSION['login'] = FALSE;
    session_destroy();
   }

  //Ham truy van tat ca du lieu trong bang user
  public function get_all_user($con, $query) {
    $result = mysqli_query($con,$query);
    return $result;
  }

  //Ham them moi mot user
  public function insert_user($con, $username, $md5password, $password, $type) {
    $query = "INSERT INTO user (username , md5password , password ,type) VALUES ('$username','$md5password','$password','$type');";
    $result = mysqli_query($con,$query);
    if ($result) {
      return true;
    }
    else {
      return false;
    }
  }
  //ham xoa nguoi dung
  public function delete_user($con, $username) {
    $query = "DELETE FROM user WHERE username = '$username'";
    $result = mysqli_query($con,$query);
    if ($result) {
      return true;
    }
    else {
      return false;
    }
  }

  //ham cap nhat nguoi dung
  public function update_user($con,$username,$password, $md5password) {
    $query = "UPDATE user
              SET password='$password', md5password='$md5password'
              WHERE username = '$username'";
    $result = mysqli_query($con,$query);
    if ($result) {
      return true;
    }
    else {
      return false;
    }
  }

  //Ham kiem tra ten nguoi dung da ton tai trong bang "user" hay khong
  public function check_user_exist($con,$username) {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /*Ham kiem tra ten nguoi dung co ton tai trong bang "sinhvien" hay "giangvien"
    -Neu la sinh viên thì trả về true
    -Ngươc lại là giảng viên trả về false
    */

  public function check_user_exist_table ($con,$username,$type) {
    if ($type == 'sinhvien') {
      $query = "SELECT * FROM sinhvien WHERE sinhvien.Ma_SV = '$username' ";
    }
    $result = mysqli_query($con,$query);
    if ($result) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
  /*Hàm trả lại bảng(sinh viên hoặc giảng viên) từ mã đầu vào :
    -Nếu là sinh viên : trả về chuoi 'sinhvien'
    -Ngược lại nếu là giảng viên : trả về 'giangvien'.
  */
  public function return_table($con,$ma){
    $sql1 = "SELECT * FROM sinhvien WHERE Ma_SV = '$ma'";
    $sql2 = "SELECT * FROM giangvien WHERE Ma_GV = '$ma'";
    $result1 = mysqli_query($con, $sql1);
    $result2 = mysqli_query($con, $sql2);
    $count1 = mysqli_num_rows($result1);
    $count2 = mysqli_num_rows($result2);
    $str1 = "sinhvien";
    $str2 = "giangvien";
    if ($count1 > 0) {
      return $str1;
    }
    if ($count2 > 0) {
      return $str2;
    }
  }

  //Hàm lấy tổng số hàng
  public function select_all($con,$sql) {
    $result = mysqli_query($con,$sql);
    $num_rows = mysqli_fetch_row($result);
    return $num_rows[0];
  }

  //Hàm truy vấn giới hạn
  public function readAll($con,$from,$rows_per_page) {
    $sql = "SELECT * FROM user LIMIT $from , $rows_per_page";
    $result = mysqli_query($con,$sql);
    return $result;
  }
}

 ?>
