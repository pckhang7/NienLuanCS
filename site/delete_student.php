<?php
  include 'connection.php';
  include 'session.php';
  include 'class.student.php';
  $student = new student();
  $username = null;
  if (!empty($_GET['id'])) {
    $username = $_REQUEST['id'];
  }
  $result = $student->delete_student($con,$username);
  if($result) {
    echo "<script>
       alert('Bạn đã xóa thành công!');
       window.location.href='student.php';
    </script>";
  }
  mysqli_close($con);

 ?>
