<?php
/*Ket noi den co so du lieu*/
  include 'connect.php';

  //Bat dau session
  session_start();
  //luu tru session
  $user_check = $_SESSION['login_user'];
  $sql = "SELECT * FROM user WHERE username = '$user_check'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $login_session = $row['username'];
  if (!isset($login_session)){
    mysqli_close($con);//Dong ket noi
    header("Location: login.php");
  }
 ?>
