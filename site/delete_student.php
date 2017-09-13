<?php
  include 'connection.php';
  include 'session.php';
  include 'class.student.php';
  include 'class.teacher.php';
  $student = new student();
  $teacher = new teacher();
  $username = null;
  if (!empty($_GET['id'])) {
    $username = $_REQUEST['id'];
  }
  //Kiểm tra xem có phải là sinh viên hay không
  $check = $student->check_student($con,$username);
  if ($check == TRUE) {
    $result = $student->delete_student($con,$username);
    if($result) {
      echo "<script>
         alert('Bạn đã xóa thành công!');
         window.location.href='student.php';
      </script>";
    }
  }
  else {
    $result = $teacher->delete_teacher($con,$username);
    if($result) {
      echo "<script>
         alert('Bạn đã xóa thành công!');
         window.location.href='teacher.php';
      </script>";
    }
  }

  mysqli_close($con);

 ?>
