//Dung de kiem tra Session
<?php
include 'connect.php';

session_start();
$user_check = $_SESSION['login_user'];
$sql = mysql_query("SELECT username from user where username=''")
$row = mysql_fetch_array($sql);
$login_session = $row['username'];
if (!isset($login_session)) {
  header("Location: login.php");
}
 ?>
