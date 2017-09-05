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

  //Ham kiem tra ten nguoi dung da ton tai trong bang "user" hay khong
  public function check_user_exist($con,$username) {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      return false;
    }
    else {
      return true;
    }
  }

  //Ham kiem tra ten nguoi dung co ton tai trong bang "sinhvien" hay "giangvien"
  public function check_user_exist_table ($con,$username,$type) {
    if ($type == 'sinhvien') {
      $query = "SELECT * FROM sinhvien WHERE sinhvien.Ma_SV = '$username' ";
    }
    else {
      $query = "SELECT * FROM giangvien WHERE giangvien.Ma_GV = '$username' ";
    }
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
      return true;
    }
    else {
      return false;
    }
  }
}

 ?>
