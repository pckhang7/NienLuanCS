<?php
  include 'connection.php';
  include 'session.php';
  include 'class.subject.php';
  $subject = new subject();
  $id = null;
  if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
  }
  if ($id == null) {
    header ("Location: subject.php");
  }
  $sql = $subject->delete_subject($con,$id);
  if (mysqli_query($con,$sql)) {
    echo "<script>
            alert('Bạn đã xóa thành công!');
            window.location.href='subject.php';
          </script>";
  }
  mysqli_close($con);
 ?>
