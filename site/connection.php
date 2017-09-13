<?php
$con = new mysqli("localhost", "root", "", "mydb") or
  die("Khong the ket noi den database " . mysqli_connect_errno());
mysqli_set_charset($con , 'utf8');
 ?>
