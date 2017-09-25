<?php
  //Thiết lập định hướng và phân trang
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  //Thiết lập số hàng trên một trang
  $rows_per_page = 10;
  //Giới hạn câu truy vấn
  //VD : $page = 1 -> $from_num_row = 0 , tưc là nếu phân trang ở vị trí 1 thì hiển
  // thị số hàng 1->10 trên trang hiện tại từ câu truy vấn dữ liệu
  $from_num_row = ($rows_per_page * $page) - $rows_per_page;

  echo "<ul class='pagination'>";

  //Thiết lập nút đầu tiên
  if ($page > 1) {
    echo "<li><a href='{$page_url}' title='Về Đầu'>Về đầu</a></li>";
  }

  //Tổng số phân trang
  $total_pages = ceil($total_rows/$rows_per_page);

  //Số liên kết hiện thị xung quanh
  $range = 2;

  //hiển thị liên két xung quang phân trang hiện tại
  // VD : phân trang hiện tại là 3 , thi for(1->6) và hiển thì 1 2 3 4 5
  $first = $page - $range;
  $last = $page + $range + 1;

  for ($x = $first ; $x < $last; $x++) {
    //Chắc là $x > 0 và $x <=  $total_pages
    if (($x > 0) && ($x <= $total_pages)) {
      //Nếu $x là phân trang hiện tại
      if ($x == $page) {
        echo "<li class='active'><a href='#'>$x</a></li>";
      }
      else {
        echo "<li><a href='{$page_url}?page=$x'>$x</a></li>";
      }
    }
  }

  //Thiết lập nút cuối phân trang
  if ($page < $total_pages) {
    echo "<li><a href='{$page_url}?page={$total_pages}'>Về cuối</a></li>";
  }

  echo "</ul>";
  ?>
