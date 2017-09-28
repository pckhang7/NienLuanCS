<?php
  session_start();
  include 'connection.php';
  //Nhan tu khoa o tim kiem
  $searchTerm = $_GET['term'];
  $ma_gv = $_SESSION['username'];
  $query = "SELECT * FROM giangvien_hp WHERE Ma_HP LIKE '%" . $searchTerm . "%'
            AND Ma_GV = '$ma_gv'";
  $result = mysqli_query($con,$query);
  while($row = mysqli_fetch_array($result)) {
    $data[] = $row['Ma_HP'];
  }
  echo json_encode($data);
 ?>
